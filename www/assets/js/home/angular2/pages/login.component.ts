
import {Component, OnInit}   from 'angular2/core';
import {Router,ROUTER_DIRECTIVES}              from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/login.php',
  directives: [ROUTER_DIRECTIVES]
})
export class Login implements OnInit {
  constructor(
    private _router: Router) { }
	ngAfterViewInit() {
	  $.getScript('assets/js/home/login.js', function(){});
	}
}