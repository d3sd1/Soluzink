<?php require('../../../../../kernel/core.php');
$token = $core->generateCSRFToken();
$captchaCode = $core->generateCaptcha();
$message = $captchaCode['message'];
if(USER_IS_BLOCKED || USER_TYPE_CLIENT) {die();}
?>
		<div class="container-fluid pg-header contact-bg">
            <div class="pg-header-content">
               <h1 class="pg-title"> <?php echo $lang['home']['contact']['title'] ?> </h1>
               <h4 class="pg-subtitle"> <?php echo $lang['home']['contact']['desc'] ?> </h4>
            </div>
            <div class="pg-header-icon fa fa-envelope-open"></div>
        </div>
         <div class="container pg-content">
            <div class="col-sm-12 text-center">
               <?php
               $notes = $db->query('SELECT upn.note,upn.lastTimeUpdated,u.name,u.surnames FROM users_psicos_notes upn JOIN users_psicos_sessions ups ON ups.sessionId=upn.sessionid JOIN users u ON u.id=ups.psico_id WHERE upn.pid='.USER_ID);
                            
                $noteId = 0;
                while($note = $notes->fetch_array())
                {
                    echo '<div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading'.$noteId.'">
                      <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$noteId.'" aria-expanded="'.($noteId == 0 ? 'true':'false').'" aria-controls="collapse'.$noteId.'">
                        '.$note['name'].' '.$note['surnames'].' ~ '.date('d/m/Y - H:i',$note['lastTimeUpdated']).' ('.$core->timeElapsed($note['lastTimeUpdated']).')
                      </a>
                    </h4>
                    </div>
                    <div id="collapse'.$noteId.'" class="panel-collapse collapse'.($noteId == 0 ? ' in':'').'" role="tabpanel" aria-labelledby="heading'.$noteId.'">
                      <div class="panel-body">
                        '.$note['note'].'
                      </div>
                    </div>
                  </div>';
                    $noteId++;
                }
                ?>
            </div>
         </div>