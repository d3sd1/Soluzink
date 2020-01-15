var working = false;
$('#recoverFormUnlocked').on('submit', function(e) {
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
        var datasPrev = window.location.href.split('/').slice(-1).pop(),datas;
        if(datasPrev.search('%7C'))
        {
            while (datasPrev.toString().indexOf('%7C') != -1)
            {
                datasPrev = datasPrev.toString().replace('%7C','|');
            }
        }
        datas = datasPrev.split('|||');
	$.ajax({
		data:  $("#recoverFormUnlocked").serialize() + '&code=' + datas[0] + '&email=' + datas[1],
		url:   '/codepassrecover',
		type:  'POST',
		success:  function (response) {
			if(response == 'RECOVER_SUCCESS')
			{
				setTimeout(function() {
					$this.addClass('ok');
					$state.html(langTranscription['RECOVER_SUCCESS_FULL']);
                                        setTimeout(function(){ window.location.href = '/#/Login'; }, (configTranscription['loadTime']*1.5));
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
			else
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					switch(response)
					{
						case 'PASS_NOTSET':
						responseTXT = langTranscription['PWD_NOTSET'];
						break;
						case 'PASS_NOT_MATCH':
						responseTXT = langTranscription['PASS_NOT_MATCH'];
						break;
						case 'PASSWORD_NOTVALID':
						responseTXT = langTranscription['REGISTER_PASSWORD_NOTVALID'];
						break;
						case 'CODE_NOTVALID':
						responseTXT = langTranscription['RECOVER_CODE_INVALID'];
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