<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN && !USER_TYPE_CLIENT)
    {
        if(!isset($_POST['maxdate']) || $_POST['maxdate'] == null)
        {
            echo 'ERROR_NODATA_MAXDATE';
            die();
        }

        if(!isset($_POST['days']) || $_POST['days'] == null)
        {
            echo 'ERROR_NODATA_DAYS';
            die();
        }
        if((isset($_POST['weeklyexceptions']) && !is_array($_POST['weeklyexceptions'])) || !is_array($_POST['days']) || !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_POST['maxdate']))
        {
            echo 'ERROR_DATA_INVALID';
            die();
        }
        $i = 0;
        $finalI;
        $finalA;
        $sessionsMorning = 0;
        $sessionsAfternoon = 0;
        $sessionsNight = 0;
        foreach($_POST['days'] as $weekday => $weekdata)
        {
            $a = 0;
            if(is_array($weekdata))
            {
                foreach($weekdata as $data)
                {
                    $lengthInfo = explode('--',$data);
                    $timeInfo = explode('.',$lengthInfo[0]);

                    $length = $lengthInfo[1];
                    $hour = $timeInfo[0];
                    $minutes = $timeInfo[1];
                    $estimation = $hour*60+$minutes+$length;
                    
                    /* Check availability */
                    if($hour < 8 && $hour >= 0)
                    {
                        $sessionsMorning = 1;
                    }
                    else if($hour < 16 && $hour >= 8)
                    {
                        $sessionsAfternoon = 1;
                    }
                    else if($hour <= 23 && $hour >= 16)
                    {
                        $sessionsNight = 1;
                    }
                    /* Next estimation */
                    if(array_key_exists($a+1,$weekdata))
                    {
                        if(count($weekdata) > 1 && $a != count($weekdata)-1)
                        {
                            $aa = 0;
                            foreach($weekdata as $val)
                            {
                                if($aa > $a)
                                {
                                    $nextDayData = $weekdata[$aa];
                                    $finalA = $aa;
                                    $finalI = $i;
                                    break;
                                }
                                $aa++;
                            }
                        }
                        else
                        {
                            $nextDayData = $weekdata[$a+1];
                            $finalA = $a;
                            $finalI = $i;
                        }
                    }
                    else
                    {
                        if(array_key_exists($i+1,$_POST['days']))
                        {
                            if(count($_POST['days'][$i+1]) > 1)
                            {
                                if($a == 23 && explode('.',explode('--',$_POST['days'][$i+1][0])[0]) == '00')
                                {
                                    
                                $nextDayData = $_POST['days'][$i+1][0];
                                $finalA = 0;
                                $finalI = $i+1;
                                }
                                else
                                {
                                    $nextDayData = null;
                                }
                            }
                            elseif(count($_POST['days'][$i+1]) == 0)
                            {
                                $nextDayData = null;
                            }
                            else
                            {
                                $nextDayData = $_POST['days'][$i+1][$a+1];
                                $finalA = $a;
                                $finalI = $i;
                            }
                        }
                        else
                        {
                            if(array_key_exists(0,$_POST['days']) && count($_POST['days'][0]) > 0)
                            {
                                if($a == 23 && $i == 6)
                                {
                                    $nextDayData = '00.00--60';
                                    $finalA = 0;
                                    $finalI = 0;
                                }
                                else
                                {
                                    $nextDayData = null;
                                }
                            }
                            else
                            {
                                $nextDayData = null;
                            }
                        }
                    }
                    if(isset($nextDayData) && $nextDayData != null)
                    {
                        $nextLengthInfo = explode('--',$nextDayData);
                        $nextTimeInfo = explode('.',$nextLengthInfo[0]);

                        $nextHour = $nextTimeInfo[0];
                        $nextMinutes = $nextTimeInfo[1];
                        $nextEstimation = $nextHour*60+$nextMinutes;
                    }
                    else
                    {
                        $nextEstimation = $estimation+1;
                    }
                    if($estimation > $nextEstimation)
                    {
                        echo 'ERROR_DAY_BIGGER_THAN_NEXT|||'.$lang['CORE']['days'][$finalI].' '.$lang['home']['profile']['calendar']['error']['on'].' '.$_POST['days'][$finalI][$finalA]; //|||dia|||hora (indice)
                        die();
                    }
                    $a++;
                }
            }
            $i++;
        }
        /* SUCCESS, RESET */
        $email->accountGotUpdated(USER_EMAIL);
        $actualDay = 0;
        for($actualDay = 0;$actualDay < 7; $actualDay++)
        {
            if(!array_key_exists($actualDay,$_POST['days']))
            {
                $_POST['days'][$actualDay] = [];
            }
        }
        ksort( $_POST['days']);
        $db->query('UPDATE users_psicos_calendar SET sessionsOnMorning='.$sessionsMorning.',sessionsOnAfternoon='.$sessionsAfternoon.',sessionsOnNight='.$sessionsNight.', weekly_calendar="'.addslashes(json_encode($_POST['days'])).'",week_exceptions="'.(isset($_POST['weeklyexceptions']) ? addslashes(json_encode($_POST['weeklyexceptions'])):addslashes('{"0":["00"],"1":["00"],"2":["00"],"3":["00"],"4":["00"],"5":["00"],"6":["00"]}')).'",maxdate="'.$_POST['maxdate'].'" WHERE user_id='.USER_ID) or die($db->error);
        echo 'CHANGES_SUCCESS';
    }
    else
    {
        echo 'CRASH_NOWAY';
        die();
    }
}