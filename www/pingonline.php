<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN)
    {
        $db->query('UPDATE users SET onlineLastPing='.time().',online=1 WHERE id='.USER_ID);
    }
}