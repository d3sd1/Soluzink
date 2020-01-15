<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN && isset($_POST['checkPin']) && $_POST['checkPin'] != null && $db->query('SELECT profupdatecode FROM users WHERE id='.USER_ID)->fetch_row()[0] == $_POST['checkPin'])
    {
        $db->query('DELETE FROM users_recoveracc_code WHERE uid='.USER_ID);
        $db->query('UPDATE users SET wrongpasstimes=0,wrongunblockcodetimes=0,profupdatecode=0 WHERE id='.USER_ID);
        try
        {
            $core->checkCSRFToken('POST');
        }
        catch(Exception $e)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['cpn_pass2']) || $_POST['cpn_pass2'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['cpn_pass1']) || $_POST['cpn_pass1'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['cpn_oldpass']) || $_POST['cpn_oldpass'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($_POST['cpn_pass1'] != $_POST['cpn_pass2'])
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!$core->validate('password',$_POST['cpn_pass1'],array(USER_NAME,USER_SURNAMES,USER_EMAIL,USER_PHONE)))
        {
            echo 'FORM_ERROR';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.USER_EMAIL.'" AND pwd="'.md5($core->crypt($_POST['cpn_pass1'])).'"')->num_rows > 0)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.USER_EMAIL.'" AND pwd="'.md5($core->crypt($_POST['cpn_oldpass'])).'"')->num_rows == 0)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.USER_EMAIL.'" AND pwd="'.md5($core->crypt($_POST['cpn_oldpass'])).'"')->num_rows == 0)
        {
            $db->query('UPDATE users SET wrongpasstimes=wrongpasstimes+1 WHERE email="'.USER_EMAIL.'"');
            if(config('profile.blockaccount.afterwrongpasstimes') <= $db->query('SELECT wrongpasstimes FROM users  WHERE email="'.USER_EMAIL.'"')->fetch_row()[0])
            {
                $core->blockAccount(USER_ID, USER_EMAIL);
                echo 'PWD_EXCEDED_LIMIT';
                die();
            }
            else
            {
                echo 'FORM_ERROR';
                die();
            }
        }
        $db->query('UPDATE users SET pwd="'.md5($core->crypt($_POST['cpn_pass1'])).'" WHERE id='.USER_ID);
        echo 'SUCCESS';
        $email->userProfileUpdatedPasswordSuccess(USER_EMAIL);
        die();
    }
    else
    {
        $db->query('UPDATE users SET wrongpasstimes=wrongpasstimes+1 WHERE email="'.USER_EMAIL.'"');
        if(config('profile.blockaccount.afterwrongpasstimes') <= $db->query('SELECT wrongpasstimes FROM users  WHERE email="'.USER_EMAIL.'"')->fetch_row()[0])
        {
            $core->blockAccount(USER_ID, USER_EMAIL);
            echo 'PWD_EXCEDED_LIMIT';
            die();
        }
        else
        {
            echo 'ERROR';
            die();
        }
    }
}