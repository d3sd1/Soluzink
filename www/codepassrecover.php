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
    if(@$_POST['newPass'] == null  || !@isset($_POST['newPass']))
    {
        echo 'PASS_NOTSET';
        die();
    }
    if(@$_POST['newPass2'] == null  || !@isset($_POST['newPass2']))
    {
        echo 'PASS_NOTSET';
        die();
    }
    if(@$_POST['code'] == null  || !@isset($_POST['code']))
    {
        echo 'CODE_NOTSET';
        die();
    }
    if($_POST['newPass2'] != $_POST['newPass'])
    {
        echo 'PASS_NOT_MATCH';
        die();
    }
    $uinfo = $db->query('SELECT name, surnames, email, phone FROM users WHERE email="'.$_POST['email'].'"')->fetch_row();
    if(!$core->validate('password',$_POST['newPass'],array($uinfo[0],$uinfo[1],$uinfo[2],$uinfo[3])))
    {
        echo 'PASSWORD_NOTVALID';
        die();
    }
    if($db->query('SELECT code FROM users_recoverpass WHERE email="'.$_POST['email'].'" AND code='.$_POST['code'].' ORDER BY timestamp DESC LIMIT 1')->num_rows == 0)
    {
        echo 'CODE_NOTVALID';
        die();
    }
    $db->query('UPDATE users SET pwd="'.md5($core->crypt($_POST['newPass'])).'" WHERE email="'.$_POST['email'].'"');
    $email->recoverPassSuccess($_POST['email'],$uinfo[0].' '.$uinfo[1]);
    $db->query('DELETE FROM users_recoverpass WHERE email="'.$_POST['email'].'"');
    echo 'RECOVER_SUCCESS';
}