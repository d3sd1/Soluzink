<?php
require('phpmailer/PHPMailerAutoload.php');
$email = new mail();
class mail {
    private function send($title, $msg, $simpleMsg, $to, $toName, $timesUnsubscribed, $from = 'admin@soluzink.com', $fromName = 'Soluzink')
    {
        $mail = new PHPMailer;
        $mail->CharSet = $GLOBALS['lang']['CONFIG']['encoding'];
        $mail->setFrom($from, $fromName);
        $mail->addReplyTo($from, $fromName);
        $mail->addAddress($to,$toName);
        $mail->Subject = $title;
        $mail->msgHTML($msg);
        $mail->AltBody = $simpleMsg;
         $mail->addCustomHeader('List-Unsubscribe','<unsubscribe@soluzink.com>, <'.URL.'/unsubscribe?email='.$to.'&&code='.$GLOBALS['core']->crypt($to.$timesUnsubscribed).'>');

        if(!$mail->send())
        {
            error_log('Mail error on function sent() -> ' . $mail->ErrorInfo);
            return false;
        }
        else
        {
            return true;
        }
    }
    public function adminResponseContact($email,$name,$message)
    {
        global $core;
        global $lang;
        $link = URL;
        $this->send($lang['MAIL'][$func]['title'], $message, $message, $email, $name, 0, 'admin@soluzink.com', 'Soluzink');
    
    }
    public function userProfileUpdatedPasswordSuccess($email)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Profile';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function userRegisterWelcome($email,$name)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Test';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, $name, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function userAlertSession($email,$name)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/UserSession';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, $name, USER_NEWSLETTER_UNSUBTIMES, 'notifier@soluzink.com', 'Soluzink');
    }
    public function psicoAlertSession($email,$name)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/PsicoSession';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, $name, USER_NEWSLETTER_UNSUBTIMES, 'notifier@soluzink.com', 'Soluzink');
    }
    public function userGotBanned($email)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Login';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function maintenanceEndAdvisor()
    {
        global $lang;
        global $core;
        global $db;
        $advisor = $db->query('SELECT ma.email,u.name,u.newsletterUnsubscribedTimes FROM maintenance_advisor ma JOIN users u ON ma.email=u.email');
        while($row = $advisor->fetch_row())
        {
            $func = __FUNCTION__;
            $link = URL.'/#/Psicos';
            ob_start();
            include 'phpmailer/templates/withbtn.php';
            $html = ob_get_clean();
            $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $row[0], $row[1], $row[2]);
        }
        $db->query('TRUNCATE TABLE maintenance_advisor');
    }
    public function recoverPassSuccess($email,$name)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Login';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, $name, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function recoverPass($email,$name,$code)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/RecoverPass/'.$code;
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, $name, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function userForcedLogoutAnotherDevice($email)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/LogoutLoggedSmw';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function userLoginAdvisorAnotherDevice($email,$name)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Logout';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, $name, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function accountUpdateProfile($email, $code)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Profile';
        $lang['MAIL']['accountUpdateProfile']['btn'] = $code;
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES);
    }
    public function accountGotUpdated($email)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Profile';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES);
    }
    public function accountBlockedSendCode($email, $code)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Recover';
        $lang['MAIL']['accountBlockedSendCode']['btn'] = $code;
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function accountGotBlockedByPasswordAttempts($email)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Recover';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function accountGotBlockedAtAll($email)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Contact';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function accountGotUnblocked($email)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Psicos';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, USER_NAME, USER_NEWSLETTER_UNSUBTIMES, 'security@soluzink.com', 'Soluzink');
    }
    public function psicoRegisterWelcome($email,$name)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Profile';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $email, $name, USER_NEWSLETTER_UNSUBTIMES);
    }
    public function newsletterUnsubscribed($to, $toName, $timesUnsubscribed)
    {
        global $lang;
        global $core;
        $func = __FUNCTION__;
        $link = URL.'/#/Psicos';
        ob_start();
        include 'phpmailer/templates/withbtn.php';
        $html = ob_get_clean();
        $this->send($lang['MAIL'][$func]['title'], $html, $lang['MAIL'][$func]['content'], $to, $toName, USER_NEWSLETTER_UNSUBTIMES, 'subscriptions@soluzink.com', 'Soluzink');
    }
}