<?php
$areWeInMaintenance = true;
require('kernel/core.php');
if(!config('maintenance') && isset($areWeInMaintenance))
{
    header('Location: '.URL);
}
?>
<html lang="en-us" class="no-js">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $lang['CONFIG']['encoding'] ?>"/>
        <meta name="description" content="<?php echo $lang['META']['description'] ?>"/>
        <meta name="author" content="<?php echo $lang['META']['author'] ?>"/>

        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <link rel="icon" href="<?php echo URL ?>/favicon.ico" type="image/x-icon"/>
        <title><?php echo $lang['maintenance']['title'] ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ================= Favicon ================== -->
        <!-- Standard -->
        <link rel="shortcut icon" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL ?>/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL ?>/favicon.ico">
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/common/base.css" />
        <link rel="stylesheet" href="<?php echo URL ?>/assets/css/maintenance/style.css" />
	<script src="<?php echo URL ?>/assets/js/maintenance/modernizr.js"></script>
    </head>
    <body>

		<!-- Page preloader -->
		<div id="loading">
			<div id="preloader">
				<span></span>
				<span></span>
			</div>
		</div>

		<!-- Overlay -->
		<div class="global-overlay">

			<canvas id="constellationel"></canvas>

			<div class="overlay">

				<!-- Lines Overlay -->
				<div class="overlay-dash"></div>

			</div>
		</div>

		<!-- START - Home Part -->
		<section id="home-wrap">

			<!-- Stars Overlay - Uncomment the next 3 lines to activate the effect-->
			<!-- <div id='stars'></div>
			<div id='stars2'></div>
			<div id='stars3'></div> -->

			<div class="content">

				<!-- Your logo -->
                                <div class="brand-logo"> <a href="#home"> Soluzink </a> </div>
				<h1 class="text-intro opacity-0"><span class="polyfy-title"><?php echo $lang['maintenance']['content'] ?></span></h1>

				<p class="text-intro opacity-0"><?php echo $lang['maintenance']['desc'] ?></p>

				<a data-dialog="somedialog" class="action-btn trigger text-intro opacity-0"><?php echo $lang['maintenance']['notify']['button'] ?></a>
						
			</div> <!-- /. content -->

			<!-- Social icons -->
			<div class="social-icons text-intro opacity-0">

				<a target="soluzinkSocialLink" href="https://twitter.com/<?php echo config('twitter.account.name') ?>"><i class="fa fa-twitter"></i></a>
				<a target="soluzinkSocialLink" href="https://facebook.com/<?php echo config('facebook.account.name') ?>"><i class="fa fa-facebook"></i></a>

			</div> <!-- /. social-icons -->

		</section>
		<!-- END - Home Part -->

		<!-- START - Newsletter Popup -->
		<div id="somedialog" class="dialog">

			<div class="dialog__overlay"></div>
					
			<div class="dialog__content">
						
				<div class="dialog-inner">
							
					<h4><?php echo $lang['maintenance']['notify']['title'] ?></h4>
							
					<p><?php echo $lang['maintenance']['notify']['desc'] ?></p>

					<!-- Newsletter Form -->
					<div id="subscribe">

		                <form action="<?php echo URL ?>/notifymaintenance" id="notifyMe" method="POST">

		                    <div class="form-group">

		                        <div class="controls">
		                            
		                        	<!-- Field  -->
		                        	<input type="text" id="mail-sub" name="email" autocomplete="off" placeholder="<?php echo $lang['maintenance']['notify']['email.ph'] ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?php echo $lang['maintenance']['notify']['email.ph'] ?>'" class="form-control email srequiredField" />

		                        	<!-- Spinner top left during the submission -->
		                        	<i class="fa fa-spinner opacity-0"></i>

		                            <!-- Button -->
		                            <button class="btn btn-lg submit"><?php echo $lang['maintenance']['notify']['send'] ?></button>

		                            <div class="clear"></div>

		                        </div>

		                    </div>

		                </form>

						<!-- Answer for the newsletter form is displayed in the next div, do not remove it. -->
						<div class="block-message">

							<div class="message">

								<p class="notify-valid"></p>

							</div>

						</div>

        			</div>
        			<!-- /. Newsletter Form -->

				</div>
				<!-- /. dialog-inner -->

				<!-- Button Cross to close the Newsletter Popup -->
				<button class="close-newsletter" data-dialog-close><i class="icon ion-close-round"></i></button>

			</div>
			<!-- /. dialog__content -->
						
		</div>
		<!-- END - Newsletter Popup -->

		<!-- Root element of PhotoSwipe, the gallery. Must have class pswp. -->
		<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

		    <!-- Background of PhotoSwipe. 
	        	It's a separate element as animating opacity is faster than rgba(). -->
		    <div class="pswp__bg"></div>

		    <!-- Slides wrapper with overflow:hidden. -->
		    <div class="pswp__scroll-wrap">

		        <!-- Container that holds slides. 
		            PhotoSwipe keeps only 3 of them in the DOM to save memory.
		            Don't modify these 3 pswp__item elements, data is added later on. -->
		        <div class="pswp__container">
		            <div class="pswp__item"></div>
		            <div class="pswp__item"></div>
		            <div class="pswp__item"></div>
		        </div>

		        <div class="pswp__ui pswp__ui--hidden">
		            <div class="pswp__top-bar">
		                <div class="pswp__counter"></div>
		                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
		                <button class="pswp__button pswp__button--share" title="Share"></button>
		                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
		                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
		                <div class="pswp__preloader">
		                    <div class="pswp__preloader__icn">
		                      <div class="pswp__preloader__cut">
		                        <div class="pswp__preloader__donut"></div>
		                      </div>
		                    </div>
		                </div>
		            </div>
		            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
		                <div class="pswp__share-tooltip"></div> 
		            </div>
		            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
		            </button>
		            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
		            </button>
		            <div class="pswp__caption">
		                <div class="pswp__caption__center"></div>
		            </div>
		        </div>
		    </div>
		</div>
        <script type="text/javascript" src="<?php echo URL ?>/assets/vendors/jquery3/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/js/maintenance/jquery.easings.min.js"></script>
        <script type="text/javascript" src="<?php echo URL ?>/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/velocity/velocity.min.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/velocity/velocity.ui.min.js"></script> 
	<script type="text/javascript">/*
 notifyMe jQuery Plugin v1.0.0
 Copyright (c)2014 Sergey Serafimovich
 Licensed under The MIT License.
*/
(function(e) {
    e.fn.notifyMe = function(t) {
        var r = e(this);
        var i = e(this).find("input[name=email]");
        var o = e(this).find(".note");
        e(this).on("submit", function(t) {
            t.preventDefault();
            var p = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (p.test(i.val()) && i.val() != null) {
                $(".message").removeClass("error bad-email success-full");
                $(".message").hide().html('').fadeIn();
                $(".fa-spinner").addClass("fa-spin").removeClass("opacity-0");
                o.show();
                e.ajax({
                    type: "POST",
                    url: '<?php echo URL ?>/notifymaintenance',
                    data: {
                        email: i.val()
                    },
                    success: function(e) {
                        if (e == "success") {
                            $(".fa-spinner").addClass("opacity-0").removeClass("fa-spin");
                            $(".message").removeClass("bad-email").addClass("success-full");
                            $(".block-message").addClass("show-block-valid").removeClass("show-block-error");
                            $(".message").html('<p class="notify-valid"><?php echo $lang['maintenance']['notify']['success'] ?></p>').fadeIn();
                        } else if(e == "validationError") {
                             $(".fa-spinner").addClass("opacity-0").removeClass("fa-spin");
                            $(".block-message").addClass("show-block-error").removeClass("show-block-valid");
                            $(".message").html('<p class="notify-valid"><?php echo $lang['maintenance']['notify']['fake'] ?></p>').fadeIn();
                        }
                        else {
                            $(".fa-spinner").addClass("opacity-0").removeClass("fa-spin");
                            $(".block-message").addClass("show-block-error").removeClass("show-block-valid");
                            $(".message").html('<p class="notify-valid"><?php echo $lang['maintenance']['notify']['error'] ?></p>').fadeIn();
                        }
                    },
                    error: function (e) {
                        $(".fa-spinner").addClass("opacity-0").removeClass("fa-spin");
                        $(".block-message").addClass("show-block-error").removeClass("show-block-valid");
                        $(".message").html('<p class="notify-valid"><?php echo $lang['maintenance']['notify']['notavaliable'] ?></p>').fadeIn();
                    }
                }).done(function(e) {
                    
                })
            }
            else {
                $(".block-message").addClass("show-block-error").removeClass("show-block-valid");
                $(".fa-spinner").addClass("opacity-0").removeClass("fa-spin");
                $(".message").html('<p class="notify-valid"><?php echo $lang['maintenance']['notify']['incorrectmail'] ?></p>').fadeIn();
            }

            // Reset and hide all messages on .keyup()
            $("#notifyMe input").on('keyup keypress', function(e) {
                var code = e.keyCode || e.which;

                if (code == 13) { 
                    e.preventDefault();
                    $("#notifyMe").submit();

                } else {

                    $(".block-message").addClass("").removeClass("show-block-valid show-block-error");
                    $(".message").fadeOut();
                }
                
            });
        })
    }

    

})(jQuery)</script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/js/maintenance/contact.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/js/maintenance/vegas-constel.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/jquery.mousewheel/jquery.mousewheel.min.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/jquery.mCustomScrollbar/jquery.mCustomScrollbar.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/js/maintenance/classie.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/js/maintenance/dialogFx.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/photoswipe/photoswipe.min.js"></script> 
	<script type="text/javascript" src="<?php echo URL ?>/assets/vendors/photoswipe/photoswipe-ui-default.min.js"></script>
	<script type="text/javascript" src="<?php echo URL ?>/assets/js/maintenance/main.js"></script>
	<!--[if lt IE 10]><script type="text/javascript" src="<?php echo URL ?>/assets/js/placeholder.js"></script><![endif]-->
	</body>
</html>