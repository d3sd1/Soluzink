var working = false;
$('footer').css('display', 'none');
$('#loginForm').on('submit', function(e) {
	e.preventDefault();
	if(working)
	{
            return;
	}
	working = true;
	var $this = $(this),$state = $this.find('button > .state');
	$this.addClass('loading');
	$state.html(langTranscription['LOGIN_ON']);
        $('.login button .spinner').attr('style','display: block');
	$.ajax({
		data:  $("#loginForm").serialize(),
		url:   '/login',
		type:  'POST',
		success:  function (response) {
			if(response == 'LOGIN_SUCCESS')
			{
				setTimeout(function() {
					$this.addClass('ok');
					$state.html(langTranscription['LOGIN_SUCCESS']);
					setTimeout(function(){ window.location.href = '/loggedRedirect'; }, (configTranscription['loadTime']*1.5));
				}, configTranscription['loadTime']);
			}
			else if(response == 'CRASH_CSRF')
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					$state.html(langTranscription['CRASH_CSRF']);
					setTimeout(function(){ location.reload(); }, (configTranscription['loadTime']*1.5));
				}, configTranscription['loadTime']);
			}
			else if(response == 'CRASH_ALREADYLOGGED')
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					$state.html(langTranscription['CRASH_ALREADYLOGGED']);
					setTimeout(function(){ window.location.href = '/loggedRedirect'; }, (configTranscription['loadTime']*1.5));
				}, configTranscription['loadTime']);
			}
			else if(response == 'CRASH_TOOMANYATTEMPTS')
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					$state.html(langTranscription['CRASH_TOOMANYATTEMPTS']);
				}, configTranscription['loadTime']);
			}
			else if(response == 'CRASH_ACCOUNT_BLOCKED')
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					$state.html(langTranscription['CRASH_ACCOUNT_BLOCKED']);
				}, configTranscription['loadTime']);
			}
			else if(response == 'CRASH_ACCOUNT_BANNED')
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					$state.html(langTranscription['CRASH_ACCOUNT_BANNED']);
				}, configTranscription['loadTime']);
			}
			else
			{
				if(response.toUpperCase().indexOf('PWD') >= 0)
				{
					$("input[name='loginPwd']").focus();
					$("input[name='loginPwd']").val('');
				}
				if(response.toUpperCase().indexOf('EMAIL') >= 0)
				{
					$("input[name='loginEmail']").focus();
					$("input[name='loginEmail']").val('');
					$("input[name='loginPwd']").val('');
				}
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					switch(response)
					{
						case 'EMAIL_NOTSET':
						responseTXT = langTranscription['EMAIL_NOTSET'];
						break;
						case 'PWD_NOTSET':
						responseTXT = langTranscription['PWD_NOTSET'];
						break;
						case 'EMAIL_NOTFOUND':
						responseTXT = langTranscription['EMAIL_NOTFOUND'];
						break;
						case 'PWD_WRONG':
						responseTXT = langTranscription['PWD_WRONG'];
						break;
						default:
						responseTXT += response;
					}
					$state.html(responseTXT);
					setTimeout(function() {
						$state.html(langTranscription['LOGIN_BUTTON']);
						$this.removeClass('error loading');
						working = false;
                                                $(".login button .spinner").css({"display":"none","border": "4px solid #ffffff","width": "40px"});
					}, (configTranscription['loadTime']/1.5));
				}, configTranscription['loadTime']);
			}
		}
	});
});