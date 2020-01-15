<?php require('../../../../../kernel/core.php');
$token = $core->generateCSRFToken(); ?>
<div class="recover-background">
	<div class="login-wrapper">
	  <form class="login" id="recoverForm" method="POST" autocomplete="off">
		<input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
		<p class="title"><?php echo $lang['home']['recover']['form']['title'] ?></p>
		<input type="text" name="recoverEmail" placeholder="<?php echo $lang['home']['recover']['form']['email'] ?>" autofocus/>
		<i class="fa fa-envelope-open-o"></i>
		<button class="send">
		  <i class="spinner"></i>
		  <span class="state"><?php echo $lang['home']['recover']['form']['send'] ?></span>
		</button>
	  </form>
	</div>
</div>