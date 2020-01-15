<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN)
    {
        echo 'CRASH_ALREADYLOGGED';
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
    if(!isset($_GET['type']))
    {
        $_GET['type'] = 'client';
    }
    if($_GET['type'] != 'psico' && $_GET['type'] != 'coach' && $_GET['type'] != 'client')
    {
        $_GET['type'] = 'client';
    }

    if(@$_POST['registerName'] == null  || !@isset($_POST['registerName']))
    {
        echo 'NAME_NOTSET';
        die();
    }
    if(@$_POST['registerSurnames'] == null  || !@isset($_POST['registerSurnames']))
    {
        echo 'SURNAMES_NOTSET';
        die();
    }
    if(@$_POST['registerEmail'] == null || !@isset($_POST['registerEmail']))
    {
        echo 'EMAIL_NOTSET';
        die();
    }
    if(@$_POST['registerPass'] == null || !@isset($_POST['registerPass']))
    {
        echo 'PASSWORD_NOTSET';
        die();
    }
    if(@$_POST['registerPassrep'] == null || !@isset($_POST['registerPassrep']))
    {
        echo 'PASSREP_NOTSET';
        die();
    }
    if(@$_POST['registerCaptcha'] == null || !@isset($_POST['registerCaptcha']))
    {
        echo 'CAPTCHA_NOTSET';
        die();
    }

    /* Attempts */
    if($db->query('SELECT id FROM attempts WHERE type="register" AND ip=INET_ATON(\''.USER_IP.'\')')->num_rows == 0)
    {
        $db->query('INSERT INTO attempts (attempts,ip,timestampExpires,type) VALUES (0,INET_ATON(\''.USER_IP.'\'),'.(time()+config('register.accountscreate.interval')).',"register")') or die($db->error);
    }

    $attempts = $db->query('SELECT attempts,timestampExpires FROM attempts WHERE type="register" AND ip=INET_ATON(\''.USER_IP.'\')')->fetch_row();
    if($attempts[1] < (time()+config('register.accountscreate.interval')) && $attempts[0] >= config('register.accountscreate.max'))
    {
            echo 'CRASH_TOOMANYATTEMPTS';
            die();
    }
    elseif($attempts[1] > (time()+config('register.accountscreate.interval')))
    {
            $db->query('UPDATE attempts SET attempts=0 AND timestampExpires="'.(time()+config('register.accountscreate.interval')).'" WHERE type="register" AND ip=INET_ATON(\''.USER_IP.'\')') or die($db->error);
    }

    /* VALIDATE */
    if($core->containsNumbers($_POST['registerName']))
    {
        echo 'NAME_NOTVALID';
        die();
    }
    if($core->containsNumbers($_POST['registerSurnames']))
    {
        echo 'SURNAMES_NOTVALID';
        die();
    }
    if(!$core->validate('email',$_POST['registerEmail']))
    {
        echo 'EMAIL_NOTVALID';
        die();
    }
    if($db->query('SELECT id FROM users WHERE email="'.$_POST['registerEmail'].'"')->num_rows > 0)
    {
        echo 'EMAIL_ALREADYREGISTERED';
        die();
    }
    if(!$core->validate('password',$_POST['registerPass'],array($_POST['registerName'],$_POST['registerSurnames'],$_POST['registerEmail'],$_POST['registerPhone'])))
    {
        echo 'PASSWORD_NOTVALID';
        die();
    }
    if($_POST['registerPass'] != $_POST['registerPassrep'])
    {
        echo 'PASSREP_NOTMATCH';
        die();
    }
    if($_POST['registerCaptcha'] != $core->session_getValue('soluzinkCaptcha'))
    {
        echo 'CAPTCHA_NOTVALID';
        die();
    }
    
    if((!@isset($_POST['registerPhone']) || $_POST['registerPhone'] == null) && $_GET['type'] == 'client')
    {
        $_POST['registerPhone'] = 0;
    }
    if((!@isset($_POST['registerPhone']) || $_POST['registerPhone'] == null) && ($_GET['type'] == 'psico' || $_GET['type'] == 'coach'))
    {
        echo 'PHONE_NEEDED';
        die();
    }
    
    $db->query('UPDATE attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') AND type="register"') or die($db->error); 
    $db->query('INSERT INTO users (name,surnames,email,pwd,phone,type,registerIp,dateRegistered) VALUES ("'.$_POST['registerName'].'","'.$_POST['registerSurnames'].'","'.$_POST['registerEmail'].'","'.md5($core->crypt($_POST['registerPass'])).'","'.$_POST['registerPhone'].'","'.$_GET['type'].'",INET_ATON(\''.USER_IP.'\'),"'.time().'")') or die($db->error);

    if($_GET['type'] == 'client')
    {
        $email->userRegisterWelcome($_POST['registerEmail'],$_POST['registerName'].' '.$_POST['registerSurnames']);
    }
    else
    {
        $email->psicoRegisterWelcome($_POST['registerEmail'],$_POST['registerName'].' '.$_POST['registerSurnames']);
        $psicoId = $db->query('SELECT id FROM users WHERE email="'.$_POST['registerEmail'].'"')->fetch_row()[0];
        $db->query('INTER INTO users_psicos (user_id,paypalAccount) VALUES ('.$psicoId.',"'.$_POST['registerEmail'].'")');
        $db->query('INTER INTO users_psicos_calendar (user_id,weekly_calendar,week_exceptions,maxdate) VALUES ('.$psicoId.',\'{"0": [],"1": [],"2": [],"3": [],"4": [],"5": [],"6": []}\',\'{"0": [],"1": [],"2": [],"3": [],"4": [],"5": [],"6": []}\',"'.date('Y-m-d').'")');
    }
    echo 'REGISTER_SUCCESS';
}