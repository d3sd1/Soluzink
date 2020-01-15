import {Component, OnInit,ViewEncapsulation}   from 'angular2/core';
import {Router,ROUTER_DIRECTIVES} from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/usersession.php',
  directives: [ROUTER_DIRECTIVES]
})
export class UserSession implements OnInit {

  constructor(
    private _router: Router) { }
    ngOnInit() {
    
    }
	ngAfterViewInit() {
	  $.getScript('assets/vendors/opentok/opentok.min.js', function(){
                $.getScript('assets/js/home/session.js', function(){$.getScript('assets/js/home/sessionuser.js', function(){});})
            });
	}
}