import {Component, OnInit}   from 'angular2/core';
import {Router,ROUTER_DIRECTIVES} from 'angular2/router';

@Component({
  moduleId: __moduleName,
  templateUrl: '../templates/logoutloggedsmw.php',
  directives: [ROUTER_DIRECTIVES]
})
export class LogoutLoggedSmw implements OnInit {
  constructor(
    private _router: Router) { }
    ngAfterViewInit()
    {
        $("img").lazyload({effect : "fadeIn"});
    }
}