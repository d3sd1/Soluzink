/*
 * requestAnimationFrame pollyfill
 */
if (!window.requestAnimationFrame) {
	window.requestAnimationFrame = (window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRequestAnimationFrame || window.oRequestAnimationFrame || function (callback) {
		return window.setTimeout(callback, 1000 / 60);
	});
}

$(document).ready(function(){
    
    var onMobile = false;
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) { onMobile = true; }
    
    if( ( onMobile === false ) ) {
       
        // Init plugin
		$('canvas').constellation({});
        
    } else {}
    
});

/*!
 * Mantis.js / jQuery / Zepto.js plugin for Constellation
 * @version 1.2.2
 * @author AcauÃ£ Montiel <contato@acauamontiel.com.br>
 * @license http://acaua.mit-license.org/
 */
(function ($, window) {
	/**
	 * Makes a nice constellation on canvas
	 * @constructor Constellation
	 */
	function Constellation (canvas, options) {
		var $canvas = $(canvas),
			context = canvas.getContext('2d'),
			defaults = {
				star: {
					color: 'rgba(255, 255, 255, 1)',
					width: 4
				},
				line: {
					color: 'rgba(255, 255, 255, 1)',
					width: 0.2
				},
				position: {
					x: 0, // This value will be overwritten at startup
					y: 0 // This value will be overwritten at startup
				},
				width: window.innerWidth,
				height: window.innerHeight,
				velocity: 0.1,
				length: 150,
				distance: 120,
				radius: 250,
				stars: []
			},
			config = $.extend(true, {}, defaults, options);

		function Star () {
			this.x = Math.random() * canvas.width;
			this.y = Math.random() * canvas.height;

			this.vx = (config.velocity - (Math.random() * 0.5));
			this.vy = (config.velocity - (Math.random() * 0.5));

			this.radius = Math.random() * config.star.width;
		}

		Star.prototype = {
			create: function(){
				context.beginPath();
				context.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
				context.fill();
			},

			animate: function(){
				var i;
				for (i = 0; i < config.length; i++) {

					var star = config.stars[i];

					if (star.y < 0 || star.y > canvas.height) {
						star.vx = star.vx;
						star.vy = - star.vy;
					} else if (star.x < 0 || star.x > canvas.width) {
						star.vx = - star.vx;
						star.vy = star.vy;
					}

					star.x += star.vx;
					star.y += star.vy;
				}
			},

			line: function(){
				var length = config.length,
					iStar,
					jStar,
					i,
					j;

				for (i = 0; i < length; i++) {
					for (j = 0; j < length; j++) {
						iStar = config.stars[i];
						jStar = config.stars[j];

						if (
							(iStar.x - jStar.x) < config.distance &&
							(iStar.y - jStar.y) < config.distance &&
							(iStar.x - jStar.x) > - config.distance &&
							(iStar.y - jStar.y) > - config.distance
						) {
							if (
								(iStar.x - config.position.x) < config.radius &&
								(iStar.y - config.position.y) < config.radius &&
								(iStar.x - config.position.x) > - config.radius &&
								(iStar.y - config.position.y) > - config.radius
							) {
								context.beginPath();
								context.moveTo(iStar.x, iStar.y);
								context.lineTo(jStar.x, jStar.y);
								context.stroke();
								context.closePath();
							}
						}
					}
				}
			}
		};

		this.createStars = function () {
			var length = config.length,
				star,
				i;

			context.clearRect(0, 0, canvas.width, canvas.height);

			for (i = 0; i < length; i++) {
				config.stars.push(new Star());
				star = config.stars[i];

				star.create();
			}

			star.line();
			star.animate();
		};

		this.setCanvas = function () {
			canvas.width = config.width;
			canvas.height = config.height;
		};

		this.setContext = function () {
			context.fillStyle = config.star.color;
			context.strokeStyle = config.line.color;
			context.lineWidth = config.line.width;
		};

		this.setInitialPosition = function () {
			if (!options || !options.hasOwnProperty('position')) {
				config.position = {
					x: canvas.width * 0.5,
					y: canvas.height * 0.5
				};
			}
		};

		this.loop = function (callback) {
			callback();

			window.requestAnimationFrame(function () {
				this.loop(callback);
			}.bind(this));
		};

		this.bind = function () {
			$(window).on('mousemove', function(e){
				config.position.x = e.pageX - $canvas.offset().left;
				config.position.y = e.pageY - $canvas.offset().top;
			});
		};

		this.init = function () {
			this.setCanvas();
			this.setContext();
			this.setInitialPosition();
			this.loop(this.createStars);
			this.bind();
		};
	}

	$.fn.constellation = function (options) {
		return this.each(function () {
			var c = new Constellation(this, options);
			c.init();
		});
	};
})($, window);
$(window).on('load', function(){"use strict";setTimeout(function(){$("#preloader").velocity({opacity:"0",complete:function(){$("#loading").velocity("transition.shrinkOut",{duration:1e3,easing:[.7,0,.3,1]})}})},3e3),setTimeout(function(){$("#home-wrap").velocity("transition.fadeIn",{opacity:"1",complete:function(){setTimeout(function(){$(".text-intro").each(function(e){!function(o){setTimeout(function(){$(o).addClass("animated-middle fadeInUp").removeClass("opacity-0")},150*e+150)}(this)})},3000)}},{duration:3e3,easing:[.7,0,.3,1]})},0)}),$(document).ready(function(){"use strict";function e(){o?($("body").addClass("scroll-touch"),$("a#open-more-info").on("click",function(){event.preventDefault();var e="#"+this.getAttribute("data-target");$("body").animate({scrollTop:$(e).offset().top},500)})):$("body").mCustomScrollbar({scrollInertia:150,axis:"y",callbacks:{whileScrolling:function(){var e=this.mcs.top;-200>=e?$(".to-scroll").addClass("hide-scroll"):$(".to-scroll").removeClass("hide-scroll")}}})}$("#open-more-info").on("click",function(){$("#info-wrap").toggleClass("show-info"),$("#home-wrap").toggleClass("hide-left"),$(".global-overlay").toggleClass("hide-overlay"),$("#first-inside").toggleClass("hide-top"),$("#second-inside").toggleClass("hide-bottom"),$("#back-side").toggleClass("show-side"),$(".hide-content").toggleClass("open-hide"),$("#close-more-info").toggleClass("hide-close"),$(".command-info-wrap").toggleClass("show-command"),$(".mCSB_scrollTools").toggleClass("mCSB_scrollTools-left"),setTimeout(function(){$("#mcs_container").mCustomScrollbar("scrollTo","#info-wrap",{scrollInertia:500,callbacks:!1})},350)}),$(".to-close").on("click",function(){$("#info-wrap").removeClass("show-info"),$("#home-wrap").removeClass("hide-left"),$(".global-overlay").removeClass("hide-overlay"),$("#first-inside").toggleClass("hide-top"),$("#second-inside").toggleClass("hide-bottom"),$("#back-side").toggleClass("show-side"),$(".hide-content").toggleClass("open-hide"),$("#close-more-info").toggleClass("hide-close"),$(".command-info-wrap").toggleClass("show-command"),$(".mCSB_scrollTools").toggleClass("mCSB_scrollTools-left"),setTimeout(function(){$("#mcs_container").mCustomScrollbar("scrollTo","#info-wrap",{scrollInertia:500,callbacks:!1})},350)}),$(".expand-player").on("click",function(){$("#home-wrap").velocity({opacity:"0"},{duration:0,easing:[.7,0,.3,1],delay:0,complete:function(){$(".global-overlay").velocity({opacity:"0"},{duration:0,easing:[.7,0,.3,1],delay:0})}})}),$(".compress-player").on("click",function(){$("#home-wrap").velocity({opacity:"1"},{duration:0,easing:[.7,0,.3,1],delay:0,complete:function(){$(".global-overlay").velocity({opacity:"1"},{duration:0,easing:[.7,0,.3,1],delay:0})}})}),$(function(){$("body").bind("mousewheel",function(e){e.preventDefault();var o=this.scrollTop;this.scrollTop=o+e.deltaY*e.deltaFactor*-1})});var o=navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|Windows Phone)/);e(),window.matchMedia("(min-width: 1025px)").matches&&$(function(){$("[data-toggle='tooltip']").tooltip()}),$("#notifyMe").notifyMe(),function(){var e=document.querySelector("[data-dialog]"),o=document.getElementById(e.getAttribute("data-dialog")),t=new DialogFx(o);e.addEventListener("click",t.toggle.bind(t))}();var t=function(e){for(var o=function(e){for(var o=e.childNodes,t=o.length,n=[],i,l,a,s,r=0;t>r;r++)i=o[r],1===i.nodeType&&(l=i.children[0],a=l.getAttribute("data-size").split("x"),s={src:l.getAttribute("href"),w:parseInt(a[0],10),h:parseInt(a[1],10)},i.children.length>1&&(s.title=i.children[1].innerHTML),l.children.length>0&&(s.msrc=l.children[0].getAttribute("src")),s.el=i,n.push(s));return n},t=function d(e,o){return e&&(o(e)?e:d(e.parentNode,o))},n=function(e){e=e||window.event,e.preventDefault?e.preventDefault():e.returnValue=!1;var o=e.target||e.srcElement,n=t(o,function(e){return e.tagName&&"FIGURE"===e.tagName.toUpperCase()});if(n){for(var i=n.parentNode,a=n.parentNode.childNodes,s=a.length,r=0,c,d=0;s>d;d++)if(1===a[d].nodeType){if(a[d]===n){c=r;break}r++}return c>=0&&l(c,i),!1}},i=function(){var e=window.location.hash.substring(1),o={};if(e.length<5)return o;for(var t=e.split("&"),n=0;n<t.length;n++)if(t[n]){var i=t[n].split("=");i.length<2||(o[i[0]]=i[1])}return o.gid&&(o.gid=parseInt(o.gid,10)),o},l=function(e,t,n,i){var l=document.querySelectorAll(".pswp")[0],a,s,r;if(r=o(t),s={galleryUID:t.getAttribute("data-pswp-uid"),getThumbBoundsFn:function(e){var o=r[e].el.getElementsByTagName("img")[0],t=window.pageYOffset||document.documentElement.scrollTop,n=o.getBoundingClientRect();return{x:n.left,y:n.top+t,w:n.width}}},i)if(s.galleryPIDs){for(var c=0;c<r.length;c++)if(r[c].pid===e){s.index=c;break}}else s.index=parseInt(e,10)-1;else s.index=parseInt(e,10);isNaN(s.index)||(n&&(s.showAnimationDuration=0),a=new PhotoSwipe(l,PhotoSwipeUI_Default,r,s),a.init())},a=document.querySelectorAll(e),s=0,r=a.length;r>s;s++)a[s].setAttribute("data-pswp-uid",s+1),a[s].onclick=n;var c=i();c.pid&&c.gid&&l(c.pid,a[c.gid-1],!0,!0)};t(".my-gallery")});