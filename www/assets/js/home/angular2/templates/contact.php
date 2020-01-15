<?php require('../../../../../kernel/core.php');
$token = $core->generateCSRFToken();
$captchaCode = $core->generateCaptcha();
$message = $captchaCode['message'];
if(USER_IS_BLOCKED) {die();}
?>
		<div class="container-fluid pg-header contact-bg">
            <div class="pg-header-content">
               <h1 class="pg-title"> <?php echo $lang['home']['contact']['title'] ?> </h1>
               <h4 class="pg-subtitle"> <?php echo $lang['home']['contact']['desc'] ?> </h4>
            </div>
            <div class="pg-header-icon fa fa-envelope-open"></div>
        </div>
         <div class="container page-intro"> <?php echo $lang['home']['contact']['intro'] ?> </div>
         <div class="container pg-content">
            <div class="col-sm-12 text-center">
               <div class="alert alert-success" role="alert" id="contactSuccess">
                  <p><?php echo $lang['home']['contact']['success'] ?></p>
               </div>
               <div class="alert alert-error" role="alert" id="contactError">
                  <p><?php echo $lang['home']['contact']['error'] ?></p>
               </div>
               <form method="POST" id="contactForm" name="contact" class="form-horizontal contact-form support">
                  <input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
                  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="text" name="contactName" autocomplete="off" <?php echo (USER_LOGGED_IN === false ? 'placeholder="'.$lang['home']['contact']['name'].'"':'value="'.USER_FULLNAME.'" readonly="readonly"'); ?> class="form-control" required> </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-envelope"></i></span> <input type="email" name="contactEmail" autocomplete="off" <?php echo (USER_LOGGED_IN === false ? 'placeholder=" '.$lang['home']['contact']['email'].' "':'value="'.USER_EMAIL.'" readonly="readonly"'); ?> class="form-control" required> </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-phone"></i></span> <input type="text" name="contactPhone" autocomplete="off" <?php echo (USER_LOGGED_IN === false || @USER_PHONE == 0 ? 'placeholder=" '.$lang['home']['contact']['phone'].' "':'value="'.USER_PHONE.'" readonly="readonly"'); ?> class="form-control" required> </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <textarea name="contactMessage" class="form-control" placeholder="<?php echo $lang['home']['contact']['description'] ?>" required></textarea> </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 inputGroupContainer">
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-check-square-o"></i></span> <input type="text" name="contactCaptcha" autocomplete="off" type="number" min="0" placeholder="<?php echo $lang['home']['contact']['verify'].$message ?>" class="form-control" required> </div>
                     </div>
                  </div>
                  <div class="form-group sub">
                     <div class="col-sm-12"> <button type="submit" id="contactSubmit" class="btn btn-warning submit"><?php echo $lang['home']['contact']['submit'] ?></button> </div>
                  </div>
               </form>
            </div>
         </div>