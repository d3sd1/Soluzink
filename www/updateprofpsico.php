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
        if(!isset($_POST['prof_psico_currency']) || $_POST['prof_psico_currency'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_psico_pph']) || $_POST['prof_psico_pph'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_psico_sessionnow']) || $_POST['prof_psico_sessionnow'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_psico_paypalacc']) || $_POST['prof_psico_paypalacc'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_psico_description']) || $_POST['prof_psico_description'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_psico_type']) || $_POST['prof_psico_type'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_checkpassword']) || $_POST['prof_checkpassword'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_psico_collegenumber']))
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!isset($_POST['prof_psico_specpatid']) || $_POST['prof_psico_specpatid'] == null)
        {
            echo 'ERROR_NODATA';
            die();
        }
        if(!$core->validate('email',$_POST['prof_psico_paypalacc']))
        {
            echo 'ERROR_EMAIL_NOTVALID';
            die();
        }
        if($db->query('SELECT id FROM patologies WHERE id="'.$core->decrypt($_POST['prof_psico_specpatid']).'"')->num_rows == 0)
        {
            echo 'ERROR_PAT_NOTVALID';
            die();
        }
        if($_POST['prof_psico_currency'] != 'EUR' && $_POST['prof_psico_currency'] != 'USD' && $_POST['prof_psico_currency'] != 'GBP')
        {
            echo 'ERROR_CURRENCY_NOTVALID';
            die();
        }
        if($_POST['prof_psico_type'] != 'psico' && $_POST['prof_psico_type'] != 'coach')
        {
            echo 'ERROR_TYPE_NOTVALID';
            die();
        }
        if($_POST['prof_psico_sessionnow'] != 1 && $_POST['prof_psico_sessionnow'] != 0)
        {
            echo 'ERROR_SESSNOW_NOTVALID';
            die();
        }
        if(!is_numeric($_POST['prof_psico_pph']))
        {
            echo 'ERROR_PPH';
            die();
        }
        if(strlen($_POST['prof_psico_description']) < config('profile.description.minlength'))
        {
            echo 'ERROR_DESC';
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