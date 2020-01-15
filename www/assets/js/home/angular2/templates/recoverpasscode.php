<?php require('../../../../../kernel/core.php');
$token = $core->generateCSRFToken(); ?>
<div class="recover-background">
	<div class="login-wrapper">
	  <form class="login" id="recoverFormUnlocked" method="POST" autocomplete="off">
		<input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
		<p class="title"><?php echo $lang['home']['recover']['form']['codetitle'] ?></p>
		<input type="password" name="newPass" placeholder="<?php echo $lang['home']['recover']['form']['newPass'] ?>" autofocus/>
		<i class="fa fa-lock"></i>
		<input type="password" name="newPass2" placeholder="<?php echo $lang['home']['recover']['form']['newPass2'] ?>" autofocus/>
		<i class="fa fa-lock"></i>
		<button class="send">
		  <i class="spinner"></i>
		  <span class="state"><?php echo $lang['home']['recover']['form']['sendcode'] ?></span>
		</button>
	  </form>
	</div>
</div>