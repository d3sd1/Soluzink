<?php
$dbCon = [config('mysql.host'),config('mysql.user'),config('mysql.pass'),config('mysql.db')];
$db = new mysqli($dbCon[0],$dbCon[1],$dbCon[2],$dbCon[3]);
if ($db->connect_errno) {
    exit('DATABASE_ERROR');
}
$db ->query("SET NAMES 'utf8'"); //Encode ES types