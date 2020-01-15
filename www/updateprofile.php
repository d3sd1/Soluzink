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
        if(!isset($_POST['prof_email']) || $_POST['prof_email'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!$core->validate('email',$_POST['prof_email']))
        {
            echo 'ERROR_EMAIL_NOTVALID';
            die();
        }
        if($db->query('SELECT id FROM users WHERE email="'.$_POST['prof_email'].'"')->num_rows > 0 && $_POST['prof_email'] != USER_EMAIL)
        {
            echo 'ERROR_EMAIL_ALREADYREGISTERED';
            die();
        }

        if(!isset($_POST['prof_newsletter']) || $_POST['prof_newsletter'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if($_POST['prof_newsletter'] != 0 && $_POST['prof_newsletter'] != 1)
        {
            echo 'ERROR_NEWSLETTER_NOTVALID';
            die();
        }

        if(!isset($_POST['prof_weekstartday']) || $_POST['prof_weekstartday'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if($_POST['prof_weekstartday'] != 'S' && $_POST['prof_weekstartday'] != 'M')
        {
            echo 'ERROR_WEEKSTARTDAY_NOTVALID';
            die();
        }


        if(!isset($_POST['prof_currency']) || $_POST['prof_currency'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if($_POST['prof_currency'] != 'USD' && $_POST['prof_currency'] != 'EUR' && $_POST['prof_currency'] != 'GBP')
        {
            echo 'ERROR_CURRENCY_NOTVALID';
            die();
        }

        if(!isset($_POST['prof_checkpassword']) || $_POST['prof_checkpassword'] == null)
        {
            echo 'ERROR_NODATA';
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
                echo 'PWD_WRONG';
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