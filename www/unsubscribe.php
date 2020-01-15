<?php
require('kernel/core.php');
if(isset($_GET['email']) && isset($_GET['code']))
{
    if($db->query('SELECT id FROM users WHERE email="'.$_GET['email'].'" AND newsletter=1')->num_rows != 0)
    {
        $timesUnsubscribed = $db->query('SELECT newsletterUnsubscribedTimes FROM users WHERE email="'.$_GET['email'].'"')->fetch_row()[0];
        if($core->decrypt($_GET['code']) == $_GET['email'].$timesUnsubscribed)
        {
            $db->query('UPDATE users SET newsletter=0,newsletterUnsubscribedTimes=newsletterUnsubscribedTimes+1 WHERE email="'.$_GET['email'].'"');
            header('Location: '.URL.'/?alert=true&&message=unsubscribe_success');
            $userInfo = $db->query('SELECT name,surname FROM users WHERE email="'.$_GET['email'].'"')->fetch_row();
            $email->newsletterUnsubscribed($_GET['email'],$userInfo[0].' '.$userInfo[1], $timesUnsubscribed);
        }
        else
        {
            header('Location: '.URL.'/?alert=true&&message=unsubscribe_hash_incorrect');
        }
    }
    else
    {
        header('Location: '.URL.'/?alert=true&&message=unsubscribe_already_done');
    }
}
else
{
    header('Location: '.URL.'/?alert=true&&message=unsubscribe_mail_not_found');
}