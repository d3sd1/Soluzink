<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN)
    {
        echo 'CRASH_ALREADYLOGGED';
        die();
    }
    try
    {
        $core->checkCSRFToken('POST');
    }
    catch(Exception $e)
    {
        echo 'CRASH_CSRF';
        die();
    }
    if(@$_POST['recoverEmail'] == null  || !@isset($_POST['recoverEmail']))
    {
        echo 'EMAIL_NOTSET';
        die();
    }
    if($db->query('SELECT id FROM users WHERE email="'.$_POST['recoverEmail'].'"')->num_rows == 0)
    {
        echo 'EMAIL_NOTFOUND';
        die();
    }
    $info = $db->query('SELECT u.name,u.surnames FROM users_recoverpass ur JOIN users u ON u.email=ur.email WHERE ur.timestamp+'.config('recover.attempts.interval').'>'.time().' AND ur.email="'.$_POST['recoverEmail'].'"');
    if($info->num_rows >= config('recover.attempts.max'))
    {
        echo 'CRASH_TOOMANYATTEMPTS';
        die();
    }
    $nameData = $info->fetch_row();
    $code = $core->generateRecoveraccCode();
    $db->query('INSERT INTO users_recoverpass (email,timestamp,ip,code) VALUES ("'.$_POST['recoverEmail'].'",'.time().',INET_ATON(\''.USER_IP.'\'),'.$code.')');
    $email->recoverPass($_POST['recoverEmail'],$nameData[0].' '.$nameData[1],$code.'|||'.$_POST['recoverEmail']);
    echo 'RECOVER_SUCCESS';
}