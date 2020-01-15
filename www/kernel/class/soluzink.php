<?php
$core = new soluzink();
if(!CRON)
{
    define('URL',sprintf("%s://%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',$_SERVER['SERVER_NAME']));
    define('DOMAIN',$_SERVER['SERVER_NAME']);
    define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}
define('BASEDIR',__DIR__.'/../../');
class soluzink
{
        public function checkTimezone($timezone)
        {
            return in_array($timezone, timezone_identifiers_list());
        }
	public function timeElapsed($time)
	{
		global $lang;
		$etime = (time() - $time);

		if ($etime < 1)
		{
                    return '0 '.$lang['CORE']['time.elapsed.seconds'];
		}

		$a = array( 365 * 24 * 60 * 60  =>  $lang['CORE']['time.elapsed.year'],
					 30 * 24 * 60 * 60  =>  $lang['CORE']['time.elapsed.month'],
						  24 * 60 * 60  =>  $lang['CORE']['time.elapsed.day'],
							   60 * 60  =>  $lang['CORE']['time.elapsed.hour'],
									60  =>  $lang['CORE']['time.elapsed.minute'],
									 1  =>  $lang['CORE']['time.elapsed.second']
					);
		$a_plural = array( $lang['CORE']['time.elapsed.year']   => $lang['CORE']['time.elapsed.years'],
                    $lang['CORE']['time.elapsed.month']  => $lang['CORE']['time.elapsed.months'],
                    $lang['CORE']['time.elapsed.day']    => $lang['CORE']['time.elapsed.days'],
                    $lang['CORE']['time.elapsed.hour']   => $lang['CORE']['time.elapsed.hours'],
                    $lang['CORE']['time.elapsed.minute'] => $lang['CORE']['time.elapsed.minutes'],
                    $lang['CORE']['time.elapsed.second'] => $lang['CORE']['time.elapsed.seconds']
                 );

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
                            $r = round($d);
                            return str_replace('{time}',$r . ' ' . ($r > 1 ? $a_plural[$str] : $str),$lang['CORE']['time.elapsed.ago']);
			}
		}
	}
        public function timeLeft($time)
	{
		global $lang;
		$etime = ($time - time());

		if ($etime < 1)
		{
                    return '0 '.$lang['CORE']['time.elapsed.seconds'];
		}

		$a = array( 365 * 24 * 60 * 60  =>  $lang['CORE']['time.elapsed.year'],
					 30 * 24 * 60 * 60  =>  $lang['CORE']['time.elapsed.month'],
						  24 * 60 * 60  =>  $lang['CORE']['time.elapsed.day'],
							   60 * 60  =>  $lang['CORE']['time.elapsed.hour'],
									60  =>  $lang['CORE']['time.elapsed.minute'],
									 1  =>  $lang['CORE']['time.elapsed.second']
					);
		$a_plural = array( $lang['CORE']['time.elapsed.year']   => $lang['CORE']['time.elapsed.years'],
                    $lang['CORE']['time.elapsed.month']  => $lang['CORE']['time.elapsed.months'],
                    $lang['CORE']['time.elapsed.day']    => $lang['CORE']['time.elapsed.days'],
                    $lang['CORE']['time.elapsed.hour']   => $lang['CORE']['time.elapsed.hours'],
                    $lang['CORE']['time.elapsed.minute'] => $lang['CORE']['time.elapsed.minutes'],
                    $lang['CORE']['time.elapsed.second'] => $lang['CORE']['time.elapsed.seconds']
                );

		foreach ($a as $secs => $str)
		{
                    $d = $etime / $secs;
                    if ($d >= 1)
                    {
                        $r = round($d);
                        return str_replace('{time}',$r . ' ' . ($r > 1 ? $a_plural[$str] : $str),$lang['CORE']['time.elapsed.on']);
                    }
		}
	}
	public function secondsToTime($time)
	{
		if($time < 60)
		{
			return gmdate('s', $time).$lang['CORE']['time.elapsed.seconds'];
		}
		elseif($time >= 60 && $time < 3600)
		{
			return gmdate('i', $time);
		}
		elseif($time >= 3600 && $time < 86400)
		{
			return gmdate('H', $time);
		}
		elseif($time > 86400)
		{
			return gmdate('d', $time);
		}
	}
	public function hex2rgb($hex) {
	   $hex = str_replace('#', null, $hex);

	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   return $rgb;
	}

	public function rgb2hex($rgb) {
	   return "#".str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT).str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT).str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
	}
	
	public function crypt($string) {
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = config('secretkey.1');
		$secret_iv = config('secretkey.2');
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
	}
	public function decrypt($string) {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_key = config('secretkey.1');
		$secret_iv = config('secretkey.2');
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}
	public function validate($type,$validate,$extra = null)
	{
		switch($type)
		{
			case 'email':
				$email = $validate;
				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					return true;
				}
				else
				{
					return false;
				}
			break;
			case 'url':
				if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$validate))
				{
				  return true;
				}
				else
				{
					return false;
				}
			break;
			case 'telephone':
				if(preg_match('/^[9|6|7][0-9]{8}$/',$validate))
				{
					return true;
				}
				else
				{
					return false;
				}
			break;
			case 'password':
				if(config('register.passsword.strenght') == 1)
				{
					if(strlen($validate) >= 8)
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				if(config('register.passsword.strenght') == 2)
				{
					if(strlen($validate) >= 8 && preg_match('#[0-9]+#', $validate) && preg_match('#[A-Za-z]+#', $validate))
					{
						return true;
					}
					else
					{
						return false;
					}
				}

				if(config('register.passsword.strenght') == 3)
				{
					if(strlen($validate) >= 8 && preg_match('#[0-9]+#', $validate) && preg_match('#[A-Z]+#', $validate) && preg_match('#[a-z]+#', $validate))
					{
						array_push($extra,'123','password','pass');
						// now search for known words
						$valid = true;
						for($i = 0; $i < count($extra); $i++)
						{
							if($extra[$i] != null)
							{
								if(stristr($validate,$extra[$i]) !== FALSE)
								{
									$valid = false;
									break;
								}
							}
						}
						if($valid === true)
						{
							return true;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				}
			break;
                        case 'countryalpha2':
                            if(strlen($validate) != 2)
                            {
                                return false;
                            }
                            else
                            {
                                if(!preg_match('/[^A-Za-z0-9]/', $validate))
                                {
                                    return false;
                                }
                                else
                                {
                                    return true;
                                }
                            }
                        break;
		}
	}
	public function session_isSet($sessionName)
	{
		if(isset($_SESSION[$this->crypt($sessionName)]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function session_setNew($sessionName,$sessionValue)
	{
		$_SESSION[$this->crypt($sessionName)] = $this->crypt($sessionValue);
	}
	public function session_getValue($sessionName)
	{
		return $this->decrypt($_SESSION[$this->crypt($sessionName)]);
	}
	public function session_destroy($sessionName)
	{
		unset($_SESSION[$this->crypt($sessionName)]);
	}
	public function checkCSRFToken($method = 'POST', $deleteData = false)
	{
		if(strtoupper($method) == 'GET')
		{
			$method = $_GET;
		}
		else
		{
			$method = $_POST;
		}
		if(!$this->session_isSet('CSRFImprovedProtecter') || !$this->session_isSet('CSRFImprovedProtecterTimeOut') || !isset($method['inputCSRFProtecter']))
		{
			throw new Exception('CSRF_INVALID');
		}
		$CSRFCode = $this->session_getValue('CSRFImprovedProtecter');
		$CSRFTimeOut = $this->session_getValue('CSRFImprovedProtecterTimeOut');
		if($deleteData === true)
		{
			$this->session_destroy('CSRFImprovedProtecter');
			$this->session_destroy('CSRFImprovedProtecterTimeOut');
		}
		if($this->crypt($this->getUserIP().$_SERVER['HTTP_USER_AGENT']) != $CSRFCode)
		{
			throw new Exception('CSRF_DETECTED');
		}

		if ( $method['inputCSRFProtecter'] != $CSRFCode )
		{
			throw new Exception('CSRF_DETECTED_NOTMATCH');
		}
		if($CSRFTimeOut + config('CSRF.expire.interval') < time())
		{
			throw new Exception('CSRF_EXPIRED');
		}
		return true;
	}
	public function generateCSRFToken()
	{
		$token = $this->crypt($this->getUserIP().$_SERVER['HTTP_USER_AGENT']);
		$this->session_setNew('CSRFImprovedProtecter',$token);
		$this->session_setNew('CSRFImprovedProtecterTimeOut',time());
		return $token;
	}
	public function getUserIP() {
		if (array_key_exists( 'X-Forwarded-For', $_SERVER) && filter_var($_SERVER['X-Forwarded-For'], FILTER_VALIDATE_IP) ) {
			$the_ip = $_SERVER['X-Forwarded-For'];
		} elseif (array_key_exists( 'HTTP_X_FORWARDED_FOR', $_SERVER) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)
		) {
			$the_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			
			$the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
		}
		if($the_ip == '::1')
		{
			$the_ip = '127.0.0.1';
		}
		return $the_ip;
	}
	public function stringCleaner($val) 
	{
		$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);$search = 'abcdefghijklmnopqrstuvwxyz';$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';$search .= '1234567890!@#$%^&*()';$search .= '~`";:?+/={}[]-_|\'\\';for ($i = 0; $i < strlen($search); $i++) {$val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); }
		$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');$ra = array_merge($ra1, $ra2);$found = true;while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {$pattern = '/';for ($j = 0; $j < strlen($ra[$i]); $j++) {if ($j > 0) { $pattern .= '(';$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';$pattern .= '|(&#0{0,8}([9][10][13]);?)?';$pattern .= ')?';}$pattern .= $ra[$i][$j];}$pattern .= '/i';$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);$val = preg_replace($pattern, $replacement, $val);if ($val_before == $val) {$found = false;}}} return $val;
	}
        public function cleanVar($var)
        {
            if(is_array($var))
            {
		foreach ($var as $key => $input_arr)
		{ 
                    if(is_array($input_arr))
                    {
                        $this->cleanVar($input_arr);
                    }
                    else
                    {
                        $var[$key] = addslashes($this->stringCleaner($input_arr)); 
                    }
		}
            }
        }
	public function cleanSystem()
	{
            $this->cleanVar($_POST);
            $this->cleanVar($_GET);
            $this->cleanVar($_SERVER);
            $this->cleanVar($_REQUEST);
	}
	public function containsNumbers($string)
	{
		if(1 === preg_match('~[0-9]~', $string))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function containsLetters($string)
	{
		if(1 === preg_match('~[a-zA-Z]~', $string))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function generateCaptcha()
	{
		$number1 = rand(0,10);
		$number2 = rand(0,10);
		while($number1 < $number2)
		{
			$number1 = rand(0,10);
			$number2 = rand(0,10);
		}
		$operators = ['-','+','*'];
		$operator = $operators[rand(0,(count($operators)-1))];
		$message = $number1.' '.$operator.' '.$number2.' = ';
		$result=eval('return ('.$number1.' '.$operator.' '.$number2.');');
		$this->session_setNew('soluzinkCaptcha',$result);
		return array('message' => $message, 'result' => $result);
	}
        public function getCurrency($curr, $type = 'symbol')
        {
            if($type == 'symbol')
            {
                switch($curr)
                {
                    case 'USD':
                        return $GLOBALS['lang']['CORE']['currency']['USD']['symbol'];
                    break;
                    case 'GBP':
                        return $GLOBALS['lang']['CORE']['currency']['GBP']['symbol'];
                    break;
                    case 'EUR':
                        return $GLOBALS['lang']['CORE']['currency']['EUR']['symbol'];
                    break;
                    default:
                    return $GLOBALS['lang']['CORE']['currency']['EUR']['symbol'];
                }
            }
            elseif($type == 'text')
            {
                switch($curr)
                {
                    case 'USD':
                        return $GLOBALS['lang']['CORE']['currency']['USD']['text'];
                    break;
                    case 'GBP':
                        return $GLOBALS['lang']['CORE']['currency']['GBP']['text'];
                    break;
                    case 'EUR':
                        return $GLOBALS['lang']['CORE']['currency']['EUR']['text'];
                    break;
                    default:
                        return $GLOBALS['lang']['CORE']['currency']['EUR']['text'];
                }
            }
        }
        public function safeAjaxCall()
        {
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            if(strpos(@$_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'))===false)
            {
                return false;
            }
            else if(!IS_AJAX)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        public function templateListing($type, $orderData = null, $sortDir = null, $moneyRange = null, $showedIds = null)
        {
            global $db;
            global $lang;
            $moneyRangeQuery = '';
            if($moneyRange != null)
            {
                $coinflips = explode('_',$moneyRange);
                $moneyRangeQuery = ' AND pph BETWEEN '.$coinflips[0].' AND '.$coinflips[1].' ';
            }
            $orderDir = config('listing.sort.dir');
            $orderCode = '';
            if($sortDir == 'sessionnow')
            {
                $orderCode = 'up.sessionNowEnabled '.$orderDir;
            }
            else if($sortDir == 'moreexpensive')
            {
                $orderCode = 'up.pph '.$orderDir;
            }
            else if($sortDir == 'morecheap')
            {
                $orderCode = 'up.pph '.$orderDir;
            }
            $filterCode = ' AND';
            if($orderData == null || $orderData == '' || $orderCode == '')
            {
                if(USER_LOGGED_IN)
                {
                    $userHighestPats = $db->query('SELECT patid FROM users_patologies WHERE uid='.USER_ID.' ORDER BY grade DESC');
                    $orderType = null;
                    $orderCode = '(CASE';
                    $num = 0;
                    while($patinfo = $userHighestPats->fetch_row())
                    {
                        $orderCode .= ' WHEN p.specpatid = '.$patinfo[0].' THEN '.$num;
                        $num++;
                    }
                    $orderCode .= ' ELSE '.$num.' END),';
                    $orderCode .= ' p.score '.$orderDir.', p.scoreVotesNumber '.$orderDir;
                }
                else
                {
                    $orderCode = 'p.score '.$orderDir.', p.scoreVotesNumber '.$orderDir;
                }
            }
            elseif(is_array($orderData))
            {
                foreach($orderData as $odrDat)
                {
                    if($odrDat['dataType'] == "timespace")
                    {
                        if($odrDat['dataId'] == 'morning')
                        {
                            $filterCode .= ' sessionsOnMorning=1 AND';
                        }
                        else if($odrDat['dataId'] == 'afternoon')
                        {
                            $filterCode .= ' sessionsOnAfternoon=1 AND';
                        }
                        else if($odrDat['dataId'] == 'night')
                        {
                            $filterCode .= ' sessionsOnNight=1 AND';
                        }
                    }
                    else if($odrDat['dataType'] == "patologies")
                    {
                        $filterCode .= ' specpatid='.$odrDat['dataId'].' AND';
                    }
                }
            }
            $filterCode = substr($filterCode,0,-3);
            $query = $db->query('SELECT u.photo,u.name,u.surnames,p.score, u.online, p.description, p.pph, p.pphCoin, p.score, u.id,p.scoreVotesNumber,p.specpatid,u.geoCountry,u.type,p.collegenumber,p.sessionNowEnabled
                FROM users u JOIN users_psicos p ON p.user_id=u.id
                WHERE p.pph!=0 AND p.description!=""  AND p.paypalAccount!=""
                AND u.type="'.$type.'"'.($showedIds != null ? ' AND u.id NOT IN ('.$showedIds.') ':' ').'
                '.$moneyRangeQuery.$filterCode.'
                '.(isset($orderCode) ? 'ORDER BY '.$orderCode:'').'
                LIMIT '.config('listing.default.results')) or die($db->error);
            $rowId = 0;
            $return = array('code' => ($db->error == '' ? 1 : 2), 'rowsAffected' => 0, 'content' => null, 'ids' => null);
            $return['content'] .= ' <div class="row listing grid2 white"><div class="col-sm-9">';
            $psicosShown = false;
             while($row = $query->fetch_row())
             {
                 $psicoCalendar = $db->query('SELECT user_id FROM users_psicos_calendar WHERE user_id='.$row[9]);
            
                 if($psicoCalendar->num_rows > 0)
                 {
                    if($row[15] && $row[4])
                    {
                        if($db->query('SELECT psico_id FROM users_psicos_sessions WHERE timestamp>='.time().' AND timestamp<=('.time().'+sessionlengthmins*60) AND psico_id='.$row[9])->num_rows == 0)
                        {
                            $isValidSessionInmediate = true;
                        }
                        else
                        {
                            $isValidSessionInmediate = false;
                        }
                    }
                 $starRating = null;
                 $currentStars = ($row[8]*100/$row[10])/10;
                 $numRepeats = 1;
                 while($numRepeats <= 5)
                 {
                     if($currentStars - 2 >= 0)
                     {
                         $currentStars = $currentStars-2;
                         $starRating .= '<i class="fa fa-star"></i>';
                     }
                     elseif($numRepeats <= 5 && $currentStars < 1 && $currentStars > 0)
                     {
                         $starRating .= '<i class="fa fa-star-o"></i>';
                     }
                     elseif($currentStars - 2 <= 0 && $currentStars != 0 && $numRepeats <= 5)
                     {
                         $currentStars = $currentStars-1;
                         $starRating .= '<i class="fa fa-star-half-o"></i>';
                     }
                     else
                     {
                         $starRating .= '<i class="fa fa-star-o"></i>';
                     }
                     $numRepeats++;
                 }
                 $psicosShown = true;
                $return['content'] .= '
                    <div class="col-sm-12">
                       <div class="listing-item" id="psico_'.$row[9].'" data-price-pph="'.$row[6].'" data-price-currency="'.$this->getCurrency($row[7],'symbol').'" data-psico="'.$row[1].' '.$row[2].'" data-psico-code="'.$this->crypt($row[9]).'">
                          '.($row[4] == TRUE ? '<a class="category-icon"><i class="fa fa-circle blink"></i></a> ': '').'
                          
                             <div class="listing-item-title-centralizer">
                                <div class="listing-item-title">
                                   <a href="'.URL.'/#/ExtProfile/'.$this->crypt($row[9]).'">'.$row[1].' '.$row[2].'</a>
                                   <div class="ribbon">~ '.$row[6].' '.$this->getCurrency($row[7],'symbol').'/'.$lang['CORE']['time.elapsed.hour'].'</div>
                                </div>
                             </div>
                             <a class="listing-item-link buttonBuynow"><img style="cursor: pointer" class="imageClick" data-href="'.URL.'/#/ExtProfile/'.$this->crypt($row[9]).'" draggable="false" alt="'.str_replace(array('{PROFILE_IMAGE_DEFAULT}','{URL}'),array(PROFILE_IMAGE_DEFAULT,URL),$row[0]).'" data-original="'.str_replace(array('{PROFILE_IMAGE_DEFAULT}','{URL}'),array(PROFILE_IMAGE_DEFAULT,URL),$row[0]).'"/> 
                          </a> 
                          <div class="listing-item-data">
                             <div class="listing-item-excerpt col-md-12 nopadding wordwrap"> '.$row[5].' </div>
                             <div class="listing-item-result col-md-'.($row[15] && $row[4] && $isValidSessionInmediate ? '2':'4').' nopadding"> <div class="panel panel-default listing-item-result-color textcenter"><div class="panel-heading">'.$lang['home']['listing']['details']['sessionsdone'].'</div><div class="panel-body textcenter">'.$db->query('SELECT user_id FROM users_psicos_sessions WHERE timestamp>'.time().' AND psico_id='.$row[9])->num_rows.'</div></div></div>
                             <div class="listing-item-result col-md-'.($row[15] && $row[4] && $isValidSessionInmediate ? '2':'4').' nopadding"> <div class="panel panel-default listing-item-result-color textcenter"><div class="panel-heading">'.$lang['home']['listing']['details']['speciality'].'</div><div class="panel-body textcenter">'.$lang['DB']['treatments'][$db->query('SELECT langkey FROM patologies WHERE id='.$row[11])->fetch_row()[0]].'</div></div></div>
                             '.($row[13] == 'psico' ? '<div class="listing-item-result col-md-4 nopadding"> <div class="panel panel-default listing-item-result-color textcenter"><div class="panel-heading">'.$lang['home']['listing']['details']['collegednumber'].'</div><div class="panel-body textcenter">'.$row[14].'</div></div></div>':'').'
                             '.($row[15] && $row[4] && $isValidSessionInmediate ? '<div class="listing-item-result col-md-4 nopadding"> <button style="cursor: pointer" class="btn btn-warning buynow">'.$lang['home']['listing']['details']['reservenow'].'</button> </div>':'').'
                          </div>
                          <div class="listing-category-name"><img style="height: 30px; width: 30px; margin-right: 10px;" src="'.URL.'/assets/images/countries/'.strtolower($row[12]).'.png"/><span class="psicoScore">'.$starRating.'</span> </div>
                       </div>
                    </div>';
                $return['ids'] .= $row[9].',';
                 }
                $rowId++;
             }
             $return['content'] .= ' 
                    </div><div class="col-sm-3" id="cldrCntr">
                        <div class="soluzinkCldr-loader fa fa-spinner fa-spin"></div>
                        <input type="hidden" data-price-pph="" data-price-currency="" data-psico="" id="calendarListingGlobal" /></div></div>';
             
             if($rowId == 0)
             {
                $return['code'] = 2;
             }
             $return['ids'] = substr($return['ids'], 0, -1);
             $return['rowsAffected'] = $rowId;
             if(!$psicosShown)
             {
                 $return['content'] = '';
                 $return['code'] = 2;
                 $return['rowsAffected'] = 0;
                 $return['ids'] = '';
             }
            return $return;
        }
        public function getCalendar($psicoId, $returnArray = false)
        {
            global $db;
            $psicoInfo = $db->query('SELECT weekly_calendar,week_exceptions,maxdate FROM users_psicos_calendar WHERE user_id='.$psicoId)->fetch_array();
            $baseDays = json_decode($psicoInfo['weekly_calendar'],true);
            $finalDays = $baseDays;
            if($psicoInfo['week_exceptions'] != '')
            {
                $excludedDays = json_decode($psicoInfo['week_exceptions']);
                if(json_last_error() == 0)
                {
                    foreach($excludedDays as $day => $data)
                    {
                            if(count($data) > 1)
                            {
                                foreach($data as $dayRecord)
                                {
                                    $dayRecord = $data[0];
                                    if(stristr($dayRecord, '+') !== false && array_search(str_replace(array('+','-'),null,$dayRecord),$finalDays[$day]) === false)
                                    {
                                        $finalDays[$day][] = str_replace('+',null,$dayRecord);
                                        sort($finalDays[$day]);
                                    }
                                    else if(stristr($dayRecord, '-') && array_search(str_replace(array('+','-'),null,$dayRecord),$finalDays[$day]) !== false)
                                    {
                                        $position = array_search(str_replace('-',null,$dayRecord),$finalDays[$day]);
                                        unset($finalDays[$day][$position]);
                                        sort($finalDays[$day]);
                                    }
                                }
                            }
                            else if(count($data) == 1)
                            {
                                $dayRecord = $data[0];
                                if(stristr($dayRecord, '+') !== false && array_search(str_replace(array('+','-'),null,$dayRecord),$finalDays[$day]) === false)
                                {
                                    $finalDays[$day][] = str_replace('+',null,$dayRecord);
                                    sort($finalDays[$day]);
                                }
                                else if(stristr($dayRecord, '-') && array_search(str_replace(array('+','-'),null,$dayRecord),$finalDays[$day]) !== false)
                                {
                                    $position = array_search(str_replace('-',null,$dayRecord),$finalDays[$day]);
                                    unset($finalDays[$day][$position]);
                                    sort($finalDays[$day]);
                                }
                            }
                    }
                }
                else
                {
                    error_log('Error parsing JSON of a calendar profile. Profile ID: '.$psicoCode.', error code:'.json_last_error());
                }
                $contratedDaysAlready = $db->query('SELECT timestamp FROM users_psicos_sessions WHERE timestamp>'.time().' AND psico_id='.$psicoId);
                $daysContrated = [];
                while($row = $contratedDaysAlready->fetch_row())
                {
                    $daysContrated[] = $row[0];
                }
            }
            else
            {
                return 'NO_CALENDAR';
            }
            $response = array('days' => $finalDays,'maxdate' => $psicoInfo['maxdate'],'dayscontrated' => $daysContrated);
            if(!$returnArray)
            {
                return json_encode($response);
            }
            else
            {
                return $response;
            }
        }
        public function formatCC($action, $cc)
        {
            switch($action)
            {
                case 'sendtodb':
                    return $this->crypt(str_replace(' ', '', $cc));
                break;
                case 'getfromdb':
                    $baseCreditCard = $this->decrypt($cc);
                    $formattedCreditCard = null;
                    for($i = 0; $i < strlen($baseCreditCard); $i++)
                    {
                        if($i%4==0 && $i != 0)
                        {
                            $formattedCreditCard .= ' '.substr($baseCreditCard,$i,1);
                        }
                        else
                        {
                            $formattedCreditCard .= substr($baseCreditCard,$i,1);
                        }
                    }
                    return $formattedCreditCard;
                break;
                case 'getfromdbencoded':
                    $baseCreditCard = $this->decrypt($cc);
                    $formattedCreditCard = null;
                    for($i = 0; $i < strlen($baseCreditCard); $i++)
                    {
                        if($i%4==0 && $i != 0)
                        {
                            $formattedCreditCard .= ' ';
                        }
                        if($i+4 >= strlen($baseCreditCard))
                        {
                            $formattedCreditCard .= substr($baseCreditCard,$i,1);
                        }
                        else
                        {
                            $formattedCreditCard .= '●';
                        }
                    }
                    return $formattedCreditCard;
                break;
                default:
                    die('No action selected at format CC function. Execution denied.');
            }
        }
        public function convertCurrency($amount,$currency,$wantedCurrency)
        {
            global $db;
            $baseCurrency1 = $db->query('SELECT currencyVal FROM currencies WHERE currencyCode="'.$currency.'"')->fetch_row()[0];
            $baseCurrency2 = $db->query('SELECT currencyVal FROM currencies WHERE currencyCode="'.$wantedCurrency.'"')->fetch_row()[0];
            return ($amount*$baseCurrency2)/$baseCurrency1;
        }
        public function imgCompress($source, $destination, $quality = 90)
        {
            $info = @getimagesize($source);
            if ($info['mime'] == 'image/jpeg')
            {
                    $image = @imagecreatefromjpeg($source);
            }
            elseif($info['mime'] == 'image/gif')
            {
                    $image = @imagecreatefromgif($source);
            }
            elseif($info['mime'] == 'image/png')
            {
                    @imagealphablending($image, false);
                    @imagesavealpha($image, true);
                    $image = @imagecreatefrompng($source);
            }
            @imagejpeg($image, $destination, $quality);
            return $destination;
        }
        function getUploadFileSizeBytes($val) {
            $val = trim($val);
            $last = strtolower($val[strlen($val)-1]);
            switch($last) {
                case 'g':
                    $val *= (1024 * 1024 * 1024);
                    break;
                case 'm':
                    $val *= (1024 * 1024);
                    break;
                case 'k':
                    $val *= 1024;
                    break;
            }
            return $val;
        }
        function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
        function generateRecoveraccCode()
        {
            return rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        }
        function blockAccount($userId,$userEmail)
        {
            global $db;
            global $email;
            $genCode = $this->generateRecoveraccCode();
            $db->query('INSERT INTO users_recoveracc_code (uid,seccode,timestamp) VALUES ('.$userId.','.$genCode.','.time().')');
            $email->accountBlockedSendCode($userEmail,$genCode);
        }
        function blockAccountResendCode($userId,$userEmail)
        {
            global $db;
            global $email;
            $genCode = $this->generateRecoveraccCode();
            $db->query('UPDATE users_recoveracc_code SET seccode='.$genCode.', timestamp='.time().' WHERE uid='.$userId);
            $email->accountBlockedSendCode($userEmail,$genCode);
        }
}