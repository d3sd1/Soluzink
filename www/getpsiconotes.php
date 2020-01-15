<?php
require('kernel/core.php');
if($core->safeAjaxCall() && USER_LOGGED_IN && !USER_TYPE_CLIENT)
{
    $sessionId = $_POST['sessionId'];
    $query = $db->query('SELECT note FROM users_psicos_notes WHERE sessionid="'.$sessionId.'" AND pid='.USER_ID);
    if($query->num_rows > 0)
    {
        echo $query->fetch_row()[0];
    }
}
else
{
    echo false;
    die();
}