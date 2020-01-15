$('#listingSearchTags').tagsinput({
    tagClass: 'big btn-primary',
    allowDuplicates: false,
    itemValue: 'id',
    itemText: 'label'
});
$('.triggerFilter').click(function()
{ 
    $('#listingSearchTags').tagsinput('add', { id: $(this).children('a').text(), label: $(this).children('a').text(), dataType: $(this).children('a').attr('data-type'), dataId: $(this).children('a').attr('data-infoid')});
    loadMoreListing();
});
$('.triggerOrderSwapper').click(function()
{ 
    loadMoreListing($(this).children('a').attr('data-ordertype'));
});
$("#moneyPicker").ionRangeSlider({
    type: "double",
    grid: true,
    min: configTranscription["LISTING_MIN_MONEY"],
    max: configTranscription["LISTING_MAX_MONEY"],
    from: configTranscription["LISTING_MIN_MONEY"],
    prefix: configTranscription["ACTUAL_CURRENCY"],
    onFinish: function (data) {
        loadMoreListing(null,data['from']+'_'+data['to']);
    }
});
$(document).on("click", ".imageClick", function(e){
    e.preventDefault();
    window.location = $(this).attr('data-href');
});
var newsessionid;
$(document).on("click", ".buttonBuynow", function(e){
    var psicoinf = $(this).parent(".listing-item"), pid = psicoinf.attr("data-psico-code"), pph = psicoinf.attr("data-price-pph"), currency = psicoinf.attr("data-price-currency"), psiconame = psicoinf.attr("data-psico");
    e.preventDefault();
    if (e.target !== this) {return;}
vex.dialog.confirm({
    message: '¿Seguro que deseas solicitar una sesión inmediata con este docente?',
    buttons: [
            $.extend({}, vex.dialog.buttons.YES, { text: "Sí"}),
            $.extend({}, vex.dialog.buttons.NO, { text: "No" })
    ],
    overlayClosesOnClick: false,
    onSubmit: function () {
        event.preventDefault();
        event.stopPropagation();
        $.ajax({
            url: "/checkinmediatesession",
            type: "POST",
            async: false,
            cache: false,
            data: {newid: true,pid: pid},
            success: function(newid)
            {
                newsessionid = newid;
            }
        });
        vex.closeAll();
        if(typeof newsessionid != 'undefined' && newsessionid != '' && newsessionid != null && newsessionid != 'error')
        {
            vex.dialog.open({
                input: [
                    'Estamos esperando a la respuesta del docente. Si el círculo de abajo se cierra y no hay respuesta del docente, se cancelará la petición. Espera unos segundos...',
                    '<div class="row"><div class="col-md-12" style="text-align: center;"><div id="contractTimer"></div></div></div>'
                ].join(''),
                buttons: [
                        $.extend({}, vex.dialog.buttons.YES, { className: 'button-hidden', text: '' }),
                        $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                ],
                overlayClosesOnClick: false
            });
            var lastcircleVal = 0;
            $("#contractTimer").circletimer({
                timeout: configTranscription["contractingCheckerInterval"],
                onComplete: (function() {
                    lastcircleVal = 0;
                    vex.closeAll();
                    vex.dialog.open({
                        input: [
                            'El docente no ha respondido a tu solicitud. Vuelve a intentarlo o prueba con otro.',
                            ].join(''),
                        buttons: [
                                $.extend({}, vex.dialog.buttons.YES, { text: 'Entendido' }),
                                $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                        ],
                        overlayClosesOnClick: false
                    });
                }),
                onUpdate: (function(val) {
                    var actualPercentage = Math.round(val/configTranscription["contractingCheckerInterval"]*100);
                    if(actualPercentage == 20 || actualPercentage == 40 || actualPercentage == 60 || actualPercentage == 80 || actualPercentage == 100)
                    {
                        if(lastcircleVal != actualPercentage)
                        {
                            lastcircleVal = actualPercentage;
                            $.ajax({
                                url: "/checkinmediatesession",
                                type: "POST",
                                cache: false,
                                data: {checkid: true, sessid: newsessionid},
                                success: function(data)
                                {
                                    if(data == 'ERROR')
                                    {
                                        vex.closeAll();
                                        vex.dialog.open({
                                            input: [
                                                'Ha ocurrido un error con la petición. Vuelve a intentarlo más tarde'
                                            ].join(''),
                                            buttons: [
                                                    $.extend({}, vex.dialog.buttons.YES, { text: 'Aceptar' }),
                                                    $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                                            ],
                                            overlayClosesOnClick: false
                                        });
                                    }
                                    else if(data == 'ACCEPTED')
                                    {
                                        vex.closeAll();
                                        $("#paymentGateway").attr('data-psicocode',pid);
                                        $("#calendarListingGlobal").attr('data-price-pph',pph)
                                        .attr('data-price-currency',currency)
                                        .attr('data-psico',psiconame)
                                        .attr('data-actualid',pid)
                                        .attr('data-sessionlenght',"30");
                                        $("#paymentGateway").click();
                                    }
                                }
                            });
                        }
                    }
                })
            });
            $("#contractTimer").circletimer("start");
        }
        else
        {
            vex.closeAll();
            vex.dialog.open({
                input: [
                    'Ha ocurrido un error con la petición. Vuelve a intentarlo más tarde'
                ].join(''),
                buttons: [
                        $.extend({}, vex.dialog.buttons.YES, { text: 'Aceptar' }),
                        $.extend({}, vex.dialog.buttons.NO, { className: 'button-hidden', text: '' })
                ],
                overlayClosesOnClick: false
            });
        }
    },
    callback: function (value) {}
})
});

