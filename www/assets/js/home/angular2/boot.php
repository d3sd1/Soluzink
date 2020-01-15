<?php require('../../../../kernel/core.php');
if(config('debug'))
{
	echo 'import {provide} from \'angular2/core\';';
}
else
{
	echo 'import {provide,enableProdMode} from \'angular2/core\';';
}?>

import {bootstrap}        from 'angular2/platform/browser';
import {ROUTER_PROVIDERS, LocationStrategy, HashLocationStrategy} from 'angular2/router';

import {AppComponent}     from './app.component.php';
<?php
if(!config('debug'))
{
	echo 'enableProdMode();';
}
?>

bootstrap(AppComponent, [
  ROUTER_PROVIDERS,
  provide(LocationStrategy, { useClass: HashLocationStrategy })
]);