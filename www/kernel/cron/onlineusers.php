<?php
/* Set Script to 60 SECONDS */
define('CRON',true);
require(__DIR__ . '/../core.php');
$db->query('UPDATE users SET online=0 WHERE onlineLastPing<'.(time()-config('userlogged.checkonline.interval')));