<?php
require('kernel/core.php');
if($core->safeAjaxCall() && USER_LOGGED_IN)
{
    if(USER_TYPE_CLIENT && ($_POST['vote'] == 0 || $_POST['vote'] == 1) && $db->query('SELECT voted FROM users_psicos_sessions WHERE sessionId="'.$_POST['sessionId'].'"')->fetch_row()[0] == 0)
    {
        if($_POST['testimonial'] != '')
        {
            $db->query('INSERT INTO testimonials (content,timestamp,uid,pid,treatmentKey) VALUES ("'.$_POST['testimonial'].'",'.time().','.USER_ID.',(SELECT psico_id FROM users_psicos_sessions WHERE sessionId="'.$_POST['sessionId'].'"),(SELECT patid,MAX(grade) FROM users_patologies WHERE uid='.USER_ID.' GROUP BY patid LIMIT 1))');
        }
        if($_POST['vote'] == 1)
        {
            $db->query('UPDATE users_psicos SET score=score+1,scoreVotesNumber=scoreVotesNumber+1 WHERE user_id='.USER_ID);
        }
        else
        {
            $db->query('UPDATE users_psicos SET scoreVotesNumber=scoreVotesNumber+1 WHERE user_id='.USER_ID);
        }
        $db->query('UPDATE users_psicos_sessions SET satisfacted='.$_POST['vote'].',voted=1 WHERE sessionId="'.$_POST['sessionId'].'"');
    }
} 
?>