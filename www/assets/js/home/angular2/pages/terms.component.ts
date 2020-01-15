import {Component, OnInit}   from 'angular2/core';
import {Router}              from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/terms.php'
})
export class Terms implements OnInit {

  constructor(
    private _router: Router) { }
}