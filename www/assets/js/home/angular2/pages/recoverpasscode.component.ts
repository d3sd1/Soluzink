import {Component, OnInit}   from 'angular2/core';
import {Router}              from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/recoverpasscode.php'
})
export class RecoverPassCode implements OnInit {
  constructor(
    private _router: Router) { }
	ngAfterViewInit() {
	  $.getScript('assets/js/home/recoverpasscode.js', function(){});
	}
}