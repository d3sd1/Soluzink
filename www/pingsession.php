<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN)
    {
        $reminders_asuser = $db->query('SELECT up.timestamp, u.name,u.surnames, u.photo FROM users_psicos_sessions up JOIN users u ON up.psico_id=u.id WHERE timestamp+sessionlengthmins*60 > '.time().' AND user_id='.USER_ID.' ORDER BY timestamp DESC LIMIT 1')->fetch_array();
        $reminders_aspsico =  $db->query('SELECT up.timestamp, u.name,u.surnames, u.photo FROM users_psicos_sessions up JOIN users u ON up.psico_id=u.id WHERE timestamp+sessionlengthmins*60 > '.time().' AND psico_id='.USER_ID.' ORDER BY timestamp DESC LIMIT 1')->fetch_array();
        if($reminders_asuser['timestamp'] > $reminders_aspsico['timestamp'])
        {
            $type = 'CLIENT';
            $reminders = $reminders_asuser;
        }
        else if($reminders_asuser['timestamp'] < $reminders_aspsico['timestamp'])
        {
            $type = 'PROF';
            $reminders = $reminders_aspsico;
        }
        else
        {
            $type = 'CLIENT';
            $reminders = $reminders_asuser;
        }
        if(isset($reminders) && ($reminders['timestamp']-time())/60 <= config('remindersession.whenminsleft'))
        {
            if($reminders['timestamp']-time() < 0)
            {
                $justnow = 'true';
                $timeLeft = $lang['home']['notify']['reminder']['justnow'];
            }
            else
            {
                $justnow = 'false';
                $timeLeft = $reminders['timestamp']-time();
            }
            echo $type.'|||'.$reminders['name'].' '.$reminders['surnames'].'|||'.$reminders['photo'].'|||'.lcfirst($core->timeLeft($reminders['timestamp'])).'|||'.$timeLeft.'|||'.$justnow;
            die();
        }
        else
        {
            echo 'NO_REMINDERS';
            die();
        }
    }
}