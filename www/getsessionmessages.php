<?php
require('kernel/core.php');
header("Content-type:application/json");
if($core->safeAjaxCall() && USER_LOGGED_IN)
{
    $messages = $db->query('SELECT content,sender FROM chat_messages WHERE sessionId="'.$_POST['sessionId'].'" ORDER BY timestamp ASC') or die($db->error);
    $messagesResponse = array();
    $count = 0;
    while($msg = $messages->fetch_array())
    {
        $messagesResponse[$count] = array();
        $messagesResponse[$count]['msg'] = $msg['content'];
        $messagesResponse[$count]['type'] = ($msg['sender'] == USER_ID ? 'selfuser':'otheruser');
        $count++;
    }
    echo json_encode($messagesResponse);
}
else
{
    echo json_encode(array('NOT_VALID'));
    die();
}