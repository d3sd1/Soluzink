<?php
require('kernel/core.php');
if($core->safeAjaxCall() && USER_LOGGED_IN)
{
    if(isset($_GET['includepayments']) && $_GET['includepayments'] == true && !config('payments.enabled.global'))
    {
        echo 'PAYMENTS_DISABLED';
        die();
    }
    if(USER_LOGGED_IN)
    {
        if($core->session_getValue('soluzinkUserLoginCode') != USER_LOGINCODE)
        {
            $db->query('UPDATE users SET sessioninsecurerecent=1 WHERE email="'.USER_EMAIL.'"');
            $email->userForcedLogoutAnotherDevice(USER_EMAIL);
            echo 'INSECURE_SESSION';
            die();
        }
        else
        {
            if(USER_IS_BLOCKED)
            {
                $email->accountGotBlockedByPasswordAttempts(USER_EMAIL);
                $email->accountBlockedSendCode(USER_EMAIL,$db->query('SELECT seccode FROM users_recoveracc_code WHERE uid='.USER_ID)->fetch_row()[0]);
                echo 'ACC_BLOCKED';
                die();
            }
            else
            {
                if(USER_BANNED)
                {
                    echo 'BANNED';
                    die();
                }
                else
                {
                    echo 'CONNECTED';
                    die();
                }
            }
        }
    }
    else
    {
        echo 'NOT_CONNECTED';
        die();
    }
}