"use strict"; 
$(document).ready(function(){
	var height = $(window).height();
	$('.full-height').css('min-height', (height));
	$('#map_canvas').height($('#form_card_height').height());
	$('.full-width-header').width($('.main-wrapper').width());
        if($('.testimonial-carousel > div').length > 1)
        {
            $('.testimonial-carousel').owlCarousel({
                    loop:true,
                    margin:0,
                    nav:true,
                    navText: ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
                    dots:false,
                    autoplay:true,
                    responsive:{
                            0:{
                                    items:1
                            }
                    }
            });
        }
	smoothScroll.init({
		speed: 800,
		easing: 'easeInOutCubic',
		offset: 50,
		updateURL: false,
		callbackBefore: function ( toggle, anchor ) {},
		callbackAfter: function ( toggle, anchor ) {},
	});
	var progressBar = $('.progress-bar-graph div');
	for(var i = 0; i < progressBar.length; i++){
		$(progressBar[i]).appear(function(){			
			var percent = $(this).find('span').attr('data-width');
			var $endNum = parseInt($(this).find('.bar-wrap strong i').text(),10);
			
			var $that = $(this);			
			$(this).find('span').animate({
				'width' : percent + '%'
			},1600, function(){
			});			
			$(this).find('.bar-wrap strong').animate({
				'opacity' : 1
			},1400);			
			if(percent == '100'){
				$that.find('bar-wrap strong').addClass('full');
			}	
		});
	}
});
function openProfileImageModal()
{
    vex.defaultOptions.className = configTranscription['modalTheme'];
    vex.closeAll();
    vex.dialog.open({
       input: [
               '<img draggable="false" style="width: 100%; height: 100%" src="' + $('#profileImageURL').css('background-image').replace('url("','').replace('")','') + '"/>'
       ].join(''),
       buttons: [
               $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SUCCESS_BUTTON'] }),
               $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
       ],
       overlayClosesOnClick: true
   });
}
function updateCalendarCell(el,inputTrigger = false)
{
    if(!inputTrigger)
    {
        if($(el).children('input').val() > 59 || $(el).children('input').val() < 0)
        {
            $(el).children('input').val('00');
        }
        if($(el).hasClass('calendarSelected'))
        {
            $(el).removeClass('calendarSelected').addClass('calendarDeselected');
            $(el).children('.calendarSelectLength').remove();
        }
        else if($(el).hasClass('calendarDeselected'))
        {
            $(el).removeClass('calendarDeselected');
            $(el).children('.calendarSelectLength').remove();
        }
        else
        {
            $(el).addClass('calendarSelected');
            $(el).append('<div class="form-group calendarSelectLength"><select class="form-control"><option value="30">30 ' + langTranscription['PROFILE_CALENDAR_EDITOR_SESSLENGTH_MIN'] + '</option><option value="60">60 ' + langTranscription['PROFILE_CALENDAR_EDITOR_SESSLENGTH_MIN'] + '</option></select></div>');
        }
    }
    else
    {
        if($(el).parent().children('input').val() > 59 || $(el).parent().children('input').val() < 0)
        {
            $(el).parent().children('input').val('00');
        }
        if(!$(el).parent().hasClass('calendarSelected'))
        {
            $(el).parent().addClass('calendarSelected').removeClass('calendarDeselected');
            $(el).parent().append('<div class="form-group calendarSelectLength"><select class="form-control"><option value="30">30 ' + langTranscription['PROFILE_CALENDAR_EDITOR_SESSLENGTH_MIN'] + '</option><option value="60">60 ' + langTranscription['PROFILE_CALENDAR_EDITOR_SESSLENGTH_MIN'] + '</option></select></div>');
        }
    }
}
$("#calendarEditor").on('click','.calendarTime', function(el) {
    if($(el.target).hasClass('calendarTime'))
    {
        updateCalendarCell(this);
    }
});
$("#calendarEditor").on('click','#updateProfCalendar', function(el) {
    $('#showFormErrorCalendar').addClass('hideme');
    $('#showFormErrorPersCalendar').remove();
    if($('#calendarMaxDate').val() == '' || Math.floor(new Date($('#calendarMaxDate').val()).getTime()/1000) < Math.floor(Date.now() / 1000))
    {
        if(!$('#showFormErrorCalendar').hasClass('hideme')){
            $('#showFormErrorCalendar').addClass('hideme');
       }
       $('<div class="row" id="showFormErrorPersCalendar"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_CALENDARMAXDATE'] + '</div></div></div>').insertAfter('#showFormErrorCalendar');
                    
    }
    else
    {
        var data = {};
        data['days'] = {0: [],1: [],2: [],3: [],4: [],5: [],6: []};
        data['weeklyexceptions'] = {0: [],1: [],2: [],3: [],4: [],5: [],6: []};
        data['maxdate'] = $('#calendarMaxDate').val();
        $('.calendarTime').each(function(){
            if($(this).hasClass('calendarSelected'))
            {
                data['days'][$(this).attr('data-weekday')].push($(this).attr('data-hour') + '.' + $(this).children('input').val() + '--' + $(this).find('select').val());
            }
            else if($(this).hasClass('calendarDeselected'))
            {
                data['weeklyexceptions'][$(this).attr('data-weekday')].push('-'+$(this).attr('data-hour'));
            }
        });
        var resultJSON = JSON.stringify(data);
        $.ajax({
            url : configTranscription['URL'] + '/updatecalprof',
            type : "post",
            async: true,
            beforeSend: function() { 
                $('#updateProfCalendar').attr('data-realtext',$('#updateProfCalendar').text()).html('<i class="fa fa-spinner fa-spin"></i>');
                $('#updateProfCalendar').attr('disabled',true);
            },
            data: {maxdate: data['maxdate'],days: data['days'],weeklyexceptions: data['weeklyexceptions']},
            success : function(res) {
                var resparr = res.split('|||');
                switch(resparr[0])
                {
                    case 'ERROR_NODATA_MAXDATE':
                        $('<div class="row" id="showFormErrorPersCalendar"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_CALENDARMAXDATE'] + '</div></div></div>').insertAfter('#showFormErrorCalendar');
                    break;
                    case 'ERROR_NODATA_DAYS':
                        $('<div class="row" id="showFormErrorPersCalendar"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_CALENDARDAYS'] + '</div></div></div>').insertAfter('#showFormErrorCalendar');
                    break;
                    case 'ERROR_DATA_INVALID':
                        $('<div class="row" id="showFormErrorPersCalendar"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_INVALIDDATA'] + '</div></div></div>').insertAfter('#showFormErrorCalendar');
                    break;
                    case 'CHANGES_SUCCESS':
                        closeNotification();
                        $('<div class="row" id="showFormErrorPersCalendar"><div class="col-md-12"><div class="alert alert-info fade in">' + langTranscription['PROFILE_UPD_SUCCESSCLDR'] + '</div></div></div>').insertAfter('#showFormErrorCalendar');
                    break;
                    case 'CRASH_NOWAY':
                       $('<div class="row" id="showFormErrorPersCalendar"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_NOWAY'] + '</div></div></div>').insertAfter('#showFormErrorCalendar');
                    break;
                    case 'ERROR_DAY_BIGGER_THAN_NEXT':
                        $('<div class="row" id="showFormErrorPersCalendar"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_SESSIONSDROPPED'].replace('{{detect}}',resparr[1]) + '</div></div></div>').insertAfter('#showFormErrorCalendar');
                    break;
                }
                $('#updateProfCalendar').html($('#updateProfCalendar').attr('data-realtext')).removeAttr('data-realtext');
                $('#updateProfCalendar').attr('disabled',false);
            }
        });
    }
});
$("#calendarEditor").on('blur','.calendarHour',function() {
    updateCalendarCell(this,true);
});
function openImageUploader()
{
    vex.defaultOptions.className = configTranscription['modalTheme'];
    vex.closeAll();
    vex.dialog.open({
        input: [
                '<form id="changeProfileImage" method="post" enctype="multipart/form-data">' + 

        '<div class="slim"' + 
	' data-ratio="1:1"' + 
	' data-size="' + configTranscription['profileImageSize'] + ',' + configTranscription['profileImageSize'] + '"' + 
	' data-force-size="' + configTranscription['profileImageSize'] + ',' + configTranscription['profileImageSize'] + '"' + 
        ' data-label="' + langTranscription['PROFILE_IMGUPL_INPUT'] + '"' + 
	' data-instant-edit="true"' + 
	' data-download="false"' + 
        ' data-button-confirm-label="' + langTranscription['PROFILE_IMGUPL_SEND'] + '"' + 
        ' data-button-confirm-title="' + langTranscription['PROFILE_IMGUPL_SEND'] + '"' + 
        ' data-button-cancel-label="' + langTranscription['PROFILE_IMGUPL_BACK'] + '"' + 
        ' data-button-cancel-title="' + langTranscription['PROFILE_IMGUPL_BACK'] + '"' + 
        ' data-button-edit-label="' + langTranscription['PROFILE_IMGUPL_EDIT'] + '"' + 
        ' data-button-edit-title="' + langTranscription['PROFILE_IMGUPL_EDIT'] + '"' + 
        ' data-button-remove-label="' + langTranscription['PROFILE_IMGUPL_RMV'] + '"' + 
        ' data-button-remove-title="' + langTranscription['PROFILE_IMGUPL_RMV'] + '"' + 
        ' data-button-rotate-label="' + langTranscription['PROFILE_IMGUPL_TURN'] + '"' + 
        ' data-button-rotate-title="' + langTranscription['PROFILE_IMGUPL_TURN'] + '">' + 
        '    <input type="file" accept="image/jpeg, image/gif"/>' + 
        '</div>' + 

    '</form>'
        ].join(''),
        buttons: [
                $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SEND'] }),
                $.extend({}, vex.dialog.buttons.NO, { text: langTranscription['PROFILE_IMGUPL_BACK'] })
        ],
        overlayClosesOnClick: false,
        onSubmit: function () {
            event.preventDefault();
            event.stopPropagation();
            $.ajax({
            url : configTranscription['URL'] + '/changeprofileimage',
            type : "post",
            async: true,
            data: $("#changeProfileImage").serialize(),
            beforeSend: function () {
                $("#changeProfileImage").click(function(){event.preventDefault(); event.stopPropagation(); return false; });
                $('.slim-btn').each(function() {
                   $('.slim-btn').attr('disabled',true);
                });
                $('.vex-dialog-button-secondary').html('<i class="fa fa-spinner fa-spin"></i>');
                $('.vex-dialog-button-secondary').attr('disabled',true);
                $('.vex-dialog-button-primary').html('<i class="fa fa-spinner fa-spin"></i> ' + langTranscription['PROFILE_IMGUPL_PROCCESSING'] + ' <i class="fa fa-spinner fa-spin"></i>');
                $('.vex-dialog-button-primary').attr('disabled',true);
            },
            success : function(res) {
                var response = res.split('|||');
                switch(response[0])
                {
                    case 'NO_FACE_DETECTED':
                        vex.closeAll();
                        vex.dialog.open({
                           input: [
                                   '<div class="alert alert-danger"><strong>' + langTranscription['PROFILE_IMGUPL_ERROR_TITLE'] + '</strong> ' + langTranscription['PROFILE_IMGUPL_ERROR_HIDDENFACE'] + '</div>'
                           ].join(''),
                           buttons: [
                                   $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SUCCESS_BUTTON'] }),
                                   $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                           ],
                           overlayClosesOnClick: false,
                           additionalClass: 'text-center',
                           onSubmit: function () {
                               event.preventDefault();
                               openImageUploader();
                           }
                       });
                    break;
                    case 'ERROR_PIC_SIZE':
                        vex.closeAll();
                        vex.dialog.open({
                           input: [
                                   '<div class="alert alert-danger"><strong>' + langTranscription['PROFILE_IMGUPL_ERROR_TITLE'] + '</strong> ' + langTranscription['PROFILE_IMGUPL_ERROR_PICSIZE'] + '</div>'
                           ].join(''),
                           buttons: [
                                   $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SUCCESS_BUTTON'] }),
                                   $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                           ],
                           overlayClosesOnClick: false,
                           additionalClass: 'text-center'
                       });
                    break;
                    case 'ERROR_IMG_TYPE':
                        vex.closeAll();
                        vex.dialog.open({
                           input: [
                                   '<div class="alert alert-danger"><strong>' + langTranscription['PROFILE_IMGUPL_ERROR_TITLE'] + '</strong> ' + langTranscription['PROFILE_IMGUPL_ERROR_IMGTYPE'] + '</div>'
                           ].join(''),
                           buttons: [
                                   $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SUCCESS_BUTTON'] }),
                                   $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                           ],
                           overlayClosesOnClick: false,
                           additionalClass: 'text-center'
                       });
                    break;
                    case 'ERROR_PIC_WIDTH_HEIGHT':
                        vex.closeAll();
                        vex.dialog.open({
                           input: [
                                   '<div class="alert alert-danger"><strong>' + langTranscription['PROFILE_IMGUPL_ERROR_TITLE'] + '</strong> ' + langTranscription['PROFILE_IMGUPL_ERROR_IMGSIZEWIDTHHEIGHT'] + '</div>'
                           ].join(''),
                           buttons: [
                                   $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SUCCESS_BUTTON'] }),
                                   $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                           ],
                           overlayClosesOnClick: false,
                           additionalClass: 'text-center'
                       });
                    break;
                    case 'ERROR':
                        vex.closeAll();
                        vex.dialog.open({
                           input: [
                                   '<div class="alert alert-danger"><strong>' + langTranscription['PROFILE_IMGUPL_ERROR_TITLE'] + '</strong> ' + langTranscription['PROFILE_IMGUPL_ERROR_GENERAL'] + '</div>'
                           ].join(''),
                           buttons: [
                                   $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SUCCESS_BUTTON'] }),
                                   $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                           ],
                           overlayClosesOnClick: false,
                           additionalClass: 'text-center'
                       });
                    break;
                    case 'SUCCESS':
                        $('#profileImageURL').attr('style', 'background-image: url(\'' +  response[1] + '?' + new Date().getTime() + '\');').fadeIn();
                        vex.closeAll();
                        vex.dialog.open({
                           input: [
                                   '<i class="fa fa-spinner fa-spin" style="font-size: 100px"></i>'
                           ].join(''),
                           buttons: [
                                   $.extend({}, vex.dialog.buttons.YES, { className: 'button-hidden', text: '' }),
                                   $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                           ],
                           overlayClosesOnClick: false,
                           additionalClass: 'text-center'
                       });
                       $('#profileImageURL').css("background", response[1] + '?' + new Date().getTime()).fadeIn();

                       setTimeout(function() {vex.closeAll(); vex.dialog.open({
                           input: [
                                   '<div class="alert alert-info"><strong>' + langTranscription['PROFILE_IMGUPL_SUCCESS_TITLE'] + '</strong> ' + langTranscription['PROFILE_IMGUPL_SUCCESS_DESC'] + '</div>'
                           ].join(''),
                           buttons: [
                                   $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SUCCESS_BUTTON'] }),
                                   $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                           ],
                           overlayClosesOnClick: false,
                           additionalClass: 'text-center'
                       });
                   },1000);
                    break;
                }
                $('.vex-dialog-button-secondary').html(langTranscription['PROFILE_IMGUPL_BACK']);
                $('.vex-dialog-button-secondary').attr('disabled',false);
                $('.vex-dialog-button-primary').html(langTranscription['PROFILE_IMGUPL_SEND']);
                $('.vex-dialog-button-primary').attr('disabled',false);
            }
         });
        }
    });
    $('#changeProfileImage').slim('parse');
}
$("#updateProfile").keypress(function(e) {
    if(e.which == 13) {
        updateProfile();
    }
});
$("#updateProfileTrigger").click(function(){
    updateProfile();
});
$("#updatePasswordTrigger").click(function(){
    vex.closeAll();
    vex.dialog.open({
       input: [
               '<div class="alert alert-danger fade in hide" id="updatePasswordMessage"></div><form id="updatePasswordModal"><div class="input-group"><span class="input-group-addon">' + langTranscription['PROFILE_UPDATE_PASSWORD_NEWPASS1'] + '</span><input type="password" class="form-control" placeholder="' + langTranscription['PROFILE_UPDATE_PASSWORD_NEWPASS1PH'] + '" name="cpn_pass1"></div>' +
               '<div class="input-group"><span class="input-group-addon">' + langTranscription['PROFILE_UPDATE_PASSWORD_NEWPASS2'] + '</span><input type="password" class="form-control" placeholder="' + langTranscription['PROFILE_UPDATE_PASSWORD_NEWPASS2PH'] + '" name="cpn_pass2"></div>' +
               '<div class="input-group"><span class="input-group-addon">' + langTranscription['PROFILE_UPDATE_PASSWORD_OLDPASS'] + '</span><input type="password" class="form-control" placeholder="' + langTranscription['PROFILE_UPDATE_PASSWORD_OLDPASSPH'] + '" name="cpn_oldpass"></div></form>'
       ].join(''),
       buttons: [
               $.extend({}, vex.dialog.buttons.YES, {text: langTranscription['PROFILE_UPDATE_PASSWORD_BTNOK']}),
               $.extend({}, vex.dialog.buttons.NO, {text: langTranscription['PROFILE_UPDATE_PASSWORD_BTNCNL']})
       ],
       overlayClosesOnClick: false,
       additionalClass: 'text-center',
       onSubmit: function (e) {
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
               url : configTranscription['URL'] + '/updatepassword',
               type : "post",
               async: false,
               data: $("#updatePasswordModal").serialize() + '&inputCSRFProtecter=' + $('input[name=\'inputCSRFProtecter\']').val(),
               beforeSend: function () {
                   $('.vex-dialog-button-primary').html('<i class="fa fa-spinner fa-spin"></i>');
                   $('.vex-dialog-button-primary').addClass('disableClick');
                   $('.vex-dialog-button-secondary').addClass('disableClick');
               },
               success : function(res) {
                   $('.vex-dialog-button-primary').html(langTranscription['PROFILE_UPDATE_PASSWORD_BTNOK']);
                   $('.vex-dialog-button-primary').removeClass('disableClick');
                   $('.vex-dialog-button-secondary').removeClass('disableClick');
                   if($('#updatePasswordMessage').hasClass('hide'))
                   {
                       $('#updatePasswordMessage').removeClass('hide');
                   }
                   switch(res)
                   {
                       case 'ERROR_NODATA':
                           $('#updatePasswordMessage').text(langTranscription['PROFILE_UPDATE_PASSWORD_NODATA']);
                       break;
                       case 'ERROR_NOTMATCH':
                           $('#updatePasswordMessage').text(langTranscription['PROFILE_UPDATE_PASSWORD_NOTMATCH']);
                       break;
                       case 'ERROR_OLDPASS':
                           $('#updatePasswordMessage').text(langTranscription['PROFILE_UPDATE_PASSWORD_OLDPASSNOTMATCH']);
                       break;
                       case 'CRASH_CSRF':
                           $('#updatePasswordMessage').text(langTranscription['CRASH_CSRF']);
                           setTimeout(function(){ location.reload(); }, (configTranscription['loadTime']*1.5));
                       break;
                       case 'CRASH_NOTLOGGED':
                           $('#updatePasswordMessage').text(langTranscription['PROFILE_UPD_ERROR_NOTLOGGED']);
                           setTimeout(function(){ location.reload(); }, (configTranscription['loadTime']*1.5));
                       break;
                       case 'PASSWORD_NOTVALID':
                           $('#updatePasswordMessage').text(langTranscription['REGISTER_PASSWORD_NOTVALID']);
                       break;
                       case 'ERROR_PASSWORD_ISSAME':
                           $('#updatePasswordMessage').text(langTranscription['PROFILE_UPDATE_PASSWORD_ISSAME']);
                       break;
                       case 'CHANGES_SUCCESS':
                           $('#updatePasswordMessage').attr('class','alert alert-info').text(langTranscription['PROFILE_UPDATE_PASSWORD_SUCCESS']);
                           showPinForm($("#updatePasswordModal").serialize() + '&inputCSRFProtecter=' + $('input[name=\'inputCSRFProtecter\']').val(),'checkupdatepasswordpin')
                       break;
                       case 'PWD_EXCEDED_LIMIT':
                           $('#updatePasswordMessage').text(langTranscription['PROFILE_UPD_ERROR_PWDEXCEEDLIMIT']);
                           window.setTimeout(function(){window.location = '/#/Recover';}, 3000);
                       break;
                    default:
                       $('#updatePasswordMessage').text(langTranscription['PROFILE_UPDATE_PASSWORD_NODATA']);
                   }
               }
           });
       }
    });
    $('#updatePasswordModal').keypress(function (e) {
    if (e.which == 13) {
      $('.vex-dialog-button-primary').click();
      return false;
    }
  });
});
$("#editProfPsico").submit(function( event ) {
    
    $('#showFormErrorProf').addClass('hideme');
    $('#showFormErrorPersProf').remove();
    var doesItFailed = false;
    $('#editProfPsico select, #editProfPsico input[name][name!=\'inputCSRFProtecter\'], #editProfPsico textarea').each(function(){
        if(!validateInput(this))
        {
            doesItFailed = true;
        }
    });
    if(!doesItFailed)
    {
        $.ajax({
            url : configTranscription['URL'] + '/updateprofpsico',
            type : "post",
            async: true,
            data: $("#editProfPsico").serialize(),
            beforeSend: function () {
                $('#updateProfPsicoTrigger').html('<i class="fa fa-spinner fa-spin"></i>');
                $('#updateProfPsicoTrigger').addClass('disableClick');
            },
            success : function(res) {
                switch(res)
                {
                    case 'CRASH_CSRF':
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['CRASH_CSRF'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                         setTimeout(function(){ location.reload(); }, (configTranscription['loadTime']*1.5));
                    break;
                    case 'ERROR_NODATA':
                        $('#showFormErrorProf').removeClass('hideme');
                    break;
                    case 'ERROR_EMAIL_NOTVALID':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_EMAILFORMAT'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'ERROR_CURRENCY_NOTVALID':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_CURRENCY_NOTVALID'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'PWD_EXCEDED_LIMIT':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_PWDEXCEEDLIMIT'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                        window.setTimeout(function(){window.location = '/#/Recover';}, 3000);
                    break;
                    case 'PWD_WRONG':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_PWDWRONG'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'ERROR_PPH':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_PPH'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'ERROR_TYPE_NOTVALID':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_TYPE_NOTVALID'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'ERROR_SESSNOW_NOTVALID':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_SESSNOW_NOTVALID'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'ERROR_DESC':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_DESCRIPTION'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'ERROR_PAT_NOTVALID':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_PAT'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                    case 'CHANGES_SUCCESS':
                        closeNotification();
                         if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                         }
                        showPinForm($('#editProfPsico').serialize(),'checkupdateprofprofilepin','showFormErrorPersProf','showFormErrorProf');
                    break;
                    case 'CRASH_NOTLOGGED':
                        if(!$('#showFormErrorProf').hasClass('hideme')){
                             $('#showFormErrorProf').addClass('hideme');
                        }
                        $('<div class="row" id="showFormErrorPersProf"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_NOTLOGGED'] + '</div></div></div>').insertAfter('#showFormErrorProf');
                    break;
                }
                $('#updateProfPsicoTrigger').html(langTranscription['PROFILE_UPD_BUTTON']);
                $('#updateProfPsicoTrigger').removeClass('disableClick');
             }
        });
    }
    else
    {
        $('#showFormErrorProf').removeClass('hideme');
    }
  event.preventDefault();
});
function updateCurrencies()
{
    $('input[name=\'prof_psico_pph\']').prev('span').text(langTranscription['PROFILE_UPD_PPH_CURENCY'].replace('{{currency}}',langTranscription['PROFILE_UPD_PPH_CURENCY_' + $('select[name=\'prof_psico_currency\']').val()]));
}
function updatePsicoFields(field)
{
    if(field.value == 'psico')
    {
        $('#showCollegeNumber').attr('style','');
    }
    else
    {
        $('#showCollegeNumber').css('display','none');
    }
}
$('#selectPat').selectpicker();
function showPinForm(form,url,pers = 'showFormErrorPers',error = 'showFormError')
{
    $('#' + pers).remove();
    vex.defaultOptions.className = configTranscription['modalTheme'];
    vex.closeAll();
    vex.dialog.open({
        input: [
            langTranscription['PROFILE_UPD_CONFIRM_TITLE'] + 
    '<div class="input-group" id="confirmPinForm">' +
    '<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>' +
    '<input type="text" class="form-control" autocomplete="off" name="secretPinUpdateProfile" placeholder="' + langTranscription['PROFILE_UPD_CONFIRM_PH'] + '">' +
    '</div>'
        ].join(''),
        buttons: [
                $.extend({}, vex.dialog.buttons.YES, { text: langTranscription['PROFILE_IMGUPL_SEND'] }),
                $.extend({}, vex.dialog.buttons.NO, { text: langTranscription['PROFILE_IMGUPL_BACK'] })
        ],
        overlayClosesOnClick: false,
        onSubmit: function (event) {
            event.preventDefault();
            event.stopPropagation();
            $('#showFormErrorConfirmPin').remove();
            $.ajax({
                url : configTranscription['URL'] + '/' + url,
                type : "post",
                async: true,
                beforeSend: function(e) {
                    $('.vex-dialog-button-primary').attr('data-realText',$('.vex-dialog-button-primary').text()).html('<i class="fa fa-spinner fa-spin"></i>');
                    $('.vex-dialog-button-secondary').attr('disabled',true);
                },
                data: form + '&checkPin=' + $("input[name='secretPinUpdateProfile']").val(),
                success: function(data) {
                    if(data == 'SUCCESS')
                    {
                        vex.closeAll();
                        $('input[name=\'prof_checkpassword\']').val('');
                        $('<div class="row" id="' + pers + '"><div class="col-md-12"><div class="alert alert-info fade in">' + langTranscription['PROFILE_UPD_SUCCESS'] + '</div></div></div>').insertAfter('#' + error);
                    }
                    else if(data == 'ERROR')
                    {
                        $("input[name='secretPinUpdateProfile']").val('').focus();
                        $('<div class="row" id="showFormErrorConfirmPin"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_PIN_ERROR'] + '</div></div></div>').insertBefore('#confirmPinForm');
                    }
                    else if(data == 'FORM_ERROR')
                    {
                        vex.closeAll();
                        if($('#' + error).hasClass('hideme')){
                            $('#' + error).removeClass('hideme');
                        }
                    }
                    else if(data == 'PWD_EXCEDED_LIMIT')
                    {
                        vex.closeAll();
                        if(!$('#' + error).hasClass('hideme')){
                            $('#' + error).addClass('hideme');
                        }
                        $('<div class="row" id="' + pers + '"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_PWDEXCEEDLIMIT'] + '</div></div></div>').insertAfter('#' + error);
                        window.setTimeout(function(){window.location = '/#/Recover';}, 3000);
                    }
                    $('.vex-dialog-button-primary').html($('.vex-dialog-button-primary').attr('data-realText')).removeAttr('data-realText');
                    $('.vex-dialog-button-secondary').attr('disabled',false);
                }});
        }
    });
}
function updateProfile()
{
    $('#showFormError').addClass('hideme');
    $('#showFormErrorPers').remove();
    var doesItFailed = false;
    $('#updateProfile select, #updateProfile input[name!=\'inputCSRFProtecter\']').each(function(){
        if(!validateInput(this))
        {
            doesItFailed = true;
        }
    });
    if(!doesItFailed)
    {
        $.ajax({
               url : configTranscription['URL'] + '/updateprofile',
               type : "post",
               async: true,
               data: $("#updateProfile").serialize(),
               beforeSend: function () {
                   $('#updateProfileTrigger').html('<i class="fa fa-spinner fa-spin"></i>');
                   $('#updateProfileTrigger').addClass('disableClick');
               },
               success : function(res) {
                   switch(res)
                   {
                       case 'CRASH_CSRF':
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['CRASH_CSRF'] + '</div></div></div>').insertAfter('#showFormError');
                            setTimeout(function(){ location.reload(); }, (configTranscription['loadTime']*1.5));
                       break;
                       case 'ERROR_NODATA':
                           $('#showFormError').removeClass('hideme');
                       break;
                       case 'ERROR_EMAIL_NOTVALID':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_EMAILFORMAT'] + '</div></div></div>').insertAfter('#showFormError');
                       break;
                       case 'ERROR_EMAIL_ALREADYREGISTERED':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_EMAILREGISTERED'] + '</div></div></div>').insertAfter('#showFormError');
                       break;
                       case 'ERROR_NEWSLETTER_NOTVALID':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_NEWSLETTER_NOTVALID'] + '</div></div></div>').insertAfter('#showFormError');
                       break;
                       case 'ERROR_WEEKSTARTDAY_NOTVALID':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_WEEKSTARTDAY_NOTVALID'] + '</div></div></div>').insertAfter('#showFormError');
                       break;
                       case 'ERROR_CURRENCY_NOTVALID':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_CURRENCY_NOTVALID'] + '</div></div></div>').insertAfter('#showFormError');
                       break;
                       case 'PWD_EXCEDED_LIMIT':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_PWDEXCEEDLIMIT'] + '</div></div></div>').insertAfter('#showFormError');
                           window.setTimeout(function(){window.location = '/#/Recover';}, 3000);
                       break;
                       case 'PWD_WRONG':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_PWDWRONG'] + '</div></div></div>').insertAfter('#showFormError');
                       break;
                       case 'CHANGES_SUCCESS':
                            if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                            }
                           showPinForm($('#updateProfile').serialize(),'checkupdateprofilepin');
                           
                       break;
                       case 'CRASH_NOTLOGGED':
                           if(!$('#showFormError').hasClass('hideme')){
                                $('#showFormError').addClass('hideme');
                           }
                           $('<div class="row" id="showFormErrorPers"><div class="col-md-12"><div class="alert alert-danger fade in">' + langTranscription['PROFILE_UPD_ERROR_NOTLOGGED'] + '</div></div></div>').insertAfter('#showFormError');
                       break;
                   }
                   $('#updateProfileTrigger').html(langTranscription['PROFILE_UPD_BUTTON']);
                   $('#updateProfileTrigger').removeClass('disableClick');
               }
        });
    }
    else
    {
        $('#showFormError').removeClass('hideme');
    }
}
var success = {inputClass: 'has-success has-feedback', icon: 'z-index-5 glyphicon glyphicon-ok form-control-feedback'};
var error = {inputClass: 'has-error has-feedback', icon: 'z-index-5 glyphicon glyphicon-remove form-control-feedback'};
var warning = {inputClass: 'has-warning has-feedback', icon: 'z-index-5 glyphicon glyphicon-warning-sign form-control-feedback'};
var loading = {inputClass: '', icon: 'z-index-5 glyphicon glyphicon-refresh glyphicon-spin form-control-feedback'};
function clearPrevStatus(input)
{
    $(input).parent().removeClass(success['inputClass'] + ' ' + error['inputClass'] + ' ' + loading['inputClass'] + ' ' + warning['inputClass']);
    $(input).parent().find('span#statusIcon').removeClass(success['icon'] + ' ' + error['icon'] + ' ' + loading['icon'] + ' ' + warning['icon']);
}
function setEditorMode(input)
{
    clearPrevStatus(input);
    $(input).parent().addClass(loading['inputClass']);
    $(input).parent().find('span#statusIcon').addClass(loading['icon']);
}
function validateInput(input)
{
    clearPrevStatus(input);
    if(input.value != '' && input.value != null)
    {
        switch($(input).attr('data-filtertype'))
        {
            case 'email':
                if(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(input.value))
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass(success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass(error['icon']);
                    return false;
                }
            break;
            case 'newsletter':
                if(input.value == 1 || input.value == 0)
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            break;
            case 'weekstartday':
                if(input.value == 'S' || input.value == 'M')
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            break;
            case 'currency':
                if(input.value == 'EUR' || input.value == 'USD' || input.value == 'GBP')
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' +  success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            break;
            case 'password':
                if(input.value != '' && input.value != null)
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass(success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass(error['icon']);
                    return false;
                }
            break;
            case 'profpph':
                if(!isNaN(input.value) && input.value != 0)
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' +  success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            break;
            case 'proftype':
                if(input.value == 'psico' || input.value == 'coach')
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' +  success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            case 'sessionnow':
                if(input.value == 1 || input.value == 0)
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' +  success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            break;
            case 'profdesc':
                if(input.value.length >= configTranscription['profileDescMinLength'])
                {
                    $(input).parent().addClass(success['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' +  success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().addClass(error['inputClass']);
                    $(input).parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            break;
            case 'collegenumber':
                $(input).parent().addClass(success['inputClass']);
                $(input).parent().find('span#statusIcon').addClass('right10 ' +  success['icon']);
                return true;
            break;
            case 'specialization':
                if(input.value.length > 0)
                {
                    $(input).parent().parent().addClass(success['inputClass']);
                    $(input).parent().parent().find('span#statusIcon').addClass('right10 ' +  success['icon']);
                    return true;
                }
                else
                {
                    $(input).parent().parent().addClass(error['inputClass']);
                    $(input).parent().parent().find('span#statusIcon').addClass('right10 ' + error['icon']);
                    return false;
                }
            break;
        }
    }
    else
    {
        $(input).parent().addClass(warning['inputClass']);
        $(input).parent().find('span#statusIcon').addClass(warning['icon']);
    }
}
$('#updateProfile select, #updateProfile input[name!=\'inputCSRFProtecter\']').each(function(){
    validateInput(this);
});
$('#editProfPsico select, #editProfPsico input[name!=\'inputCSRFProtecter\'], #editProfPsico textarea').each(function(){
    validateInput(this);
});