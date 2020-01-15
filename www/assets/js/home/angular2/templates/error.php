<?php require('../../../../../kernel/core.php'); ?>
         <div class="container-fluid pg-header error-bg">
            <div class="pg-header-content">
               <h1 class="pg-title"> 404 </h1>
               <h4 class="pg-subtitle"> <?php echo $lang['home']['error']['title'] ?> </h4>
            </div>
            <div class="pg-header-icon fa fa-frown-o"></div>
         </div>
         <div class="container page-intro"> <?php echo $lang['home']['error']['desc'] ?> </div>
         <div class="container pg-content">
            <div class="row text-center">
               <div class="col-sm-6"> <img alt="<?php echo $lang['SEO']['ALTIMAGE']['error']['tree'] ?>" draggable="false" data-original="<?php echo URL ?>/assets/images/home/error/tree.png" class="not-found-image"/> </div>
               <div class="col-sm-4">
                  <h2><?php echo $lang['home']['error']['but'] ?></h2>
                  <p><?php echo $lang['home']['error']['still'] ?></p>
                  <br/> <a [routerLink]="['/Psicos']" class="button big search-pop-button"><?php echo $lang['home']['error']['psicos'] ?></a> 
                  <h4><?php echo $lang['home']['error']['or'] ?></h4>
                  <a [routerLink]="['/Coaches']" class="button big"><?php echo $lang['home']['error']['coaches'] ?></a> 
               </div>
            </div>
         </div>