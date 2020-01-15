<?php require('../../../../../kernel/core.php') ?>
         <div class="container-fluid pg-header logout-bg">
            <div class="pg-header-content">
               <h1 class="pg-title"> <?php echo $lang['home']['logout']['logout']['title'] ?> </h1>
               <h4 class="pg-subtitle"> <?php echo $lang['home']['logout']['logout']['desc'] ?> </h4>
            </div>
            <div class="pg-header-icon fa fa-check"></div>
         </div>
         <div class="container page-intro"> <?php echo $lang['home']['logout']['logout']['advanced'] ?> </div>
         <div class="container pg-content">
            <div class="row text-center">
               <div class="img-left"> <img draggable="false" alt="<?php echo $lang['SEO']['ALTIMAGE']['logout']['banner1'] ?>" data-original="<?php echo URL ?>/assets/images/home/logout/banner1.jpg"/> </div>
               <div class="text-inline">
                  <h2><?php echo $lang['home']['logout']['logout']['title1'] ?></h2>
                  <?php echo $lang['home']['logout']['logout']['desc1'] ?>
               </div>
            </div>
            <div class="separator s-line-dashed"></div>
            <div class="row text-center">
               <div class="img-left"> <img draggable="false" alt="<?php echo $lang['SEO']['ALTIMAGE']['logout']['banner2'] ?>" data-original="<?php echo URL ?>/assets/images/home/logout/banner2.jpg"/> </div>
               <div class="text-inline">
                  <h2><?php echo $lang['home']['logout']['logout']['title2'] ?></h2>
                  <?php echo $lang['home']['logout']['logout']['desc2'] ?>
               </div>
            </div>
            <div class="separator s-line-dashed"></div>
            <div class="row text-center">
               <div class="img-left"> <img draggable="false" alt="<?php echo $lang['SEO']['ALTIMAGE']['logout']['banner3'] ?>" data-original="<?php echo URL ?>/assets/images/home/logout/banner3.jpg"/> </div>
               <div class="text-inline">
                  <h2><?php echo $lang['home']['logout']['logout']['title3'] ?></h2>
                  <?php echo $lang['home']['logout']['logout']['desc3'] ?>
               </div>
            </div>
            <div class="separator"></div>
            <div class="row text-center"> <a [routerLink]="['/Psicos']" class="button big"><?php echo $lang['home']['logout']['logout']['start'] ?></a> </div>
         </div>