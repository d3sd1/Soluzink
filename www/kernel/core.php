<?php
/* CHECK IF CRON */
if(!defined('CRON'))
{
    define('CRON',false);
}
/* Session improved security */
ini_set('session.cookie_secure',false);
ini_set('session.cookie_httponly',false);
ini_set('session.cookie_lifetime',604800);
ini_set('session.gc_maxlifetime',604800);
session_start();
function config($val,$type = false,$possibleValues = false)
{
    if($possibleValues)
    {
        return $GLOBALS['CONFIG'][$val]['possibleValues'];
    }
    else
    {
        if(!$type)
        {
            return $GLOBALS['CONFIG'][$val]['value'];
        }
        else
        {
            return $GLOBALS['CONFIG'][$val]['type'];
        }
    }
}
require('class/config.php');
require('class/database.php');
require('class/soluzink.php');
/* Sanitize navigator variables */
if(!CRON)
{
    $core->cleanSystem();
}
/* Debug if set */
if(config('debug'))
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
else
{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
/* Get user language */
if($core->session_isSet('soluzinkLang') && array_key_exists($core->session_getValue('soluzinkLang'),array_flip(config('langs.avaliable'))))
{
    define('USER_LANG',$core->session_getValue('soluzinkLang'));
}
else
{
    if($core->session_isSet('soluzinkLang'))
    {
        $core->session_destroy('soluzinkLang');
    }
    
    if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
    {
        $usrLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
    else
    {
        $usrLang = config('langs.default');
    }
    $user2keyLang = substr($usrLang,0,2); 
    if(array_key_exists($user2keyLang,array_flip(config('langs.avaliable'))))
    {
        define('USER_LANG',$user2keyLang);
        $core->session_setNew('soluzinkLang',$user2keyLang);
    }
    else
    {
        define('USER_LANG',config('langs.default'));
        $core->session_setNew('soluzinkLang',$user2keyLang);
    }
}

$lang = array();
if(config('langs.default') != USER_LANG)
{
    require('langs/'.config('langs.default').'.php');
    require('langs/'.USER_LANG.'.php');
}
else
{
    require('langs/'.USER_LANG.'.php');
}
if($core->session_isSet('soluzinkUserEmail') && !CRON)
{
    $userData = $db->query('SELECT name,surnames,loginID,email,phone,id,geoTimeZone,type,onlineLastPing,weekStarts,photo,newsletter,currency,wrongpasstimes,banned,type,newsletterUnsubscribedTimes FROM users WHERE email="'.$core->session_getValue('soluzinkUserEmail').'"')->fetch_row();
    define('USER_WEEKSTARTS',$userData[9]);
    define('USER_NEWSLETTER',$userData[11]);
    define('USER_CURRENCY',$userData[12]);
    define('USER_BANNED',$userData[14]);
    define('USER_NEWSLETTER_UNSUBTIMES',$userData[16]);
    define('USER_PROFILEIMG',str_replace(array('{PROFILE_IMAGE_DEFAULT}','{URL}'),array(URL.config('profile.default.image'),URL),$userData[10]));
    define('USER_LAST_PING',$userData[8]);
    define('USER_TYPE',$userData[7]);
    define('USER_TIMEZONE',$userData[6]);
    define('USER_ID',$userData[5]);
    define('USER_EMAIL',$userData[3]);
    define('USER_PHONE',$userData[4]);
    define('USER_LOGINCODE',$userData[2]);
    define('USER_NAME',$userData[0]);
    define('USER_SURNAMES',$userData[1]);
    define('USER_FULLNAME',$userData[0].' '.$userData[1]);
    define('USER_LOGGED_IN',true);
    if($userData[15] == 'psico' || $userData[15] == 'coach')
    {
        $psicoInfo = $db->query('SELECT * FROM users_psicos WHERE user_id='.USER_ID)->fetch_array();
        define('USER_TYPE_CLIENT',false);
        define('USER_PROF_CURRENCY',$psicoInfo['pphCoin']);
        define('USER_PROF_PPH',$psicoInfo['pph']);
        define('USER_PROF_PAYPALACC',$psicoInfo['paypalAccount']);
        define('USER_PROF_DESCRIPTION',$psicoInfo['description']);
        define('USER_PROF_COLLEGENUMBER',$psicoInfo['collegenumber']);
        define('USER_PROF_SPECPATID',$psicoInfo['specpatid']);
        define('USER_PROF_SESSNOW',$psicoInfo['sessionNowEnabled']);
    }
    else
    {
        define('USER_TYPE_CLIENT',true);
    }
    if(config('profile.blockaccount.afterwrongpasstimes') <= $userData[13])
    {
        define('USER_IS_BLOCKED',true);
    }
    else
    {
        define('USER_IS_BLOCKED',false);
    }
    if($core->checkTimezone(USER_TIMEZONE))
    {
        date_default_timezone_set(USER_TIMEZONE);
    }
}
else
{
    define('USER_LOGGED_IN',false);
    define('USER_IS_BLOCKED',false);
    define('USER_NEWSLETTER_UNSUBTIMES',0);
}
if($core->session_isSet('timezone'))
{
    if($core->checkTimezone($core->session_getValue('timezone')))
    {
        date_default_timezone_set($core->session_getValue('timezone'));
    }
}
if(!CRON) //Check if that's not owned cron, and it's an user.
{
    define('USER_IP',$core->getUserIP());
    define('PROFILE_IMAGE_DEFAULT',URL.config('profile.default.image'));
    if(config('maintenance') && !isset($areWeInAdmin) && !isset($areWeInMaintenance))
    {
        header('Location: '.URL.'/maintenance');
        die();
    }
}
if(!$core->session_isSet('soluzinkMaintenanceClearTS'))
{
    $core->session_setNew('soluzinkMaintenanceClearTS',time());
}
require('class/mail.php');