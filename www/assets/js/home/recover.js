var working = false;
$('#recoverForm').on('submit', function(e) {
	e.preventDefault();
	if(working)
	{
		return;
	}
	working = true;
	var $this = $(this),$state = $this.find('button > .state');
	$this.addClass('loading');
	$state.html(langTranscription['RECOVERING_ON']);
        $('.login button .spinner').attr('style','display: block');
	$.ajax({
		data:  $("#recoverForm").serialize(),
		url:   '/passrecover',
		type:  'POST',
		success:  function (response) {
			if(response == 'RECOVER_SUCCESS')
			{
				setTimeout(function() {
					$this.addClass('ok');
					$state.html(langTranscription['RECOVER_SUCCESS']);
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
					$state.html(langTranscription['CRASH_RECOVER_TOOMANYATTEMPTS']);
				}, configTranscription['loadTime']);
			}
			else
			{
				if(response.toUpperCase().indexOf('EMAIL') >= 0)
				{
					$("input[name='recoverEmail']").focus();
				}
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					switch(response)
					{
						case 'EMAIL_NOTSET':
						responseTXT = langTranscription['EMAIL_NOTSET'];
						break;
						case 'EMAIL_NOTFOUND':
						responseTXT = langTranscription['EMAIL_NOTFOUND'];
						break;
						default:
						responseTXT += response;
					}
					$state.html(responseTXT);
					setTimeout(function() {
						$state.html(langTranscription['RECOVER_BUTTON']);
						$this.removeClass('error loading');
						working = false;
                                                $(".login button .spinner").css({"display":"none","border": "4px solid #ffffff","width": "40px"});
					}, (configTranscription['loadTime']/1.5));
				}, configTranscription['loadTime']);
			}
		}
	});
});