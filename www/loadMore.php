<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(isset($_POST['type']) && ($_POST['type'] == 'psico' || $_POST['type'] == 'coach'))
    {
        $response = $core->templateListing($_POST['type'],$_POST['sortData'],$_POST['sortDir'],$_POST['moneyRange'],$_POST['showedIds']);
        echo json_encode($response);
    }
}