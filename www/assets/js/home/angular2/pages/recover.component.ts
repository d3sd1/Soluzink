import {Component}   from 'angular2/core';
import {Router,ROUTER_DIRECTIVES}              from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/recover.php',
  directives: [ROUTER_DIRECTIVES]
})
export class Recover {
  constructor(
    private _router: Router) { }
	ngAfterViewInit() {
	  $.getScript('assets/js/home/recoveracc.js', function(){});
	}
}