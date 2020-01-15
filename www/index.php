<?php
require('kernel/core.php');
?><!DOCTYPE html>
<html>
  <head>
	<base href="<?php echo URL ?>"></base>
        <title><?php echo $lang['home']['title'] ?></title>
        <noscript>
          <meta http-equiv="refresh" content="0;url=<?php echo URL ?>/nojs">
        </noscript>
        <!-- PERSONAL -->
        <link href="https://fonts.googleapis.com/css?family=Capriola|Roboto" rel="stylesheet">
        <link href="<?php echo URL ?>/assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL ?>/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- BASE -->
        <link href="<?php echo URL ?>/assets/css/common/base.css" rel="stylesheet">
        <link href="<?php echo URL ?>/assets/css/home/loader.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/home/calendar.min.css">

        <script src="<?php echo URL ?>/assets/vendors/jquery3/jquery.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/jquery.dragscroll/jquery.dragscroll.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/jquery.lazyload/jquery.lazyload.min.js"></script>                
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/vex/css/vex.css" />
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/vex/css/vex-theme-os.css" />
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/semanticui/semantic.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/bootstrap-select/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/slim/css/slim.min.css">	
		
		
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/material/material.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/owl.carousel/owl.carousel.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/home/myprofile.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/home/style.css">
        <script src="<?php echo URL ?>/assets/vendors/semanticui/semantic.min.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/jquery.mCustomScrollbar/jquery.mCustomScrollbar.min.css">
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/bootstrap-tagsinput/bootstrap-tagsinput.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/ion.rangeslider/normalize.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/ion.rangeslider/ion.rangeSlider.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/ion.rangeslider/ion.rangeSlider.skinHTML5.css">
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/ion.rangeslider/ion.rangeSlider.min.js"></script>
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/circletimer/circletimer.css">
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/circletimer/circletimer.min.js"></script>

        <!-- ANGULAR -->
        <script src="<?php echo URL ?>/assets/vendors/angular2/polyfills.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/angular2/system.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/angular2/typescript.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/angular2/Rx.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/angular2/angular2.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/angular2/router.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/vex/js/vex.combined.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/bootstrap-notify/bootstrap-notify.min.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/notify/notify.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/moment/moment.min.js"></script>
        <!-- Favicon and Apple Icons -->
        <link rel="shortcut icon" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL ?>/favicon.ico">
        <script>
                <?php
                if($core->session_getValue('soluzinkMaintenanceClearTS') < config('lastMaintenanceTimestamp'))
                {
                    $core->session_destroy('soluzinkMaintenanceClearTS');
                    $core->session_setNew('soluzinkMaintenanceClearTS',time());
                    echo 'document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });';
                }
                ?>
        var lastValue, sessionActive = false, langTranscription = {
            LOGIN_ON: '<?php echo $lang['home']['login']['messages']['connecting'] ?>',
            HOUR: '<?php echo $lang['CORE']['time.elapsed.hour'] ?>',
            HOURS: '<?php echo $lang['CORE']['time.elapsed.hours'] ?>',
            MINUTE: '<?php echo $lang['CORE']['time.elapsed.minute'] ?>',
            MINUTES: '<?php echo $lang['CORE']['time.elapsed.minutes'] ?>',
            SECOND: '<?php echo $lang['CORE']['time.elapsed.second'] ?>',
            SECONDS: '<?php echo $lang['CORE']['time.elapsed.seconds'] ?>',
            CRASH_CSRF: '<?php echo $lang['home']['login']['messages']['crashCSRF'] ?>',
            LOGIN_SUCCESS: '<?php echo $lang['home']['login']['messages']['success'] ?>',
            CRASH_TOOMANYATTEMPTS: '<?php echo $lang['home']['login']['messages']['crashtoomanyattempts'] ?>',
            LOGIN_BUTTON: '<?php echo $lang['home']['login']['form']['send'] ?>',
            responseTXT: '<?php echo $lang['home']['login']['messages']['notdefined'] ?>',
            EMAIL_NOTSET: '<?php echo $lang['home']['login']['messages']['emailnotset'] ?>',
            PWD_NOTSET: '<?php echo $lang['home']['login']['messages']['pwdnotset'] ?>',
            EMAIL_NOTFOUND: '<?php echo $lang['home']['login']['messages']['emailnotfound'] ?>',
            PWD_WRONG: '<?php echo $lang['home']['login']['messages']['pwdwrong'] ?>',
            CRASH_ALREADYLOGGED: '<?php echo $lang['home']['login']['messages']['crashalreadylogged'] ?>',
            CRASH_ALREADYSENT: '<?php echo $lang['home']['login']['messages']['crashalreadysent'] ?>',
            CONTACT_SEND: '<?php echo $lang['home']['contact']['submit'] ?>',
            CONTACT_SUCCESS: '<?php echo $lang['home']['contact']['success'] ?>',
            NAME_NOTSET: '<?php echo $lang['home']['contact']['messages']['namenotset'] ?>',
            PHONE_NOTSET: '<?php echo $lang['home']['contact']['messages']['phonenotset'] ?>',
            MESSAGE_NOTSET: '<?php echo $lang['home']['contact']['messages']['messagenotset'] ?>',
            CAPTCHA_NOTSET: '<?php echo $lang['home']['contact']['messages']['captchanotset'] ?>',
            CONTACT_NAME_NOTVALID: '<?php echo $lang['home']['contact']['messages']['namenotvalid'] ?>',
            CONTACT_EMAIL_NOTVALID: '<?php echo $lang['home']['contact']['messages']['emailnotvalid'] ?>',
            CONTACT_PHONE_NOTVALID: '<?php echo $lang['home']['contact']['messages']['phonenotvalid'] ?>',
            CONTACT_CAPTCHA_NOTVALID: '<?php echo $lang['home']['contact']['messages']['captchaincorrect'] ?>',
            CONTACT_MESSAGE_NOTVALID: '<?php echo str_replace(array('{minLength}','{maxLength}'),array(config('contact.message.minlength'),config('contact.message.maxlength')),$lang['home']['contact']['messages']['messagenotvalid']) ?>',
            CONTACT_CAPTCHA_MSG: '<?php echo $lang['home']['contact']['verify'] ?>',
            REGISTER_SEND: '<?php echo $lang['home']['register']['submit'] ?>',
            REGISTER_SUCCESS: '<?php echo $lang['home']['register']['success'] ?>',
            PASSWORD_NOTSET: '<?php echo $lang['home']['register']['messages']['passnotset'] ?>',
            PASSREP_NOTSET: '<?php echo $lang['home']['register']['messages']['passrepnotset'] ?>',
            SURNAMES_NOTSET: '<?php echo $lang['home']['register']['messages']['surnamesnotset'] ?>',
            REGISTER_NAME_NOTVALID: '<?php echo $lang['home']['register']['messages']['namenotvalid'] ?>',
            REGISTER_SURNAMES_NOTVALID: '<?php echo $lang['home']['register']['messages']['surnamesnotvalid'] ?>',
            REGISTER_EMAIL_NOTVALID: '<?php echo $lang['home']['register']['messages']['emailnotvalid'] ?>',
            REGISTER_PHONE_NOTVALID: '<?php echo $lang['home']['register']['messages']['phonenotvalid'] ?>',
            REGISTER_PASSWORD_NOTVALID: '<?php echo $lang['home']['register']['messages']['passwordnotvalid'][config('register.passsword.strenght')] ?>',
            REGISTER_PASSREP_NOTVALID: '<?php echo $lang['home']['register']['messages']['passrepnotvalid'] ?>',
            REGISTER_EMAIL_ALREADYREGISTERED: '<?php echo $lang['home']['register']['messages']['emailalreadyregistered'] ?>',
            CRASH_REGISTERTOOMANYATTEMPTS: '<?php echo $lang['home']['register']['messages']['crashtoomanyattempts'] ?>',
            CRASH_LOGINERROR: '<?php echo $lang['home']['register']['messages']['loginerrorgeneric'] ?>',
            LISTING_NOMORERECORDS: '<?php echo $lang['home']['listing']['error']['nomorerecords'] ?>',
            LISTING_SHOWRESULTS: '<?php echo str_replace('{number}',0,$lang['home']['listing']['results']) ?>',
            LISTING_LOADING: '<?php echo $lang['home']['listing']['loading'] ?>',
            LISTING_SORT_DEFAULT: '<?php echo $lang['home']['listing']['sort']['default'] ?>',
            LISTING_SORT_ASC: '<?php echo $lang['home']['listing']['sort']['asc'] ?>',
            LISTING_SORT_DSC: '<?php echo $lang['home']['listing']['sort']['dsc'] ?>',
            RECOVER_SUCCESS: '<?php echo $lang['home']['recover']['success'] ?>',
            RECOVER_SUCCESS_FULL: '<?php echo $lang['home']['recover']['successfull'] ?>',
            CRASH_RECOVER_TOOMANYATTEMPTS: '<?php echo $lang['home']['recover']['messages']['crashtoomanyattempts'] ?>',
            RECOVER_BUTTON: '<?php echo $lang['home']['recover']['form']['send'] ?>',
            RECOVERING_ON: '<?php echo $lang['home']['recover']['form']['sending'] ?>',
            CLNDR_DAY: {1: '<?php echo $lang['CORE']['days']['monday'] ?>', 2: '<?php echo $lang['CORE']['days']['tuesday'] ?>', 3: '<?php echo $lang['CORE']['days']['wednesday'] ?>', 4: '<?php echo $lang['CORE']['days']['thursday'] ?>', 5: '<?php echo $lang['CORE']['days']['friday'] ?>', 6: '<?php echo $lang['CORE']['days']['saturday'] ?>', 0: '<?php echo $lang['CORE']['days']['sunday'] ?>'},
            CLNDR_DAY_SHORT: {1: '<?php echo $lang['CORE']['daysShort']['monday'] ?>', 2: '<?php echo $lang['CORE']['daysShort']['tuesday'] ?>', 3: '<?php echo $lang['CORE']['daysShort']['wednesday'] ?>', 4: '<?php echo $lang['CORE']['daysShort']['thursday'] ?>', 5: '<?php echo $lang['CORE']['daysShort']['friday'] ?>', 6: '<?php echo $lang['CORE']['daysShort']['saturday'] ?>', 7: '<?php echo $lang['CORE']['daysShort']['sunday'] ?>', 0: '<?php echo $lang['CORE']['daysShort']['sunday'] ?>'},
            CLNDR_MONTH: ['<?php echo $lang['CORE']['months']['1'] ?>', '<?php echo $lang['CORE']['months']['2'] ?>', '<?php echo $lang['CORE']['months']['3'] ?>', '<?php echo $lang['CORE']['months']['4'] ?>', '<?php echo $lang['CORE']['months']['5'] ?>', '<?php echo $lang['CORE']['months']['6'] ?>', '<?php echo $lang['CORE']['months']['7'] ?>', '<?php echo $lang['CORE']['months']['8'] ?>', '<?php echo $lang['CORE']['months']['9'] ?>', '<?php echo $lang['CORE']['months']['10'] ?>', '<?php echo $lang['CORE']['months']['11'] ?>', '<?php echo $lang['CORE']['months']['12'] ?>'],
            CLNDR_MONTH_SHORT: ['<?php echo $lang['CORE']['monthsShort']['1'] ?>', '<?php echo $lang['CORE']['monthsShort']['2'] ?>', '<?php echo $lang['CORE']['monthsShort']['3'] ?>', '<?php echo $lang['CORE']['monthsShort']['4'] ?>', '<?php echo $lang['CORE']['monthsShort']['5'] ?>', '<?php echo $lang['CORE']['monthsShort']['6'] ?>', '<?php echo $lang['CORE']['monthsShort']['7'] ?>', '<?php echo $lang['CORE']['monthsShort']['8'] ?>', '<?php echo $lang['CORE']['monthsShort']['9'] ?>', '<?php echo $lang['CORE']['monthsShort']['10'] ?>', '<?php echo $lang['CORE']['monthsShort']['11'] ?>', '<?php echo $lang['CORE']['monthsShort']['12'] ?>'],
            CLNDR_RESERVE_DAY: '<?php echo $lang['home']['clndr']['day']['reserveday'] ?>',
            CLNDR_RESERVE_NOW: '<?php echo $lang['home']['clndr']['day']['reservenow'] ?>',
            CLNDR_DAY_TXT: '<?php echo $lang['home']['clndr']['day']['txt'] ?>',
            CLNDR_DAY_MORNING: '<?php echo $lang['home']['clndr']['day']['morning'] ?>',
            CLNDR_DAY_AFTERNOON: '<?php echo $lang['home']['clndr']['day']['afternoon'] ?>',
            CLNDR_DISABLED: '<?php echo $lang['home']['clndr']['disabled'] ?>',
            PAYMENT_GTW_CC_OKBUTTON: '<?php echo $lang['home']['modal']['buySessions']['btn']['accept'] ?>',
            PAYMENT_GTW_CC_CLBUTTON: '<?php echo $lang['home']['modal']['buySessions']['btn']['decline'] ?>',
            PAYMENT_GTW_CC_INPUT_CCN: '<?php echo $lang['home']['modal']['card']['number'] ?>',
            PAYMENT_GTW_CC_INPUT_CVC: '<?php echo $lang['home']['modal']['card']['cvc'] ?>',
            PAYMENT_GTW_CC_INPUT_EXP: '<?php echo $lang['home']['modal']['card']['expiry'] ?>',
            PAYMENT_GTW_CC_INPUT_CCO: '<?php echo $lang['home']['modal']['card']['name'] ?>',
            PAYMENT_GTW_CC_INPUT_CCO_VAL: '<?php echo (USER_LOGGED_IN === true ? ' value="'.USER_NAME.' '.USER_SURNAMES.'"':$lang['home']['modal']['buySessions']['card']['defaultName']) ?>',
            PAYMENT_GTW_CC_ANIM_OWNER: '<?php echo (USER_LOGGED_IN === true ? USER_NAME.' '.USER_SURNAMES:$lang['home']['modal']['buySessions']['card']['defaultName']) ?>',
            PAYMENT_GTW_CC_ANIM_EXP: '<?php echo $lang['home']['modal']['buySessions']['card']['defaultExpiry'] ?>',
            PAYMENT_ERR_LOGGEDOUT: '<?php echo $lang['home']['modal']['buySessions']['needlogin'] ?>',
            PAYMENT_ERR_LOGIN: '<?php echo $lang['home']['modal']['buySessions']['loginbtn'] ?>',
            PAYMENT_ERR_REGISTER: '<?php echo $lang['home']['modal']['buySessions']['registerbtn'] ?>',
            PAYMENT_CARD_HOLDER: '<?php echo $lang['home']['modal']['buySessions']['card']['holder'] ?>',
            PAYMENT_SAVE_CC: '<?php echo $lang['home']['modal']['buySessions']['card']['save'] ?>',
            PAYMENT_UNSAVED_CC: '<?php echo $lang['home']['modal']['buySessions']['card']['newCard'] ?>',
            PAYMENT_GTW_CC_CARD_MMYYYY: '<?php echo $lang['home']['modal']['buySessions']['card']['MMYYYY'] ?>',
            PAYMENT_GTW_CC_CARD_VALIDDATE: '<?php echo $lang['home']['modal']['buySessions']['card']['VALIDDATE'] ?>',
            PAYMENT_SUCCESS_TITLE: '<?php echo $lang['home']['modal']['buySessions']['success']['title'] ?>',
            PAYMENT_SUCCESS_CONTENT: '<?php echo $lang['home']['modal']['buySessions']['success']['content'] ?>',
            PAYMENT_SUCCESS_CONTENT_PRICE: '<?php echo $lang['home']['modal']['buySessions']['success']['price'] ?>',
            PAYMENT_SUCCESS_CONTENT_DATE: '<?php echo $lang['home']['modal']['buySessions']['success']['datetit'] ?>',
            PAYMENT_SUCCESS_CONTENT_PSICO: '<?php echo $lang['home']['modal']['buySessions']['success']['psico'] ?>',
            PAYMENT_SUCCESS_CONTENT_DURATION: '<?php echo $lang['home']['modal']['buySessions']['success']['duration'] ?>',
            PAYMENTS_DISABLED_ALERT: '<?php echo $lang['home']['modal']['buySessions']['paymentsdisabled'] ?>',
            PAYMENT_SUCCESS_CONTENT_DURATION_TIME: '<?php echo $lang['home']['modal']['buySessions']['success']['durationtime'] ?>',
            PAYMENT_SUCCESS_BUTTON: '<?php echo $lang['home']['modal']['buySessions']['success']['button'] ?>',
            PAYMENT_SUCCESS_CONTENT_INVID: '<?php echo $lang['home']['modal']['buySessions']['success']['invoiceId'] ?>',
            PAYMENT_RESUME_PREPAYMENT: '<?php echo $lang['home']['modal']['buySessions']['resumePrepayment'] ?>',
            PAYMENT_SUCCESS_CONTENT_PRICE_TODO: '<?php echo $lang['home']['modal']['buySessions']['success']['pricetodo'] ?>',
            PROFILE_IMGUPL_BACK: '<?php echo $lang['home']['modal']['buySessions']['btn']['decline'] ?>',
            PROFILE_IMGUPL_INPUT: '<?php echo $lang['home']['modal']['profile']['imageupload']['text'] ?>',
            PROFILE_IMGUPL_ERROR_TITLE: '<?php echo $lang['home']['modal']['profile']['imageupload']['error']['title'] ?>',
            PROFILE_IMGUPL_ERROR_PICSIZE: '<?php echo $lang['home']['modal']['profile']['imageupload']['error']['picsize'] ?>',
            PROFILE_IMGUPL_ERROR_GENERAL: '<?php echo $lang['home']['modal']['profile']['imageupload']['error']['general'] ?>',
            PROFILE_IMGUPL_ERROR_IMGTYPE: '<?php echo $lang['home']['modal']['profile']['imageupload']['error']['imgtype'] ?>',
            PROFILE_IMGUPL_SUCCESS_TITLE: '<?php echo $lang['home']['modal']['profile']['imageupload']['success']['title'] ?>',
            PROFILE_IMGUPL_SUCCESS_DESC: '<?php echo $lang['home']['modal']['profile']['imageupload']['success']['desc'] ?>',
            PROFILE_IMGUPL_SUCCESS_BUTTON: '<?php echo $lang['home']['modal']['profile']['imageupload']['success']['button'] ?>',
            PROFILE_IMGUPL_ERROR_HIDDENFACE: '<?php echo $lang['home']['modal']['profile']['imageupload']['error']['noface'] ?>',
            PROFILE_IMGUPL_LOADING: '<?php echo $lang['home']['modal']['profile']['imageupload']['loading'] ?>',
            PROFILE_IMGUPL_SEND: '<?php echo $lang['home']['modal']['buySessions']['btn']['accept'] ?>',
            PROFILE_IMGUPL_EDIT: '<?php echo $lang['home']['modal']['buySessions']['btn']['edit'] ?>',
            PROFILE_IMGUPL_RMV: '<?php echo $lang['home']['modal']['buySessions']['btn']['rmv'] ?>',
            PROFILE_IMGUPL_TURN: '<?php echo $lang['home']['modal']['buySessions']['btn']['turn'] ?>',
            PROFILE_IMGUPL_ERROR_IMGSIZEWIDTHHEIGHT: '<?php echo $lang['home']['modal']['profile']['imageupload']['error']['imgsizewidthheight'] ?>',
            PROFILE_IMGUPL_PROCCESSING: '<?php echo $lang['home']['modal']['profile']['imageupload']['proccessing'] ?>',
            PROFILE_UPD_BUTTON: '<?php echo $lang['home']['profile']['editor']['send'] ?>',
            PROFILE_UPD_ERROR_EMAILFORMAT: '<?php echo $lang['home']['profile']['editor']['error']['emailformat'] ?>',
            PROFILE_UPD_ERROR_EMAILREGISTERED: '<?php echo $lang['home']['profile']['editor']['error']['emailregistered'] ?>',
            PROFILE_UPD_ERROR_NEWSLETTER_NOTVALID: '<?php echo $lang['home']['profile']['editor']['error']['newsletternotvalid'] ?>',
            PROFILE_UPD_ERROR_SESSNOW_NOTVALID: '<?php echo $lang['home']['profile']['editor']['error']['sessnownotvalid'] ?>',
            PROFILE_UPD_ERROR_WEEKSTARTDAY_NOTVALID: '<?php echo $lang['home']['profile']['editor']['error']['weekstartdaynotvalid'] ?>',
            PROFILE_UPD_ERROR_CURRENCY_NOTVALID: '<?php echo $lang['home']['profile']['editor']['error']['currencynotvalid'] ?>',
            PROFILE_UPD_ERROR_PWDEXCEEDLIMIT: '<?php echo $lang['home']['profile']['editor']['error']['pwdexceedlimit'] ?>',
            PROFILE_UPD_ERROR_PWDWRONG: '<?php echo $lang['home']['profile']['editor']['error']['pwdwrong'] ?>',
            PROFILE_UPD_ERROR_NOTLOGGED: '<?php echo $lang['home']['profile']['editor']['error']['notlogged'] ?>',
            PROFILE_UPD_SUCCESS: '<?php echo $lang['home']['profile']['editor']['success']['title'] ?>',
            PROFILE_UPD_CONFIRM_TITLE: '<?php echo $lang['home']['profile']['editor']['confirm']['title'] ?>',
            PROFILE_UPD_CONFIRM_PH: '<?php echo $lang['home']['profile']['editor']['confirm']['ph'] ?>',
            PROFILE_UPD_PIN_ERROR: '<?php echo $lang['home']['profile']['editor']['confirm']['pinerror'] ?>',
            RECOVERACC_CODE_NOTSET: '<?php echo $lang['home']['recoveracc']['form']['error']['codenotset'] ?>',
            RECOVERACC_SUCCESS: '<?php echo $lang['home']['recoveracc']['form']['success'] ?>',
            RECOVERACC_CRASH_TOOMANYATTEMPTS: '<?php echo $lang['home']['recoveracc']['form']['error']['toomanyattempts'] ?>',
            RECOVERACC_SENDING: '<?php echo $lang['home']['recoveracc']['form']['sending'] ?>',
            CRASH_ACCOUNT_BLOCKED: '<?php echo $lang['home']['login']['form']['error']['accountblocked'] ?>',
            RECOVERACC_BUTTON: '<?php echo $lang['home']['recoveracc']['form']['send'] ?>',
            RECOVERACC_CODE_WRONG: '<?php echo $lang['home']['login']['form']['error']['codewrong'] ?>',
            RECOVERACC_INTERNAL_ERROR: '<?php echo $lang['home']['login']['form']['error']['internalerror'] ?>',
            RECOVERACC_NOT_LOGGED: '<?php echo $lang['home']['login']['form']['error']['notlogged'] ?>',
            RECOVERACC_TOO_EARLY: '<?php echo $lang['home']['login']['form']['error']['tooearly'] ?>',
            RECOVERACC_RESEND_SUCCESS: '<?php echo $lang['home']['login']['form']['success']['resend'] ?>',
            PHONE_NEEDED: '<?php echo $lang['home']['register']['form']['error']['phonenotsent'] ?>',
            CRASH_ACCOUNT_BANNED: '<?php echo $lang['home']['login']['messages']['banned'] ?>',
            PAYMENT_ERROR_ANOTHER_SESSION: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['anothersession'] ?>',
            PAYMENT_NOT_LOGGED: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['notlogged'] ?>',
            PAYMENT_INVALID_CCN: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['invalidccn'] ?>',
            PAYMENT_INVALID_NAME: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['invalidname'] ?>',
            PAYMENT_INVALID_EXP: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['invalidexp'] ?>',
            PAYMENT_INVALID_CVC: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['invalidcvc'] ?>',
            PAYMENT_API_CRASH: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['apicrash'] ?>',
            PAYMENT_INVALID_PSICO: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['invalidpsico'] ?>',
            PAYMENT_DATA_NOT_VALID: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['datanotvalid'] ?>',
            PAYMENT_DATE_ALREADY_PASSED: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['alreadypassed'] ?>',
            PAYMENT_DATE_ALREADYPICKED: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['datepickedalready'] ?>',
            PAYMENT_CALENDAR_NOT_ENABLED: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['calendarnotenabled'] ?>',
            PAYMENT_TRANSACTION_ERROR: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['transactionerror'] ?>',
            PAYMENT_API_ERROR: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['apierror'] ?>',
            PAYMENT_DATA_NOT_COMPLETED: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['datanotcompleted'] ?>',
            PAYMENT_PAYMENTS_DISABLED: '<?php echo $lang['home']['modal']['buySessions']['payment']['error']['paymentsdisabled'] ?>',
            pagetitle: '<?php echo $lang['pagetitle']['base'] ?>',
            pagetitlePsicos: '<?php echo $lang['pagetitle']['psicos'] ?>',
            pagetitleCoaches: '<?php echo $lang['pagetitle']['coaches'] ?>',
            pagetitleTest: '<?php echo $lang['pagetitle']['test'] ?>',
            pagetitleProfile: '<?php echo $lang['pagetitle']['profile'] ?>',
            pagetitleTerms: '<?php echo $lang['pagetitle']['terms'] ?>',
            pagetitleContact: '<?php echo $lang['pagetitle']['contact'] ?>',
            pagetitlePsicoRegister: '<?php echo $lang['pagetitle']['psicoregister'] ?>',
            pagetitleUserRegister: '<?php echo $lang['pagetitle']['userregister'] ?>',
            pagetitleLogin: '<?php echo $lang['pagetitle']['login'] ?>',
            pagetitleRecoverPass: '<?php echo $lang['pagetitle']['recoverpass'] ?>',
            pagetitleLogoutLoggedSmw: '<?php echo $lang['pagetitle']['logoutloggedsmw'] ?>',
            pagetitleLogout: '<?php echo $lang['pagetitle']['logout'] ?>',
            pagetitleUserSession: '<?php echo $lang['pagetitle']['usersession'] ?>',
            pagetitlePsicoSession: '<?php echo $lang['pagetitle']['psicosession'] ?>',
            pagetitleRecover: '<?php echo $lang['pagetitle']['recover'] ?>',
            pagetitlePrivacy: '<?php echo $lang['pagetitle']['privacy'] ?>',
            pagetitleExtProfile: '<?php echo $lang['pagetitle']['extprofile'] ?>',
            pagetitleError: '<?php echo $lang['pagetitle']['error'] ?>',
            pagetitleRecoverPassCode: '<?php echo $lang['pagetitle']['recoverpasscode'] ?>',
            pagetitleTestSingle: '<?php echo $lang['pagetitle']['testsingle'] ?>',
            pagetitleNotes: '<?php echo $lang['pagetitle']['notes'] ?>',
            userSessionReminder: '<?php echo $lang['home']['notify']['reminder']['user'] ?>',
            psicoSessionReminder: '<?php echo $lang['home']['notify']['reminder']['psico'] ?>',
            userSessionReminderNavigator: '<?php echo $lang['home']['notify']['reminder']['usernav'] ?>',
            psicoSessionReminderNavigator: '<?php echo $lang['home']['notify']['reminder']['psiconav'] ?>',
            userSessionReminderNavigatorJustNow: '<?php echo $lang['home']['notify']['reminder']['usernavjustnow'] ?>',
            psicoSessionReminderNavigatorJustNow: '<?php echo $lang['home']['notify']['reminder']['psiconavjustnow'] ?>',
            userSessionReminderJustNow: '<?php echo $lang['home']['notify']['reminder']['userjustnow'] ?>',
            psicoSessionReminderJustNow: '<?php echo $lang['home']['notify']['reminder']['psicojustnow'] ?>',
            NAVIGATOR_ENABLE_NOTIFICATIONS: '<?php echo $lang['home']['notify']['navigator']['enable'] ?>',
            PROFILE_UPDATE_PASSWORD_BTNOK: '<?php echo $lang['home']['profile']['update']['password']['btnok'] ?>',
            PROFILE_UPDATE_PASSWORD_BTNCNL: '<?php echo $lang['home']['profile']['update']['password']['btncnl']  ?>',
            PROFILE_UPDATE_PASSWORD_NEWPASS1PH: '<?php echo $lang['home']['profile']['update']['password']['newpass1ph']  ?>',
            PROFILE_UPDATE_PASSWORD_NEWPASS2PH: '<?php echo $lang['home']['profile']['update']['password']['newpass2ph']  ?>',
            PROFILE_UPDATE_PASSWORD_OLDPASSPH: '<?php echo $lang['home']['profile']['update']['password']['oldpassph']  ?>',
            PROFILE_UPDATE_PASSWORD_NEWPASS1: '<?php echo $lang['home']['profile']['update']['password']['newpass1']  ?>',
            PROFILE_UPDATE_PASSWORD_NEWPASS2: '<?php echo $lang['home']['profile']['update']['password']['newpass2']  ?>',
            PROFILE_UPDATE_PASSWORD_OLDPASS: '<?php echo $lang['home']['profile']['update']['password']['oldpass']  ?>',
            PROFILE_UPDATE_PASSWORD_NODATA: '<?php echo $lang['home']['profile']['update']['password']['nodata']  ?>',
            PROFILE_UPDATE_PASSWORD_SUCCESS: '<?php echo $lang['home']['profile']['update']['password']['success']  ?>',
            PROFILE_UPDATE_PASSWORD_NOTMATCH: '<?php echo $lang['home']['profile']['update']['password']['notmatch']  ?>',
            PROFILE_UPDATE_PASSWORD_OLDPASSNOTMATCH: '<?php echo $lang['home']['profile']['update']['password']['oldpassnotmatch']  ?>',
            PROFILE_UPDATE_PASSWORD_ISSAME: '<?php echo $lang['home']['profile']['update']['password']['issame']  ?>',
            PROFILE_UPD_ERROR_PPH: '<?php echo $lang['home']['profile']['update']['error']['pph']  ?>',
            PROFILE_UPD_ERROR_TYPE_NOTVALID: '<?php echo $lang['home']['profile']['update']['error']['type']  ?>',
            PROFILE_UPD_ERROR_DESCRIPTION: '<?php echo $lang['home']['profile']['update']['error']['desc']  ?>',
            PROFILE_UPD_PPH_CURENCY: '<?php echo $lang['home']['profile']['editorProf']['pph']  ?>',
            PROFILE_UPD_PPH_CURENCY_EUR: '<?php echo $lang['CORE']['currency']['EUR']['symbol'] ?>',
            PROFILE_UPD_PPH_CURENCY_GBP: '<?php echo $lang['CORE']['currency']['GBP']['symbol'] ?>',
            PROFILE_UPD_PPH_CURENCY_USD: '<?php echo $lang['CORE']['currency']['USD']['symbol'] ?>',
            PASS_NOT_MATCH: '<?php echo $lang['home']['recover']['passnotmatch']  ?>',
            RECOVER_CODE_INVALID: '<?php echo $lang['home']['recover']['codeinvalid'] ?>',
            TEST_BTN_NEXT: '<?php echo $lang['home']['test']['next'] ?>',
            TEST_BTN_SUBMIT: '<?php echo $lang['home']['test']['submit'] ?>',
            TEST_DONE: '<?php echo $lang['home']['test']['done'] ?>',
            CHAT_CONNECTED_SUCCESS: '<?php echo $lang['home']['chat']['connectedsuccess'] ?>',
            CHAT_DISCONNECTED_SUCCESS: '<?php echo $lang['home']['chat']['disconnectedsuccess'] ?>',
            CHAT_SERVER_DOWN: '<?php echo $lang['home']['chat']['serverdown'] ?>',
            CHAT_SERVER_ERROR: '<?php echo $lang['home']['chat']['servererror'] ?>',
            CHAT_SERVER_ERROR_MSGPH: '<?php echo $lang['home']['chat']['servererrormsgph'] ?>',
            CHAT_MESSAGE_NOTSERVED: '<?php echo $lang['home']['chat']['mesgnotserved'] ?>',
            NOTES_INVALID: '<?php echo $lang['home']['notes']['notloaded'] ?>',
            voteSuccess: '<?php echo $lang['home']['session']['ended']['votes']['success'] ?>',
            SESSION_ENDING: '<?php echo $lang['home']['session']['ending']['notify'] ?>',
            SESSION_ABANDONED: '<?php echo $lang['home']['session']['abandoned'] ?>',
            SESSION_LIMITED_WINDOW: '<?php echo $lang['home']['session']['limitwindow'] ?>',
            PROFILE_UPD_ERROR_PAT: '<?php echo $lang['home']['profile']['update']['error']['pat'] ?>',
            PROFILE_CALENDAR_EDITOR_SESSLENGTH_MIN: '<?php echo $lang['home']['profile']['calendar']['editor']['sesslenghtmin'] ?>',
            PROFILE_UPD_ERROR_CALENDARMAXDATE: '<?php echo $lang['home']['profile']['calendar']['error']['maxdate'] ?>',
            PROFILE_UPD_ERROR_CALENDARDAYS: '<?php echo $lang['home']['profile']['calendar']['error']['days'] ?>',
            PROFILE_UPD_ERROR_INVALIDDATA: '<?php echo $lang['home']['profile']['calendar']['error']['invdata'] ?>',
            PROFILE_UPD_ERROR_NOWAY: '<?php echo $lang['home']['profile']['calendar']['error']['noway'] ?>',
            PROFILE_UPD_ERROR_SESSIONSDROPPED: '<?php echo $lang['home']['profile']['calendar']['error']['sessiondropped'] ?>',
            PROFILE_UPD_SUCCESSCLDR: '<?php echo $lang['home']['profile']['calendar']['success'] ?>',
        };
        var configTranscription = {
            loadTime: <?php echo config('login.seconds.delay')*1000 ?>,
            sortDir: '<?php echo config('listing.sort.dir') ?>',
            defaultSortDir: '<?php echo config('listing.sort.dir') ?>',
            showedIdsAlready: null,
            actualSortType: 'bestmatch',
            weekStartDayMonday: <?php echo (defined('USER_WEEKSTARTS') ? (USER_WEEKSTARTS == 'M' ? 'true':'false'):(config('timezone.default.weekdaystart') == 'M' ? 'true':'false'));  ?>,
            modalTheme: '<?php echo config('api.jquery.vex-theme') ?>',
            dbg: <?php echo config('debug') ?>,
            URL: '<?php echo URL ?>',
            paymentStatus: <?php echo config('payments.enabled.global') ?>,
            paymentDot: '●',
            loggedIn: 0,
            maxFileSize: <?php echo round($core->getUploadFileSizeBytes(config('php.profile.maximagesize'))*0.000001) ?>,
            profileImageSize: <?php echo config('profile.photos.pxsize') ?>,
            sessionDefaultLenghtInMins: <?php echo config('session.defaultlenghtmins') ?>,
            chatServer: '<?php echo config('chat.host').':'.config('chat.port') ?>',
            profileDescMinLength: '<?php echo config('profile.description.minlength') ?>',
            LISTING_MAX_MONEY: <?php echo ceil($db->query('SELECT MAX(pph) FROM users_psicos WHERE pphCoin="'.(USER_LOGGED_IN ? USER_CURRENCY:config('default.currency')).'"')->fetch_row()[0])?>,
            LISTING_MIN_MONEY: <?php echo ceil($db->query('SELECT MIN(pph) FROM users_psicos WHERE pphCoin="'.(USER_LOGGED_IN ? USER_CURRENCY:config('default.currency')).'"')->fetch_row()[0])?>,
            ACTUAL_CURRENCY: '<?php if(USER_LOGGED_IN) { echo $lang['CORE']['currency'][USER_CURRENCY]['symbol']; } else { echo $lang['CORE']['currency'][config('default.currency')]['symbol']; } ?>',
            contractingCheckerInterval:  <?php echo config('sessionnow.checker.interval') ?>*1000,
            <?php if(USER_LOGGED_IN) { echo 'userPhoto: \''.USER_PROFILEIMG.'\','; } ?>
        };
        vex.defaultOptions.className = configTranscription['modalTheme'];
        
        System.config({
          transpiler: 'typescript', 
          typescriptOptions: {emitDecoratorMetadata: true}, 
          packages: {'home': {defaultExtension: 'ts'}} 
        });
        System.import('<?php echo URL ?>/assets/js/home/angular2/boot.php').then(null, console.error.bind(console)); 
 
                    function closeNotification()
                    {
                        if(typeof notify != "undefined")
                        {
                            notify.close();
                        }
                    }
            <?php
            
            if(USER_LOGGED_IN)
            {
                if(!USER_TYPE_CLIENT && (USER_PROF_PPH == 0 || USER_PROF_PAYPALACC == ''|| USER_PROF_DESCRIPTION == ''))
                {
                    echo '$( document ).ready(function() {
                        notify = $.notify({
                        message: "'.$lang['home']['profile']['needupdate']['psico'].'",
                            icon: "'.USER_PROFILEIMG.'",
                            title: "'.USER_NAME.' '.USER_SURNAMES.'",
                            url: "'.URL.'/#/Profile",
                            target: "_self"
                        },{
                            timer:0,
                            delay:0,
                            type: \'minimalist\',
                            icon_type: \'image\',
                            template: \'<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">\' +
                                    \'<a onclick="closeNotification()" href="{3}"><img data-notify="icon" class="img-circle pull-left">\' +
                                    \'<span data-notify="title">{1}</span>\' +
                                    \'<span data-notify="message">{2}</span>\' +
                            \'</a></div>\',
                            newest_on_top: false,
                            placement: {
                                    from: \'bottom\',
                                    align: \'right\'
                            }
                        });
                    });';
                }
                /* Check status function */
                echo 'function checkStatus() {
                    $.ajax({
                        url: \''.URL.'/pingonline\'
                      });
                }
                checkStatus();
                setInterval(checkStatus, '.(config('userlogged.checkonline.interval')*1000).');
                $(window).on("unload", function(){
                    $.ajax({
                        async: true,
                        url: \''.URL.'/pingoffline\'
                    });
                });';
                /* Session reminders */
                echo '
                    var notify, timeloop = '.(config('userlogged.checksessions.interval')*10000).',notificationsrequestaccess = false;
                    function sendLocalNotify(type,uname,image,timeleft,timeleftseconds)
                    {
                        var message,username;
                        if(type == \'client\')
                        {
                            if(timeleftseconds != 0)
                            {
                                sendmessage = langTranscription[\'userSessionReminder\'];
                            }
                            else
                            {
                                sendmessage = langTranscription[\'userSessionReminderJustNow\'];
                            }
                            gourl = "'.URL.'/index.php/#/UserSession";
                        }
                        else
                        {
                            if(timeleftseconds != 0)
                            {
                                sendmessage = langTranscription[\'psicoSessionReminder\'];
                            }
                            else
                            {
                                sendmessage = langTranscription[\'psicoSessionReminderJustNow\'];
                            }
                            gourl = "'.URL.'/index.php/#/PsicoSession";
                        }
                        closeNotification();
                        notify = $.notify({
                            message: sendmessage.replace(\'{{time}}\',timeleft),
                            icon: image,
                            title: uname,
                            url: gourl,
                            target: "_self"
                        },{
                            timer:0,
                            delay:0,
                            type: \'minimalist\',
                            icon_type: \'image\',
                            template: \'<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">\' +
                                    \'<a onclick="closeNotification()" href="{3}"><img data-notify="icon" class="img-circle pull-left">\' +
                                    \'<span data-notify="title">{1}</span>\' +
                                    \'<span data-notify="message">{2}</span>\' +
                            \'</a></div>\',
                            newest_on_top: false,
                            placement: {
                                    from: \'bottom\',
                                    align: \'right\'
                            }
                        });
                    }
                    
                    function onPermissionGrantedNotification () {
                        vex.closeAll();
                        doNotification();
                    }

                    function onPermissionDeniedNotification () {
                        vex.closeAll();
                    }
                    var unameshown,sendmessage, uimage;
                    function doNotification () {
                        var myNotification = new Notify(unameshown, {
                            body: sendmessage,
                            tag: \'Soluzink-\' + (Date.now() % 1000) / 1000,
                            timeout: '.(config('userlogged.checksessions.interval')*10000).',
                            icon: uimage
                        });

                        myNotification.show();
                    }
                    function showNavigatorNotification(type,uname,image,timeleft,timeleftseconds)
                    {
                        unameshown = uname;
                        uimage = image;
                        if(type == \'client\')
                        {
                            if(timeleftseconds != 0)
                            {
                                sendmessage = langTranscription[\'userSessionReminderNavigator\'].replace(\'{{time}}\',timeleft);
                            }
                            else
                            {
                                sendmessage = langTranscription[\'userSessionReminderNavigatorJustNow\'];
                            }
                            gourl = "'.URL.'/#/UserSession";
                        }
                        else
                        {
                            if(timeleftseconds != 0)
                            {
                                sendmessage = langTranscription[\'psicoSessionReminderNavigator\'].replace(\'{{time}}\',timeleft);
                            }
                            else
                            {
                                sendmessage = langTranscription[\'psicoSessionReminderNavigatorJustNow\'];
                            }
                            gourl = "'.URL.'/#/PsicoSession";
                        }
                        if (!Notify.needsPermission) {
                            doNotification();
                        } else if (Notify.isSupported()) {
                            notificationsrequestaccess = true;
                            vex.dialog.alert({
                                message: langTranscription[\'NAVIGATOR_ENABLE_NOTIFICATIONS\'],
                                    buttons: [
                                            $.extend({}, vex.dialog.buttons.YES, { className: \'dialog-button-hidden\', click: \'\' }),
                                            $.extend({}, vex.dialog.buttons.NO, { className: \'dialog-button-hidden\', click: \'\' })
                                    ],
                            showCloseButton: false,
                            overlayClosesOnClick: false
                            });
                            Notify.requestPermission(onPermissionGrantedNotification, onPermissionDeniedNotification);
                        }
                    }
                    function sessionReminder()
                    {
                        $.ajax({
                            url: \''.URL.'/pingsession\',
                                type : "post",
                                async: true,
                                success : function(sessions) {
                                   if(sessions != \'NO_REMINDERS\')
                                    {
                                        sessions = sessions.split(\'|||\');
                                        if(window.location.href.search(\'UserSession\') == -1 && window.location.href.search(\'PsicoSession\') == -1)
                                        {
                                            if(sessions[5])
                                            {
                                                timeloop = '.(config('userlogged.checksessions.interval')*600000).';
                                                sessions[4] = 0;
                                            }
                                            else
                                            {
                                                timeloop = sessions[4]/2*1000;
                                            }
                                            if(sessions[0] == \'CLIENT\')
                                            {
                                                if (!document.hidden) {
                                                    sendLocalNotify("client",sessions[1],sessions[2],sessions[3],sessions[4]);
                                                }
                                                else
                                                { 
                                                    showNavigatorNotification("client",sessions[1],sessions[2],sessions[3],sessions[4]);
                                                }
                                            }
                                            else
                                            {
                                                if (!document.hidden) {
                                                    sendLocalNotify("prof",sessions[1],sessions[2],sessions[3],sessions[4]);
                                                }
                                                else
                                                { 
                                                    showNavigatorNotification("prof",sessions[1],sessions[2],sessions[3],sessions[4]);
                                                }
                                            }
                                            notification.play();
                                        }
                                        else
                                        {
                                            timeloop = '.(config('userlogged.checksessions.interval')*600000).';
                                        }
                                    }
                                    else
                                    {
                                        timeloop = '.(config('userlogged.checksessions.interval')*600000).';
                                    }
                                }
                        });
                        if(timeloop < '.(config('userlogged.checksessions.interval')*600000).')
                        {
                            timeloop = '.(config('userlogged.checksessions.interval')*600000).';
                        }
                        setTimeout(sessionReminder, timeloop);
                    }
                    var notification = new Audio(\''.URL.'/assets/sounds/notification.mp3\');
                    sessionReminder();';
            }
            ?>
                <?php
                if(USER_LOGGED_IN && !USER_TYPE_CLIENT && USER_PROF_SESSNOW)
                {
                    
                    echo '
                     var sessnowid;   
                    function checkInmediateSessions()
                    {
                        $.ajax({
                            url : "/checkinmediatesessionpsico",
                            type : "post",
                            data: {action: "check"},
                            async: true,
                            success: function(e)
                            {
                                sessnowid = e;
                                vex.dialog.open({
                                    input: [
                                       "¿Aceptas la sesión inmediata solicitada por un usuario?"
                                    ].join(""),
                                    buttons: [
                                            $.extend({}, vex.dialog.buttons.YES, { text: "Aceptar" }),
                                            $.extend({}, vex.dialog.buttons.NO, { text: "Cancelar" })
                                    ],
                                    onSubmit: function () {
                                        event.preventDefault();
                                        event.stopPropagation();
                                        $.ajax({
                                            url : "/checkinmediatesessionpsico",
                                            type : "post",
                                            data: {action: "answer",sessid: sessnowid},
                                            async: true,
                                            success: function(e)
                                            {
                                                vex.dialog.open({
                                                    input: [
                                                       "A continuación deberás esperar el pago del cliente. Mientras tanto, espérale en la sala."
                                                    ].join(""),
                                                    buttons: [
                                                            $.extend({}, vex.dialog.buttons.YES, { text: "¡Vamos allá!" }),
                                                            $.extend({}, vex.dialog.buttons.NO, { className: \'button-hidden\', text: "" })
                                                    ],
                                                    overlayClosesOnClick: false,
                                                    onSubmit: function () {
                                                        event.preventDefault();
                                                        event.stopPropagation();
                                                        window.location = "/PsicoSession";
                                                    }
                                                });
                                            }
                                        });
                                    },
                                    overlayClosesOnClick: false
                                });
                            }
                        });
                    }';
                }
                ?>
    $.ajax({
        url : "/settimezone",
        type : "post",
        data: {timezone: Intl.DateTimeFormat().resolvedOptions().timeZone},
        async: true
    });
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-101612262-1', 'auto');
          ga('send', 'pageview');
                </script>
  </head>
  <body>
    <soluzink></soluzink>
    <div class="loading">
        <div id="loaderContainer">
            <div class="loaderHeader">
                <div class="loaderLogo"> <a href="#"> Soluzink </a> </div>
                <div class="loaderStatus">
                    <svg class="loaderStatusGraphic" width="60px" height="60px" viewBox="0 0 80 80">
                        <path class="loaderStatus-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
                        <path id="loaderStatusRenderer" class="loaderStatus-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
   <script src="<?php echo URL ?>/assets/vendors/modernizr/modernizr.loader.js"></script>
   <script src="<?php echo URL ?>/assets/vendors/card/jquery.card.js"></script>
   <script src="<?php echo URL ?>/assets/js/home/loader.js"></script>
  </body>

</html>
