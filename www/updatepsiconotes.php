<?php
require('kernel/core.php');
if($core->safeAjaxCall() && USER_LOGGED_IN && !USER_TYPE_CLIENT)
{
    $newNote = $_POST['newVal'];
    $sessionId = $_POST['sessionId'];
    if($db->query('SELECT pid FROM users_psicos_notes WHERE sessionid="'.$sessionId.'" AND pid='.USER_ID)->num_rows == 0)
    {
        $db->query('INSERT INTO users_psicos_notes (pid,sessionid,lastTimeUpdated,note) VALUES ('.USER_ID.',"'.$sessionId.'",'.time().',"'.$newNote.'")');
    }
    else
    {
        $db->query('UPDATE users_psicos_notes SET note="'.$newNote.'",lastTimeUpdated='.time().' WHERE sessionid="'.$sessionId.'" AND pid='.USER_ID);
    }
}
else
{
    echo 'NOT_VALID';
    die();
}