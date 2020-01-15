<?php
require('kernel/core.php');
if(USER_LOGGED_IN)
{
	$core->session_destroy('soluzinkUserLoginCode');
	$core->session_destroy('soluzinkUserEmail');
	if(!isset($_GET['redirTo']))
	{
            header('Location: '.URL.'/#/Logout');
	}
	else
	{
            header('Location: '.URL.'/'.$_GET['redirTo']);
	}
}
else
{
    header('Location: '.URL.'/start?logout=success');
}
