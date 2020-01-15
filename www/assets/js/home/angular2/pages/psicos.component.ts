import {Component, OnInit}   from 'angular2/core';
import {Router,ROUTER_DIRECTIVES} from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/psicos.php',
  directives: [ROUTER_DIRECTIVES]
})
export class Psicos implements OnInit {
  constructor(
    private _router: Router) { }

  ngAfterViewInit() {
	  $.getScript('assets/js/home/payment.js', function(){});
          $.getScript('assets/js/home/calendar.js', function(){$.getScript('assets/js/home/listing.js', function(){})});
          $("img").lazyload({effect : "fadeIn"});
	}
}