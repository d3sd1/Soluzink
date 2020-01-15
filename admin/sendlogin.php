<?php
require('admin.php');
if(!isset($_POST['g-recaptcha-response']) or @$_POST['g-recaptcha-response'] == null)
{
	echo 'ERROR_CAPTCHA|'.$alang['login.attempt.captchanull'];
	die();
}
$captchaResponse = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.config('recaptcha.secretkey').'&response='.$_POST['g-recaptcha-response'].'&remoteip='.USER_IP), true);
try
{
    $core->checkCSRFToken('POST');
}
catch(Exception $e)
{
    echo 'CSRF_DETECTED|GET_FUCKED';
    die();
}
if(!$captchaResponse['success'])
{
	echo 'ERROR_CAPTCHA|'.$alang['login.attempt.captchanull'];
	die();
}
if($db->query('SELECT id FROM admin_attempts WHERE type="login" AND ip=INET_ATON(\''.USER_IP.'\')')->num_rows === 0)
{
	$db->query('INSERT INTO admin_attempts (attempts,ip,timestampExpires,type) VALUES (0,INET_ATON(\''.USER_IP.'\'),'.(time()+config('admin.loginattempts.interval')).',"login")') or die($db->error);
}
else
{
	$preAttempts = $db->query('SELECT attempts,timestampExpires FROM admin_attempts WHERE type="login" AND ip=INET_ATON(\''.USER_IP.'\')')->fetch_row();
	if($preAttempts[1] < (time()+config('admin.loginattempts.interval')) && $preAttempts[0] > config('admin.login.maxattempts'))
	{
            echo 'ERROR_BOT|GET_FUCKED';
            die();
	}
	elseif($preAttempts[1] > (time()+config('admin.loginattempts.interval')))
	{
            $db->query('UPDATE admin_attempts SET attempts=0 AND timestampExpires="'.(time()+config('admin.loginattempts.interval')).'" WHERE type="login" AND ip=INET_ATON(\''.USER_IP.'\')') or die($db->error);
	}
}
$attemtps = $db->query('SELECT attempts FROM admin_attempts WHERE type="login" AND ip=INET_ATON(\''.USER_IP.'\')')->fetch_row()[0];
if(!isset($_POST['loginAdminUser']) or @$_POST['loginAdminUser'] == null)
{
	$db->query('UPDATE admin_attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') AND type="login"') or die($db->error);
	echo 'ERROR_USER|'.($attemtps+1);
	die();
}
if($db->query('SELECT id FROM admin_users WHERE email="'.$_POST['loginAdminUser'].'"')->num_rows == 0)
{
	$db->query('UPDATE admin_attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') AND type="login"') or die($db->error);
	echo 'ERROR_USER|'.($attemtps+1);
	die();
}
if(!isset($_POST['loginAdminPass']) or @$_POST['loginAdminPass'] == null)
{
	$db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("LOGIN_FAILED",INET_ATON(\''.USER_IP.'\'),(SELECT id FROM admin_users WHERE email="'.$_POST['loginAdminUser'].'"),"'.time().'")');
	$db->query('UPDATE admin_attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') AND type="login"') or die($db->error);
	echo 'ERROR_PWD|'.($attemtps+1);
	die();
}
if($db->query('SELECT id FROM admin_users WHERE email="'.$_POST['loginAdminUser'].'" AND pwd="'.md5($core->crypt($_POST['loginAdminPass'])).'"')->num_rows == 0)
{
	$db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("LOGIN_FAILED",INET_ATON(\''.USER_IP.'\'),(SELECT id FROM admin_users WHERE email="'.$_POST['loginAdminUser'].'"),"'.time().'")');
	$db->query('UPDATE admin_attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') AND type="login"') or die($db->error);
	echo 'ERROR_PWD|'.($attemtps+1);
	die();
}


require(subfolder.'kernel/class/ip2location/geolocator.php');
$geoLocation = new GeoLocation();
$geoLoc = $geoLocation->full(USER_IP,subfolder);
$db->query('UPDATE admin_users SET geoCountry="'.$geoLoc['countryCode'].'",geoCity="'.mb_convert_encoding($geoLoc['cityName'], 'UTF-8', 'ISO-8859-1').'",geoPostalCode="'.$geoLoc['zipCode'].'",geoLat="'.@$geoLoc['latitude'].'",geoLong="'.@$geoLoc['longitude'].'",lang="'.USER_LANG.'",lastIp=INET_ATON(\''.USER_IP.'\'),lastLogin="'.time().'" WHERE email="'.$_POST['loginAdminUser'].'"') or die($db->error);
$core->session_setNew('soluzinkAdminUser',$_POST['loginAdminUser']);
if($core->session_isSet('soluzinkAdminUserLocked'))
{
    $core->session_destroy('soluzinkAdminUserLocked');
}
$db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("LOGIN_SUCCESS",INET_ATON(\''.USER_IP.'\'),(SELECT id FROM admin_users WHERE email="'.$_POST['loginAdminUser'].'"),"'.time().'")');
echo 'LOGIN_SUCCESS|SUCCESS';