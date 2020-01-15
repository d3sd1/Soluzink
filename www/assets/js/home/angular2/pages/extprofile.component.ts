import {Component, OnInit, ViewChild}   from 'angular2/core';
import {ActivatedRoute,Router}              from 'angular2/router';

@Component({
  moduleId: __moduleName,
  template: `<profileContent></profileContent>`
})
export class ExtProfile implements OnInit {
  constructor(
    private _router: Router) {}
        ngOnInit() {
	  $.getScript('assets/js/home/profile.js', function(){});
	}
    }
}