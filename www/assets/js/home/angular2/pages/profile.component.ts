import {Component, OnInit,ViewEncapsulation}   from 'angular2/core';
import {Router,ROUTER_DIRECTIVES} from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/profile.php',
  directives: [ROUTER_DIRECTIVES]
})
export class Profile implements OnInit {

  constructor(
    private _router: Router) { }
    ngOnInit() {
    
    }
	ngAfterViewInit() {
	  $.getScript('assets/vendors/owl.carousel/owl.carousel.min.js', function(){});
	  $.getScript('assets/vendors/smooth-scroll/smooth-scroll.js', function(){});
	  $.getScript('assets/vendors/jquery.appear/jquery.appear.js', function(){});
	  $.getScript('assets/vendors/slim/js/slim.jquery.min.js', function(){});
	  $.getScript('assets/js/home/myprofile.js', function(){});
	}
}