import {Component, OnInit,ViewEncapsulation}   from 'angular2/core';
import {Router,ROUTER_DIRECTIVES} from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/notes.php',
  directives: [ROUTER_DIRECTIVES]
})
export class Notes implements OnInit {

  constructor(
    private _router: Router) { }
    ngOnInit() {
    
    }
	ngAfterViewInit() {
	}
}