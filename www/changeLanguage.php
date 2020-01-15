<?php
require('kernel/core.php');
if(in_array($_GET['langCode'],config('langs.avaliable')))
{
    if($core->session_isSet('soluzinkLang'))
    {
        $core->session_destroy('soluzinkLang');
    }
    $core->session_setNew('soluzinkLang',$_GET['langCode']);
    if(strlen(base64_decode($_GET['callbackUrl']))> 0)
    {
        header('Location: '.base64_decode($_GET['callbackUrl']));
    }
    else
    {
        header('Location: '.URL);
    }
}
else
{
    if(strlen(base64_decode($_GET['callbackUrl']))> 0)
    {
        header('Location: '.base64_decode($_GET['callbackUrl']));
    }
    else
    {
        header('Location: '.URL);
    }
}