<?php
require('kernel/core.php');
$captchaCode = $core->generateCaptcha();
$message = $captchaCode['message'];
echo (string) str_replace(' =',null,$message);
die();