"undefined",
    function() {
        "use strict";
        $(function() {
			$(".listing-item-link").on({
                mouseenter: function() {
                    var a = $(this);
                    a.parent().parent().parent().hasClass("grid2") || a.parent().parent().parent().hasClass("grid3") ? (a.siblings("a, .listing-item-rating").not(".listing-item-author").stop().animate({
                        top: "-10px",
                        opacity: 0
                    }), a.siblings(".listing-item-author").stop().animate({
                        top: "110px",
                        opacity: 0
                    }), a.siblings(".listing-item-date").stop().animate({
                        top: "-60px",
                        opacity: 0
                    })) : (a.siblings("a, .listing-item-rating").not(".listing-item-author").stop().animate({
                        top: "-10px",
                        opacity: 0
                    }), a.siblings(".listing-item-author").stop().animate({
                        top: 0,
                        opacity: 0
                    }), a.siblings(".listing-item-date").stop().animate({
                        top: "-60px",
                        opacity: 0
                    }))
                },
                mouseleave: function() {
                    var a = $(this);
                    a.parent().parent().parent().hasClass("grid2") || a.parent().parent().parent().hasClass("grid3") ? (a.siblings(".listing-item-rating").stop().animate({
                        top: "10px",
                        opacity: 1
                    }, {
                        complete: function() {
                            a.siblings(".listing-item-rating").css({
                                top: ""
                            })
                        }
                    }), a.siblings(".category-icon").stop().animate({
                        top: "25px",
                        opacity: 1
                    }, {
                        complete: function() {
                            a.siblings(".category-icon").css({
                                top: ""
                            })
                        }
                    }), a.siblings(".listing-item-author").stop().animate({
                        top: "84px",
                        opacity: 1
                    }, {
                        complete: function() {
                            a.siblings(".listing-item-author").css({
                                top: ""
                            })
                        }
                    }), a.siblings(".listing-item-date").stop().animate({
                        top: "-5px",
                        opacity: 1
                    }, {
                        complete: function() {
                            a.siblings(".listing-item-date").css({
                                top: ""
                            })
                        }
                    })) : (a.siblings("a, .listing-item-rating").not(".listing-item-author").stop().animate({
                        top: "12%",
                        opacity: 1
                    }, {
                        complete: function() {
                            a.siblings("a, .listing-item-rating").not(".listing-item-author").css({
                                top: ""
                            })
                        }
                    }), a.siblings(".listing-item-author").stop().animate({
                        top: "-44px",
                        opacity: 1
                    }, {
                        complete: function() {
                            a.siblings(".listing-item-author").css({
                                top: ""
                            })
                        }
                    }), a.siblings(".listing-item-date").stop().animate({
                        top: "-5px",
                        opacity: 1
                    }, {
                        complete: function() {
                            a.siblings(".listing-item-date").css({
                                top: ""
                            })
                        }
                    }))
                }
            });
        })
    }();

