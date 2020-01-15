<?php
$logoutActive = true;
require('admin.php');
if(ADMIN_LOGGED_IN)
{
	$core->session_destroy('soluzinkAdminUser');
        if($core->session_isSet('soluzinkAdminUserLocked'))
	{
		$core->session_destroy('soluzinkAdminUserLocked');
	}
        if(isset($_GET['ref']) && $_GET['ref'] == 'accDisabled')
        {
            $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("ACCOUNT_SUSPENDED_LOGOUT_ERROR",INET_ATON(\''.USER_IP.'\'),"'.ADMIN_ID.'","'.time().'")');
        }
        else
        {
            $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("LOGOUT_SUCCESS",INET_ATON(\''.USER_IP.'\'),"'.ADMIN_ID.'","'.time().'")');
        }
	header('Location: '.URL.'/login?logout='.(isset($_GET['ref']) ? @$_GET['ref']:'success'));
        die();
}
else
{
	header('Location: '.URL.'/login?logout=error');
        die();
}