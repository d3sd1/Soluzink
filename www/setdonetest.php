<?php
require('kernel/core.php');
if($core->safeAjaxCall() && USER_LOGGED_IN)
{
    $hap = 0;
    $mot = 0;
    $str = 0;
    $mostPat = array();
    $responsesNum = count($_POST);
    foreach($_POST as $questid => $responseid)
    {
        $question = $db->query('SELECT hap,str,mot,associatepatid FROM tests_responses WHERE questid='.$questid.' AND responseid='.$responseid);
        if($question->num_rows > 0)
        {
            $questionData = $question->fetch_array();
            $hap += $questionData['hap'];
            $str += $questionData['str'];
            $mot += $questionData['mot'];
            if(!array_key_exists($questionData['associatepatid'], $mostPat))
            {
                $mostPat[$questionData['associatepatid']] = 1;
            }
            else
            {
                $mostPat[$questionData['associatepatid']] = $mostPat[$questionData['associatepatid']]+1;
            }
        }
    }
    $hap = $hap/$responsesNum;
    $mot = $mot/$responsesNum;
    $str = $str/$responsesNum;
    if($db->query('SELECT uid FROM users_status WHERE uid='.USER_ID)->num_rows == 0)
    {
        $db->query('INSERT INTO users_status (ihap,istr,imot,ahap,astr,amot) VALUES ('.USER_ID.','.$hap.','.$str.','.$mot.','.$hap.','.$str.','.$mot.')');
    }
    else
    {
        $db->query('UPDATE users_status SET ahap='.$hap.',astr='.$str.',amot='.$mot.' WHERE uid='.USER_ID);
    }
    arsort($mostPat);
    reset($mostPat);
    $mostGottenPat = key($mostPat);
    $mostGottenPatGrade = max($mostPat)*100/$responsesNum;
    if($mostGottenPat != 0 && $db->query('SELECT id FROM patologies WHERE id='.$mostGottenPat)->num_rows > 0)
    {
        if($db->query('SELECT uid FROM users_patologies WHERE patid='.$mostGottenPat.' AND uid='.USER_ID)->num_rows == 0)
        {
            $db->query('INSERT INTO users_patologies (uid,grade,patid) VALUES ('.USER_ID.','.$mostGottenPatGrade.','.$mostGottenPat.')') or die($db->error);
        }
        else
        {
            $db->query('UPDATE users_patologies SET grade='.$mostGottenPatGrade.' WHERE patid='.$mostGottenPat.' AND uid='.USER_ID) or die($db->error);
        }
    }
}