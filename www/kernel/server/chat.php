<?php
define('CRON',true);
ignore_user_abort(1);
set_time_limit(0);
require(__DIR__.'/../core.php');
$host = config('chat.host');
$port = config('chat.port');
$null = NULL;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, 0, $port);
socket_listen($socket);
$rooms = array();
$clients = array($socket);
while (true) {
	$changed = $clients;
	socket_select($changed, $null, $null, 0, 10);
	
	/* User connection*/
	if (in_array($socket, $changed)) {
		$socket_new = socket_accept($socket);
		$clients[] = $socket_new;
		$header = socket_read($socket_new, 1024);
                $getHeaderData = explode('/',explode(' ',explode("\n",$header)[0])[1]);
                if(count($getHeaderData) == 4 && array_key_exists(2,$getHeaderData) && array_key_exists(3,$getHeaderData))
                {
                    $roomcode = $getHeaderData[2];
                    $conUserId = $getHeaderData[3];
                    perform_handshaking($header, $socket_new, $host, $port);
                    $rooms[$roomcode][$core->decrypt($conUserId)] = $socket_new;
                    socket_getpeername($socket_new, $ip);

                    $response = mask(json_encode(array('type'=>'system', 'message'=> 'CHAT_CONNECTED_SUCCESS')));
                    send_message($response,$roomcode);
                    $found_socket = array_search($socket, $changed);
                    unset($changed[$found_socket]);
                }
                else
                {
                    unset($clients[$found_socket]);
                    unset($changed[$found_socket]);
                }
	}
        
        foreach ($changed as $changed_socket) {
		while(@socket_recv($changed_socket, $buf, 1024, 0) >= 1)
		{
                    $received_text = unmask($buf);
                    $tst_msg = json_decode($received_text,true);
			$user_message = $tst_msg['message'];
			$user_room = $tst_msg['room'];
			$user_id = $core->decrypt($tst_msg['user_id']);
                        if($user_id == '' || $user_id == null)
                        {
                            $response = mask(json_encode(array('type'=>'system', 'message'=> 'CHAT_SERVER_ERROR')));
                            send_message($response,$user_room);
                        }
                        else
                        {
                            $response_text = mask(json_encode(array('type' => 'usermsg', 'message' => $user_message)));
                            send_message($response_text,$user_room,$user_id,$user_message,$user_room);
                        }
			break 2;
		}
		
		$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
		if ($buf === false) {
			$found_socket = array_search($changed_socket, $clients);
			socket_getpeername($changed_socket, $ip);
			unset($clients[$found_socket]);
                        $clientStrId = array_search($found_socket,$rooms[$roomcode]);
                        if(!$clientStrId)
                        {
                            unset($rooms[$roomcode][$clientStrId]);
                        }
			$response = mask(json_encode(array('type'=>'system', 'message'=> 'CHAT_DISCONNECTED_SUCCESS')));
			send_message($response,$user_room);
		}
	}
}
socket_close($socket);


function send_message($msg,$roomcode,$sender = -1,$singlemessage = null,$roomSessionCode=null)
{
	global $clients;
	global $rooms;
	global $db;
	global $core;
        $receptor = 0;
        if(array_key_exists($roomcode,$rooms))
        {
            foreach($rooms[$roomcode] as $clientId => $changed_socket)
            {
                @socket_write($changed_socket,$msg,strlen($msg));
                if($clientId != $sender)
                {
                    $receptor = $clientId;
                }
            }
            if($sender != -1)
            {
                if($receptor != 0)
                {
                    $db->query('INSERT INTO chat_messages (sender,receptor,sessionId,timestamp,content) VALUES ('.$sender.','.$receptor.',"'.$roomSessionCode.'",'.time().',"'.$singlemessage.'")');
                }
                else
                {
                    $db->query('INSERT INTO chat_messages (sender,receptor,sessionId,timestamp,content) VALUES ('.$sender.',0,"'.$roomSessionCode.'",'.time().',"'.$singlemessage.'")');
                    $notDelayed = mask(json_encode(array('type'=>'system', 'message'=> 'CHAT_MESSAGE_NOTSERVED')));
                    send_message($notDelayed,$roomcode);
                    
                }
            }
        }
	return true;
}

function unmask($text) {
	$length = ord($text[1]) & 127;
	if($length == 126) {
		$masks = substr($text, 4, 4);
		$data = substr($text, 8);
	}
	elseif($length == 127) {
		$masks = substr($text, 10, 4);
		$data = substr($text, 14);
	}
	else {
		$masks = substr($text, 2, 4);
		$data = substr($text, 6);
	}
	$text = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
}

function mask($text)
{
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);
	
	if($length <= 125)
		$header = pack('CC', $b1, $length);
	elseif($length > 125 && $length < 65536)
		$header = pack('CCn', $b1, 126, $length);
	elseif($length >= 65536)
		$header = pack('CCNN', $b1, 127, $length);
	return $header.$text;
}

function perform_handshaking($receved_header,$client_conn, $host, $port)
{
	$headers = array();
	$lines = preg_split("/\r\n/", $receved_header);
	foreach($lines as $line)
	{
		$line = chop($line);
		if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
		{
			$headers[$matches[1]] = $matches[2];
		}
	}

	$secKey = $headers['Sec-WebSocket-Key'];
	$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
	//hand shaking header
	$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
	"Upgrade: websocket\r\n" .
	"Connection: Upgrade\r\n" .
	"WebSocket-Origin: $host\r\n" .
	"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
}