$('footer').css('display', 'none');
var ordering = false, lastButtonId = null, lastAjaxCall = 0, noMoreRecords = false, baseCalendar = '<input type="hidden" data-price-pph="" data-price-currency="" data-psico="" id="calendarListingGlobal" />';
$('.results-count').html(langTranscription['LISTING_LOADING']);
var listingResultCountUpdated = false;
$('#loadMore').html('<i class="fa fa-spinner fa-spin"></i>');
loadMoreListing();
$('#listingResultsNumber').html($('#firstDataRowsCount').attr('number'));
function changeItemState()
{
    if(lastButtonId == null)
    {
        var firstElement = $('.listing-item').first();
        if(firstElement.length)
        {
            firstElement = firstElement[0];
            var psicoCode = $(firstElement).attr('data-psico-code');
            $(firstElement).children('.listing-item-link').addClass("active");
            
            $(firstElement).find('.listing-category-name').find('.psicoScore').each(function() {
                $(firstElement).first().find('.fa-star').addClass('fa-spin');
            });
            $("#calendarListingGlobal").attr('data-actualid',psicoCode);
            $("#calendarListingGlobal").attr('data-price-pph',$(firstElement).attr('data-price-pph')).attr('data-price-currency',$(firstElement).attr('data-price-currency')).attr('data-psico',$(firstElement).attr('data-psico'));
            $("#calendarListingGlobal").soluzinkCldr({
               inline: true,
               singleDate: true,
               startOnMonday: configTranscription['weekStartDayMonday'],
               format: "DD/MM/YYYY HH:mm", 
               hourFormat: 24,
               calendarCount: 1,
               showMinutesSelector: 1,
               showMinutesManager: 0,
               calendarSize: 'col-md-12 nopadding',
               reserveNowButtonParameters: 'data-psicoCode="' + psicoCode + '" id="paymentGateway"',
               psicoCode: psicoCode
           });
        }
        lastButtonId = $(firstElement).attr('id');
    }
   $(".listing-item").mouseenter(function() {
        if(lastButtonId != null)
        {
            $('#' + lastButtonId).children('.listing-item-link').removeClass("active");
            $('.listing-category-name .psicoScore').each(function() {
                $(this).find('.fa-star').removeClass('fa-spin');
           });
        }
        if(lastButtonId != this.getAttribute('id'))
        {
            $('#cldrCntr').html(baseCalendar);
            var psicoCode = $(this).attr('data-psico-code');
            $("#calendarListingGlobal").attr('data-actualid',psicoCode);
            $("#calendarListingGlobal").attr('data-price-pph',$(firstElement).attr('data-price-pph')).attr('data-price-currency',$(firstElement).attr('data-price-currency')).attr('data-psico',$(firstElement).attr('data-psico'));
             $("#calendarListingGlobal").soluzinkCldr({
                inline: true,
                singleDate: true,
                startOnMonday: configTranscription['weekStartDayMonday'],
                format: "DD/MM/YYYY HH:mm", 
                hourFormat: 24,
                calendarCount: 1,
                showMinutesSelector: 1,
                showMinutesManager: 0,
                calendarSize: 'col-md-12',
                reserveNowButtonParameters: 'data-psicoCode="' + psicoCode + '" id="paymentGateway"',
                psicoCode: psicoCode
            });
        }
        lastButtonId = this.getAttribute('id');
       $(this).children('.listing-item-link').addClass("active");
       $('#' + lastButtonId + ' .listing-category-name .psicoScore').each(function() {
            $(this).find('.fa-star').addClass('fa-spin');
      });
}); 
}
   function blockListing()
   {
        $('#listingTree').prepend('<i class="fa fa-spinner fa-spin listing-loader"></i>');
        $('#listingTree').addClass("listing-block-blocked");
        $('#listingFilters').addClass("listing-block-blocked");
        $('.listing-filter').addClass("listing-block-hidden");
        $('.row.listing-results').addClass("listing-block-hidden");
        $('#loadMore').addClass("listing-block-hidden");
        $('#cldrCntr').addClass("listing-block-hidden");
        $('#listingTree').each(function() {
             $(this).find('.listing-item').addClass('listing-block-hidden');
       });   
   }
   function unBlockListing()
   {
        $('#listingTree').removeClass("listing-block-blocked");
        $('#listingFilters').removeClass("listing-block-blocked");
        $('.listing-filter.listing-block-hidden').removeClass("listing-block-hidden");
        $('.row.listing-results.listing-block-hidden').removeClass("listing-block-hidden");
        $('#loadMore').removeClass("listing-block-hidden");
        $('#listingTree').remove('.fa.fa-spinner.fa-spin.listing-loader');
        $('#cldrCntr').remove('.fa.fa-spinner.fa-spin.listing-loader');
        $('#listingTree').each(function() {
            $(this).find('.listing-item.listing-block-hidden').removeClass('listing-block-hidden');
      });
    }
    


