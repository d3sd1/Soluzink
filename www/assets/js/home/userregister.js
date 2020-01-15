var responseTXT = '';
$(document).ready(function(){
   $("input[name='registerPass']").bind("cut copy paste",function(e) {
      e.preventDefault();
   });
	$("input[name='registerPassrep']").bind("cut copy paste",function(e) {
      e.preventDefault();
   });
});
$('#registerForm').on('submit', function(e) {
	e.preventDefault();
		$("#registerSubmit").html('<i class="fa fa-spinner fa-spin"/>');
		if($("#registerError").hasClass('alert-show'))
		{
			$("#registerError p").html('<i class="fa fa-spinner fa-spin"/>');
		}
		if($("#registerSuccess").hasClass('alert-show'))
		{
			$("#registerSuccess").removeClass('alert-show');
		}
		$.ajax({
			data:  $("#registerForm").serialize(),
			url:   '/userregister?type=user',
			type:  'POST',
			success:  function (response) {
				if(response == 'REGISTER_SUCCESS')
				{
					setTimeout(function() {
						if($("#registerError").hasClass('alert-show'))
						{
							$("#registerError").removeClass('alert-show');
						}
						$("#registerSuccess").addClass('alert-show');
						$("#registerSuccess p").html(langTranscription['REGISTER_SUCCESS']);
						$.ajax({                        
						   type: 'POST',                 
						   url: '/login',                     
						   data: {inputCSRFProtecter: $("input[name='inputCSRFProtecter']").val(), loginEmail: $("input[name='registerEmail']").val(), loginPwd: $("input[name='registerPass']").val() }, 
						   success: function(data)             
						   {
								if(data == 'LOGIN_SUCCESS')
								{
									setTimeout(function(){ window.location.href = '/loggedRedirect'; }, (configTranscription['loadTime']*1.5));
								}
								else
								{
									$("#registerSuccess").removeClass('alert-show');
									$("#registerError").addClass('alert-show');
									$("#registerError p").html(langTranscription['CRASH_LOGINERROR']);
									setTimeout(function(){ window.location.href = '/#/Login'; }, (configTranscription['loadTime']*1.5));
								}  
						   }
					   });
					}, configTranscription['loadTime']);
				}
				else if(response == 'CRASH_CSRF')
				{
					setTimeout(function() {
						$("#registerError").addClass('alert-show');
						$("#registerError p").html(langTranscription['CRASH_CSRF']);
						setTimeout(function(){ location.reload(); }, (configTranscription['loadTime']*1.5));
					}, configTranscription['loadTime']);
				}
				else if(response == 'CRASH_ALREADYLOGGED')
				{
					setTimeout(function() {
						$("#registerError").addClass('alert-show');
						$("#registerError p").html(langTranscription['CRASH_ALREADYLOGGED']);
						setTimeout(function(){ window.location.href = '/loggedRedirect'; }, (configTranscription['loadTime']*1.5));
					}, configTranscription['loadTime']);
				}
				else if(response == 'CRASH_TOOMANYATTEMPTS')
				{
					setTimeout(function() {
						$("#registerError").addClass('alert-show');
						$("#registerError p").html(langTranscription['CRASH_REGISTERTOOMANYATTEMPTS']);
					}, configTranscription['loadTime']);
				}
				else
				{
					if(response.toUpperCase().indexOf('NAME') >= 0)
					{
						$("input[name='registerName']").focus();
					}
					if(response.toUpperCase().indexOf('SURNAME') >= 0)
					{
						$("input[name='registerSurnames']").focus();
					}
					if(response.toUpperCase().indexOf('EMAIL') >= 0)
					{
						$("input[name='registerEmail']").focus();
					}
					if(response.toUpperCase().indexOf('PHONE') >= 0)
					{
						$("input[name='registerPhone']").focus();
					}
					if(response.toUpperCase().indexOf('PASSWORD') >= 0)
					{
						$("input[name='registerPass']").focus();
					}
					if(response.toUpperCase().indexOf('PASSREP') >= 0)
					{
						$("input[name='registerPassrep']").focus();
					}
					if(response.toUpperCase().indexOf('CAPTCHA') >= 0)
					{
						$("input[name='registerCaptcha']").focus();
					}
					setTimeout(function() {
						switch(response)
						{
							case 'NAME_NOTSET':
							responseTXT = langTranscription['NAME_NOTSET'];
							break;
							case 'SURNAMES_NOTSET':
							responseTXT = langTranscription['SURNAMES_NOTSET'];
							break;
							case 'EMAIL_NOTSET':
							responseTXT = langTranscription['EMAIL_NOTSET'];
							break;
							case 'PHONE_NOTSET':
							responseTXT = langTranscription['PHONE_NOTSET'];
							break;
							case 'PASSWORD_NOTSET':
							responseTXT = langTranscription['PASSWORD_NOTSET'];
							break;
							case 'PASSREP_NOTSET':
							responseTXT = langTranscription['PASSREP_NOTSET'];
							break;
							case 'CAPTCHA_NOTSET':
							responseTXT = langTranscription['CAPTCHA_NOTSET'];
							break;
							case 'NAME_NOTVALID':
							responseTXT = langTranscription['REGISTER_NAME_NOTVALID'];
							break;
							case 'SURNAMES_NOTVALID':
							responseTXT = langTranscription['REGISTER_SURNAMES_NOTVALID'];
							break;
							case 'EMAIL_NOTVALID':
							responseTXT = langTranscription['REGISTER_EMAIL_NOTVALID'];
							break;
							case 'PHONE_NOTVALID':
							responseTXT = langTranscription['REGISTER_PHONE_NOTVALID'];
							break;
							case 'PASSWORD_NOTVALID':
							responseTXT = langTranscription['REGISTER_PASSWORD_NOTVALID'];
							break;
							case 'PASSREP_NOTMATCH':
							responseTXT = langTranscription['REGISTER_PASSREP_NOTVALID'];
							break;
							case 'EMAIL_ALREADYREGISTERED':
							responseTXT = langTranscription['REGISTER_EMAIL_ALREADYREGISTERED'];
							break;
							case 'CAPTCHA_NOTVALID':
							$.getScript('/regCaptcha', function(message)
							{
							  $("input[name='registerCaptcha']").val('').attr('placeholder', langTranscription['CONTACT_CAPTCHA_MSG'] + message + ' =');
							});
							responseTXT = langTranscription['CONTACT_CAPTCHA_NOTVALID'];
							break;
							default:
							responseTXT += response;
						}
						$("#registerError").addClass('alert-show');
						$("#registerError p").html(responseTXT);
					}, configTranscription['loadTime']);
				}
				
				setTimeout(function() {
					$("#registerSubmit").html(langTranscription['REGISTER_SEND']);
				}, configTranscription['loadTime']);
			}
		});
		
});