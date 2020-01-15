$('#contactForm').on('submit', function(e) {
	e.preventDefault();
		$("#contactSubmit").html('<i class="fa fa-spinner fa-spin"/>');
		if($("#contactError").hasClass('alert-show'))
		{
			$("#contactError p").html('<i class="fa fa-spinner fa-spin"/>');
		}
		if($("#contactSuccess").hasClass('alert-show'))
		{
			$("#contactSuccess").removeClass('alert-show');
		}
		$.ajax({
			data:  $("#contactForm").serialize(),
			url:   '/contact',
			type:  'POST',
			success:  function (response) {
				if(response == 'CONTACT_SUCCESS')
				{
					setTimeout(function() {
						if($("#contactError").hasClass('alert-show'))
						{
							$("#contactError").removeClass('alert-show');
						}
						$("#contactSuccess").addClass('alert-show');
						$("#contactSuccess p").html(langTranscription['CONTACT_SUCCESS']);
						$("textarea[name='contactMessage']").val('');
						$("input[name='contactCaptcha']").val('');
					}, configTranscription['loadTime']);
				}
				else if(response == 'CRASH_CSRF')
				{
					setTimeout(function() {
						$("#contactError").addClass('alert-show');
						$("#contactError p").html(langTranscription['CRASH_CSRF']);
						setTimeout(function(){ location.reload(); }, (configTranscription['loadTime']*1.5));
					}, configTranscription['loadTime']);
				}
				else if(response == 'CRASH_ALREADYSENT')
				{
					setTimeout(function() {
						$("#contactError").addClass('alert-show');
						$("#contactError p").html(langTranscription['CRASH_ALREADYSENT']);
					}, configTranscription['loadTime']);
				}
				else
				{
					if(response.toUpperCase().indexOf('NAME') >= 0)
					{
						$("input[name='contactName']").focus();
					}
					if(response.toUpperCase().indexOf('EMAIL') >= 0)
					{
						$("input[name='contactEmail']").focus();
					}
					if(response.toUpperCase().indexOf('PHONE') >= 0)
					{
						$("input[name='contactPhone']").focus();
					}
					if(response.toUpperCase().indexOf('MESSAGE') >= 0)
					{
						$("input[name='contactMessage']").focus();
					}
					if(response.toUpperCase().indexOf('CAPTCHA') >= 0)
					{
						$("input[name='contactCaptcha']").focus();
					}
					setTimeout(function() {
						switch(response)
						{
							case 'NAME_NOTSET':
							responseTXT = langTranscription['NAME_NOTSET'];
							break;
							case 'EMAIL_NOTSET':
							responseTXT = langTranscription['EMAIL_NOTSET'];
							break;
							case 'PHONE_NOTSET':
							responseTXT = langTranscription['PHONE_NOTSET'];
							break;
							case 'MESSAGE_NOTSET':
							responseTXT = langTranscription['MESSAGE_NOTSET'];
							break;
							case 'CAPTCHA_NOTSET':
							responseTXT = langTranscription['CAPTCHA_NOTSET'];
							break;
							case 'NAME_NOTVALID':
							responseTXT = langTranscription['CONTACT_NAME_NOTVALID'];
							break;
							case 'EMAIL_NOTVALID':
							responseTXT = langTranscription['CONTACT_EMAIL_NOTVALID'];
							break;
							case 'PHONE_NOTVALID':
							responseTXT = langTranscription['CONTACT_PHONE_NOTVALID'];
							break;
							case 'MESSAGE_NOTVALID':
							responseTXT = langTranscription['CONTACT_MESSAGE_NOTVALID'];
							break;
							case 'CAPTCHA_NOTVALID':
							$.getScript('/regCaptcha', function(message)
							{
							  $("input[name='contactCaptcha']").val('').attr('placeholder', langTranscription['CONTACT_CAPTCHA_MSG'] + message + ' =');
							});
							responseTXT = langTranscription['CONTACT_CAPTCHA_NOTVALID'];
							break;
							default:
							responseTXT += response;
						}
						$("#contactError").addClass('alert-show');
						$("#contactError p").html(responseTXT);
					}, configTranscription['loadTime']);
				}
				
				setTimeout(function() {
					$("#contactSubmit").html(langTranscription['CONTACT_SEND']);
				}, configTranscription['loadTime']);
			}
		});
		
});