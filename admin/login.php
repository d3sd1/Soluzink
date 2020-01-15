<?php require('admin.php');
$token = $core->generateCSRFToken();
if(ADMIN_LOGGED_IN)
{
	header('Location: '.URL.'/start');
        die();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="<?php echo $alang['meta.lang'] ?>" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="<?php echo $alang['meta.lang'] ?>" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?php echo $alang['meta.lang'] ?>">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="<?php echo $alang['meta.encoding'] ?>" />
        <title><?php echo $alang['title.login'] ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php echo $alang['meta.description'] ?>" name="description" />
        <meta content="<?php echo $alang['meta.author'] ?>" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo URL ?>/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo URL ?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo URL ?>/assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo BASEURL ?>/favicon.ico" /> </head>
		<script>var loginRecaptcha; /*var forgotMailCaptcha;*/var reCaptchaCallback = function() {loginRecaptcha=grecaptcha.render('googleRecaptchaValueAdminLogin', {'sitekey' : '<?php echo config('recaptcha.publickey') ?>'}); /*forgotMailCaptcha = grecaptcha.render('googleRecaptchaValueAdminPassRet', {'sitekey' : '<?php echo config('recaptcha.publickey') ?>'});*/};</script>
		<script src="https://www.google.com/recaptcha/api.js?onload=reCaptchaCallback&render=explicit&hl=<?php echo USER_LANG ?>" async defer></script>
    <!-- END HEAD -->

    <body class="login" style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" unselectable="on" onselectstart="return false;">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(assets/pages/img/login/bg1.jpg)">
                        <div class="login-logo logo"> <a href="<?php echo URL ?>" style="opacity: 1;"> Soluzink </a> </div> </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                    <div class="login-content">
                        <h1><?php echo $alang['login.head'] ?></h1>
                        <p> <?php echo $alang['login.par'] ?> </p>
                        <form id="adminLoginForm" class="login-form" method="post" autocomplete="off">
                            <input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
                            <div class="alert alert-danger display-hide" id="loginFormSendError">
                                <button class="close" data-close="alert"></button>
                                <span id="baseError"><?php echo $alang['login.error'] ?> </span>
                            </div>
							<div class="alert alert-danger display-hide" id="loginFormErrorAttempt">
                                <button class="close" data-close="alert"></button>
                                <span id="attemptsNumber"><?php echo str_replace('{limit}',config('admin.login.maxattempts'),$alang['login.error.maxattempts']) ?> </span>
                            </div>
                            <div class="alert alert-danger display-hide" id="loginFormErrorDisabled">
                                <button class="close" data-close="alert"></button>
                                <span id="attemptsNumber"><strong><?php echo $alang['login.error.accdisabled'] ?></strong>. <?php echo $alang['login.error.accdisabled.desc'] ?></span>
                            </div>
                            <?php if(isset($_GET['logout']) && $_GET['logout'] == 'timeout')
							{
								echo '<div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
								<strong>'.$alang['logout.success'].'</strong> '.$alang['logout.success.timeout'].'
							</div>';
							}
							?>
                            <?php if(isset($_GET['logout']) && $_GET['logout'] == 'accDisabled')
							{
								echo '<div class="alert alert-warning fade in alert-dismissable" style="margin-top:18px;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
								<strong>'.$alang['logout.banned'].'</strong> '.$alang['logout.warning.banned'].'
							</div>';
							}
							?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $alang['login.email'] ?>" name="loginAdminUser" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="<?php echo $alang['login.password'] ?>" name="loginAdminPass" required/> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><div class="g-recaptcha" id="googleRecaptchaValueAdminLogin"></div></div>
                                <div class="col-sm-8 text-right">
                                    <!--<div class="forgot-password">
                                        <a href="javascript:;" id="forget-password" class="forget-password"><?php echo $alang['login.forgotpass'] ?></a>
                                    </div>-->
                                    <button class="btn green" id="loginSubmitBtn" type="submit"><?php echo $alang['login.button'] ?></button>
                                </div>
                            </div>
                        </form>
                        <!-- BEGIN FORGOT PASSWORD FORM
                        <form class="forget-form" id="adminForgotForm" method="post" autocomplete="off">
                            <input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
                            <h3 class="font-green"><?php echo $alang['login.forgotpass'] ?></h3>
                            <p> <?php echo $alang['login.forgotpass.details'] ?> </p>
                            <div class="form-group">
                                <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="<?php echo $alang['login.forgotpass.email'] ?>" name="forgotAdminEmail" />
							</div>
								<div class="g-recaptcha" id="googleRecaptchaValueAdminPassRet"></div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success uppercase"><?php echo $alang['login.forgotpass.submit'] ?></button>
                                <button type="button" id="back-btn" class="btn green btn-outline pull-right"><?php echo $alang['login.forgotpass.back'] ?></button>
                            </div>
                        </form>
                        <!-- END FORGOT PASSWORD FORM -->
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset"></div>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p><?php echo $alang['login.copyright'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="modal fade bs-modal-sm" id="badLocked" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
							<div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title"><?php echo $alang['login.badlocked'] ?></h4>
                                </div>
                                <div class="modal-body"><?php echo $alang['login.badlocked.desc'] ?></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal"><?php echo $alang['login.badlocked.close'] ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END : LOGIN PAGE 5-1 -->
        <!--[if lt IE 9]>
<script src="<?php echo URL ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo URL ?>/assets/global/plugins/excanvas.min.js"></script> 
<script src="<?php echo URL ?>/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo URL ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo URL ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo URL ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo URL ?>/assets/pages/scripts/login-5.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
		<?php
		if(isset($_GET['ref']) && $_GET['ref'] == 'badlocked')
		{
			echo '<script type="text/javascript">
				$(window).load(function(){
					$("#badLocked").modal("show");
				});
			</script>';
		}
		?>
		<script>
		$("#adminLoginForm").submit(function(event) {
				event.preventDefault();
				$("#loginFormSendError", $(".login-form")).hide();
				$("#loginFormErrorAttempt", $(".login-form")).hide();
				if(!!$('input[name=loginAdminUser').val() && !!$('input[name=loginAdminUser').val())
				{
					$.ajax({
							data:  $("#adminLoginForm").serialize(),
							url:   '<?php echo URL ?>/sendlogin',
							type:  'POST',
                                                        beforeSend: function() {
                                                            $('#loginSubmitBtn').attr('data-realtext',$('#loginSubmitBtn').text()).html('<i class="fa fa-spinner fa-spin"></i>');
                                                            $('#loginSubmitBtn').attr('disabled',true);
                                                        },
							success:  function (response) {
								response = response.split('|');
								if(response[0] == 'ERROR_BOT')
								{
									$('#attemptsNumber').html("<?php echo $alang['login.attempt.bot'] ?>");
									$("#loginFormErrorAttempt", $(".login-form")).show();
								}
								else
								{
                                                                        $('#attemptsNumber').html("<?php echo str_replace('{limit}',config('admin.login.maxattempts'),$alang['login.error.maxattempts']) ?>");
									$('#attemptsNumber').html($('#attemptsNumber').html().replace(/\<span id="attemptNumber">[0-9]<\/span>/,'<span id="attemptNumber">' + response[1] + '</span>'));
									$('#attemptsNumber').html($('#attemptsNumber').html().replace('{num}','<span id="attemptNumber">' + response[1] + '</span>'));
									if(response[0] == 'CSRF_DETECTED')
									{
                                                                            location.reload();
									} 
                                                                        else if(response[0] == 'ERROR_CAPTCHA')
									{
										grecaptcha.reset(loginRecaptcha);
										$("#loginFormErrorAttempt", $(".login-form")).show();
									} 
                                                                        else if(response[0] == 'LOGIN_SUCCESS')
									{
                                                                            window.location.replace("<?php echo URL ?>/start");
									}
									else if(response[0] == 'ERROR_USER')
									{
										grecaptcha.reset(loginRecaptcha);
                                                                                $('input[name=loginAdminPass]').val('');
										$("#loginFormErrorAttempt", $(".login-form")).show();
									}
									else if(response[0] == 'ERROR_PWD')
									{
										grecaptcha.reset(loginRecaptcha);
                                                                                $('input[name=loginAdminPass]').val('');
										$("#loginFormErrorAttempt", $(".login-form")).show();
									}
									else if(response[0] == 'ERROR_DISABLED')
									{
										grecaptcha.reset(loginRecaptcha);
                                                                                $('input[name=loginAdminPass]').val('');
										$("#loginFormErrorDisabled", $(".login-form")).show();
									}
								}
                                                            $('#loginSubmitBtn').html($('#loginSubmitBtn').attr('data-realtext'));
                                                            $('#loginSubmitBtn').attr('disabled',false);
							}
					});
				}
				else
				{
					$('#loginFormErrorAttempt').addClass('display-hide');
				}
		});
		$("#adminForgotForm").submit(function(event) {
				event.preventDefault();
				if(!$('input[name=forgotAdminEmail').val())
				{
					$.ajax({
							data:  $("#adminForgotForm").serialize(),
							url:   '<?php echo URL ?>/sendforgot',
							type:  'POST',
							success:  function (response) {
								response = response.split('|');
								if(response[0] == 'ERROR_BOT')
								{
									alert("<?php echo $alang['login.attempt.bot'] ?>");
								}
								else
								{
									if(response[0] == 'CSRF_DETECTED')
									{
                                                                            location.reload();
									} 
                                                                        else if(response[0] == 'ERROR_CAPTCHA')
									{
										grecaptcha.reset(forgotMailCaptcha);
										$("#loginFormErrorAttempt", $(".login-form")).show();
									} 
                                                                        else if(response[0] == 'ERROR_NOTSEND')
									{
										grecaptcha.reset(forgotMailCaptcha);
										alert("<?php echo str_replace('{limit}',config('admin.login.maxattempts'),$alang['login.forgotpass.maxattempts']) ?>");
									}
									else if(response[0] == 'FORGOT_SUCCESS')
									{
										window.location.replace("<?php echo URL ?>/start");
									}
								}
							}
					});
				}
				else
				{
					$('#loginFormErrorAttempt').addClass('display-hide');
				}
		});
            document.addEventListener('contextmenu', event => event.preventDefault());
       </script>
</body>
</html>