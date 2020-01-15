import {Component, OnInit}   from 'angular2/core';
import {Router}              from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/recoverpass.php'
})
export class RecoverPass implements OnInit {
  constructor(
    private _router: Router) { }
	ngAfterViewInit() {
	  $.getScript('assets/js/home/recover.js', function(){});
	}
}