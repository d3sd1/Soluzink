<?php require('../../../../../kernel/core.php');
if(USER_IS_BLOCKED || !USER_LOGGED_IN) {die();}
?>
<div class="session-spinner"><i class="fa fa-spinner fa-spin"></i></div>
<div class="session-notbought hide">
    <div class="container-fluid pg-header terms-bg">
        <div class="pg-header-content">
           <h1 class="pg-title"> <?php echo $lang['home']['session']['nosessions'] ?> </h1>
        </div>
        <div class="pg-header-icon fa fa-newspaper-o"></div>
     </div>
     <div class="container-fluid blog single-block single-option-2">
        <div class="row">
           <div class="col-md-8 col-md-offset-2 text-center">
              <div class="post-content margin-top text-justify">
                 <div class="container pg-content">
                    <div class="row text-center">
                       <div class="img-left"> <img draggable="false" src="<?php echo URL ?>/assets/images/home/session/think.png"/> </div>
                       <div class="text-inline">
                          <h2><?php echo $lang['home']['session']['buysession']['btn'] ?></h2>
                          <?php echo $lang['home']['session']['buysession']['dsc'] ?>
                       </div>
                    </div>
                    <div class="separator"></div>
                    <div class="row text-center"> <a [routerLink]="['/Psicos']" class="button big"><?php echo $lang['home']['session']['buysession']['btn'] ?></a> </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
</div>
<div class="session-badgateway hide">
    <div class="container-fluid pg-header terms-bg">
        <div class="pg-header-content">
           <h1 class="pg-title"> <?php echo $lang['home']['session']['badgateway'] ?> </h1>
        </div>
        <div class="pg-header-icon fa fa-newspaper-o"></div>
     </div>
     <div class="container-fluid blog single-block single-option-2">
        <div class="row">
           <div class="col-md-8 col-md-offset-2 text-center">
              <div class="post-content margin-top text-justify">
                 
              </div>
           </div>
        </div>
     </div>
</div>
<div class="session-ends hide">
    <div class="container-fluid pg-header terms-bg">
        <div class="pg-header-content">
           <h1 class="pg-title"> <?php echo $lang['home']['session']['ends'] ?> </h1>
        </div>
        <div class="pg-header-icon fa fa-newspaper-o"></div>
     </div>
     <div class="container-fluid blog single-block single-option-2">
        <div class="row">
           <div class="col-md-8 col-md-offset-2 text-center">
              <div class="post-content margin-top text-justify">
                  <div class="testcontainter">
                      <h1 id="session-ends-title"><?php echo $lang['home']['session']['ended']['vote'] ?></h1>
                      <ul id="votesPicker" data-question="0">
                          <li><input id="a-option" type="radio" checked name="votePicker" value="1"><label for="a-option"><?php echo $lang['home']['session']['ended']['votes']['yes'] ?></label><div class="check"></div></li>
                          <li><input id="b-option" type="radio" name="votePicker" value="0"><label for="b-option"><?php echo $lang['home']['session']['ended']['votes']['no'] ?></label><div class="check"></div></li>
                      </ul>
                      <div class="form-group" id="testimonial">
                        <label for="comment"><?php echo $lang['home']['session']['ended']['testimonial'] ?></label>
                        <textarea class="form-control" rows="5" name="testimonial" placeholder="<?php echo $lang['home']['session']['ended']['testimonialph'] ?>"></textarea>
                      </div>
                  <a class="margin-top-20 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect bg-green fonin-top-20t-white float-right bottom-20" id="confirmVote"><?php echo $lang['home']['session']['ended']['votes']['btn'] ?></a>
                </div>
              </div>
           </div>
        </div>
     </div>
</div>
<div class="session-timer hide">
    <div class="container-fluid pg-header terms-bg">
        <div class="pg-header-content">
           <h1 class="pg-title"> <?php echo $lang['home']['session']['timer'] ?> </h1>
        </div>
        <div class="pg-header-icon fa fa-newspaper-o"></div>
     </div>
     <div class="container-fluid blog single-block single-option-2">
        <div class="row">
           <div class="col-md-8 col-md-offset-2 text-center">
              <div class="post-content margin-top text-justify">
                  <h1><?php echo $lang['home']['session']['timercontent'] ?>: <span id="timersessionleft"></span></h1>
              </div>
           </div>
        </div>
     </div>
</div>
<div class="row sessionwindow row-no-padding">
    <div class="col-xs-9 left-side col-no-padding">
        <div id="videos">
            <div id="subscriber"></div>
            <div id="publisher"></div>
        </div>
    </div>
    <div class="col-xs-4 right-side col-no-padding">
        <div class="chat chat-type-client">
            <div class="chat-title">
              <h1 id="otherName"> </h1>
              <h2 id="otherSurnames"> </h2>
              <figure class="avatar"><img id="otherPhoto" src="" /></figure>
              <span id="timeLeft">00:00</span>
            </div>
            <div class="messages">
                <div class="messages-content"></div>
            </div>
            <div class="message-box">
              <textarea type="text" class="message-input" placeholder="<?php echo $lang['home']['session']['psico']['chatph'] ?>"></textarea>
              <button type="submit" class="message-submit"><?php echo $lang['home']['session']['psico']['chatsend'] ?></button>
            </div>
          </div>
    </div>
</div>