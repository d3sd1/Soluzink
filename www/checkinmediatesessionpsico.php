<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(isset($_POST['action']) && !USER_TYPE_CLIENT)
    {
        if($_POST['action'] == 'check')
        {
            $query = $db->query("SELECT id FROM users_psicos_sessions_inmediate WHERE pid=".USER_ID." AND timestamp>".(time-600)." LIMIT 1");
            if($query->num_rows > 0)
            {
                echo $query->fetch_row()[0];
            }
        }
        elseif($_POST['action'] == 'answer')
        {
            $db->query("UPDATE users_psicos_sessions_inmediate SET accepted=1 WHERE id=".$_POST['sessid']);
        }
    }
    else
    {
        echo "ERROR";
    }
}