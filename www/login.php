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
    if(@$_POST['loginEmail'] == null  || !@isset($_POST['loginEmail']))
    {
        echo 'EMAIL_NOTSET';
        die();
    }
    if(@$_POST['loginPwd'] == null || !@isset($_POST['loginPwd']))
    {
        echo 'PWD_NOTSET';
        die();
    }

    /* Attempts */
    if($db->query('SELECT id FROM attempts WHERE type="login" AND ip=INET_ATON(\''.USER_IP.'\')')->num_rows == 0)
    {
        $db->query('INSERT INTO attempts (attempts,ip,timestampExpires,type) VALUES (0,INET_ATON(\''.USER_IP.'\'),'.(time()+config('login.attempts.interval')).',"login")') or die($db->error);
    }

    $attempts = $db->query('SELECT attempts,timestampExpires FROM attempts WHERE type="login" AND ip=INET_ATON(\''.USER_IP.'\')')->fetch_row();
    if($attempts[1] < (time()+config('login.attempts.interval')) && $attempts[0] > config('login.attempts.max'))
    {
            echo 'CRASH_TOOMANYATTEMPTS';
            die();
    }
    elseif($attempts[1] > (time()+config('login.attempts.interval')))
    {
            $db->query('UPDATE attempts SET attempts=0 AND timestampExpires="'.(time()+config('login.attempts.interval')).'" WHERE type="login" AND ip=INET_ATON(\''.USER_IP.'\')') or die($db->error);
    }

    /* Login */
    if($db->query('SELECT id FROM users WHERE email="'.$_POST['loginEmail'].'"')->num_rows == 0)
    {
            $db->query('UPDATE attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') AND type="login"') or die($db->error);
            echo 'EMAIL_NOTFOUND';
            die();
    }
    if($db->query('SELECT id FROM users WHERE email="'.$_POST['loginEmail'].'" AND pwd="'.md5($core->crypt($_POST['loginPwd'])).'"')->num_rows == 0)
    {
            $db->query('UPDATE attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') AND type="login"') or die($db->error);
            echo 'PWD_WRONG';
            die();
    }
    
    if($db->query('SELECT wrongunblockcodetimes FROM users WHERE email="'.$_POST['loginEmail'].'"')->fetch_row()[0] >= config('profile.blockaccount.afterwrongcodetimes'))
    {
        echo 'CRASH_ACCOUNT_BLOCKED';
        die();
    }
    
    if($db->query('SELECT banned FROM users WHERE email="'.$_POST['loginEmail'].'"')->fetch_row()[0] == 1)
    {
        echo 'CRASH_ACCOUNT_BANNED';
        die();
    }
    
    if($db->query('SELECT INET_NTOA(lastIp) FROM users WHERE email="'.$_POST['loginEmail'].'"')->fetch_row()[0] != USER_IP)
    {
        $email->userLoginAdvisorAnotherDevice($_POST['loginEmail'],$db->query('SELECT name,surnames FROM users WHERE email="'.$_POST['loginEmail'].'"')->fetch_row()[0]);
    }

    require('kernel/class/ip2location/geolocator.php');
    $geoLocation = new GeoLocation();
    $geoLoc = $geoLocation->full(USER_IP);

    $loginCode = md5($core->crypt(microtime()));
    $db->query('UPDATE users SET geoCountry="'.$geoLoc['countryCode'].'",geoCity="'.mb_convert_encoding($geoLoc['cityName'], 'UTF-8', 'ISO-8859-1').'",geoPostalCode="'.$geoLoc['zipCode'].'",geoLat="'.@$geoLoc['latitude'].'",geoLong="'.@$geoLoc['longitude'].'",lang="'.USER_LANG.'",lastIp=INET_ATON(\''.USER_IP.'\'),dateLastLogin="'.time().'",loginID="'.$loginCode.'",sessioninsecurerecent=0 WHERE email="'.$_POST['loginEmail'].'"') or die($db->error);
    $core->session_setNew('soluzinkUserLoginCode',$loginCode);
    $core->session_setNew('soluzinkUserEmail',$_POST['loginEmail']);
    echo 'LOGIN_SUCCESS';
}