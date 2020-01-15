<?php
/* Set Script to 60 SECONDS */
define('CRON',true);
require(__DIR__ . '/../core.php');
$sessions = $db->query('SELECT ups.timestamp,user.email,psico.email,user.name,psico.name FROM users_psicos_sessions ups JOIN users user ON ups.user_id=user.id JOIN users psico ON ups.psico_id=psico.id WHERE mailalerted=0 AND timestamp+300>'.time().' AND timestamp<'.(time()+300));
while($row = $sessions->fetch_array())
{
    $email->psicoAlertSession($row['psico.email'],$row['psico.name']);
    $email->userAlertSession($row['user.email'],$row['user.name']);
    $db->query('UPDATE users_psicos_sessions SET mailalerted=1 WHERE user_id='.$row['user.email'].' AND psico_id='.$row['psico.email'].' AND timestamp='.$row['timestamp']);
}