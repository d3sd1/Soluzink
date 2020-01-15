<?php
/* Set Script to 1 HOUR */
define('CRON',true);
require(__DIR__ . '/../core.php');
$db->query('DELETE FROM admin_attempts WHERE timestampExpires > '.time());
$db->query('DELETE FROM admin_forgotten WHERE timestamp+604800 < '.time());
$db->query('DELETE FROM attempts WHERE timestampExpires > '.time());
$db->query('DELETE FROM contacts WHERE timestamp+2419200 < '.time());