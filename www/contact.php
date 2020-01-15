<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN)
    {
            if($db->query('SELECT id FROM contacts WHERE dataId='.USER_ID.' AND timestamp > '.(time()-config('contact.min.interval')).'')->num_rows > 0)
            {
                    echo 'CRASH_ALREADYSENT';
                    die();
            }
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

    if(@$_POST['contactName'] == null  || !@isset($_POST['contactName']))
    {
        echo 'NAME_NOTSET';
        die();
    }
    if(@$_POST['contactEmail'] == null || !@isset($_POST['contactEmail']))
    {
        echo 'EMAIL_NOTSET';
        die();
    }
    if(@$_POST['contactPhone'] == null || !@isset($_POST['contactPhone']))
    {
        echo 'PHONE_NOTSET';
        die();
    }
    if(@$_POST['contactMessage'] == null || !@isset($_POST['contactMessage']))
    {
        echo 'MESSAGE_NOTSET';
        die();
    }
    if(@$_POST['contactCaptcha'] == null || !@isset($_POST['contactCaptcha']))
    {
        echo 'CAPTCHA_NOTSET';
        die();
    }
    /* VALIDATE */
    if($core->containsNumbers($_POST['contactName']))
    {
        echo 'NAME_NOTVALID';
        die();
    }
    if(!$core->validate('email',$_POST['contactEmail']))
    {
        echo 'EMAIL_NOTVALID';
        die();
    }
    if(!$core->validate('telephone',$_POST['contactPhone']))
    {
        echo 'PHONE_NOTVALID';
        die();
    }
    if(strlen($_POST['contactMessage']) < config('contact.message.minlength') || strlen($_POST['contactMessage']) > config('contact.message.maxlength'))
    {
        echo 'MESSAGE_NOTVALID';
        die();
    }
    if($_POST['contactCaptcha'] != $core->session_getValue('soluzinkCaptcha'))
    {
        echo 'CAPTCHA_NOTVALID';
        die();
    }

    if(USER_LOGGED_IN)
    {
            if(USER_PHONE == 0)
            {
                    $db->query('UPDATE users SET phone='.$_POST['contactPhone'].' WHERE id='.USER_ID);
            }
            $db->query('INSERT INTO contacts (dataId, dataType, timestamp, message, solved, lang) VALUES ('.USER_ID.',"userId",'.time().',"'.$_POST['contactMessage'].'",0,"'.USER_LANG.'")');
    }
    else
    {
            if($db->query('SELECT id FROM contactData WHERE email="'.$_POST['contactEmail'].'"')->num_rows == 0)
            {
                    $db->query('INSERT INTO contactData (name,email,phone,ip) VALUES ("'.$_POST['contactName'].'","'.$_POST['contactEmail'].'","'.$_POST['contactPhone'].'",INET_ATON(\''.USER_IP.'\'))');
            }
            else
            {
                    $db->query('UPDATE contactData SET name="'.$_POST['contactName'].'",phone="'.$_POST['contactPhone'].'" WHERE email="'.$_POST['contactEmail'].'"');
            }
            $contactDataId = $db->insert_id;
            $db->query('INSERT INTO contacts (dataId, dataType, timestamp, message, solved) VALUES ('.$contactDataId.',"contactId",'.time().',"'.$_POST['contactMessage'].'",0)');
    }
    echo 'CONTACT_SUCCESS';
}