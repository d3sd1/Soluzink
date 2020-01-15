<?php require(dirname(__FILE__) . '/../../../../../kernel/core.php') ?>
<div class="body-wrapper">
         <header class="header">
            <div class="logo"> <a [href]="'<?php echo URL ?>'"> Soluzink </a> </div>
            <?php
				if(USER_LOGGED_IN)
				{
					echo '<div class="user-buttons"> 
                           <a class="menu-profile" data-toggle="dropdown">'.USER_FULLNAME.'<b class="caret"></b></a> 
                           <ul class="dropdown-menu profile-dropdown">
                              <li><a [routerLink]="[\'/Profile\']">'.$lang['home']['base']['header']['profile'].'</a></li>';
                                        if(!USER_TYPE_CLIENT)
                                        {
                                            echo '<li><a [routerLink]="[\'/Notes\']">'.$lang['home']['base']['header']['notes'].'</a></li>';
                                        }
                              echo '<li><a [href]="\''.URL.'/logout\'">'.$lang['home']['base']['header']['logout'].'</a></li>
                           </ul>
                        </div>';
				}
			?>
            <div class="navbar navbar-inverse" role="navigation" id="slide-nav">
               <div class="container">
                  <div id="slidemenu">
                     <ul class="nav navbar-nav navbar-right<?php echo (!USER_LOGGED_IN ? ' logged-out' : '') ?>">
                        <li class="dropdown">
                            <?php 
                            for($i = 0; $i < count(config('langs.avaliable')); $i++)
                            {
                                if($i == 0)
                                {
                                    echo '<a class="dropdown-toggle" data-toggle="dropdown" [href]="\'#\'"><img draggable="false" alt="'.$lang['SEO']['ALTIMAGE']['flags']['actual'].'" src="'.URL.'/assets/images/langs/'.$lang['CONFIG']['lang'].'.png"> '.$lang['CONFIG']['name'].'<b class="caret"></b></a>'
                                            . '<ul class="dropdown-menu">';
                                }
                                if(config('langs.avaliable')[$i] !== $lang['CONFIG']['lang'])
                                {
                                    echo '<li><a id="langSelectorCallbacked" [href]="\''.URL.'/changelanguage/'.config('langs.avaliable')[$i].'/*callBackUrl*\'"><img draggable="false" alt="'.str_replace('{code}',config('langs.avaliable')[$i],$lang['SEO']['ALTIMAGE']['flags']['common']).'" src="'.URL.'/assets/images/langs/'.config('langs.avaliable')[$i].'.png"> '.$lang['TRANSCRIPTION'][config('langs.avaliable')[$i]].'</a></li>';
                                }
                            }
                            ?>
                            </ul>
                        </li>	
                        <li class="dropdown">
                           <a [routerLink]="['/Psicos']" class="dropdown-toggle" data-toggle="dropdown"><?php echo $lang['home']['base']['header']['list']['full'] ?><b class="caret"></b></a> 
                           <ul class="dropdown-menu">
                              <li><a [routerLink]="['/Psicos']"><?php echo $lang['home']['base']['header']['list']['psico'] ?></a></li>
                              <li><a [routerLink]="['/Coaches']"><?php echo $lang['home']['base']['header']['list']['coach'] ?></a></li>
                           </ul>
                        </li>
                        <li>
                           <a [routerLink]="['/Test']"><?php echo $lang['home']['base']['header']['test'] ?></a> 
                        </li>
						<?php
				if(!USER_LOGGED_IN)
				{
					echo '<li>
                           <a [routerLink]="[\'/UserRegister\']">'.$lang['home']['base']['header']['register'].'</a> 
                        </li>
                        <li>
                           <a [routerLink]="[\'/Login\']">'.$lang['home']['base']['header']['login'].'</a> 
                        </li>';
				}
			?>
                        
                     </ul>
                  </div>
               </div>
            </div>
         </header>
		 
    <router-outlet></router-outlet>
	<footer>
            <div class="row footer-info">
               <div class="footer-col footer-terms"> <a [routerLink]="['/Terms']"><?php echo $lang['home']['base']['footer']['terms'] ?></a></div>
               <div class="footer-col footer-privacy"> <a [routerLink]="['/Privacy']"><?php echo $lang['home']['base']['footer']['privacy'] ?></a></div>
               <div class="footer-col social-networks">
					<a target="soluzinkSocial" [href]="'http://www.facebook.com'" class="fa fa-facebook"></a>
					<a target="soluzinkSocial" [href]="'http://www.twitter.com'" class="fa fa-twitter"></a>
				</div>
               <div class="footer-col footer-links">  <?php echo $lang['home']['base']['footer']['copyright'] ?> </div>
               <div class="footer-col footer-contact">
                  <div class="footer-address"> <?php echo $lang['home']['base']['footer']['contactPre'] ?> </div>
                  <div class="footer-contact-data"> <a [routerLink]="['/Contact']"><?php echo $lang['home']['base']['footer']['contactOff'] ?></a> </div>
               </div>
            </div>
         </footer>