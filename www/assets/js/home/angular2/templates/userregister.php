<?php require('../../../../../kernel/core.php');
$token = $core->generateCSRFToken();
$captchaCode = $core->generateCaptcha();
$message = $captchaCode['message'];
?>
		<div class="container-fluid pg-header register-bg">
            <div class="pg-header-content">
               <h1 class="pg-title"> <?php echo $lang['home']['register']['title'] ?> </h1>
               <h4 class="pg-subtitle"> <?php echo $lang['home']['register']['desc'] ?> </h4>
            </div>
            <div class="pg-header-icon fa fa-user-plus"></div>
        </div>
         <div class="container pg-content">
            <div class="col-sm-12 text-center">
               <div class="alert alert-success" role="alert" id="registerSuccess">
                  <p><?php echo $lang['home']['register']['success'] ?></p>
               </div>
               <div class="alert alert-error" role="alert" id="registerError">
                  <p><?php echo $lang['home']['register']['error'] ?></p>
               </div>
               <form method="POST" id="registerForm" name="register" class="form-horizontal contact-form support">
				  <input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
                  <div class="form-group">
                     <div class="col-sm-6">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="text" name="registerName" autocomplete="off" placeholder="<?php echo $lang['home']['register']['form']['name'] ?>" class="form-control" required> </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user-o"></i></span> <input type="text" name="registerSurnames" autocomplete="off" placeholder="<?php echo $lang['home']['register']['form']['surnames'] ?>" class="form-control" required> </div>
                     </div>
                  </div>
				  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-envelope"></i></span> <input type="email" name="registerEmail" autocomplete="off" placeholder="<?php echo $lang['home']['register']['form']['email'] ?>" class="form-control" required> </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-phone"></i></span> <input type="text" name="registerPhone" autocomplete="off" placeholder="<?php echo $lang['home']['register']['form']['phone'] ?>" class="form-control"> </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-6">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-key"></i></span> <input type="password" name="registerPass" autocomplete="off" placeholder="<?php echo $lang['home']['register']['form']['pass'] ?>" class="form-control"> </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span> <input type="password" name="registerPassrep" autocomplete="off" placeholder="<?php echo $lang['home']['register']['form']['passrep'] ?>" class="form-control"> </div>
                     </div>
                  </div>
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-check-square-o"></i></span> <input type="text" name="registerCaptcha" autocomplete="off" type="number" min="0" placeholder="<?php echo $lang['home']['contact']['verify'].$message ?>" class="form-control" required> </div>
                     </div>
                  </div>
                  <div class="form-group sub">
                     <div class="col-sm-12"> <button type="submit" id="registerSubmit" class="btn btn-warning submit"><?php echo $lang['home']['register']['submit'] ?></button> </div>
                  </div>
               </form>
            </div>
         </div>