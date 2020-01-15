var psicoCode = window.location.href.split("/").pop(), btnParams = 'data-psicoCode="' + psicoCode + '" id="paymentGateway"';
$('profileContent').load('assets/js/home/angular2/templates/extprofile.php?hash=' + psicoCode, function() {
    $.getScript('assets/js/home/calendar.js', function(){
        $("#calendarProfile" + window.location.href.split("/").pop()).soluzinkCldr({
            inline: true,
            singleDate: true,
            startOnMonday: configTranscription['weekStartDayMonday'],
            format: "DD/MM/YYYY HH:mm", 
            hourFormat: 24,
            calendarCount: 1,
            showMinutesSelector: 1,
            showMinutesManager: 0,
            calendarSize: 'col-md-12',
            reserveNowButtonParameters: btnParams,
            psicoCode: window.location.href.split("/").pop()
        });
    });
   $.getScript('assets/vendors/tweenmax/js/tweenmax.min.js', function(){});
   $.getScript('assets/vendors/jquery.caroufredsel/jquery.caroufredsel.js', function(){});
   $.getScript('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js', function(){});
   $.getScript('assets/vendors/jquery.mixitup/jquery.mixitup.min.js', function(){});
   $.getScript('assets/vendors/jquery.dropdownit/jquery.dropdownit.js', function(){});
   $.getScript('assets/js/home/profilescripts.js', function(){});
   $.getScript('assets/js/home/payment.js', function(){});
});
