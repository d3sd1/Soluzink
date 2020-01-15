<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN && isset($_POST['checkPin']) && $_POST['checkPin'] != null && $db->query('SELECT profupdatecode FROM users WHERE id='.USER_ID)->fetch_row()[0] == $_POST['checkPin'])
    {
        $db->query('DELETE FROM users_recoveracc_code WHERE uid='.USER_ID);
        $db->query('UPDATE users SET wrongpasstimes=0,wrongunblockcodetimes=0,profupdatecode=0 WHERE id='.USER_ID);
        $email->accountGotUpdated(USER_EMAIL);
        try
        {
            $core->checkCSRFToken('POST');
        }
        catch(Exception $e)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_email']) || $_POST['prof_email'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!$core->validate('email',$_POST['prof_email']))
        {
            echo 'FORM_ERROR';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.$_POST['prof_email'].'"')->num_rows > 0 && $_POST['prof_email'] != USER_EMAIL)
        {
            echo 'FORM_ERROR';
            die();
        }

        if(!isset($_POST['prof_newsletter']) || $_POST['prof_newsletter'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($_POST['prof_newsletter'] != 0 && $_POST['prof_newsletter'] != 1)
        {
            echo 'FORM_ERROR';
            die();
        }

        if(!isset($_POST['prof_weekstartday']) || $_POST['prof_weekstartday'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($_POST['prof_weekstartday'] != 'S' && $_POST['prof_weekstartday'] != 'M')
        {
            echo 'FORM_ERROR';
            die();
        }


        if(!isset($_POST['prof_currency']) || $_POST['prof_currency'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($_POST['prof_currency'] != 'USD' && $_POST['prof_currency'] != 'EUR' && $_POST['prof_currency'] != 'GBP')
        {
            echo 'FORM_ERROR';
            die();
        }

        if(!isset($_POST['prof_checkpassword']) || $_POST['prof_checkpassword'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.USER_EMAIL.'" AND pwd="'.md5($core->crypt($_POST['prof_checkpassword'])).'"')->num_rows == 0)
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
        $db->query('UPDATE users SET email="'.$_POST['prof_email'].'",newsletter='.$_POST['prof_newsletter'].',weekStarts="'.$_POST['prof_weekstartday'].'",currency="'.$_POST['prof_currency'].'" WHERE id='.USER_ID);
        $email->accountGotUpdated(USER_EMAIL);
        echo 'SUCCESS';
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