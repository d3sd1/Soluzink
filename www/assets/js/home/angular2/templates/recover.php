<?php require('../../../../../kernel/core.php');
$token = $core->generateCSRFToken();
if(!USER_IS_BLOCKED) {die();}?>
<div class="recoveracc-background">
	<div class="login-wrapper">
	  <form class="login" id="recoveraccForm" method="POST" autocomplete="off">
		<input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
		<p class="title"><?php echo $lang['home']['recoveracc']['form']['title'] ?></p>
                <div id="recoverInfoBox" class="alert alert-warning fade in">
                    <strong><?php echo $lang['home']['recoveracc']['form']['infotitle'] ?></strong> <?php echo $lang['home']['recoveracc']['form']['infodesc'] ?>
                </div>
		<input type="text" name="recoveraccCode" placeholder="<?php echo $lang['home']['recoveracc']['form']['code'] ?>" autofocus/>
		<i class="fa fa-user"></i>
		<a style="cursor: pointer" onclick="resendRecoverCode()"><?php echo $lang['home']['recoveracc']['form']['resendcode'] ?></a>
		<button class="send">
		  <i class="spinner"></i>
		  <span class="state"><?php echo $lang['home']['recoveracc']['form']['send'] ?></span>
		</button>
	  </form>
	</div>
</div>