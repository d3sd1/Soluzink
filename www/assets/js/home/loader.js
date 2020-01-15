var loadingScrolling = $('<style id="loadingScrolling">::-webkit-scrollbar {     display: none; }</style>');
$('html > head').append(loadingScrolling);
;(function(window) {
	'use strict';
	function PathLoader( el ) {
		this.el = el;
		this.el.style.strokeDasharray = this.el.style.strokeDashoffset = this.el.getTotalLength();
	}
	PathLoader.prototype._draw = function( val ) {
		this.el.style.strokeDashoffset = this.el.getTotalLength() * ( 1 - val );
	}
	PathLoader.prototype.setProgress = function( val, callback ) {
		this._draw(val);
		if( callback && typeof callback === 'function' ) {
			callback();
		}
	}
	PathLoader.prototype.setProgressFn = function( fn ) {
		if( typeof fn === 'function' ) { fn( this ); }
	}
	window.PathLoader = PathLoader;
})(window);
(function() {
	var support = { animations : Modernizr.cssanimations },
		container = document.getElementById('loaderContainer'),
		header = container.querySelector('.loaderHeader'),
		loader = new PathLoader( document.getElementById('loaderStatusRenderer')),
		animEndEventName = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' }[ Modernizr.prefixed( 'animation' ) ];
	function init() {
		var onEndInitialAnimation = function() {
			if( support.animations ) {
				this.removeEventListener( animEndEventName, onEndInitialAnimation );
			}
			startLoading();
		};
		window.addEventListener( 'scroll', noscroll );
		container.classList.add('loading');
		if( support.animations ) {
			container.addEventListener( animEndEventName, onEndInitialAnimation );
		}
		else {
			onEndInitialAnimation();
		}
	}
	function startLoading() {
		var simulationFn = function(instance) {
			var progress = 0,
				interval = setInterval( function() {
					progress = Math.min( progress + Math.random() * 0.1, 1 );
					instance.setProgress( progress );
					if( progress === 1 ) {
						container.classList.remove('loading');
						container.classList.add('loaded');
						clearInterval( interval );
                                                $('#loadingScrolling').remove();
                                                var pageTransitionsStyle = $('<style id="loadedPageTransitions">soluzink *{ animation-duration: 1s; animation-name: fade; }</style>');
                                                $('html > head').append(pageTransitionsStyle);
						var onEndHeaderAnimation = function(ev) {
							if( support.animations ) {
								if( ev.target !== header ) return;
								this.removeEventListener( animEndEventName, onEndHeaderAnimation );
							}
							window.removeEventListener( 'scroll', noscroll );
						};
						if( support.animations ) {
							header.addEventListener( animEndEventName, onEndHeaderAnimation );
						}
						else {
							onEndHeaderAnimation();
						}
					}
				}, 80 );
		};
		loader.setProgressFn( simulationFn );
	}
	function noscroll() {
		window.scrollTo( 0, 0 );
	}
	init();
})();