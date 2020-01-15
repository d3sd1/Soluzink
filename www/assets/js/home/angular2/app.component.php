<?php require('../../../../kernel/core.php') ?>import {Component} from 'angular2/core';
import { Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';

import {Psicos}     from './pages/psicos.component.ts';
import {Coaches}     from './pages/coaches.component.ts';
import {Terms}     from './pages/terms.component.ts';
import {Test}     from './pages/test.component.ts';
import {TestSingle}     from './pages/testsingle.component.ts';
import {Contact}     from './pages/contact.component.ts';
import {ExtProfile}     from './pages/extprofile.component.ts';
<?php
if(!USER_LOGGED_IN)
{
	echo '
import {UserRegister}     from \'./pages/userregister.component.ts\';
import {PsicoRegister}     from \'./pages/psicoregister.component.ts\';
import {Login}     from \'./pages/login.component.ts\';
import {RecoverPass}     from \'./pages/recoverpass.component.ts\';
import {RecoverPassCode}     from \'./pages/recoverpasscode.component.ts\';
import {LogoutLoggedSmw}     from \'./pages/logoutloggedsmw.component.ts\';
import {Logout}     from \'./pages/logout.component.ts\';';
}
else
{
    echo '
import {Recover}     from \'./pages/recover.component.ts\';
import {Profile}     from \'./pages/profile.component.ts\';';
    if(USER_TYPE_CLIENT)
    {
        echo '
import {UserSession}     from \'./pages/usersession.component.ts\';';
    }
    else
    {
        echo '
import {PsicoSession}     from \'./pages/psicosession.component.ts\';
import {Notes}     from \'./pages/notes.component.ts\';
import {UserSession}     from \'./pages/usersession.component.ts\';';
    }
}
?>

import {Privacy}     from './pages/privacy.component.ts';
import {Error}     from './pages/error.component.ts';

@Component({
  selector: 'soluzink',
  moduleId: __moduleName,
  templateUrl: './templates/base.php',
  directives: [ROUTER_DIRECTIVES]
})
@RouteConfig([

	{ path: '', component: Psicos},
	{path: '/Psicos',   name: 'Psicos',     component: Psicos},
	{path: '/Coaches',   name: 'Coaches',     component: Coaches},
	{path: '/Terms',   name: 'Terms',     component: Terms},
	{path: '/Test/:testid',   name: 'TestSingle',     component: TestSingle},
	{path: '/Test',   name: 'Test',     component: Test},
	{path: '/Contact',   name: 'Contact',     component: Contact},
	<?php
	if(!USER_LOGGED_IN)
	{
		echo '
	{path: \'/PsicoRegister\',   name: \'PsicoRegister\',     component: PsicoRegister},
	{path: \'/UserRegister\',   name: \'UserRegister\',     component: UserRegister},
	{path: \'/Login\',   name: \'Login\',     component: Login},
	{path: \'/RecoverPass\',   name: \'RecoverPass\',     component: RecoverPass},
	{path: \'/RecoverPass/:code\',   name: \'RecoverPassCode\',     component: RecoverPassCode},
	{path: \'/LogoutLoggedSmw\',   name: \'LogoutLoggedSmw\',     component: LogoutLoggedSmw},
	{path: \'/Logout\',   name: \'Logout\',     component: Logout},';
	}
	else
	{
                if(USER_TYPE_CLIENT)
                {
                    echo '
	{path: \'/UserSession\',   name: \'UserSession\',     component: UserSession},';
                }
                else
                {
                    echo '
	{path: \'/PsicoSession\',   name: \'PsicoSession\',     component: PsicoSession},
	{path: \'/Notes\',   name: \'Notes\',     component: Notes},
	{path: \'/UserSession\',   name: \'UserSession\',     component: UserSession},';
                }
		echo '
	{path: \'/Profile\',   name: \'Profile\',     component: Profile},
	{path: \'/Recover\',   name: \'Recover\',     component: Recover},';
	}
	?>
        
	{path: '/Privacy',   name: 'Privacy',     component: Privacy},
	{path: '/ExtProfile/:profileID',   name: 'ExtProfile',     component: ExtProfile},
	{path: '**', component: Error}
	])
export class AppComponent {
	constructor(private router: Router) {
		this.setUpEvents();
	}

	private setUpEvents(): void {
		this.router.subscribe((value: any) => this.onNext(value));
	}

	private onNext(value: any): void {
        if(lastValue == 'undefined')
        {
            lastValue = value;
        }
        if((lastValue == 'UserSession' || lastValue == 'PsicoSession') && lastValue != value && sessionActive)
        {
            var r = confirm(langTranscription['SESSION_ABANDONED']);
            if (r == true) {
                window.onbeforeunload = function(evt) {localStorage.openpages = "0";}
                window.location.replace(configTranscription['URL'] + '/#/' + lastValue);
                location.reload();
            }
            else
            {
                window.onbeforeunload = function(evt) {localStorage.openpages = "0";}
            }
        }
        lastValue = value;
        if(value.search('ExtProfile') != -1)
        {
            langkey = 'ExtProfile';
        }
        else
        {
            langkey = value;
        }
        
        if(typeof langTranscription['pagetitle'+langkey] == 'undefined')
        {
            if(value.search('RecoverPass') != -1)
            {
                langkey = 'RecoverPassCode';
            }
            else if(value.search('Test') != -1)
            {
                langkey = 'TestSingle';
            }
            else
            {
                langkey = langTranscription['pagetitleError'];
            }
        }
            $(document).prop('title', langTranscription['pagetitle'] + ' ~ ' + langTranscription['pagetitle'+langkey]);
            $.getScript('assets/js/home/checkmaintenance.js', function(){});
            <?php
            /* Check the user current session is the lastest */
            if(USER_LOGGED_IN)
            {
                    echo '
            $.getScript(\'assets/js/home/checklogin.js\', function(){});';
            }
            ?>
            configTranscription['showedIdsAlready'] = null;
            if(value.search('ExtProfile') == -1 && value.search('Psicos') == -1 && value.search('Coaches') == -1 && value.search('Recover') == -1 && value.search('Login') == -1 && value.search('PsicoSession') == -1)
            {
                $('footer').removeAttr('style', '');
            }
	}
	ngAfterViewInit() {
	  $.getScript('assets/js/home/base.js', function(){});
	}
}
