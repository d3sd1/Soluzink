<?php require('../../../../../kernel/core.php');
$token = $core->generateCSRFToken();?>
<div class="login-background">
	<div class="login-wrapper">
	  <form class="login" id="loginForm" method="POST" autocomplete="off">
		<input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
		<p class="title"><?php echo $lang['home']['login']['form']['title'] ?></p>
		<input type="text" name="loginEmail" placeholder="<?php echo $lang['home']['login']['form']['email'] ?>" autofocus/>
		<i class="fa fa-user"></i>
		<input type="password" name="loginPwd" placeholder="<?php echo $lang['home']['login']['form']['password'] ?>" />
		<i class="fa fa-key"></i>
		<a [routerLink]="['/RecoverPass']"><?php echo $lang['home']['login']['form']['forgotpassword'] ?></a>
		<button class="send">
		  <i class="spinner"></i>
		  <span class="state"><?php echo $lang['home']['login']['form']['send'] ?></span>
		</button>
	  </form>
	</div>
</div>