$("#filterListingElements").click(function() {
    $('#filterResultsListing').modal({
        show: 'false'
    }); 
});
function itemOnScreen(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
var cldrBasePosition = 0;
$(document).scroll(function() {
    if(cldrBasePosition == 0 && $('#cldrCntr').length)
    {
        cldrBasePosition = $('#cldrCntr').offset().top;
    }
  if(($('#cldrCntr').length && $('.listing-filter').length) && !itemOnScreen('.practician-type'))
  {
      if((($('.listing-filter').offset().top + $('.listing-filter').height()) < $('#cldrCntr').offset().top) && $(window).scrollTop() > cldrBasePosition)
        {
            if($('#cldrCntr').css('top') != '150px')
            {
                $('#cldrCntr').stop().clearQueue().animate({'top': '150px'},50);
            }
        }
        else if((($('.listing-filter').offset().top + $('.listing-filter').height()) < $('#cldrCntr').offset().top))
        {
            if($('#cldrCntr').css('top') != 'inherit')
            {
                $('#cldrCntr').stop().clearQueue().attr('style','top: inherit');
            }
        }
  }
  else
  {
            if($('#cldrCntr').css('top') != 'inherit')
            {
                $('#cldrCntr').stop().clearQueue().attr('style','top: inherit');
            }
  }
});

$(function() {
    if($('#loadMore').length)
    {
        var oTop = $('#loadMore').offset().top - window.innerHeight;

        $(window).scroll(function(){
            if($('#loadMore').length)
            {
                var pTop = $('body').scrollTop();
                if( pTop > oTop && !noMoreRecords && !ordering){
                        $('#loadMore').html('<i class="fa fa-spinner fa-spin"></i>');
                        setTimeout(loadMoreListing, configTranscription['loadTime']*1.3);
                }
            }
        });
    }
});
function loadMoreListing(sorDirData = null, moneyRange = null)
{
    if(lastAjaxCall + 2 < Math.round(+new Date()/1000) && $('#loadMore').length)
    {
        lastAjaxCall = Math.round(+new Date()/1000);
        $.ajax({
            url: "/loadMore",
            type: "POST",
            cache: false,
            data: {type: $('#listingTree').attr('data-type'),
                sortData: ($("#listingSearchTags").tagsinput('items').length > 0 ? $("#listingSearchTags").tagsinput('items'):''),
                sortDir: (sorDirData != null ? sorDirData:''),
                moneyRange: (moneyRange != null ? moneyRange:''),
                showedIds: configTranscription['showedIdsAlready']},
            dataType: "json",
            beforeSend: function()
            {
                lastAjaxCall = Math.round(+new Date()/1000);
            },
            success: function(data)
            {
                if(!listingResultCountUpdated)
                {
                    listingResultCountUpdated = true;
                    $('.results-count').html(langTranscription['LISTING_SHOWRESULTS']);
                }
                if(data.code == 1)
                {
                    $(data.content).insertBefore('#loadMore');
                    $('#listingResultsNumber').html(parseInt($('#listingResultsNumber').html(),10)+parseInt(data.rowsAffected,10));
                    oTop = $('#loadMore').offset().top - window.innerHeight;
                     $('#loadMore').html('');
                     if(configTranscription['showedIdsAlready'] == null)
                     {
                        configTranscription['showedIdsAlready'] = data.ids;
                    }
                    else
                    {
                        configTranscription['showedIdsAlready'] += ',' + data.ids;
                    }
                    lastButtonId = null;
                    changeItemState();
                    $("img").lazyload({effect : "fadeIn"});
                }
                else if(data.code == 2)
                {
                    noMoreRecords = true;
                    $('#loadMore').html('<i class="fa fa-exclamation-triangle"></i> <div>' + langTranscription['LISTING_NOMORERECORDS'] + '</div>');
                }
            }
        });
    }
}
        $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    changeItemState();
});