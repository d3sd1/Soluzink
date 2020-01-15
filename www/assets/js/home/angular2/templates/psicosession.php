<?php require('../../../../../kernel/core.php');
if(USER_IS_BLOCKED || !USER_LOGGED_IN) {die();}
?>
<div class="session-spinner"><i class="fa fa-spinner fa-spin"></i></div>
<div class="session-notbought hide">
    <div class="container-fluid pg-header terms-bg">
        <div class="pg-header-content">
           <h1 class="pg-title"> <?php echo $lang['home']['session']['psiconosession']['title'] ?> </h1>
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
                          <h2><?php echo $lang['home']['session']['psiconosession']['h2'] ?></h2>
                          <?php echo $lang['home']['session']['psiconosession']['dsc'] ?>
                       </div>
                    </div>
                    <div class="separator"></div>
                    <div class="row text-center"> <a [routerLink]="['/Profile']" class="button big"><?php echo $lang['home']['session']['psiconosession']['btn'] ?></a> </div>
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

<div class="session-ends-psico hide">
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
                      <h1><?php echo $lang['home']['session']['ended']['psico'] ?></h1>
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
        <div class="chat chat-type-psico">
            <div class="chat-title">
              <h1 id="otherName"> </h1>
              <h2 id="otherSurnames"> </h2>
              <figure class="avatar">
                <img id="otherPhoto" src="" /></figure>
            </div>
            <div class="messages">
              <div class="messages-content"></div>
            </div>
            <div class="message-box">
              <textarea type="text" class="message-input" placeholder="<?php echo $lang['home']['session']['psico']['chatph'] ?>"></textarea>
              <button type="submit" class="message-submit"><?php echo $lang['home']['session']['psico']['chatsend'] ?></button>
            </div>
          </div>
        <textarea placeholder="<?php echo $lang['home']['session']['psico']['notesph'] ?>" rows="20" id="psicoNotes" cols="40" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"></textarea>
    </div>
</div>