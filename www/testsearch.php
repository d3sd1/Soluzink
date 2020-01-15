<?php
require('kernel/core.php');
header("Content-type:application/json");
if($core->safeAjaxCall() && isset($_GET['p']))
{
    $result = array('items' => array());
    $tests = $db->query('SELECT langkey,id FROM tests');
    
    $i = 0;
    while($row = $tests->fetch_row())
    {
        if(stristr($lang['test'][$row[0]],$_GET['p']) !== FALSE)
        {
            $result['items'][$i] = array();
            $result['items'][$i]['name'] = $lang['test'][$row[0]];
            $result['items'][$i]['id'] = URL.'/#/Test/'.$core->crypt($row[1]);
            $i++;
        }
    }
    echo json_encode($result);
}