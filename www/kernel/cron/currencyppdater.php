<?php
/* Set Script to 1 hour */
define('CRON',true);
require(__DIR__ . '/../core.php');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://api.fixer.io/latest'
));
$resp = json_decode(curl_exec($curl));
function updateRate($key,$val)
{
    global $db;
    if($db->query('SELECT currencyCode FROM currencies WHERE currencyCode="'.$key.'"')->num_rows == 0)
    {
        $db->query('INSERT INTO currencies (currencyCode,currencyVal) VALUES ("'.$key.'",'.$val.')');
    }
    else
    {
        $db->query('UPDATE currencies SET currencyVal='.$val.' WHERE currencyCode="'.$key.'"');
    }
}
updateRate($resp->base,1);
foreach($resp->rates as $key => $val)
{
    updateRate($key,$val);
}
curl_close($curl);