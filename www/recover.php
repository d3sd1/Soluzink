<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(!USER_LOGGED_IN || !USER_IS_BLOCKED)
    {
        echo 'CRASH_NOTLOGGED';
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
    if(@$_POST['recoveraccCode'] == null  || !@isset($_POST['recoveraccCode']))
    {
        echo 'CODE_NOTSET';
        die();
    }
    if($db->query('SELECT wrongunblockcodetimes FROM users WHERE id='.USER_ID)->fetch_row()[0] >= config('profile.blockaccount.afterwrongcodetimes'))
    {
        $email->accountGotBlockedAtAll(USER_EMAIL);
        echo 'CRASH_TOOMANYATTEMPTS';
        die();
    }
    $queryCode = $db->query('SELECT seccode FROM users_recoveracc_code WHERE uid='.USER_ID);
    if($queryCode->num_rows > 0 && $_POST['recoveraccCode'] != $queryCode->fetch_row()[0])
    {
        $db->query('UPDATE users SET wrongunblockcodetimes=wrongunblockcodetimes+1 WHERE id='.USER_ID);
        echo 'CODE_WRONG';
        die();
    }
    if($queryCode->num_rows == 0)
    {
        echo 'INTERNAL_ERROR';
        die();
    }
    $db->query('DELETE FROM users_recoveracc_code WHERE uid='.USER_ID);
    $db->query('UPDATE users SET wrongpasstimes=0,wrongunblockcodetimes=0 WHERE id='.USER_ID);
    $email->accountGotUnblocked(USER_EMAIL);
    echo 'RECOVER_SUCCESS';
}