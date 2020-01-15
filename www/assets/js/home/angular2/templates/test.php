<?php require('../../../../../kernel/core.php');
if(USER_IS_BLOCKED) {die();}
?><div class="container-fluid pg-header tests-bg">
            <div class="pg-header-content">
               <h1 class="pg-title"> <?php echo $lang['home']['tests']['title'] ?> </h1>
            </div>
            <div class="pg-header-icon fa fa-search"></div>
         </div>
         <div class="container-fluid blog single-block single-option-2">
            <div class="row">
               <div class="col-md-8 col-md-offset-2 text-center">
                  <div class="post-content margin-top text-justify">
                      <div class="ui search">
                        <input class="prompt" type="text" placeholder="<?php echo $lang['home']['tests']['searchph'] ?>">
                        <div class="results"></div>
                      </div>
                  </div>
               </div>
            </div>
         </div>