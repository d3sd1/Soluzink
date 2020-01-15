<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    echo $core->generateCSRFToken();
}