<?php
require('kernel/core.php');
header("Content-type:application/json");
if($core->safeAjaxCall() && isset($_POST['psicoCode']))
{
    $psicoCode = $core->decrypt($_POST['psicoCode']);
    if($psicoCode != '')
    {
        if($db->query('SELECT user_id FROM users_psicos_calendar WHERE user_id='.$psicoCode)->num_rows > 0)
        {
            $calendar = $core->getCalendar($core->decrypt($_POST['psicoCode']));
            if($calendar == 'NO_CALENDAR')
            {
                echo 'NO_CALENDAR';
                die();
            }
            else
            {
                echo $calendar;
                die();
            }
        }
        else
        {
            echo 'NO_CALENDAR';
            die();
        }
    }
}