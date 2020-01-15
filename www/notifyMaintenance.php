<?php
$areWeInMaintenance = true;
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(config('maintenance') && !isset($areWeInMaintenance))
    {
        header('Location: '.URL);
    }
    if(!$core->validate('email',$_POST['email']))
    {
        echo 'invalidMail';
        die();
    }
    if($db->query('SELECT id FROM maintenance_advisor WHERE email="'.$_POST['email'].'"')->num_rows === 0)
    {
        $db->query('INSERT INTO maintenance_advisor (email,timestamp) VALUES ("'.$_POST['email'].'",'.time().')');
        echo 'success';
        die();
    }
    else
    {
        echo 'validationError';
        die();
    }
}
else
{
    header('Location: '.URL);   
}