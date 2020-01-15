<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN)
    {
        if($core->checkTimezone($_POST['timezone']))
        {
            $db->query('UPDATE users SET geoTimeZone="'.$_POST['timezone'].'" WHERE id='.USER_ID);
        }
    }
    else
    {
        $core->session_setNew('timezone', $_POST['timezone']);
    }
}