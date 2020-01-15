var working = false;
$('footer').css('display', 'none');
function resendRecoverCode()
{
    $('#recoverInfoBox').hide();
    $('#recoverInfoBoxSecond').hide();
    $.ajax({ url: '/generatenewblockedcode',
        type: 'POST',
        success: function(response){
           switch(response)
           {
               case 'CRASH_NOTLOGGED':
                   $('<div id="recoverInfoBoxSecond" class="alert alert-danger fade in">' + langTranscription['RECOVERACC_NOT_LOGGED'] + '</div>').insertAfter( "#recoverInfoBox" );
               break;
               case 'TOO_EARLY':
                   $('<div id="recoverInfoBoxSecond" class="alert alert-danger fade in">' + langTranscription['RECOVERACC_TOO_EARLY'] + '</div>').insertAfter( "#recoverInfoBox" );
               break;
               case 'RESEND_SUCCESS':
                   $('<div id="recoverInfoBoxSecond" class="alert alert-info fade in">' + langTranscription['RECOVERACC_RESEND_SUCCESS'] + '</div>').insertAfter( "#recoverInfoBox" );
               break;
           }
    }});
}
$(document).ready(function(){
    $.ajax({ url: '/checklogin',
        context: document.body,
        success: function(response){
           if(response != 'ACC_BLOCKED')
            {
                window.location.replace(configTranscription['URL'] + '/#/Psicos');
            }
    }});
});
$('#recoveraccForm').on('submit', function(e) {
        $('#recoverInfoBox').show();
        $('#recoverInfoBoxSecond').hide();
	e.preventDefault();
	if(working)
	{
            return;
	}
	working = true;
	var $this = $(this),$state = $this.find('button > .state');
	$this.addClass('loading');
	$state.html(langTranscription['RECOVERACC_SENDING']);
        $('.login button .spinner').attr('style','display: block');
	$.ajax({
		data:  $("#recoveraccForm").serialize(),
		url:   '/recover',
		type:  'POST',
		success:  function (response) {
			if(response == 'RECOVER_SUCCESS')
			{
				setTimeout(function() {
					$this.addClass('ok');
					$state.html(langTranscription['RECOVERACC_SUCCESS']);
					setTimeout(function(){ window.location.replace(configTranscription['URL'] + '/#/Psicos'); }, (configTranscription['loadTime']*1.5));
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
			else if(response == 'CRASH_NOTLOGGED')
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					$state.html(langTranscription['CRASH_ALREADYLOGGED']);
					setTimeout(function(){ window.location.replace('/#/Psicos'); }, (configTranscription['loadTime']*1.5));
				}, configTranscription['loadTime']);
			}
			else if(response == 'CRASH_TOOMANYATTEMPTS')
			{
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					$state.html(langTranscription['RECOVERACC_CRASH_TOOMANYATTEMPTS']);
					setTimeout(function(){ window.location.replace(configTranscription['URL'] + '/logout'); }, (configTranscription['loadTime']*1.5));
				}, configTranscription['loadTime']);
			}
			else
			{
                            $("input[name='recoveraccCode']").focus();
                            $("input[name='recoveraccCode']").val('');
				setTimeout(function() {
					$this.addClass('error');
                                        $(".login button .spinner").css({"display":"block","border": "none","width": "0px"});
					switch(response)
					{
						case 'CODE_NOTSET':
						responseTXT = langTranscription['RECOVERACC_CODE_NOTSET'];
						break;
						case 'CODE_WRONG':
						responseTXT = langTranscription['RECOVERACC_CODE_WRONG'];
						break;
						case 'INTERNAL_ERROR':
						responseTXT = langTranscription['RECOVERACC_INTERNAL_ERROR'];
						break;
						default:
						responseTXT += response;
					}
					$state.html(responseTXT);
					setTimeout(function() {
						$state.html(langTranscription['RECOVERACC_BUTTON']);
						$this.removeClass('error loading');
						working = false;
                                                $(".login button .spinner").css({"display":"none","border": "4px solid #ffffff","width": "40px"});
					}, (configTranscription['loadTime']/1.5));
				}, configTranscription['loadTime']);
			}
		}
	});
});