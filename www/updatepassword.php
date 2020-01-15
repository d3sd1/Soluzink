<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN)
    {
        try
        {
            $core->checkCSRFToken('POST');
        }
        catch(Exception $e)
        {
            echo 'CRASH_CSRF';
            die();
        }
        if(!isset($_POST['cpn_pass1']) || $_POST['cpn_pass1'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['cpn_pass2']) || $_POST['cpn_pass2'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['cpn_oldpass']) || $_POST['cpn_oldpass'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if($_POST['cpn_pass1'] != $_POST['cpn_pass2'])
        {
            echo 'ERROR_NOTMATCH';
            die();
        }
        if(!$core->validate('password',$_POST['cpn_pass1'],array(USER_NAME,USER_SURNAMES,USER_EMAIL,USER_PHONE)))
        {
            echo 'PASSWORD_NOTVALID';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.USER_EMAIL.'" AND pwd="'.md5($core->crypt($_POST['cpn_pass1'])).'"')->num_rows > 0)
        {
            echo 'ERROR_PASSWORD_ISSAME';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.USER_EMAIL.'" AND pwd="'.md5($core->crypt($_POST['cpn_oldpass'])).'"')->num_rows == 0)
        {
            $db->query('UPDATE users SET wrongpasstimes=wrongpasstimes+1 WHERE email="'.USER_EMAIL.'"');
            if(config('profile.blockaccount.afterwrongpasstimes') <= $db->query('SELECT wrongpasstimes FROM users WHERE email="'.USER_EMAIL.'"')->fetch_row()[0])
            {
                $core->blockAccount(USER_ID, USER_EMAIL);
                echo 'PWD_EXCEDED_LIMIT';
                die();
            }
            else
            {
                echo 'ERROR_OLDPASS';
                die();
            }
        }
        /* SUCCESS, RESET */
        $genCode = $core->generateRecoveraccCode();
        $email->accountUpdateProfile(USER_EMAIL,$genCode);
        $db->query('UPDATE users SET profupdatecode='.$genCode.' WHERE id='.USER_ID);
        echo 'CHANGES_SUCCESS';
    }
    else
    {
        echo 'CRASH_NOTLOGGED';
        die();
    }
}