<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(!USER_LOGGED_IN || !USER_IS_BLOCKED)
    {
        echo 'CRASH_NOTLOGGED';
        die();
    }
    if(time() - config('profile.blockaccount.resendcodeinterval') > $db->query('SELECT timestamp FROM users_recoveracc_code WHERE uid='.USER_ID)->fetch_row()[0])
    {
        $core->blockAccountResendCode(USER_ID,USER_EMAIL);
        echo 'RESEND_SUCCESS';
        die();
    }
    else
    {
        echo 'TOO_EARLY';
        die();
    }
}