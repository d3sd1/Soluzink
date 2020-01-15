<?php
require('kernel/core.php');
?>
<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!--><html lang="<?php echo $lang['META']['lang'] ?>"> <!--<![endif]-->
    <head>
        <meta charset="<?php echo $lang['CONFIG']['encoding'] ?>">
        <title><?php echo $lang['index']['title'] ?></title>
        <meta name="description" content="<?php echo $lang['META']['description'] ?>">
        <meta name="author" content="<?php echo $lang['META']['author'] ?>">
        <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/start/fonts.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/animate.css/animate.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/jquery.flexslider/flexslider.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/start/style.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/start/responsive.css">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/common/base.css">
        <!-- Favicon and Apple Icons -->
        <link rel="shortcut icon" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL ?>/favicon.ico">
        <noscript>
          <meta http-equiv="refresh" content="0;url=<?php echo URL ?>/nojs">
        </noscript>
    </head>
    <body data-spy="scroll" data-target="#main-menu">
        <div class="geass-loader-overlay left"></div><!-- End .geass-loader-overlay left -->
        <div class="geass-loader-overlay right"></div><!-- End .geass-loader-overlay right -->
        <div id="wrapper">

            <!-- Header / Menu Section -->
            <header id="header" class="transparent">
                <nav class="navbar navbar-default navbar-transparent" role="navigation">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                                <span class="sr-only"><?php echo $lang['index']['header']['responsive']['open'] ?></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div class="logo"> <a class="scrollto" href="#home"> Soluzink </a> </div>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse navbar-right" id="main-menu">
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <?php 
                                    for($i = 0; $i < count(config('langs.avaliable')); $i++)
                                    {
                                        if($i == 0)
                                        {
                                            echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#"><img draggable="false" alt="'.$lang['SEO']['ALTIMAGE']['flags']['actual'].'" src="'.URL.'/assets/images/langs/'.$lang['CONFIG']['lang'].'.png"> '.$lang['CONFIG']['name'].'<b class="caret"></b></a>'
                                                    . '<ul class="dropdown-menu">';
                                        }
                                        if(config('langs.avaliable')[$i] !== $lang['CONFIG']['lang'])
                                        {
                                            echo '<li><a id="langSelectorCallbacked" href="'.URL.'/changelanguage/'.config('langs.avaliable')[$i].'/*callBackUrl*"><img draggable="false" alt="'.str_replace('{code}',config('langs.avaliable')[$i],$lang['SEO']['ALTIMAGE']['flags']['common']).'" src="'.URL.'/assets/images/langs/'.config('langs.avaliable')[$i].'.png"> '.$lang['TRANSCRIPTION'][config('langs.avaliable')[$i]].'</a></li>';
                                        }
                                    }
                                    ?>
                                    </ul>
                                </li>
                                <li><a href="#whysoluzink"><?php echo $lang['psico']['header']['whysoluzink'] ?></a></li>
                                <li><a href="#services"><?php echo $lang['index']['header']['services'] ?></a></li>
                                <li><a href="<?php echo URL ?>/logout?redirTo=#/PsicoRegister"><?php echo $lang['psico']['header']['startnow'] ?></a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </header>

            <!-- Home Section -->
            <section id="home" class="homebg2 section gfullscreen section-bg">
                <div class="section-overlay redbg"></div>
                <div class="section-content vcenter-container">
                    <div class="vcenter">
                        <p class="home-top-text"><?php echo $lang['psico']['welcome']['title'] ?></p>
                        <div class="flexslider home-flex-slider">
                            <ul class="slides">
                                <li>
                                    <p><?php echo $lang['psico']['welcome']['msg1'] ?></p>
                                </li>
                                <li>
                                    <p><?php echo $lang['psico']['welcome']['msg2'] ?></p>
                                </li>
                                <li>
                                    <p><?php echo $lang['psico']['welcome']['msg3'] ?></p>
                                </li>
                            </ul>
                        </div><!-- flexslider -->
                    </div><!-- vcenter -->
                </div><!-- End .section-content -->
                <a href="#whysoluzink" class="scrollto-btn scrollto"><i class="fa fa-angle-double-down"></i></a>
            </section><!-- End #home -->

            <!-- About Us Section -->
            <section id="whysoluzink" class="section">
                <header class="container text-center">
                    <h1 class="section-title"><?php echo $lang['psico']['whysoluzink']['title'] ?></h1>
                    <p class="section-desc">
                        <?php echo $lang['psico']['whysoluzink']['desc'] ?>
                    </p>
                </header>
				
                <div class="lg-margin visible-xs clearfix"></div><!-- space -->
                
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h3><?php echo $lang['psico']['whysoluzink']['row1']['title'] ?></h3>
                            <p><?php echo $lang['psico']['whysoluzink']['row1']['p1'] ?></p>
                            <p><?php echo $lang['psico']['whysoluzink']['row1']['p2'] ?></p>
                            <p><?php echo $lang['psico']['whysoluzink']['row1']['p3'] ?></p>
                        </div><!-- End .col-md-6 -->

                        <div class="md-margin visible-xs clearfix"></div><!-- space -->

                        <div class="col-md-6 col-sm-6">
                            <div class="accordion-panel" id="accordion-panel2">
                                <div class="accordion-panel-group panel">
                                    <a class="accordion-panel-title yellow" data-toggle="collapse" data-parent="#accordion-panel2" href="#panel-one2"><i class="fa fa-briefcase"></i><?php echo $lang['psico']['whysoluzink']['row2']['sect1'] ?></a>

                                    <div class="accordion-panel-body collapse in" id="panel-one2">
                                        <div class="accordion-body-wrapper">
                                            <p><?php echo $lang['psico']['whysoluzink']['row2']['desc1'] ?></p>
                                        </div><!-- End .accordion-body-wrapper -->
                                    </div><!-- End .accordion-body -->
                                </div><!-- End .accordion-group --> 
                                <div class="accordion-panel-group panel">

                                    <a class="accordion-panel-title red" data-toggle="collapse" data-parent="#accordion-panel2" href="#panel-three2"><i class="fa fa-bar-chart"></i><?php echo $lang['psico']['whysoluzink']['row2']['sect2'] ?></a>

                                    <div class="accordion-panel-body collapse" id="panel-three2">
                                        <div class="accordion-body-wrapper">
                                            <p><?php echo $lang['psico']['whysoluzink']['row2']['desc2'] ?></p>
                                        </div><!-- End .accordion-body-wrapper -->
                                    </div><!-- End .accordion-panel-body -->
                                </div><!-- End .accordion-panel-group -->
                                <div class="accordion-panel-group panel">

                                    <a class="accordion-panel-title lightblue" data-toggle="collapse" data-parent="#accordion-panel2" href="#panel-four2"><i class="fa fa-group"></i><?php echo $lang['psico']['whysoluzink']['row2']['sect3'] ?></a>

                                    <div class="accordion-panel-body collapse" id="panel-four2">
                                        <div class="accordion-body-wrapper">
                                            <p><?php echo $lang['psico']['whysoluzink']['row2']['desc3'] ?></p>
                                        </div><!-- End .accordion-body-wrapper -->
                                    </div><!-- End .accordion-panel-body -->
                                </div><!-- End .accordion-panel-group -->
                            </div><!-- End .accordion-panel -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->

                <div class="md-margin visible-xs clearfix"></div><!-- space -->

                <div class="container img-container">
                    <div class="row">
                        <div class="col-md-10 col-md-push-1 col-sm-10 col-sm-push-1">
                            <img draggable="false" alt="<?php echo $lang['SEO']['ALTIMAGE']['start']['help'] ?>" data-original="<?php echo URL ?>/assets/images/start/help.png" class="img-responsive wow fadeInUpBig">
                        </div><!-- End .col-md-8 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </section>
            
            <!-- Count Parallax Section -->
            <div class="countto-container parallax" data-stellar-background-ratio="0.15">
                <div class="overlaybg"></div><!-- End .overlaybg -->
                <div class="parallax-content">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-3 col-sm-6 col-xs-6 count-container">
                                <span class="count" data-from="0" data-to="<?php echo $db->query('SELECT id FROM users WHERE type="psico"')->num_rows ?>" data-speed="3000" data-refresh-interval="50">0</span>
                                <h3><?php echo $lang['psico']['countto']['psicosregistered'] ?></h3>
                            </div><!-- End .count-container -->

                            <div class="col-md-3 col-sm-6 col-xs-6 count-container">
                                <span class="count" data-from="0" data-to="<?php echo $db->query('SELECT user_id FROM users_psicos_sessions')->num_rows ?>" data-speed="3000" data-refresh-interval="50">0</span>
                                <h3><?php echo $lang['psico']['countto']['sessions'] ?></h3>
                            </div><!-- End .count-container -->

                            <div class="xlg-margin visible-sm visible-xs hidden-xss clearfix"></div><!-- space -->

                            <div class="col-md-3 col-sm-6 col-xs-6 count-container">
                                <span class="count" data-from="0" data-to="<?php echo $db->query('SELECT id FROM pays')->num_rows ?>" data-speed="3000" data-refresh-interval="50">0</span>
                                <h3><?php echo $lang['psico']['countto']['pays'] ?></span></h3>
                            </div><!-- End .count-container -->

                            <div class="col-md-3 col-sm-6 col-xs-6 count-container">
                                <span class="count" data-from="0" data-to="<?php echo $db->query('SELECT id FROM users WHERE type="client" AND online=1')->num_rows ?>" data-speed="3000" data-refresh-interval="50">0</span>
                                <h3><?php echo $lang['psico']['countto']['clients'] ?></h3>
                            </div><!-- End .count-container -->

                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .parallax-content -->
            </div><!-- End .countto-container -->

            <!-- Services Section -->
            <section id="services" class="section">
                <header class="container text-center">
                    <h1 class="section-title"><?php echo $lang['index']['services']['title'] ?></h1>
                    <p class="section-desc">
                        <?php echo $lang['psico']['services']['desc'] ?>
                    </p>
                </header>

                <div id="our-services">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="service wow fadeInUp" data-wow-delay="0.25s">
                                    <div class="service-header">
                                        <span class="service-icon yellowbg"><i class="fa fa-photo"></i></span>
                                        <h2><?php echo $lang['index']['services']['motivation']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                            <div class="col-md-3 col-sm-6">
                                <div class="service wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="service-header">
                                        <span class="service-icon orangebg"><i class="fa fa-file-code-o"></i></span>
                                        <h2><?php echo $lang['index']['services']['depression']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                            <div class="visible-sm clearfix md-margin"></div><!-- clear -->
                            <div class="col-md-3 col-sm-6">
                                <div class="service  wow fadeInUp" data-wow-delay="0.75s">
                                    <div class="service-header">
                                        <span class="service-icon lightbluebg"><i class="fa fa-certificate"></i></span>
                                        <h2><?php echo $lang['index']['services']['mobbing']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                            <div class="col-md-3 col-sm-6">
                                <div class="service wow fadeInUp" data-wow-delay="1s">
                                    <div class="service-header">
                                        <span class="service-icon bluebg"><i class="fa fa-cloud"></i></span>
                                        <h2><?php echo $lang['index']['services']['sexual']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                        </div><!-- End .row -->

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="service wow fadeInUp" data-wow-delay="0.25s">
                                    <div class="service-header">
                                        <span class="service-icon redbg"><i class="fa fa-eye"></i></span>
                                        <h2><?php echo $lang['index']['services']['sleep']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                            <div class="col-md-3 col-sm-6">
                                <div class="service wow fadeInUp" data-wow-delay="0.5s">
                                    <div class="service-header">
                                        <span class="service-icon purplebg"><i class="fa fa-group"></i></span>
                                        <h2><?php echo $lang['index']['services']['eat']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                            <div class="visible-sm clearfix md-margin"></div><!-- clear -->
                            <div class="col-md-3 col-sm-6">
                                <div class="service  wow fadeInUp" data-wow-delay="0.75s">
                                    <div class="service-header">
                                        <span class="service-icon lightgreenbg"><i class="fa fa-sitemap"></i></span>
                                        <h2><?php echo $lang['index']['services']['school']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                            <div class="col-md-3 col-sm-6">
                                <div class="service wow fadeInUp" data-wow-delay="1s">
                                    <div class="service-header">
                                        <span class="service-icon greenbg"><i class="fa fa-support"></i></span>
                                        <h2><?php echo $lang['index']['services']['addictions']['title'] ?></h2>
                                    </div><!-- End .services-header -->
                                </div><!-- End .service -->
                            </div><!-- End .col-md-3 -->
                        </div><!-- End .row -->
                    </div><!-- Ênd .container -->

                    <div class="sm-margin"></div><!-- space -->

                    <div class="container text-center">
                        <a href="<?php echo URL ?>/#/PsicoRegister" class="btn btn-lg btn-soluzink  wow tada"><?php echo $lang['index']['services']['more'] ?></a>
                    </div>
                </div><!-- End #our-services -->
            </section>
            
            <footer id="footer" class="pattern13">
                <div class="footer-social-icons pattern13">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="social-icons-container">
                                    <li><a target="soluzinkSocialLink" href="https://twitter.com/<?php echo config('twitter.account.name') ?>" class="twitter add-tooltip" data-placement="top" data-toggle="tooltip" title="<?php echo $lang['GLOBAL']['social']['followus']['twitter'] ?>"><i class="fa fa-twitter"></i></a></li>
                                    <li><a target="soluzinkSocialLink" href="https://facebook.com/<?php echo config('facebook.account.name') ?>" class="facebook add-tooltip" data-placement="top" data-toggle="tooltip" title="<?php echo $lang['GLOBAL']['social']['followus']['facebook'] ?>"><i class="fa fa-facebook"></i></a></li>
                                </ul>
                            </div>
                            
                            <div class="col-md-4">
                                <a href="<?php echo URL ?>/start"><span class="footer-date highlight soluzink"><?php echo $lang['index']['footer']['checkclients'] ?></span></a>
                            </div>
                            
                            <div class="col-md-4">
                            <p><?php echo $lang['index']['footer']['copy'] ?></p>
                            <?php echo date('Y') ?>
                            </div>
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .footer-social-icons -->
            </footer>
            
        </div><!-- End #wrapper -->

        <!-- Scroll Top Button -->
        <a href="#home" id="scroll-top" class="add-tooltip" data-placement="top"><i class="fa fa-angle-double-up"></i></a>

        <!--- jQuery -->
        <script src="<?php echo URL ?>/assets/vendors/jquery1/jquery.min.js"></script>

        <!-- Queryloader -->
        <script src="<?php echo URL ?>/assets/vendors/queryloader2/queryloader2.min.js"></script>

        <!-- Modernizr -->
        <script src="<?php echo URL ?>/assets/vendors/modernizr/modernizr.js"></script>
        <!-- Plugins -->
        <script src="<?php echo URL ?>/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo URL ?>/assets/js/start/plugins.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/jquery.flexslider/jquery.flexslider-min.js"></script>
        <script src="<?php echo URL ?>/assets/js/start/main.js"></script>
        <script src="<?php echo URL ?>/assets/vendors/jquery.lazyload/jquery.lazyload.min.js"></script>
        
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-101612262-1', 'auto');
          ga('send', 'pageview');
          $("img").lazyload({effect : "fadeIn"});
            $(document).ready(function() {
                $("#langSelectorCallbacked").each(function( index ) {
                    $(this).attr("href", $(this).attr("href").replace('*callBackUrl*',btoa(window.location.href)));
                });
            });
        </script>
    </body>
</html>