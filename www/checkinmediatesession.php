<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(isset($_POST['newid']))
    {
        if(isset($_POST['pid']))
        {
            $pid = $core->decrypt($_POST['pid']);
            if($pid != null && $pid != '' && USER_LOGGED_IN)
            {
                $db->query("INSERT INTO users_psicos_sessions_inmediate (uid,pid,timestamp) VALUES (".USER_ID.",".$pid.",".time().")") or die($db->error);
                echo $core->crypt($db->insert_id);
            }
            else
            {
                echo "ERROR";
            }
        }
        else
        {
            echo "ERROR";
        }
    }
    elseif(isset($_POST['checkid']))
    {
        $sessid = $core->decrypt($_POST['sessid']);
        if($sessid != null && $sessid != '' && USER_LOGGED_IN)
        {
            if($db->query("SELECT accepted FROM users_psicos_sessions_inmediate WHERE id=".$sessid)->fetch_row()[0] == 1)
            {
                echo 'ACCEPTED';
            }
        }
        else
        {
            echo "ERROR";
        }
    }
}