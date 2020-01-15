<?php
/* Set Script to every MONDAY AT 00:00 */
define('CRON',true);
require(__DIR__ . '/../core.php');
$db->query('UPDATE users_psicos_calendar SET week_exceptions=\'{"0": [],"1": [],"2": [],"3": [],"4": [],"5": [],"6": []}\'');