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
            echo 'CRASH_CSRF';
            die();
        }
        if(!isset($_POST['prof_psico_currency']) || $_POST['prof_psico_currency'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_psico_pph']) || $_POST['prof_psico_pph'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_psico_paypalacc']) || $_POST['prof_psico_paypalacc'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($_POST['prof_psico_sessionnow'] != 1 && $_POST['prof_psico_sessionnow'] != 0)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_psico_description']) || $_POST['prof_psico_description'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_psico_type']) || $_POST['prof_psico_type'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_checkpassword']) || $_POST['prof_checkpassword'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!$core->validate('email',$_POST['prof_psico_paypalacc']))
        {
            echo 'FORM_ERROR';
            die();
        }

        if($_POST['prof_psico_currency'] != 'EUR' && $_POST['prof_psico_currency'] != 'USD' && $_POST['prof_psico_currency'] != 'GBP')
        {
            echo 'FORM_ERROR';
            die();
        }
        if($_POST['prof_psico_type'] != 'psico' && $_POST['prof_psico_type'] != 'coach')
        {
            echo 'FORM_ERROR';
            die();
        }
        
        if(!is_numeric($_POST['prof_psico_pph']))
        {
            echo 'FORM_ERROR';
            die();
        }
        if(strlen($_POST['prof_psico_description']) < config('profile.description.minlength'))
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_psico_collegenumber']))
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_psico_specpatid']) || $_POST['prof_psico_specpatid'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if(!isset($_POST['prof_psico_sessionnow']) || $_POST['prof_psico_sessionnow'] == null)
        {
            echo 'FORM_ERROR';
            die();
        }
        if($db->query('SELECT id FROM patologies WHERE id="'.$core->decrypt($_POST['prof_psico_specpatid']).'"')->num_rows == 0)
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
                echo 'FORM_ERROR16';
                die();
            }
        }
        $db->query('UPDATE users_psicos SET specpatid='.$core->decrypt($_POST['prof_psico_specpatid']).',collegenumber="'.$_POST['prof_psico_collegenumber'].'",pphCoin="'.$_POST['prof_psico_currency'].'",pph="'.$_POST['prof_psico_pph'].'",paypalAccount="'.$_POST['prof_psico_paypalacc'].'",description="'.$_POST['prof_psico_description'].'",sessionNowEnabled='.$_POST['prof_psico_sessionnow'].' WHERE user_id='.USER_ID) or die($db->error);
        $db->query('UPDATE users SET type="'.$_POST['prof_psico_type'].'" WHERE id='.USER_ID) or die($db->error);
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