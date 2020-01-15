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
if($db->query('SELECT id FROM admin_attempts WHERE type="forgot" AND ip=INET_ATON(\''.USER_IP.'\')')->num_rows == 0)
{
	$db->query('INSERT INTO admin_attempts (attempts,ip,timestampExpires,type) VALUES (0,INET_ATON(\''.USER_IP.'\'),'.(time()+config)('admin.loginattempts.interval').',"forgot")') or die($db->error);
}
else
{
	$preAttempts = $db->query('SELECT attempts,timestampExpires FROM admin_attempts WHERE type="forgot" AND ip=INET_ATON(\''.USER_IP.'\')')->fetch_row();
	if($preAttempts[1] < time())
	{
		$db->query('UPDATE admin_attempts SET attempts=0 WHERE ip=INET_ATON(\''.USER_IP.'\') WHERE type="forgot"') or die($db->error);
	}
	elseif($preAttempts[0] > config('admin.login.maxattempts'))
	{
		echo 'ERROR_BOT|GET_FUCKED';
		die();
	}
}
$attemtps = $db->query('SELECT attempts FROM admin_attempts WHERE type="forgot" AND ip=INET_ATON(\''.USER_IP.'\')')->fetch_row()[0];
if(!isset($_POST['forgotAdminEmail']) or @$_POST['forgotAdminEmail'] == null)
{
	$db->query('UPDATE admin_attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') WHERE type="forgot"') or die($db->error);
	echo 'ERROR_NOTSEND|'.($attemtps+1);
	die();
}
if($db->query('SELECT id FROM admin_users WHERE user="'.$_POST['forgotAdminEmail'].'"')->num_rows == 0)
{
	$db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("FORGOT_FAILED",INET_ATON(\''.USER_IP.'\'),(SELECT id FROM admin_users WHERE email="'.$_POST['forgotAdminEmail'].'"),"'.time().'")') or die($db->error);
	$db->query('UPDATE admin_attempts SET attempts=attempts+1 WHERE ip=INET_ATON(\''.USER_IP.'\') WHERE type="forgot"') or die($db->error);
	echo 'ERROR_NOTSEND|'.($attemtps+1);
	die();
}
$db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("FORGOT_SUCCESS",INET_ATON(\''.USER_IP.'\'),(SELECT id FROM admin_users WHERE email="'.$_POST['forgotAdminEmail'].'"),"'.time().'")');
$db->query('INSERT INTO admin_forgotten (email,ip,timestamp) VALUES ("'.$_POST['forgotAdminEmail'].'",INET_ATON(\''.USER_IP.'\'),'.time().')');
echo 'FORGOT_SUCCESS|SUCCESS';