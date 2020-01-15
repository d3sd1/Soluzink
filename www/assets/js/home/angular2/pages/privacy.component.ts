import {Component, OnInit}   from 'angular2/core';
import {Router}              from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/privacy.php'
})
export class Privacy implements OnInit {

  constructor(
    private _router: Router) { }
}