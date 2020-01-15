var apiKey,sessionId,token,otherPhoto,lastMessage,myUserId,endSession,otherFullname,updatedClockLowTime = false,$messages = $('.messages-content'),sessionStatus;
$('footer').css('display', 'none');
if(localStorage.openpages == '1'){
    function checkSessions(type)
    {
    }
        alert(langTranscription['SESSION_LIMITED_WINDOW']);
        window.location.replace(configTranscription['URL'] + '/#/Psicos');
    }else{
        localStorage.openpages = "1";
function checkSessions(type)
{
    $.ajax({
        url : "/checksession?type=" + type,
        async: true,
        success : function(resp) {
            //console.log(resp);
            $('.session-spinner').css('display', 'none');
            resp = resp.split('|||');
            if(!$('.session-notbought').hasClass('hide'))
            {
                $('.session-notbought').addClass('hide');
            }
            if(!$('.session-badgateway').hasClass('hide'))
            {
                $('.session-badgateway').addClass('hide');
            }
            if(!$('.session-timer').hasClass('hide'))
            {
                $('.session-timer').addClass('hide');
            }
            if(!$('.sessionwindow').hasClass('hide'))
            {
                $('.sessionwindow').addClass('hide');
            }
            if(!$('.session-ends').hasClass('hide'))
            {
                $('.session-ends').addClass('hide');
            }
            if(resp[0] == 'SESSION_ACTIVE')
            {
                sessionActive = true;
                sessionStatus = true;
                var d, h, m,
                   i = 0;
           if($messages.length)
           {
                 $messages.mCustomScrollbar();
             }
             else
             {
                 $messages.mCustomScrollbar('destroy');
                }

                $('.sessionwindow').removeClass('hide');
                var idled = false;
                $('#videos').on('click', '#hangCall', function() {
                    if(sessionStatus)
                    {
                        subscriber.publishAudio(false);
                        subscriber.publishVideo(false);
                    }
                    else
                    {
                        subscriber.publishAudio(true);
                        subscriber.publishVideo(true);
                    }
                    sessionStatus = !sessionStatus;
                    showUncaller();
               });
                function showCaller()
                {
                    $('<div id="hangCall"><img src="' + configTranscription['URL'] + '/assets/images/home/session/' + (sessionStatus ? 'call':'endcall') + '.png"/></div>').prependTo('#videos').fadeIn();
                }
                function showUncaller(idle = false)
                {
                    $('#hangCall').fadeOut(400, function() {$(this).remove();});
                    if(idle)
                    {
                        idled = true;
                    }
                }
                $('#videos').on('mouseleave', function() {
                    if(!$('#hangCall').is(":hover"))
                    {
                        showUncaller();
                    }
                });
                $('#videos').mouseenter(showCaller);
                var timeout = null;
                $('#videos').on('mousemove', function() {
                    if(!$('#hangCall').length)
                    {
                        clearTimeout(timeout);
                        if(idled)
                        {
                            $('#videos').mouseenter();
                            idled = false;
                        }
                        if(!$('#hangCall').is(":hover"))
                        {
                            timeout = setTimeout(function() {
                                showUncaller(true);
                            }, 1500);
                        }
                    }
                });
                apiKey = resp[1];
                sessionId = resp[2];
                token = resp[3];
                $('#otherName').text(resp[4]);
                $('#otherSurnames').text(resp[5]);
                $('#otherPhoto').attr('src',resp[6]);
                otherPhoto = resp[6];
                otherFullname = resp[4] + ' ' + resp[5];
                myUserId = resp[7];
                endSession = resp[8];
                function handleError(error) {
                  if (error) {
                   // console.log(error.message);
                  }
                }
                  var session = OT.initSession(apiKey, sessionId);
                  session.on('streamCreated', function(event) {
                    session.subscribe(event.stream, 'subscriber', {
                      insertMode: 'replace',
                    width: '100%',
                    height: '100%'
                    }, handleError);
                  });
                  var publisher = OT.initPublisher('publisher', {
                    insertMode: 'replace'
                  }, handleError);
                  session.connect(token, function(error) {
                    if (error) {
                      handleError(error);
                    } else {
                      session.publish(publisher, handleError);
                    }
                  });
                  
                /* Prompt user if leaving page when there's a session */
                window.onbeforeunload = function(evt) {localStorage.openpages = "0"; return true;}
                $(document).on("click", "a[href]", function(){session.disconnect();});
                $(window).on("click", "a[href]", function(){websocket.close();$messages.mCustomScrollbar('destroy');$messages = null});
                  function startClock()
                  {
                      secondsLeft = endSession-Math.floor(Date.now() / 1000);
                      mins = Math.floor(secondsLeft/60);
                      if(mins.toString().length == 1)
                      {
                          mins = ("0" + mins).slice(-2);
                      }
                      seconds = ("0" + Math.floor(secondsLeft%60)).slice(-2);
                      if(mins < 5 && !updatedClockLowTime)
                      {
                          updatedClockLowTime = true;
                          function closeNotification()
                          {
                            if(typeof notify != "undefined")
                            {
                                notify.close();
                            }
                          }
                        closeNotification();
                            notify = $.notify({
                                message: langTranscription['SESSION_ENDING'],
                                icon: otherPhoto,
                                title: otherFullname
                            },{
                                timer:0,
                                delay:0,
                                type: 'minimalist',
                                icon_type: 'image',
                                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                        '<a onclick="closeNotification()"><img data-notify="icon" class="img-circle pull-left">' +
                                        '<span data-notify="title">{1}</span>' +
                                        '<span data-notify="message">{2}</span>' +
                                '</a></div>',
                                newest_on_top: false,
                                placement: {
                                        from: 'bottom',
                                        align: 'right'
                                }
                            });
                            $('#timeLeft').css('color', '#FF7514');
                      }
                      if(mins == 0 && seconds == 0)
                      {
                        checkSessionStatus();
                      }
                      else
                      {
                        setTimeout(startClock, 1000);
                        $('#timeLeft').text(mins + ':' + seconds);
                      }
                  }
                  startClock();
                function checkSessionStatus()
                {
                    if(Math.floor(Date.now() / 1000) > endSession)
                    {
                        session.disconnect();
                        websocket.close();
                        $messages.mCustomScrollbar('destroy');
                        $messages = null;
                        if(type == 'client')
                        {
                            if(!$('.sessionwindow').hasClass('hide'))
                            {
                                $('.sessionwindow').addClass('hide');
                            }
                            $('.session-ends').removeClass('hide');
                            $('#confirmVote').click(function(){
                                $.ajax({
                                    url : "/votepsico",
                                    async: true,
                                    type: 'post',
                                    data: {sessionId: sessionId,vote: $('input[name="votePicker"]:checked').val(),testimonial: $('textarea[name="testimonial"]').val()},
                                    success : function(resp) {
                                        $('#votesPicker').remove();
                                        $('#confirmVote').remove();
                                        $('#testimonial').remove();
                                        $('#session-ends-title').text(langTranscription['voteSuccess']);
                                    }
                                });
                            });
                        }
                        else
                        {
                            if(!$('.sessionwindow').hasClass('hide'))
                            {
                                $('.sessionwindow').addClass('hide');
                            }
                            $('.session-ends-psico').removeClass('hide');
                        }
                    }
                }
               checkSessionStatus();
                setInterval(checkSessionStatus, 60000);
                $('.sessionwindow').css('height',$(window).height()-60);
                $(window).on('resize', function(){
                      $('.sessionwindow').css('height',$(window).height()-60);
                      updateScrollbar();
                  });
                $('#publisher').draggable({ containment: ".sessionwindow", scroll: false });
                
                /* CHAT */
                $.ajax({
                    url : "/getsessionmessages",
                    async: true,
                    type: 'post',
                    data: {sessionId: sessionId},
                    success : function(resp) {
                        if(resp.length > 0)
                        {
                            for(i = resp.length-1; i >= 0; i--)
                            {
                                    insertMessage(resp[i]['msg'],resp[i]['type'],'prependTo');
                            }
                        }
                    }
                });
               function updateScrollbar() {
                   if($messages != null)
                   {
                       $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
                        scrollInertia: 10,
                        timeout: 0
                      });
                   }
               }

               function setDate(){
                 d = new Date()
                 if (m != d.getMinutes()) {
                   m = d.getMinutes();
                   $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
                 }
               }
               function insertMessage(msg,type,level = 'appendTo') {
                   if ($.trim(msg) == '') {
                     return false;
                   }
                   if(type == 'system')
                   {
                       if(level == 'appendTo')
                       {
                            $('<div class="message message-server">' + msg + '</div>').appendTo('.mCSB_container').addClass('new');
                       }
                       else if(level == 'prependTo')
                       {
                           $('<div class="message message-server">' + msg + '</div>').prependTo('.mCSB_container').addClass('new');
                       }
                   }
                   else if(type == 'selfuser')
                   {
                       if(level == 'appendTo')
                       {
                            $('<div class="message message-personal">' + msg + '</div>').appendTo('.mCSB_container').addClass('new');
                        }
                        else if(level == 'prependTo')
                        {
                            $('<div class="message message-personal">' + msg + '</div>').prependTo('.mCSB_container').addClass('new');
                       }
                       lastMessage = msg;
                       $('.message-input').val('');
                   }
                   else
                   {
                       if(level == 'appendTo')
                       {
                            $('<div class="message new"><figure class="avatar"><img src="'+otherPhoto+'" /></figure>'+msg+'</div>').appendTo('.mCSB_container').addClass('new');
                        }
                       else if(level == 'prependTo')
                       {
                             $('<div class="message new"><figure class="avatar"><img src="'+otherPhoto+'" /></figure>'+msg+'</div>').prependTo('.mCSB_container').addClass('new');
                       }
                   }
                   setDate();
                   $('.message.loading').remove();
                   updateScrollbar();
               }


               $('.message-input').bind('keydown', function(e) {
                    if (e.which == 13) {
                                   manageMessageSender();
                                   return false;
                                 }
                 });
               $('.message-submit').click(function(){
                   manageMessageSender();	
               });
               function manageMessageSender()
               {
                   var mymessage = $('.message-input').val();
                   if(mymessage == ""){
                       return false;
                   }
                   else
                   {
                       insertMessage(mymessage,'selfuser');
                       $('.message-input').val('');
                       var msg = {
                           message: mymessage,
                           room: sessionId,
                           user_id: myUserId
                       };
                       websocket.send(JSON.stringify(msg));
                   }
               }


               $(document).ready(function(){
                   var wsUri = "wss://" + configTranscription['chatServer'] + "/chatserver/" + sessionId + '/' + myUserId; 	
                   websocket = new WebSocket(wsUri); 
                   websocket.onmessage = function(ev) {
                           var msg = JSON.parse(ev.data);
                           if(msg.type == 'system')
                           {
                               insertMessage(langTranscription[msg.message],msg.type);
                           }
                           else
                           {
                               if(msg.message != lastMessage)
                               {
                                   insertMessage(msg.message,msg.type);
                               }
                           }
                   };

                   websocket.onerror = function(ev){insertMessage(langTranscription['CHAT_SERVER_ERROR'],'system');$('.message-input').attr('disabled',true);$('.message-submit').attr('disabled',true);$('.message-input').text(langTranscription['CHAT_SERVER_ERROR_MSGPH']);}; 
                   websocket.onclose = function(ev){insertMessage(langTranscription['CHAT_SERVER_DOWN'],'system');$('.message-input').attr('disabled',true);$('.message-submit').attr('disabled',true);$('.message-input').text(langTranscription['CHAT_SERVER_ERROR_MSGPH']);}; 
               });
               /* Notes */
               
               if($('#psicoNotes').length)
               {
                   function updatePsicoNotes()
                   {
                       $.ajax({
                            url : "/updatepsiconotes",
                            async: true,
                            type: 'post',
                            data: {newVal: $('textarea#psicoNotes').val(), sessionId: sessionId}
                        });
                   }
                   function getPsicoNotes()
                   {
                       $.ajax({
                            url : "/getpsiconotes",
                            async: true,
                            type: 'post',
                            data: {sessionId: sessionId},
                            success : function(resp) {
                                if(resp === false)
                                {
                                    $('textarea#psicoNotes').val('').attr('placeholder',langTranscription['NOTES_INVALID']);
                                }
                                else
                                {
                                    $('textarea#psicoNotes').val(resp);
                                }
                            }
                        });
                   }
                   getPsicoNotes();
                    var timer = null;
                     $('textarea#psicoNotes').keyup(function() {
                         if (timer) {
                             clearTimeout(timer);
                         }
                         timer = setTimeout(function() {
                             updatePsicoNotes();
                         }, 5000);
                    });
                    $('textarea#psicoNotes').blur(function() {
                        if (timer) {
                            clearTimeout(timer);
                        }
                        updatePsicoNotes();
                    });
              }
            }
            else if(resp[0] == 'WAIT_FOR_IT')
            {
                sessionActive = false;
                $('.session-timer').removeClass('hide');
                !function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){"use strict";function b(a){if(a instanceof Date)return a;if(String(a).match(g))return String(a).match(/^[0-9]*$/)&&(a=Number(a)),String(a).match(/\-/)&&(a=String(a).replace(/\-/g,"/")),new Date(a);throw new Error("Couldn't cast `"+a+"` to a date object.")}function c(a){var b=a.toString().replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1");return new RegExp(b)}function d(a){return function(b){var d=b.match(/%(-|!)?[A-Z]{1}(:[^;]+;)?/gi);if(d)for(var f=0,g=d.length;f<g;++f){var h=d[f].match(/%(-|!)?([a-zA-Z]{1})(:[^;]+;)?/),j=c(h[0]),k=h[1]||"",l=h[3]||"",m=null;h=h[2],i.hasOwnProperty(h)&&(m=i[h],m=Number(a[m])),null!==m&&("!"===k&&(m=e(l,m)),""===k&&m<10&&(m="0"+m.toString()),b=b.replace(j,m.toString()))}return b=b.replace(/%%/,"%")}}function e(a,b){var c="s",d="";return a&&(a=a.replace(/(:|;|\s)/gi,"").split(/\,/),1===a.length?c=a[0]:(d=a[0],c=a[1])),Math.abs(b)>1?c:d}var f=[],g=[],h={precision:100,elapse:!1,defer:!1};g.push(/^[0-9]*$/.source),g.push(/([0-9]{1,2}\/){2}[0-9]{4}( [0-9]{1,2}(:[0-9]{2}){2})?/.source),g.push(/[0-9]{4}([\/\-][0-9]{1,2}){2}( [0-9]{1,2}(:[0-9]{2}){2})?/.source),g=new RegExp(g.join("|"));var i={Y:"years",m:"months",n:"daysToMonth",d:"daysToWeek",w:"weeks",W:"weeksToMonth",H:"hours",M:"minutes",S:"seconds",D:"totalDays",I:"totalHours",N:"totalMinutes",T:"totalSeconds"},j=function(b,c,d){this.el=b,this.$el=a(b),this.interval=null,this.offset={},this.options=a.extend({},h),this.instanceNumber=f.length,f.push(this),this.$el.data("countdown-instance",this.instanceNumber),d&&("function"==typeof d?(this.$el.on("update.countdown",d),this.$el.on("stoped.countdown",d),this.$el.on("finish.countdown",d)):this.options=a.extend({},h,d)),this.setFinalDate(c),this.options.defer===!1&&this.start()};a.extend(j.prototype,{start:function(){null!==this.interval&&clearInterval(this.interval);var a=this;this.update(),this.interval=setInterval(function(){a.update.call(a)},this.options.precision)},stop:function(){clearInterval(this.interval),this.interval=null,this.dispatchEvent("stoped")},toggle:function(){this.interval?this.stop():this.start()},pause:function(){this.stop()},resume:function(){this.start()},remove:function(){this.stop.call(this),f[this.instanceNumber]=null,delete this.$el.data().countdownInstance},setFinalDate:function(a){this.finalDate=b(a)},update:function(){if(0===this.$el.closest("html").length)return void this.remove();var b,c=void 0!==a._data(this.el,"events"),d=new Date;b=this.finalDate.getTime()-d.getTime(),b=Math.ceil(b/1e3),b=!this.options.elapse&&b<0?0:Math.abs(b),this.totalSecsLeft!==b&&c&&(this.totalSecsLeft=b,this.elapsed=d>=this.finalDate,this.offset={seconds:this.totalSecsLeft%60,minutes:Math.floor(this.totalSecsLeft/60)%60,hours:Math.floor(this.totalSecsLeft/60/60)%24,days:Math.floor(this.totalSecsLeft/60/60/24)%7,daysToWeek:Math.floor(this.totalSecsLeft/60/60/24)%7,daysToMonth:Math.floor(this.totalSecsLeft/60/60/24%30.4368),weeks:Math.floor(this.totalSecsLeft/60/60/24/7),weeksToMonth:Math.floor(this.totalSecsLeft/60/60/24/7)%4,months:Math.floor(this.totalSecsLeft/60/60/24/30.4368),years:Math.abs(this.finalDate.getFullYear()-d.getFullYear()),totalDays:Math.floor(this.totalSecsLeft/60/60/24),totalHours:Math.floor(this.totalSecsLeft/60/60),totalMinutes:Math.floor(this.totalSecsLeft/60),totalSeconds:this.totalSecsLeft},this.options.elapse||0!==this.totalSecsLeft?this.dispatchEvent("update"):(this.stop(),this.dispatchEvent("finish")))},dispatchEvent:function(b){var c=a.Event(b+".countdown");c.finalDate=this.finalDate,c.elapsed=this.elapsed,c.offset=a.extend({},this.offset),c.strftime=d(this.offset),this.$el.trigger(c)}}),a.fn.countdown=function(){var b=Array.prototype.slice.call(arguments,0);return this.each(function(){var c=a(this).data("countdown-instance");if(void 0!==c){var d=f[c],e=b[0];j.prototype.hasOwnProperty(e)?d[e].apply(d,b.slice(1)):null===String(e).match(/^[$A-Z_][0-9A-Z_$]*$/i)?(d.setFinalDate.call(d,e),d.start()):a.error("Method %s does not exist on jQuery.countdown".replace(/\%s/gi,e))}else new j(this,b[0],b[1])})}});
                $("#timersessionleft")
                .countdown(resp[1], function(event) {
                    var times = event.strftime('%H:%M:%S').split(':');
                  $(this).text(
                    times[0] + ' ' + (times[0] != 1 ? langTranscription['HOURS']:langTranscription['HOUR']) + ' ' +
                    times[1] + ' ' + (times[1] != 1 ? langTranscription['MINUTES']:langTranscription['MINUTE']) + ' ' +
                    times[2] + ' ' + (times[2] != 1 ? langTranscription['SECONDS']:langTranscription['SECOND'])
                  );
                }).on('finish.countdown',  function() { checkSessions(); });
            }
            else if(resp[0] == 'NO_SESSIONS')
            {
                sessionActive = false;
                $('.session-notbought').removeClass('hide');
            }
            else if(resp[0] == 'BAD_GATEWAY')
            {
                sessionActive = false;
                $('.session-badgateway').removeClass('hide');
            }
        }
     });
 }
    }