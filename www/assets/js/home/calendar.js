! function(_0x44d4x1, _0x44d4x2, _0x44d4x3, _0x44d4x4) {
    var _0x44d4x5 = function(_0x44d4x2, _0x44d4x3) {
        this['elem'] = _0x44d4x2, this['$elem'] = _0x44d4x1(_0x44d4x2), this['options'] = _0x44d4x3, this['metadata'] = this['$elem']['data']('plugin-options')
    };
	var validatedDays, inputSelector = '', invalidCalendar = false, invalidWeeklyDays = [], validWeeklyDays, validWeeklyDaysFixed = [], actualHourIndex = '', firstIteration = true, maxDateTimestamp, recentlyChangedDay =  false, actualDayNumber = new Date().getDay(), actualDayInfo = {'dayName': '', 'day': '', 'month': '', 'monthShort':'', 'year': '', 'hour': '', 'minute': '', lenght: ''};
	function compareArrays(arr1, arr2){
            if (arr1.length !== arr2.length) return false;
            for (var i = 0, len = arr1.length; i < len; i++){
                if (arr1[i] !== arr2[i]){
                    return false;
                }
            }
            return true; 
        }
        function deleteOldCalendar()
        {
            validatedDays, inputSelector = '', invalidCalendar = false, invalidWeeklyDays = [], validWeeklyDays, validWeeklyDaysFixed = [], actualHourIndex = '', firstIteration = true, maxDateTimestamp, recentlyChangedDay =  false, actualDayNumber = new Date().getDay(), actualDayInfo = {'dayName': '', 'day': '', 'month': '', 'monthShort':'', 'year': '', 'hour': '', 'minute': '', lenght: ''};
        }
	function getValidHours(psicoCode)
	{
		$.ajax({url: "/calendarhours", method: 'POST', data: {psicoCode: psicoCode}, async: false, cache: false, success: function(result){
                        if(result != 'NO_CALENDAR')
                        {
                            validWeeklyDays = result.days;
                            reservedDays = result.dayscontrated;
                            for(i = 0; i < reservedDays.length; i++)
                            {
                                if(!(moment.unix(reservedDays[i]).format("DD/MM/YYYY") in invalidWeeklyDays))
                                {
                                    invalidWeeklyDays[moment.unix(reservedDays[i]).format("DD/MM/YYYY")] = [];
                                }
                                invalidWeeklyDays[moment.unix(reservedDays[i]).format("DD/MM/YYYY")].push(moment.unix(reservedDays[i]).format("HH:mm"));
                                
                            }
                            for(i = 0; i < validWeeklyDays[actualDayNumber].length; i++)
                            {
                                var dayTimeInfo = validWeeklyDays[actualDayNumber][i].split('--')[0].split('.');
                                var actualTime = new Date();
                                if(dayTimeInfo[0] < actualTime.getHours())
                                {
                                    validWeeklyDays[actualDayNumber].splice(i, 1);
                                }
                                else if(dayTimeInfo[0] == actualTime.getHours())
                                {
                                    if(dayTimeInfo[1] <= actualTime.getMinutes())
                                    {
                                        validWeeklyDays[actualDayNumber].splice(i, 1);
                                    }
                                }
                            }
                            maxDateTimestamp = moment(result.maxdate).format("X");
                        }
                        else
                        {
                            validWeeklyDays = JSON.parse('{"0":["00"],"1":["00"],"2":["00"],"3":["00"],"4":["00"],"5":["00"],"6":["00"]}');
                            actualDayInfo = {'dayName': '00', 'day': '00', 'month': '00', 'monthShort':'00', 'year': '2000', 'hour': '00', 'minute': '00', lenght: '00'}
                            invalidCalendar = true;
                        }
		}, error: function(xhr, status, error) {
                    validWeeklyDays = JSON.parse('{"0":["00"],"1":["00"],"2":["00"],"3":["00"],"4":["00"],"5":["00"],"6":["00"]}');
                    actualDayInfo = {'dayName': '00', 'day': '00', 'month': '00', 'monthShort':'00', 'year': '2000', 'hour': '00', 'minute': '00', lenght: '00'}
                    invalidCalendar = true;
                }});
	}
        function getTimeMinute(time)
        {
            if(typeof time != 'undefined')
            {
                if(time.toString().indexOf(".") != -1)
                {
                    return time.split('.')[1].split('--')[0];
                }
                else
                {
                    return '00';
                }
            }
        }
        function getSessionDuration(time)
        {
            if(typeof time != 'undefined')
            {
                if(time.toString().indexOf("--") != -1)
                {
                    return time.split('.')[1].split('--')[1];
                }
                else
                {
                    return configTranscription['sessionDefaultLenghtInMins'];
                }
            }
        }
        function getTimeHour(time)
        {
            if(typeof time != 'undefined')
            {
                if(time.toString().indexOf(".") != -1)
                {
                    return time.split('.')[0].split('--')[0];
                }
                else
                {
                    return time.split('--')[0];
                }
            }
        }
    _0x44d4x5['prototype'] = {
        public: {
            startDate: moment(),
            endDate: moment(),
            format: 'L LT',
            dateSeparator: ' - ',
            calendarCount: 2,
            inline: !1,
            minDate: null,
            maxDate: null,
            showHeader: !0,
            showFooter: !0,
            showTimePickers: !0,
            hourFormat: 12,
            minuteSteps: 1,
            startOnMonday: !1,
            container: 'body',
            showOn: 'bottom',
            locale: moment['locale'](),
            singleDate: !1,
            target: null,
            autoCloseOnSelect: !1,
            startEmpty: !1,
            showMinutesSelector: 1,
            showMinutesManager: 1,
            calendarSize: 'col-md-3',
            calendarBoxSizeCalendar: 'col-md-12 nopadding',
            calendarBoxSizeResume: 'col-md-12',
            reserveNowButtonParameters: '',
            psicoCode: '',
            ranges: [{
                title: 'Today',
                startDate: moment()['startOf']('day'),
                endDate: moment()['endOf']('day')
            }, {
                title: '3 Days',
                startDate: moment()['startOf']('day'),
                endDate: moment()['add'](2, 'days')['endOf']('day')
            }, {
                title: '5 Days',
                startDate: moment()['startOf']('day'),
                endDate: moment()['add'](4, 'days')['endOf']('day')
            }, {
                title: '1 Week',
                startDate: moment()['startOf']('day'),
                endDate: moment()['add'](6, 'days')['endOf']('day')
            }, {
                title: 'Till Next Week',
                startDate: moment()['startOf']('day'),
                endDate: moment()['endOf']('week')['endOf']('day')
            }, {
                title: 'Till Next Month',
                startDate: moment()['startOf']('day'),
                endDate: moment()['endOf']('month')['endOf']('day')
            }],
            rangeLabel: 'Ranges: ',
            cancelLabel: 'Cancel',
            applyLabel: 'Apply',
            onbeforeselect: function() {
                return !0
            },
            onafterselect: function() {},
            onbeforeshow: function() {},
            onbeforehide: function() {},
            onaftershow: function() {},
            onafterhide: function() {},
            onfirstselect: function() {},
            onrangeselect: function() {},
            onbeforemonthchange: function() {
                return !0
            },
            onaftermonthchange: function() {},
            ondraw: function() {},
            oninit: function() {},
            disableDays: function() {
                return !1
            },
            disabledRanges: [],
            continuous: !1,
            enableMonthSwitcher: !0,
            enableYearSwitcher: !0
        },
        private: {
            startSelected: !1,
            currentDate: moment(),
            endSelected: !0,
            hoverDate: null,
            headerStartDay: null,
            headerStartDate: null,
            headerStartWeekday: null,
            firstValueSelected: !1,
            headerEndDay: null,
            headerEndDate: null,
            headerEndWeekday: null,
            swipeTimeout: null,
            isMobile: !1,
            valElements: ['BUTTON', 'OPTION', 'INPUT', 'LI', 'METER', 'PROGRESS', 'PARAM'],
            dontHideOnce: !1,
            initiator: null,
            initComplete: !1,
            startDateBackup: null,
            startDateInitial: null,
            endDateInitial: null,
            startScrolling: !1,
            lastScrollDirection: 'bottom',
            updateTimeout: null
        },
        init: function() {
            if($(inputSelector).attr('data-actualid') != $(this['$elem']).attr('data-actualid'))
            {
                deleteOldCalendar();
            }
            return this['config'] = _0x44d4x1['extend']({}, this['public'], this['options'], this['metadata']), this['globals'] = _0x44d4x1['extend']({}, this['private']), this['globals']['isMobile'] = this['checkMobile'](), this['applyConfig'](), this['fetchInputs'](), this['drawUserInterface'](), this['addInitialEvents'](), this['$elem']['data']('soluzinkCldr', this), this['config']['oninit'](this), this['globals']['initComplete'] = !0, this['hideLoader'](), this
        },
        validateDates: function() {
            var _0x44d4x1;
            moment(this['config']['startDate'])['locale'](this['config']['locale'])['isValid']() && moment(this['config']['endDate'])['locale'](this['config']['locale'])['isValid']() ? (this['config']['startDate'] = moment(this['config']['startDate'])['locale'](this['config']['locale']), this['config']['endDate'] = moment(this['config']['endDate'])['locale'](this['config']['locale']), this['config']['startDate']['isAfter'](this['config']['endDate']) && (_0x44d4x1 = this['config']['startDate']['clone'](), this['config']['startDate'] = this['config']['endDate']['clone'](), this['config']['endDate'] = _0x44d4x1['clone'](), _0x44d4x1 = null)) : (this['config']['startDate'] = moment(), this['config']['endDate'] = moment()), null !== this['config']['minDate'] && moment(this['config']['minDate'])['locale'](this['config']['locale'])['isValid']() ? this['config']['minDate'] = moment(this['config']['minDate'])['locale'](this['config']['locale']) : this['config']['minDate'] = null, null !== this['config']['maxDate'] && moment(this['config']['maxDate'])['locale'](this['config']['locale'])['isValid']() ? this['config']['maxDate'] = moment(this['config']['maxDate'])['locale'](this['config']['locale']) : this['config']['maxDate'] = null, null !== this['config']['minDate'] && null !== this['config']['maxDate'] && this['config']['minDate']['isAfter'](this['config']['maxDate']) && (_0x44d4x1 = this['config']['minDate']['clone'](), this['config']['minDate'] = this['config']['maxDate']['clone'](), this['config']['maxDate'] = _0x44d4x1['clone'](), _0x44d4x1 = null)
        },
        hideLoader: function() {
            $('.soluzinkCldr-container').removeClass('hide');
            $('.soluzinkCldr-loader').addClass('hide');
        },
        applyConfig: function() {
            getValidHours(this['config']['psicoCode']);
            if(invalidCalendar)
            {
                $('<div class=\'disabledContentText\'>' + langTranscription['CLNDR_DISABLED'] + '</div>').insertAfter(this['$elem']);
            }
            moment['locale'](this['config']['locale']),
			null === this['config']['target'] && (this['config']['target'] = this['$elem']),
			!1 === this['globals']['isMobile'] ? (
				!0 === this['config']['inline'] ? (
					this['container'] = this['$elem']['wrapAll']('<div' + (invalidCalendar ? ' style=\'z-index: 0;\'':'') + ' class=\'soluzinkCldr-container ' + this['config']['calendarSize'] + (invalidCalendar ? ' disabledContent':'') + '\'></div>')['parent'](),
					this['input'] = _0x44d4x1('<div class=\'soluzinkCldr-input\'></div>')['appendTo'](this['container']),
					this['elem']['type'] = 'hidden'
				) : (this['container'] = _0x44d4x1('<div class=\'soluzinkCldr-container soluzinkCldr-popup\'><div class=\'soluzinkCldr-box-arrow-top\'></div></div>')['appendTo'](this['config']['container']),
				this['input'] = _0x44d4x1('<div class=\'soluzinkCldr-input\'></div>')['appendTo'](this['container']),
				this['container']['hide']()),
				this['input']['addClass'](this['config']['calendarBoxSizeCalendar']),
				!1 === this['config']['inline'] && this['setViewport']()) : (this['container'] = _0x44d4x1('<div class=\'soluzinkCldr-container-mobile\'></div>')['appendTo'](this['config']['container']),
				this['input'] = _0x44d4x1('<div class=\'soluzinkCldr-input\'></div>')['appendTo'](this['container']), this['input']['hide'](), this['$elem']['on']('focus', function() {
                _0x44d4x1(this)['blur']()
            }));
        },
        fetchInputs: function() {
            $('.soluzinkCldr-container').addClass('hide');
            moment['locale'](this['config']['locale']);
            var _0x44d4x2 = null;
            if (_0x44d4x2 = -1 !== _0x44d4x1['inArray'](this['elem']['tagName'], this['globals']['valElements']) ? this['$elem']['val']() : this['$elem']['text'](), !1 === this['config']['singleDate'] && _0x44d4x2['indexOf'](this['config']['dateSeparator']) > 0) {
                var _0x44d4x3 = _0x44d4x2['split'](this['config']['dateSeparator']);
                2 == _0x44d4x3['length'] && moment(_0x44d4x3[0], this['config']['format'])['isValid']() && moment(_0x44d4x3[1], this['config']['format'])['isValid']() && (this['config']['startDate'] = moment(_0x44d4x3[0], this['config']['format']), this['config']['endDate'] = moment(_0x44d4x3[1], this['config']['format']))
            } else {
                if (!0 === this['config']['singleDate']) {
                    var _0x44d4x4 = _0x44d4x2;
                    moment(_0x44d4x4, this['config']['format'])['isValid']() && (this['config']['startDate'] = moment(_0x44d4x4, this['config']['format']), this['config']['endDate'] = moment(_0x44d4x4, this['config']['format']))
                }
            };
            this['validateDates'](), this['globals']['currentDate'] = moment(this['config']['startDate'])
        },
        drawUserInterface: function() {
            this['drawHeader'](), this['calendars'] = this['input']['find']('.soluzinkCldr-calendars')['first']();
            for (var _0x44d4x1 = this['globals']['currentDate']['clone'](), _0x44d4x2 = 0; _0x44d4x2 < this['config']['calendarCount']; _0x44d4x2++) {
                this['drawCalendarOfMonth'](_0x44d4x1), _0x44d4x1 = _0x44d4x1['month'](_0x44d4x1['month']() + 1)
            };
            this['calendars']['find']('.soluzinkCldr-calendar')['last']()['addClass']('no-border-right'), this['drawArrows'](), this['reDrawCells']();
            if(Array.isArray(validWeeklyDays))
            {
                this['drawTimePickers'](), this['drawFooter'](),  !0 === this['globals']['isMobile'] || !1 === this['config']['inline'] ? this['setViewport']() : this['fetchTimePickerValues'](), this['updateInput'](!1);
            }
        },
        drawHeader: function() {
            inputSelector = this['input'].prev('input');
            $(inputSelector).attr('data-sessionlenght',getSessionDuration(validWeeklyDays[actualDayNumber][0]));
            var _0x44d4x1 = '<div class=\'soluzinkCldr-header\'><div class=\'soluzinkCldr-header-start\'><div class=\'soluzinkCldr-header-start-day\'></div><div class=\'soluzinkCldr-header-start-date\'></div><div class=\'soluzinkCldr-header-start-weekday\'></div></div><div class=\'soluzinkCldr-header-start-time\'></div><button ' + this['config']['reserveNowButtonParameters'] + ' id="calendarConfirmBtn" class="btn btn-warning buynow">' + langTranscription['CLNDR_RESERVE_NOW'] + '</button>';
            !1 === this['config']['singleDate'] && (_0x44d4x1 += '<div class=\'soluzinkCldr-header-separator\'><i class=\'fa fa-chevron-right\'></i></div><div class=\'soluzinkCldr-header-end\'><div class=\'soluzinkCldr-header-end-day\'></div><div class=\'soluzinkCldr-header-end-date\'></div><div class=\'soluzinkCldr-header-end-weekday\'></div></div>'),
			_0x44d4x1 += '</div><div class=\'soluzinkCldr-calendars\'></div>',
			this['input']['append'](_0x44d4x1), !1 === this['config']['showHeader'] && this['input']['find']('.soluzinkCldr-header')['hide'](),
			this['globals']['headerStartDay'] = this['input']['find']('.soluzinkCldr-header-start-day'),
			this['globals']['headerStartDate'] = this['input']['find']('.soluzinkCldr-header-start-date'),
			this['globals']['headerStartWeekday'] = this['input']['find']('.soluzinkCldr-header-start-weekday'),
			this['globals']['headerEndDay'] = this['input']['find']('.soluzinkCldr-header-end-day'),
			this['globals']['headerEndDate'] = this['input']['find']('.soluzinkCldr-header-end-date'),
			this['globals']['headerEndWeekday'] = this['input']['find']('.soluzinkCldr-header-end-weekday'),
			this['updateHeader']()
        },
        updateHeader: function() {
            null !== this['config']['startDate'] ? (this['globals']['headerStartDay']['text'](this['config']['startDate']['date']()),
			this['globals']['isMobile'] ? this['globals']['headerStartDate']['text'](langTranscription['CLNDR_MONTH_SHORT'][this['config']['startDate']['month']()] + ' ' + this['config']['startDate']['year']()) : this['globals']['headerStartDate']['text'](langTranscription['CLNDR_MONTH'][this['config']['startDate']['month']()] + ' ' + this['config']['startDate']['year']()),
			this['globals']['headerStartWeekday']['text'](langTranscription['CLNDR_DAY'][this['config']['startDate']['day']()])) : (this['globals']['headerStartDay']['text'](''),
			this['globals']['headerStartDate']['text'](''), this['globals']['headerStartWeekday']['text']('')),
			!1 === this['config']['singleDate'] && (null !== this['config']['endDate'] ? (this['globals']['headerEndDay']['text'](this['config']['endDate']['date']()),
			this['globals']['isMobile'] ? this['globals']['headerEndDate']['text'](moment['monthsShort'](this['config']['endDate']['month']()) + ' ' + this['config']['endDate']['year']()) : this['globals']['headerEndDate']['text'](moment['months'](this['config']['endDate']['month']()) + ' ' + this['config']['endDate']['year']()),
			this['globals']['headerEndWeekday']['text'](moment['weekdays'](this['config']['endDate']['day']()))) : (this['globals']['headerEndDay']['text'](''),
			this['globals']['headerEndDate']['text'](''), this['globals']['headerEndWeekday']['text']('')));
		
			if(!recentlyChangedDay)
			{
				actualDayInfo['dayName'] = langTranscription['CLNDR_DAY'][this['config']['startDate']['day']()];
				actualDayInfo['day'] = this['config']['startDate']['date']();
				actualDayInfo['month'] = langTranscription['CLNDR_MONTH'][this['config']['startDate']['month']()];
				actualDayInfo['monthShort'] = langTranscription['CLNDR_MONTH_SHORT'][this['config']['startDate']['month']()];
				actualDayInfo['year'] = this['config']['endDate']['year']();
			}
        },
        updateInput: function(_0x44d4x2) {
            if (!this['config']['startEmpty'] || this['globals']['firstValueSelected']) {
                if (!0 === this['config']['singleDate']) {
                    if (null === this['config']['startDate']) {
                        return
                    }
                } else {
                    if (null === this['config']['startDate'] || null === this['config']['endDate']) {
                        return
                    }
                };
                this['updateTime']()
            }
		},
        drawArrows: function() {
            this['container']['find']('.soluzinkCldr-title')['length'] > 0 && (this['globals']['isMobile'] ? (this['container']['find']('.soluzinkCldr-title')['prepend']('<div class=\'soluzinkCldr-prev\'><i class=\'fa fa-arrow-left\'></i></div>'), this['container']['find']('.soluzinkCldr-title')['append']('<div class=\'soluzinkCldr-next\'><i class=\'fa fa-arrow-right\'></i></div>')) : (this['container']['find']('.soluzinkCldr-title')['first']()['prepend']('<div class=\'soluzinkCldr-prev\'><i class=\'fa fa-arrow-left\'></i></div>'), this['container']['find']('.soluzinkCldr-title')['last']()['append']('<div class=\'soluzinkCldr-next\'><i class=\'fa fa-arrow-right\'></i></div>')))
        },
        drawCalendarOfMonth: function(_0x44d4x1) {
            moment['locale'](this['config']['locale']);
            var _0x44d4x2 = moment['localeData'](this['config']['locale'])['firstDayOfWeek'](),
                _0x44d4x3 = moment(_0x44d4x1)['startOf']('month')['subtract'](1, 'day')['endOf']('month')['startOf']('week');
            1 == _0x44d4x2 && !1 === this['config']['startOnMonday'] ? (_0x44d4x3['subtract'](1, 'days'), _0x44d4x2 = 0) : 0 === _0x44d4x2 && !0 === this['config']['startOnMonday'] && (_0x44d4x3['add'](1, 'days'), _0x44d4x2 = 1);
            var _0x44d4x4 = '<div class=\'soluzinkCldr-calendar\' data-month=\'' + _0x44d4x1['month']() + '\'>',
                _0x44d4x5 = 0,
                _0x44d4x6 = '',
                _0x44d4x7 = '';
            this['config']['enableMonthSwitcher'] && (_0x44d4x6 = ' class=\'soluzinkCldr-month-switch\''), this['config']['enableYearSwitcher'] && (_0x44d4x7 = ' class=\'soluzinkCldr-year-switch\''), _0x44d4x4 += '<div class=\'soluzinkCldr-title\'><span><b' + _0x44d4x6 + '>' + langTranscription['CLNDR_MONTH'][_0x44d4x1['month']()] + '</b>&nbsp;<span' + _0x44d4x7 + '>' + _0x44d4x1['year']() + '</span></span></div>', _0x44d4x4 += '<div class=\'soluzinkCldr-days-container\'>';
            for (var _0x44d4x8 = _0x44d4x2; _0x44d4x8 < _0x44d4x2 + 7; _0x44d4x8++) {
                _0x44d4x4 += '<div class=\'soluzinkCldr-dayofweek\'>' + langTranscription['CLNDR_DAY_SHORT'][_0x44d4x8] + '</div>'
            };
            for (; _0x44d4x5 < 42;) {
                var _0x44d4x9 = _0x44d4x3['startOf']('day')['unix']();
                _0x44d4x4 += '<div class=\'' + (_0x44d4x1['month']() == _0x44d4x3['month']() ? 'soluzinkCldr-day' : 'soluzinkCldr-disabled') + '\' data-value=\'' + _0x44d4x9 + '\'><span>' + _0x44d4x3['date']() + '</span></div>', _0x44d4x5++, _0x44d4x3['add'](1, 'days')
            };
            _0x44d4x4 += '</div>', _0x44d4x4 += '</div>', this['calendars']['append'](_0x44d4x4);
            $('.soluzinkCldr-header-end').html('');
        },
        drawTimePickers: function() {
            this['input']['find']('.soluzinkCldr-timepickers')['remove'](), this['input']['append']('<div class=\'soluzinkCldr-timepickers\'></div>'), this['timepickers'] = this['input']['find']('.soluzinkCldr-timepickers'), this['config']['showTimePickers'] || this['timepickers']['hide']();
            var _0x44d4x2 = 0,
                _0x44d4x3 = 23,
                _0x44d4x4 = !1;
            12 == this['config']['hourFormat'] && (_0x44d4x2 = 1, _0x44d4x3 = 12, _0x44d4x4 = !0);
            var _0x44d4x5 = _0x44d4x1('<div class=\'soluzinkCldr-timepicker soluzinkCldr-timepicker-start\'></div>')['appendTo'](this['timepickers']);
            this['addTimePickerHours'](_0x44d4x5, _0x44d4x2, _0x44d4x3), this['addTimePickerHourMinuteSeparator'](_0x44d4x5), this['addTimePickerMinutes'](_0x44d4x5, this['config']['minuteSteps']), _0x44d4x4 && this['addTimePickerAMPM'](_0x44d4x5), !1 === this['config']['singleDate'] && (_0x44d4x5 = _0x44d4x1('<div class=\'soluzinkCldr-timepicker soluzinkCldr-timepicker-end\'></div>')['appendTo'](this['timepickers']), this['addTimePickerHours'](_0x44d4x5, _0x44d4x2, _0x44d4x3), this['addTimePickerHourMinuteSeparator'](_0x44d4x5), this['addTimePickerMinutes'](_0x44d4x5, this['config']['minuteSteps']), _0x44d4x4 && this['addTimePickerAMPM'](_0x44d4x5)), this['addTimePickerEvents'](), this['fetchTimePickerValues']()
        },
        addTimePickerHours: function(_0x44d4x2, _0x44d4x3, _0x44d4x4) {
            var _0x44d4x5 = _0x44d4x1('<div class=\'soluzinkCldr-timepicker-hours-wrapper\'></div>')['appendTo'](_0x44d4x2),
                _0x44d4x6 = _0x44d4x1('<div class=\'soluzinkCldr-timepicker-hours\'></div>')['appendTo'](_0x44d4x5),
                _0x44d4x7 = '<div class=\'soluzinkCldr-hour-selected-prev\'>&nbsp;</div>';
                _0x44d4x7 += '<div class=\'soluzinkCldr-hour-selected\'>' + ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2) + '</div>';
                if(validatedDays[actualDayNumber].length > 1)
                {
                    _0x44d4x7 += '<div class=\'soluzinkCldr-hour-selected-next\'>' + ('0' + getTimeHour(validatedDays[actualDayNumber][1])).slice(-2) + '</div>';
                }
                else
                {
                    _0x44d4x7 += '<div class=\'soluzinkCldr-hour-selected-next\'>' + ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2) + '</div>';   
                }
                _0x44d4x6['append'](_0x44d4x7)['data']({
                    value: _0x44d4x3,
                    min: _0x44d4x3,
                    max: _0x44d4x4,
                    step: 1
                }),
			_0x44d4x1('<div class=\'soluzinkCldr-timepicker-hour-arrows\'><div class=\'soluzinkCldr-timepicker-hours-up soluzinkCldr-direction-up\'><i class=\'fa fa-arrow-up\'></i></div><div class=\'soluzinkCldr-timepicker-hours-down soluzinkCldr-direction-down\'><i class=\'fa fa-arrow-down\'></i></div></div>')['appendTo'](_0x44d4x2),
			this['preventParentScroll'](_0x44d4x5);
        },
        addTimePickerMinutes: function(_0x44d4x2, _0x44d4x3) {
			if(this['config']['showMinutesSelector'])
			{
				var _0x44d4x4 = _0x44d4x1('<div class=\'soluzinkCldr-timepicker-minutes-wrapper\'></div>')['appendTo'](_0x44d4x2),
					_0x44d4x5 = _0x44d4x1('<div class=\'soluzinkCldr-timepicker-minutes\'></div>')['appendTo'](_0x44d4x4),
					_0x44d4x6 = '<div class=\'soluzinkCldr-minute-selected-prev\'>&nbsp;</div>';
                                        _0x44d4x6 += '<div class=\'soluzinkCldr-minute-selected\'>00</div>',  _0x44d4x6 += '<div class=\'soluzinkCldr-minute-selected-next\'>01</divided>', _0x44d4x5['append'](_0x44d4x6)['data']({
					value: 0,
					min: 0,
					max: 59 % _0x44d4x3 != 0 ? 59 - 59 % _0x44d4x3 : 59,
					step: _0x44d4x3
				});
				if(this['config']['showMinutesManager'])
				{
					_0x44d4x6 += _0x44d4x1('<div class=\'soluzinkCldr-timepicker-minute-arrows\'><div class=\'soluzinkCldr-timepicker-minutes-up soluzinkCldr-direction-up\'><i class=\'fa fa-arrow-up\'></i></div><div class=\'soluzinkCldr-timepicker-minutes-down soluzinkCldr-direction-down\'><i class=\'fa fa-arrow-down\'></i></div></div>')['appendTo'](_0x44d4x2), this['preventParentScroll'](_0x44d4x4)
				}
			}
		},
		
        addTimePickerHourMinuteSeparator: function(_0x44d4x2) {
			if(this['config']['showMinutesSelector'])
			{
				_0x44d4x1('<div class=\'soluzinkCldr-hour-minute-seperator\'>:</div>')['appendTo'](_0x44d4x2)
			}
        },
        addTimePickerAMPM: function(_0x44d4x2) {
            var _0x44d4x3 = _0x44d4x1('<div class=\'soluzinkCldr-timepicker-ampm\'></div>')['appendTo'](_0x44d4x2);
            _0x44d4x3['append']('<div class=\'soluzinkCldr-timepicker-ampm-am\'>AM</div>'), _0x44d4x3['append']('<div class=\'soluzinkCldr-timepicker-ampm-pm\'>PM</div>')
        },
        addTimePickerEvents: function() {
            var _0x44d4x2 = this,
                _0x44d4x3 = function(_0x44d4x1) {
                    var _0x44d4x3 = _0x44d4x1['parents']('.soluzinkCldr-timepicker')['hasClass']('soluzinkCldr-timepicker-start') ? 'start' : 'end',
                        _0x44d4x4 = _0x44d4x1['hasClass']('soluzinkCldr-timepicker-minutes-up') || _0x44d4x1['hasClass']('soluzinkCldr-timepicker-minutes-down') ? 'minute' : 'hour',
                        _0x44d4x5 = _0x44d4x1['hasClass']('soluzinkCldr-timepicker-minutes-up') || _0x44d4x1['hasClass']('soluzinkCldr-timepicker-hours-up') ? 'up' : 'down',
                        _0x44d4x6 = _0x44d4x2['timepickers']['find']('.soluzinkCldr-timepicker-' + _0x44d4x3 + ' .soluzinkCldr-timepicker-' + _0x44d4x4 + 's'),
                        _0x44d4x7 = _0x44d4x6['data']();
						
                    if (_0x44d4x7 && _0x44d4x7['hasOwnProperty']('value')) {
                        var containerValueHours = _0x44d4x2['container']['find']('.soluzinkCldr-hour-selected').text();
                        var containerValueMinute = _0x44d4x2['container']['find']('.soluzinkCldr-minute-selected').text();
                        for(i = 0; i < validatedDays[actualDayNumber].length; i++)
                        {
                            if(validatedDays[actualDayNumber][i].toString().indexOf(".") != -1)
                            {
                                var avaliableHoursWithMinutes = validatedDays[actualDayNumber][i].toString().split('--')[0].split('.');
                                if(parseInt(avaliableHoursWithMinutes[0],10) === parseInt(containerValueHours,10) && parseInt(avaliableHoursWithMinutes[1],10) === parseInt(containerValueMinute,10) )
                                {
                                    actualHourIndex = i;
                                }
                            }
                            else
                            {
                                if(parseInt(validatedDays[actualDayNumber][i].toString(), 10) == parseInt(containerValueHours, 10))
                                {
                                    actualHourIndex = i;
                                }
                            }
                        }
                        prevHour = '';
                        nextHour = '';
                        if(actualHourIndex == -1 && recentlyChangedDay)
                        {
                                actualHourIndex = 0;
                                recentlyChangedDay = false;
                        }
                        if(validatedDays[actualDayNumber].length > 1)
                        {
                            switch (_0x44d4x5) {
                                case 'down':
                                if(actualHourIndex >= 0 && actualHourIndex != validatedDays[actualDayNumber].length-1)
                                {
                                        prevHour = ('0' + getTimeHour(validatedDays[actualDayNumber][actualHourIndex])).slice(-2);
                                        _0x44d4x7['value'] = ('0' + getTimeHour(validatedDays[actualDayNumber][actualHourIndex+1])).slice(-2);
                                        $('.soluzinkCldr-minute-selected').html((getTimeMinute(validatedDays[actualDayNumber][actualHourIndex+1]).slice(-2)));
                                        $(inputSelector).attr('data-sessionlenght',(getSessionDuration(validatedDays[actualDayNumber][actualHourIndex+1])));
                                        if(typeof getTimeHour(validatedDays[actualDayNumber][actualHourIndex+2]) !== 'undefined')
                                        {
                                            nextHour = ('0' + getTimeHour(validatedDays[actualDayNumber][actualHourIndex+2])).slice(-2);
                                        }
                                        else
                                        {
                                            nextHour = ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2);
                                        }
                                }
                                else
                                {
                                        prevHour = ('0' + getTimeHour(validatedDays[actualDayNumber][validatedDays[actualDayNumber].length-1])).slice(-2);
                                        _0x44d4x7['value'] = ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2);
                                        $('.soluzinkCldr-minute-selected').html(('0' + getTimeMinute(validatedDays[actualDayNumber][0])).slice(-2));
                                        $(inputSelector).attr('data-sessionlenght',(getSessionDuration(validatedDays[actualDayNumber][0])));
                                        nextHour = ('0' + getTimeHour(validatedDays[actualDayNumber][1])).slice(-2);
                                }
                                    break;
                                case 'up':
                                if(actualHourIndex >= 0 && actualHourIndex != 0)
                                {
                                        _0x44d4x7['value'] = ('0' + getTimeHour(validatedDays[actualDayNumber][actualHourIndex-1])).slice(-2);
                                        $('.soluzinkCldr-minute-selected').html((getTimeMinute(validatedDays[actualDayNumber][actualHourIndex-1]).slice(-2)));
                                        $(inputSelector).attr('data-sessionlenght',(getSessionDuration(validatedDays[actualHourIndex-1][0])));
                                        if(typeof validatedDays[actualDayNumber][actualHourIndex-2] !== 'undefined')
                                        {
                                                prevHour = ('0' + getTimeHour(validatedDays[actualDayNumber][actualHourIndex-2])).slice(-2);
                                                nextHour = ('0' + getTimeHour(validatedDays[actualDayNumber][actualHourIndex])).slice(-2);
                                        }
                                        else
                                        {
                                                prevHour = ('0' + getTimeHour(validatedDays[actualDayNumber][validatedDays[actualDayNumber].length-1])).slice(-2);
                                                nextHour = ('0' + getTimeHour(validatedDays[actualDayNumber][1])).slice(-2);
                                        }
                                }
                                else
                                {
                                        prevHour = ('0' + getTimeHour(validatedDays[actualDayNumber][validatedDays[actualDayNumber].length-2])).slice(-2);
                                        _0x44d4x7['value'] = ('0' + getTimeHour(validatedDays[actualDayNumber][validatedDays[actualDayNumber].length-1])).slice(-2);
                                        $('.soluzinkCldr-minute-selected').html(('0' + getTimeMinute(validatedDays[actualDayNumber][validatedDays[actualDayNumber].length-1])).slice(-2));
                                        $(inputSelector).attr('data-sessionlenght',(getSessionDuration(validatedDays[actualDayNumber][0])));
                                        nextHour = ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2);
                                }				
                            };
                    }
                    else
                    {
                        prevHour = ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2);
                        _0x44d4x7['value'] = ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2);
                        $('.soluzinkCldr-minute-selected').html(('0' + getTimeMinute(validatedDays[actualDayNumber][0])).slice(-2));
                        $(inputSelector).attr('data-sessionlenght',(getSessionDuration(validatedDays[actualDayNumber][0])));
                        nextHour = ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2);
                    }
                    var baseVal = parseInt($('.soluzinkCldr-minute-selected').text(),10);
                    var prevMinute = baseVal-1;
                    $('.soluzinkCldr-minute-selected-prev').html((prevMinute !== 60) ? ((prevMinute !== -1) ? ('0' + prevMinute).slice(-2):59):('00').slice(-2));
                    var nextMinute = baseVal+1;
                    $('.soluzinkCldr-minute-selected-next').html((nextMinute !== 60) ? ((nextMinute !== -1) ? ('0' + nextMinute).slice(-2):59):('00').slice(-2));
                        _0x44d4x6['data'](_0x44d4x7), _0x44d4x6['find']('.soluzinkCldr-' + _0x44d4x4 + '-selected-prev')['html'](prevHour), _0x44d4x6['find']('.soluzinkCldr-' + _0x44d4x4 + '-selected')['text'](('00' + _0x44d4x7['value'])['slice'](-2)), _0x44d4x6['find']('.soluzinkCldr-' + _0x44d4x4 + '-selected-next')['html'](_0x44d4x7['value'] + _0x44d4x7['step'] > _0x44d4x7['max'] ? nextHour : nextHour), _0x44d4x2['input']['is'](':visible') && _0x44d4x2['updateInput']()
					}
                };
            this['timepickers']['find']('.soluzinkCldr-timepicker-minutes-up, .soluzinkCldr-timepicker-minutes-down, .soluzinkCldr-timepicker-hours-up, .soluzinkCldr-timepicker-hours-down')['off']('click.soluzinkCldr')['on']('click.soluzinkCldr', function(_0x44d4x2) {
                _0x44d4x3(_0x44d4x1(this))
            }), this['timepickers']['find']('.soluzinkCldr-timepicker-hours-wrapper, .soluzinkCldr-timepicker-minutes-wrapper')['off']('mousewheel.soluzinkCldr DOMMouseScroll.soluzinkCldr')['on']('mousewheel.soluzinkCldr DOMMouseScroll.soluzinkCldr', function(_0x44d4x2) {
                (_0x44d4x2['originalEvent']['wheelDelta'] || -_0x44d4x2['originalEvent']['detail']) / 120 > 0 ? _0x44d4x1(_0x44d4x2['currentTarget'])['hasClass']('soluzinkCldr-timepicker-hours-wrapper') ? _0x44d4x3(_0x44d4x1(this)['siblings']('.soluzinkCldr-timepicker-hour-arrows')['find']('.soluzinkCldr-timepicker-hours-up')) : _0x44d4x1(_0x44d4x2['currentTarget'])['hasClass']('soluzinkCldr-timepicker-minutes-wrapper') && _0x44d4x3(_0x44d4x1(this)['siblings']('.soluzinkCldr-timepicker-minute-arrows')['find']('.soluzinkCldr-timepicker-minutes-up')) : _0x44d4x1(_0x44d4x2['currentTarget'])['hasClass']('soluzinkCldr-timepicker-hours-wrapper') ? _0x44d4x3(_0x44d4x1(this)['siblings']('.soluzinkCldr-timepicker-hour-arrows')['find']('.soluzinkCldr-timepicker-hours-down')) : _0x44d4x1(_0x44d4x2['currentTarget'])['hasClass']('soluzinkCldr-timepicker-minutes-wrapper') && _0x44d4x3(_0x44d4x1(this)['siblings']('.soluzinkCldr-timepicker-minute-arrows')['find']('.soluzinkCldr-timepicker-minutes-down'))
            }), this['globals']['isMobile'] && this['timepickers']['find']('.soluzinkCldr-timepicker-minutes, .soluzinkCldr-timepicker-hours')['each'](function() {
                var _0x44d4x4 = new Hammer(this);
                _0x44d4x4['get']('pan')['set']({
                    direction: Hammer['DIRECTION_VERTICAL']
                }), _0x44d4x4['on']('panmove', _0x44d4x2['panThrottle'](function(_0x44d4x2) {
                    var _0x44d4x4 = _0x44d4x1(_0x44d4x2['target']);
                    return _0x44d4x2['velocityY'] > 0 ? _0x44d4x4['hasClass']('soluzinkCldr-timepicker-hours-wrapper') || _0x44d4x4['parents']('.soluzinkCldr-timepicker-hours-wrapper')['length'] > 0 ? (_0x44d4x3(_0x44d4x4['parents']('.soluzinkCldr-timepicker')['find']('.soluzinkCldr-timepicker-hours-up')), _0x44d4x2['srcEvent']['preventDefault']()) : (_0x44d4x4['hasClass']('soluzinkCldr-timepicker-minutes-wrapper') || _0x44d4x4['parents']('.soluzinkCldr-timepicker-minutes-wrapper')['length'] > 0) && (_0x44d4x3(_0x44d4x4['parents']('.soluzinkCldr-timepicker')['find']('.soluzinkCldr-timepicker-minutes-up')), _0x44d4x2['srcEvent']['preventDefault']()) : _0x44d4x4['hasClass']('soluzinkCldr-timepicker-hours-wrapper') || _0x44d4x4['parents']('.soluzinkCldr-timepicker-hours-wrapper')['length'] > 0 ? (_0x44d4x3(_0x44d4x4['parents']('.soluzinkCldr-timepicker')['find']('.soluzinkCldr-timepicker-hours-down')), _0x44d4x2['srcEvent']['preventDefault']()) : (_0x44d4x4['hasClass']('soluzinkCldr-timepicker-minutes-wrapper') || _0x44d4x4['parents']('.soluzinkCldr-timepicker-minutes-wrapper')['length'] > 0) && (_0x44d4x3(_0x44d4x4['parents']('.soluzinkCldr-timepicker')['find']('.soluzinkCldr-timepicker-minutes-down')), _0x44d4x2['srcEvent']['preventDefault']()), !1
                }))
            }), this['timepickers']['find']('.soluzinkCldr-timepicker-ampm > div')['off']('click.soluzinkCldr')['on']('click.soluzinkCldr', function() {
                _0x44d4x1(this)['addClass']('soluzinkCldr-ampm-selected')['siblings']()['removeClass']('soluzinkCldr-ampm-selected'), _0x44d4x2['updateInput']()
            })
        },
        panThrottle: function(_0x44d4x2) {
            return _0x44d4x1['proxy'](function() {
                var _0x44d4x1 = this,
                    _0x44d4x3 = Array['prototype']['slice']['call'](arguments),
                    _0x44d4x4 = Math['ceil'](Math['abs'](_0x44d4x3[0]['deltaY']) / 20) || 1;
                this['globals']['panScrollPos'] != _0x44d4x4 && (_0x44d4x2['apply'](_0x44d4x1, _0x44d4x3), this['globals']['panScrollPos'] = _0x44d4x4)
            }, this)
        },
        preventParentScroll: function(_0x44d4x1) {
            var _0x44d4x2 = function(_0x44d4x1) {
                var _0x44d4x2 = 'mousewheel' === _0x44d4x1['type'] ? _0x44d4x1['wheelDelta'] : -40 * _0x44d4x1['detail'];
                _0x44d4x2 < 0 && this['scrollHeight'] - this['offsetHeight'] - this['scrollTop'] <= 0 ? (this['scrollTop'] = this['scrollHeight'], _0x44d4x1['preventDefault']()) : _0x44d4x2 > 0 && _0x44d4x2 > this['scrollTop'] && (this['scrollTop'] = 0, _0x44d4x1['preventDefault']())
            };
            _0x44d4x1['get'](0)['addEventListener']('mousewheel', _0x44d4x2), _0x44d4x1['get'](0)['addEventListener']('DOMMouseScroll', _0x44d4x2)
        },
        updateTime: function() {
            var _0x44d4x1 = null,
                _0x44d4x2 = null;
            12 == this['config']['hourFormat'] ? (_0x44d4x1 = moment(this['timepickers']['find']('.soluzinkCldr-timepicker-start .soluzinkCldr-hour-selected')['text']() + ' ' + this['timepickers']['find']('.soluzinkCldr-timepicker-start .soluzinkCldr-minute-selected')['text']() + ' ' + this['timepickers']['find']('.soluzinkCldr-timepicker-start .soluzinkCldr-ampm-selected')['text'](), 'hh mm a'), _0x44d4x2 = moment(this['timepickers']['find']('.soluzinkCldr-timepicker-end .soluzinkCldr-hour-selected')['text']() + ' ' + this['timepickers']['find']('.soluzinkCldr-timepicker-end .soluzinkCldr-minute-selected')['text']() + ' ' + this['timepickers']['find']('.soluzinkCldr-timepicker-end .soluzinkCldr-ampm-selected')['text'](), 'hh mm a')) : (_0x44d4x1 = moment(this['timepickers']['find']('.soluzinkCldr-timepicker-start .soluzinkCldr-hour-selected')['text']() + ' ' + this['timepickers']['find']('.soluzinkCldr-timepicker-start .soluzinkCldr-minute-selected')['text'](), 'HH mm'),
			_0x44d4x2 = moment(this['timepickers']['find']('.soluzinkCldr-timepicker-end .soluzinkCldr-hour-selected')['text']() + ' ' + this['timepickers']['find']('.soluzinkCldr-timepicker-end .soluzinkCldr-minute-selected')['text'](), 'HH mm')), _0x44d4x1['isValid']() && this['config']['startDate']['set']({
                hour: _0x44d4x1['hours'](),
                minute: _0x44d4x1['minutes']()
            }), _0x44d4x2['isValid']() && this['config']['endDate']['set']({
                hour: _0x44d4x2['hours'](),
                minute: _0x44d4x2['minutes']()
            }), this['validateDates']();
			
                actualDayInfo['hour'] = this['timepickers']['find']('.soluzinkCldr-timepicker-start .soluzinkCldr-hour-selected')['text']();
                actualDayInfo['minute'] = this['timepickers']['find']('.soluzinkCldr-timepicker-start .soluzinkCldr-minute-selected')['text']();
                actualDayInfo['lenght'] = $(inputSelector).attr('data-sessionlenght');
                $('.soluzinkCldr-header-start-time').text(langTranscription['CLNDR_DAY_TXT'].replace('{{hour}}',actualDayInfo['hour']).replace('{{lenght}}',(typeof actualDayInfo['lenght'] != 'undefined' ? actualDayInfo['lenght']:configTranscription['sessionDefaultLenghtInMins'])).replace('{{minute}}',actualDayInfo['minute'] + ' ' + ((actualDayInfo['hour'] < 12) ? langTranscription['CLNDR_DAY_MORNING'] : langTranscription['CLNDR_DAY_AFTERNOON'])));
                if($('.soluzinkCldr-selected').length)
                {
                    $(inputSelector).val(moment.unix($('.soluzinkCldr-selected').attr('data-value')).format("DD/MM/YYYY") + ' ' + $('.soluzinkCldr-hour-selected').text() + ':' + $('.soluzinkCldr-minute-selected').text());
                }
        },
        fetchTimePickerValues: function() {
            if (this['timepickers'] !== _0x44d4x4 && null !== this['config']['startDate'] && null !== this['config']['endDate']) {
                var _0x44d4x1 = moment(this['config']['startDate'])['set']({
                        minute: 1 != this['config']['minuteSteps'] ? Math['round'](this['config']['startDate']['minutes']() / this['config']['minuteSteps']) * this['config']['minuteSteps'] : this['config']['startDate']['minutes']()
                    }),
                    _0x44d4x2 = moment(this['config']['endDate'])['set']({
                        minute: 1 != this['config']['minuteSteps'] ? Math['round'](this['config']['endDate']['minutes']() / this['config']['minuteSteps']) * this['config']['minuteSteps'] : this['config']['endDate']['minutes']()
                    }),
                    _0x44d4x3 = _0x44d4x1['hours'](),
                    _0x44d4x5 = _0x44d4x2['hours'](),
                    _0x44d4x6 = _0x44d4x1['minutes'](),
                    _0x44d4x7 = _0x44d4x2['minutes'](),
                    _0x44d4x8 = null,
                    _0x44d4x9 = null;
                if (12 == this['config']['hourFormat']) {
                    var _0x44d4xa = _0x44d4x1['format']('hh mm a')['split'](' ');
                    _0x44d4x3 = parseInt(_0x44d4xa[0], 10), _0x44d4x8 = _0x44d4xa[2]['toLowerCase']();
                    var _0x44d4xb = _0x44d4x2['format']('hh mm a')['split'](' ');
                    _0x44d4x5 = parseInt(_0x44d4xb[0], 10), _0x44d4x9 = _0x44d4xb[2]['toLowerCase']()
                };
                this['setStartTimeValue'](getTimeHour(validatedDays[actualDayNumber][0]), getTimeMinute(validatedDays[actualDayNumber][0]), _0x44d4x8), this['setEndTimeValue'](_0x44d4x5, _0x44d4x7, _0x44d4x9)
            }
        },
        setStartTimeValue: function(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
			var _0x44d4x4 = this['timepickers']['find']('.soluzinkCldr-timepicker-start'),
                _0x44d4x5 = _0x44d4x4['find']('.soluzinkCldr-timepicker-hours');
            _0x44d4x5['data']('value', _0x44d4x1);
            var _0x44d4x6 = _0x44d4x5['data']();
            if(validatedDays[actualDayNumber].length > 1)
            {
                _0x44d4x6 && _0x44d4x6['hasOwnProperty']('value') && (_0x44d4x5['find']('.soluzinkCldr-hour-selected-prev')['html'](('0' + getTimeHour(validatedDays[actualDayNumber][validWeeklyDays[actualDayNumber].length-1]))).slice(-2));
            }
            else
            {
                _0x44d4x6 && _0x44d4x6['hasOwnProperty']('value') && (_0x44d4x5['find']('.soluzinkCldr-hour-selected-prev')['html'](('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2)));   
            }
            var _0x44d4x7 = _0x44d4x4['find']('.soluzinkCldr-timepicker-minutes');
            _0x44d4x7['data']('value', _0x44d4x2), _0x44d4x6 = _0x44d4x7['data'](), _0x44d4x6 && _0x44d4x6['hasOwnProperty']('value') && (_0x44d4x7['find']('.soluzinkCldr-minute-selected-prev')['html'](_0x44d4x6['value'] - _0x44d4x6['step'] < _0x44d4x6['min'] ? ('00' + _0x44d4x6['max'])['slice'](-2) : ('00' + (_0x44d4x6['value'] - _0x44d4x6['step']))['slice'](-2)), _0x44d4x7['find']('.soluzinkCldr-minute-selected')['text'](getTimeMinute(validatedDays[actualDayNumber][0])), _0x44d4x7['find']('.soluzinkCldr-minute-selected-next')['html'](_0x44d4x6['value'] + _0x44d4x6['step'] > _0x44d4x6['max'] ? ('00' + _0x44d4x6['min'])['slice'](-2) : ('00' + (_0x44d4x6['value'] + _0x44d4x6['step']))['slice'](-2))), null !== _0x44d4x3 && _0x44d4x4['find']('.soluzinkCldr-timepicker-ampm-' + _0x44d4x3)['addClass']('soluzinkCldr-ampm-selected')
			},
        setEndTimeValue: function(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
            var _0x44d4x4 = this['timepickers']['find']('.soluzinkCldr-timepicker-end'),
                _0x44d4x5 = _0x44d4x4['find']('.soluzinkCldr-timepicker-hours');
            _0x44d4x5['data']('value', _0x44d4x1);
            var _0x44d4x6 = _0x44d4x5['data']();
            _0x44d4x6 && _0x44d4x6['hasOwnProperty']('value') && (_0x44d4x5['find']('.soluzinkCldr-hour-selected-prev')['html'](_0x44d4x6['value'] - _0x44d4x6['step'] < _0x44d4x6['min'] ? ('00' + _0x44d4x6['max'])['slice'](-2) : ('00' + (_0x44d4x6['value'] - _0x44d4x6['step']))['slice'](-2)), _0x44d4x5['find']('.soluzinkCldr-hour-selected')['text'](('00' + _0x44d4x6['value'])['slice'](-2)), _0x44d4x5['find']('.soluzinkCldr-hour-selected-next')['html'](_0x44d4x6['value'] + _0x44d4x6['step'] > _0x44d4x6['max'] ? ('00' + _0x44d4x6['min'])['slice'](-2) : ('00' + (_0x44d4x6['value'] + _0x44d4x6['step']))['slice'](-2)));
            var _0x44d4x7 = _0x44d4x4['find']('.soluzinkCldr-timepicker-minutes');
            _0x44d4x7['data']('value', _0x44d4x2), _0x44d4x6 = _0x44d4x7['data'](), _0x44d4x6 && _0x44d4x6['hasOwnProperty']('value') && (_0x44d4x7['find']('.soluzinkCldr-minute-selected-prev')['html'](_0x44d4x6['value'] - _0x44d4x6['step'] < _0x44d4x6['min'] ? ('00' + _0x44d4x6['max'])['slice'](-2) : ('00' + (_0x44d4x6['value'] - _0x44d4x6['step']))['slice'](-2)), _0x44d4x7['find']('.soluzinkCldr-minute-selected')['text'](('00' + _0x44d4x6['value'])['slice'](-2)), _0x44d4x7['find']('.soluzinkCldr-minute-selected-next')['html'](_0x44d4x6['value'] + _0x44d4x6['step'] > _0x44d4x6['max'] ? ('00' + _0x44d4x6['min'])['slice'](-2) : ('00' + (_0x44d4x6['value'] + _0x44d4x6['step']))['slice'](-2))), null !== _0x44d4x3 && _0x44d4x4['find']('.soluzinkCldr-timepicker-ampm-' + _0x44d4x3)['addClass']('soluzinkCldr-ampm-selected')
        },
        drawFooter: function() {
            if (!1 === this['config']['singleDate'] && !0 === this['config']['showFooter']) {
                this['input']['append']('<div class=\'soluzinkCldr-ranges\'></div>');
                var _0x44d4x1 = this['input']['find']('.soluzinkCldr-ranges');
                _0x44d4x1['append']('<i class=\'fa fa-retweet\'></i><div class=\'soluzinkCldr-range-header\'>' + this['config']['rangeLabel'] + '</div>');
                for (var _0x44d4x2 in this['config']['ranges']) {
                    _0x44d4x1['append']('<div class=\'soluzinkCldr-range\' data-id=\'' + _0x44d4x2 + '\'>' + this['config']['ranges'][_0x44d4x2]['title'] + '</div>')
                }
            };
            this['globals']['isMobile'] && (!0 !== this['config']['singleDate'] && !1 !== this['config']['showFooter'] || this['input']['append']('<div class=\'soluzinkCldr-filler\'></div>'), this['input']['append']('<div class=\'soluzinkCldr-footer\'></div>'), this['footer'] = this['input']['find']('.soluzinkCldr-footer'), this['footer']['append']('<button class=\'soluzinkCldr-cancel\'>' + this['config']['cancelLabel'] + '</button>'), this['footer']['append']('<button class=\'soluzinkCldr-apply\'>' + this['config']['applyLabel'] + '</button>'))
        },
        drawNextMonth: function(_0x44d4x1) {
            if (null === this['globals']['swipeTimeout']) {
                var _0x44d4x2 = this;
                this['globals']['swipeTimeout'] = setTimeout(function() {
                    var _0x44d4x1 = _0x44d4x2['calendars']['get'](0)['scrollTop'];
                    !0 === _0x44d4x2['config']['onbeforemonthchange'](_0x44d4x2, _0x44d4x2['globals']['currentDate']['startOf']('month'), 'next') && (_0x44d4x2['globals']['currentDate']['add'](1, 'month'), _0x44d4x2['reDrawCalendars'](), _0x44d4x2['config']['onaftermonthchange'](_0x44d4x2, _0x44d4x2['globals']['currentDate']['startOf']('month'))), _0x44d4x2['calendars']['get'](0)['scrollTop'] = _0x44d4x1, _0x44d4x2['globals']['swipeTimeout'] = null
                }, 100)
            };
            _0x44d4x1 && 'function' == typeof _0x44d4x1['stopPropagation'] && _0x44d4x1['stopPropagation']()
        },
        drawPrevMonth: function(_0x44d4x1) {
            if (null === this['globals']['swipeTimeout']) {
                var _0x44d4x2 = this;
                this['globals']['swipeTimeout'] = setTimeout(function() {
                    var _0x44d4x1 = _0x44d4x2['calendars']['get'](0)['scrollTop'];
                    !0 === _0x44d4x2['config']['onbeforemonthchange'](_0x44d4x2, _0x44d4x2['globals']['currentDate']['startOf']('month'), 'prev') && (_0x44d4x2['globals']['currentDate']['subtract'](1, 'month'), _0x44d4x2['reDrawCalendars'](), _0x44d4x2['config']['onaftermonthchange'](_0x44d4x2, _0x44d4x2['globals']['currentDate']['startOf']('month'))), _0x44d4x2['calendars']['get'](0)['scrollTop'] = _0x44d4x1, _0x44d4x2['globals']['swipeTimeout'] = null
                }, 100)
            };
            _0x44d4x1 && 'function' == typeof _0x44d4x1['stopPropagation'] && _0x44d4x1['stopPropagation']()
        },
        cellClicked: function(_0x44d4x3) {
            _0x44d4x3 = _0x44d4x3 || _0x44d4x2['event'], _0x44d4x3['target'] = _0x44d4x3['target'] || _0x44d4x3['srcElement'], !1 === _0x44d4x1(_0x44d4x3['target'])['hasClass']('soluzinkCldr-day') && (_0x44d4x3['target'] = _0x44d4x1(_0x44d4x3['target'])['closest']('.soluzinkCldr-day')['get'](0));
			var _0x44d4x4 = _0x44d4x1(_0x44d4x3['target'])['data']('value'),
                _0x44d4x5 = moment['unix'](_0x44d4x4);
            if (!1 === this['config']['singleDate']) { //for date ranges
                if (!1 === this['globals']['startSelected']) {
                    this['globals']['startDateBackup'] = this['config']['startDate']['clone'](), this['config']['startDate'] = _0x44d4x5, this['config']['endDate'] = null, this['globals']['startSelected'] = !0, this['globals']['endSelected'] = !1, void(0) !== this['footer'] && this['footer']['find']('.soluzinkCldr-apply')['attr']('disabled', 'disabled'), this['config']['onfirstselect'](this, this['config']['startDate'])
                } else {
                    if (_0x44d4x5['isBefore'](this['config']['startDate'])) {
                        var _0x44d4x6 = this['config']['startDate']['clone']();
                        this['config']['startDate'] = _0x44d4x5['clone'](), _0x44d4x5 = _0x44d4x6
                    };
                    this['globals']['startDateBackup'] = null, this['config']['endDate'] = _0x44d4x5, this['globals']['endSelected'] = !0, this['globals']['startSelected'] = !1, this['globals']['hoverDate'] = null, !1 === this['globals']['isMobile'] ? !0 === this['config']['onbeforeselect'](this, this['config']['startDate'], this['config']['endDate']) && !0 === this['checkRangeContinuity']() ? (this['globals']['firstValueSelected'] = !0, this['updateInput'](!0), this['config']['autoCloseOnSelect'] && !1 === this['config']['inline'] && this['hideDropdown'](null)) : this['fetchInputs']() : !1 === this['checkRangeContinuity']() ? this['fetchInputs']() : this['updateInput'](!1), void(0) !== this['footer'] && this['footer']['find']('.soluzinkCldr-apply')['removeAttr']('disabled')
                }
            } else {
                this['config']['startDate'] = _0x44d4x5,
				this['config']['endDate'] = _0x44d4x5,
				this['globals']['endSelected'] = !0,
				this['globals']['startSelected'] = !1,
				this['globals']['hoverDate'] = null,
				this['globals']['firstValueSelected'] = !0;
				
				actualDayInfo['day'] = _0x44d4x3['currentTarget']['innerText'];
				actualDayInfo['dayName'] = langTranscription['CLNDR_DAY'][this['config']['startDate']['day']()];
				actualDayInfo['month'] = langTranscription['CLNDR_MONTH'][this['config']['startDate']['month']()];
				actualDayInfo['monthShort'] = langTranscription['CLNDR_MONTH_SHORT'][this['config']['startDate']['month']()];
				actualDayInfo['year'] = this['config']['endDate']['year']();
				!1 === this['globals']['isMobile'] ? (
					!0 === this['config']['onbeforeselect'](this, this['config']['startDate'], this['config']['endDate'])
						? this['updateInput'](!0) : this['fetchInputs'](),
						this['config']['autoCloseOnSelect'] && !1 === this['config']['inline'] && this['hideDropdown'](null)) : this['updateInput'](!1);
						
						
						
            };
            this['reDrawCells']();
            this['updateHeader'](), _0x44d4x3 && 'function' == typeof _0x44d4x3['stopPropagation'] && _0x44d4x3['stopPropagation']();
            recentlyChangedDay = true;
            actualDayInfo['hour'] = ('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2);
            actualDayInfo['minute'] = ('0' + getTimeMinute(validatedDays[actualDayNumber][0])).slice(-2);
            actualDayInfo['lenght'] = getSessionDuration(validatedDays[actualDayNumber][0]);
            $('.soluzinkCldr-header-start-time').text(langTranscription['CLNDR_DAY_TXT'].replace('{{hour}}',actualDayInfo['hour']).replace('{{lenght}}',actualDayInfo['lenght']).replace('{{minute}}',actualDayInfo['minute'] + ' ' + ((actualDayInfo['hour'] < 12) ? langTranscription['CLNDR_DAY_MORNING'] : langTranscription['CLNDR_DAY_AFTERNOON'])));
            $(inputSelector).attr('data-sessionlenght',actualDayInfo['lenght']);
            if(validatedDays[actualDayNumber].length > 1)
            {
                $('.soluzinkCldr-hour-selected-prev').html(('0' + getTimeHour(validatedDays[actualDayNumber][validatedDays[actualDayNumber].length-1])).slice(-2));
                $('.soluzinkCldr-hour-selected').html(('0' + actualDayInfo['hour']).slice(-2));
                $('.soluzinkCldr-hour-selected-next').html(('0' + getTimeHour(validatedDays[actualDayNumber][1])).slice(-2));
            }
            else
            {
                $('.soluzinkCldr-hour-selected-prev').html(('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2));
                $('.soluzinkCldr-hour-selected').html(('0' + actualDayInfo['hour']).slice(-2));
                $('.soluzinkCldr-hour-selected-next').html(('0' + getTimeHour(validatedDays[actualDayNumber][0])).slice(-2));
            }
            var baseVal = parseInt(getTimeMinute(validatedDays[actualDayNumber][0]),10);
            var prevMinute = baseVal-1;
            var nextMinute = baseVal+1;
            $('.soluzinkCldr-minute-selected-prev').html((prevMinute !== 60) ? ((prevMinute !== -1) ? ('0' + prevMinute).slice(-2):59):('00').slice(-2));
            $('.soluzinkCldr-minute-selected').html(actualDayInfo['minute']);
            $('.soluzinkCldr-minute-selected-next').html((nextMinute !== 60) ? ((nextMinute !== -1) ? ('0' + nextMinute).slice(-2):59):('00').slice(-2));
            if($('.soluzinkCldr-selected').length)
            {
                $(inputSelector).val(moment.unix($('.soluzinkCldr-selected').attr('data-value')).format("DD/MM/YYYY") + ' ' + $('.soluzinkCldr-hour-selected').text() + ':' + $('.soluzinkCldr-minute-selected').text());
            }
        },
        checkRangeContinuity: function() {
            if (!1 === this['config']['continuous']) {
                return !0
            };
            for (var _0x44d4x2 = this['config']['endDate']['diff'](this['config']['startDate'], 'days'), _0x44d4x3 = moment(this['config']['startDate']), _0x44d4x4 = 0; _0x44d4x4 <= _0x44d4x2; _0x44d4x4++) {
                if (_0x44d4x1['grep'](this['config']['disabledRanges'], function(_0x44d4x1) {
                        return _0x44d4x3['isBetween'](_0x44d4x1['start'], _0x44d4x1['end'], 'day', '[]')
                    })['length'] > 0 || !0 === this['config']['disableDays'](_0x44d4x3)) {
                    return !1
                };
                _0x44d4x3['add'](1, 'days')
            };
            return !0
        },
        cellHovered: function(_0x44d4x3) {
            _0x44d4x3 = _0x44d4x3 || _0x44d4x2['event'], _0x44d4x3['target'] = _0x44d4x3['target'] || _0x44d4x3['srcElement'], !1 === _0x44d4x1(_0x44d4x3['target'])['hasClass']('soluzinkCldr-day') && (_0x44d4x3['target'] = _0x44d4x1(_0x44d4x3['target'])['closest']('.soluzinkCldr-day')['get'](0));
            var _0x44d4x4 = _0x44d4x1(_0x44d4x3['target'])['data']('value');
            this['globals']['hoverDate'] = moment['unix'](_0x44d4x4), !0 === this['globals']['startSelected'] && this['reDrawCells'](), _0x44d4x3 && 'function' == typeof _0x44d4x3['stopPropagation'] && _0x44d4x3['stopPropagation']()
        },
        reDrawCalendars: function() {
            this['input']['empty'](), this['drawUserInterface']()
        },
        monthSwitchClicked: function() {
            var _0x44d4x2 = this;
            this['calendars']['get'](0)['scrollTop'] = 0;
            for (var _0x44d4x3 = _0x44d4x1('<div class=\'soluzinkCldr-month-selector\'></div>')['appendTo'](this['calendars']), _0x44d4x4 = this['globals']['currentDate']['get']('month'), _0x44d4x5 = 0; _0x44d4x5 < 12; _0x44d4x5++) {
                _0x44d4x3['append']('<div class=\'soluzinkCldr-ms-month' + (_0x44d4x4 == _0x44d4x5 ? ' current' : '') + '\' data-month=\'' + _0x44d4x5 + '\'>' + langTranscription['CLNDR_MONTH'][_0x44d4x5] + '</div>');
            };
            _0x44d4x3['slideDown'](300)['css']('display', 'flex'), _0x44d4x3['find']('.soluzinkCldr-ms-month')['off']('click')['on']('click', function(_0x44d4x3) {
                _0x44d4x2['globals']['currentDate']['set']('month', _0x44d4x1(this)['data']('month')), _0x44d4x2['calendars']['find']('.soluzinkCldr-month-selector')['remove'](), _0x44d4x2['reDrawCalendars'](), _0x44d4x3['stopPropagation']()
            })
        },
        yearSwitchClicked: function() {
            var _0x44d4x2 = this;
            this['calendars']['get'](0)['scrollTop'] = 0;
            for (var _0x44d4x3 = _0x44d4x1('<div class=\'soluzinkCldr-year-selector\'></div>')['appendTo'](this['calendars']), _0x44d4x4 = this['globals']['currentDate']['get']('year'), _0x44d4x5 = _0x44d4x4 - 7; _0x44d4x5 < _0x44d4x4 + 8; _0x44d4x5++) {
                _0x44d4x3['append']('<div class=\'soluzinkCldr-ys-year' + (_0x44d4x4 == _0x44d4x5 ? ' current' : '') + '\' data-year=\'' + _0x44d4x5 + '\'>' + _0x44d4x5 + '</div>')
            };
            _0x44d4x3['slideDown'](300)['css']('display', 'flex'), _0x44d4x3['find']('.soluzinkCldr-ys-year')['off']('click')['on']('click', function(_0x44d4x3) {
                _0x44d4x2['globals']['currentDate']['set']('year', _0x44d4x1(this)['data']('year')), _0x44d4x2['calendars']['find']('.soluzinkCldr-year-selector')['remove'](), _0x44d4x2['reDrawCalendars'](), _0x44d4x3['stopPropagation']()
            })
        },
        hideDropdown: function(_0x44d4x3) {
            if (null === _0x44d4x3 || (_0x44d4x3 = _0x44d4x3 || _0x44d4x2['event'], _0x44d4x3['target'] = _0x44d4x3['target'] || _0x44d4x3['srcElement'], this['globals']['initiator'] !== _0x44d4x3['target'])) {
                return this['input']['is'](':visible') && (this['config']['onbeforehide'](this), this['globals']['isMobile'] ? (this['input']['css']({
                    display: 'none'
                }), _0x44d4x1('body')['removeClass']('soluzinkCldr-open')) : this['container']['css']({
                    display: 'none'
                }), this['globals']['hoverDate'] = null, null !== this['globals']['startDateBackup'] && (this['config']['startDate'] = this['globals']['startDateBackup'], this['globals']['startSelected'] = !1), this['config']['onafterhide'](this)), !1
            }
        },
        showDropdown: function(_0x44d4x3) {
            return _0x44d4x3 = _0x44d4x3 || _0x44d4x2['event'], _0x44d4x3['target'] = _0x44d4x3['target'] || _0x44d4x3['srcElement'], this['input']['is'](':visible') || (_0x44d4x3['target'] !== this['elem'] && (this['globals']['dontHideOnce'] = !0, this['globals']['initiator'] = _0x44d4x3['target']), this['fetchInputs'](), this['globals']['startDateInitial'] = this['config']['startDate']['clone'](), this['globals']['endDateInitial'] = this['config']['endDate']['clone'](), this['reDrawCalendars'](), this['config']['onbeforeshow'](this), this['globals']['isMobile'] ? (this['input']['css']({
                display: 'flex'
            }), _0x44d4x1('body')['addClass']('soluzinkCldr-open')) : this['container']['css']({
                display: 'block'
            }), this['setViewport'](), this['config']['onaftershow'](this)), !1
        },
        reDrawCells: function() {
            getValidHours(this['config']['psicoCode']);
            var dateStamp = '';
            if(Array.isArray(validWeeklyDays))
            {
                validWeeklyDaysFixed = validWeeklyDays.map(function(arr) {
                    return arr.slice();
                });
                for (var _0x44d4x2 = this, _0x44d4x3 = this['container']['find']('.soluzinkCldr-day, .soluzinkCldr-disabled'), _0x44d4x4 = 0; _0x44d4x4 < _0x44d4x3['length']; _0x44d4x4++) {
                    var _0x44d4x5 = _0x44d4x3[_0x44d4x4],
                        _0x44d4x6 = _0x44d4x1(_0x44d4x5),
                        _0x44d4x7 = _0x44d4x6['attr']('data-value'),
                        actualDaySetInfo = moment(moment.unix(_0x44d4x7).format('YYYY-MM-DD')).day(),
                        dateStamp = moment.unix(_0x44d4x7).format('YYYY-MM-DD'),
                        _0x44d4x8 = moment['unix'](_0x44d4x7)['locale'](_0x44d4x2['config']['locale']),
                        _0x44d4x9 = _0x44d4x8['day'](),
                        _0x44d4xa = '';

                    var actualDayDate = moment.unix(_0x44d4x7).format("DD/MM/YYYY");
                for(i = 0; i < Object.keys(invalidWeeklyDays).length; i++)
                {
                    if(actualDayDate == Object.keys(invalidWeeklyDays)[i])
                    {
                        for(a = 0; a < validWeeklyDaysFixed[actualDaySetInfo].length; a++)
                        {
                            var fixedHours = validWeeklyDaysFixed[actualDaySetInfo][a].split('--')[0].split('.');
                            if(!(1 in fixedHours))
                            {
                                fixedHours[1] = '00';
                            }
                            if(('0' + fixedHours[0]).slice(-2) + ':' + ('0' + fixedHours[1]).slice(-2) === invalidWeeklyDays[actualDayDate][i])
                            {
                                validWeeklyDaysFixed[actualDaySetInfo].splice(a, 1);
                            }
                        }
                    }
                }
                if (validWeeklyDaysFixed.sort().join('|') !== validWeeklyDays.sort().join('|')) 
                {
                    validatedDays = validWeeklyDaysFixed;
                }
                else
                {
                    validatedDays = validWeeklyDays;
                }
                                    if(!moment()['isBefore'](_0x44d4x8, 'day') && !moment()['isSame'](_0x44d4x8, 'day'))
                                    {
                                        _0x44d4xa += ' soluzinkCldr-disabled';
                                    }
                                    else
                                    {
                            if(validatedDays[actualDaySetInfo].length == 0 || _0x44d4x7 > maxDateTimestamp)
                            {
                                _0x44d4xa += ' soluzinkCldr-disabled';
                            }
                            else
                            {
                                _0x44d4xa = 'soluzinkCldr-day';
                                6 != _0x44d4x9 && 0 !== _0x44d4x9 || (_0x44d4xa += ' soluzinkCldr-weekend'), moment()['isSame'](_0x44d4x8, 'day') && (_0x44d4xa += ' soluzinkCldr-today'), !1 === _0x44d4x2['config']['singleDate'] && null !== _0x44d4x2['config']['startDate'] && _0x44d4x2['config']['startDate']['isSame'](_0x44d4x8, 'day') && (_0x44d4xa += ' soluzinkCldr-start'), !1 === _0x44d4x2['config']['singleDate'] && null !== _0x44d4x2['config']['endDate'] && _0x44d4x2['config']['endDate']['isSame'](_0x44d4x8, 'day') && (_0x44d4xa += ' soluzinkCldr-end'), !1 === _0x44d4x2['config']['singleDate'] && null !== _0x44d4x2['config']['startDate'] && null !== _0x44d4x2['config']['endDate'] && _0x44d4x8['isBetween'](_0x44d4x2['config']['startDate'], _0x44d4x2['config']['endDate'], 'day', '[]') && (_0x44d4xa += ' soluzinkCldr-selected'), !0 === _0x44d4x2['config']['singleDate'] && null !== _0x44d4x2['config']['startDate'] && _0x44d4x2['config']['startDate']['isSame'](_0x44d4x8, 'day') && (_0x44d4xa += ' soluzinkCldr-selected'), !0 === _0x44d4x2['globals']['startSelected'] && !1 === _0x44d4x2['globals']['endSelected'] && null !== _0x44d4x2['globals']['hoverDate'] && (_0x44d4x8['isBetween'](_0x44d4x2['globals']['hoverDate'], _0x44d4x2['config']['startDate'], 'day', '[]') || _0x44d4x8['isBetween'](_0x44d4x2['config']['startDate'], _0x44d4x2['globals']['hoverDate'], 'day', '[]')) && (_0x44d4xa += ' soluzinkCldr-hovered');
                            }
                    }
                                    var _0x44d4xb = _0x44d4x2['config']['disabledRanges']['length'] > 0 && _0x44d4x1['grep'](_0x44d4x2['config']['disabledRanges'], function(_0x44d4x1) {
                        return _0x44d4x8['isBetween'](_0x44d4x1['start'], _0x44d4x1['end'], 'day', '[]')
                    })['length'] > 0 || !0 === _0x44d4x2['config']['disableDays'](_0x44d4x8);
                    (_0x44d4xb || _0x44d4x8['month']() != _0x44d4x6['closest']('.soluzinkCldr-calendar')['data']('month') || null !== _0x44d4x2['config']['maxDate'] && _0x44d4x8['isAfter'](_0x44d4x2['config']['maxDate'], 'day') || null !== _0x44d4x2['config']['minDate'] && _0x44d4x8['isBefore'](_0x44d4x2['config']['minDate'], 'day')) && (_0x44d4xa = 'soluzinkCldr-disabled'), _0x44d4xb && (_0x44d4xa += ' soluzinkCldr-disabled-range'), _0x44d4x6['attr']('class', _0x44d4xa)
                };
                            _0x44d4x7['value'] = getTimeHour(validatedDays[actualDayNumber][0]);
                this['attachEvents'](), this['config']['ondraw'](this);
                if($(this['container']['find']('.soluzinkCldr-selected')[0]).text() != '' && $(this['container']['find']('.soluzinkCldr-selected')[0]).text() != null)
                {
                    actualDayNumber = moment(moment.unix($(this['container']['find']('.soluzinkCldr-selected')[0]).attr('data-value')).format('YYYY-MM-DD')).day();
                    firstIteration = false;
                }
                else if(firstIteration)
                {
                    $(this['container']['find']('.soluzinkCldr-day')[0]).addClass('soluzinkCldr-selected');
                    actualDayNumber = moment(moment.unix($(this['container']['find']('.soluzinkCldr-selected')[0]).attr('data-value')).format('YYYY-MM-DD')).day();
                }
            }
        },
        rangeClicked: function(_0x44d4x3) {
            if (_0x44d4x3 = _0x44d4x3 || _0x44d4x2['event'], _0x44d4x3['target'] = _0x44d4x3['target'] || _0x44d4x3['srcElement'], !1 === _0x44d4x1(_0x44d4x3['target'])['hasClass']('soluzinkCldr-range') && (_0x44d4x3['target'] = _0x44d4x1(_0x44d4x3['target'])['closest']('.soluzinkCldr-range')['get'](0)), _0x44d4x3['target']['hasAttribute']('data-id')) {
                var _0x44d4x4 = _0x44d4x1(_0x44d4x3['target'])['attr']('data-id');
                this['globals']['currentDate'] = this['config']['ranges'][_0x44d4x4]['startDate']['clone']()['locale'](this['config']['locale']), this['config']['startDate'] = this['config']['ranges'][_0x44d4x4]['startDate']['clone']()['locale'](this['config']['locale']), this['config']['endDate'] = this['config']['ranges'][_0x44d4x4]['endDate']['clone'](), !1 === this['checkRangeContinuity']() ? this['fetchInputs']() : (this['config']['onrangeselect'](this, this['config']['ranges'][_0x44d4x4]), this['reDrawCalendars'](), this['config']['inline'] || this['setViewport']()), _0x44d4x3 && 'function' == typeof _0x44d4x3['stopPropagation'] && _0x44d4x3['stopPropagation']()
            }
        },
        setViewport: function() {
            if (!0 === this['globals']['isMobile']) {
                _0x44d4x1(_0x44d4x2)['off']('resize.soluzinkCldr')['on']('resize.soluzinkCldr', _0x44d4x1['proxy'](function() {
                    if (_0x44d4x1(_0x44d4x2)['width']() < _0x44d4x1(_0x44d4x2)['height']()) {
                        this['input']['removeClass']('soluzinkCldr-input-top-reset');
                        var _0x44d4x3 = this['input']['find']('.soluzinkCldr-calendar:visible:first')['innerHeight']();
                        _0x44d4x3 > this['input']['find']('.soluzinkCldr-calendars')['height']() ? this['input']['find']('.soluzinkCldr-calendars')['css']('min-height', _0x44d4x3) : this['input']['find']('.soluzinkCldr-calendars')['css']('max-height', _0x44d4x3), this['input']['position']()['top'] < 0 && this['input']['addClass']('soluzinkCldr-input-top-reset')
                    } else {
                        this['input']['find']('.soluzinkCldr-calendars')['css']('min-height', '0px')['css']('max-height', '99999px')
                    };
                    this['fetchTimePickerValues']()
                }, this)), _0x44d4x1(_0x44d4x2)['resize']()
            } else {
                var _0x44d4x3 = {
                        top: _0x44d4x2['scrollY'] || _0x44d4x2['pageYOffset'],
                        left: _0x44d4x2['scrollX'] || _0x44d4x2['pageXOffset'],
                        bottom: (_0x44d4x2['scrollY'] || _0x44d4x2['pageYOffset']) + _0x44d4x2['innerHeight'],
                        right: (_0x44d4x2['scrollX'] || _0x44d4x2['pageXOffset']) + _0x44d4x2['innerWidth']
                    },
                    _0x44d4x4 = this['getDimensions'](this.$elem, !0),
                    _0x44d4x5 = this['getDimensions'](this['container'], !0);
                'top' == this['config']['showOn'] && _0x44d4x4['offsetTop'] - _0x44d4x5['height'] < _0x44d4x3['top'] || 'top' != this['config']['showOn'] && _0x44d4x4['offsetTop'] + _0x44d4x4['height'] + _0x44d4x5['height'] < _0x44d4x3['bottom'] ? (this['container']['css']('top', _0x44d4x4['offsetTop'] + _0x44d4x4['height'] + 8), this['container']['find']('.soluzinkCldr-box-arrow-bottom')['removeClass']('soluzinkCldr-box-arrow-bottom')['addClass']('soluzinkCldr-box-arrow-top')) : (this['container']['css']('top', _0x44d4x4['offsetTop'] - _0x44d4x5['height'] - 8), this['container']['find']('.soluzinkCldr-box-arrow-top')['removeClass']('soluzinkCldr-box-arrow-top')['addClass']('soluzinkCldr-box-arrow-bottom')), _0x44d4x4['offsetLeft'] + _0x44d4x5['width'] > _0x44d4x3['right'] ? this['container']['css']('left', _0x44d4x3['right'] - _0x44d4x5['width']) : _0x44d4x4['offsetLeft'] < _0x44d4x3['left'] ? this['container']['css']('left', _0x44d4x3['left']) : this['container']['css']('left', _0x44d4x4['offsetLeft'] - 10), this['container']['find']('.soluzinkCldr-box-arrow-top, .soluzinkCldr-box-arrow-bottom')['css']('margin-left', _0x44d4x4['offsetLeft'] - parseInt(this['container']['css']('left'), 10))
            };
            this['fetchTimePickerValues']()
        },
        getDimensions: function(_0x44d4x1, _0x44d4x2) {
            return {
                width: _0x44d4x2 ? _0x44d4x1['outerWidth']() : _0x44d4x1['innerWidth'](),
                height: _0x44d4x2 ? _0x44d4x1['outerHeight']() : _0x44d4x1['innerHeight'](),
                offsetTop: _0x44d4x1['offset']()['top'],
                offsetLeft: _0x44d4x1['offset']()['left']
            }
        },
        attachEvents: function() {
            var _0x44d4x2 = _0x44d4x1['proxy'](this['drawNextMonth'], this),
                _0x44d4x3 = _0x44d4x1['proxy'](this['drawPrevMonth'], this),
                _0x44d4x4 = _0x44d4x1['proxy'](this['cellClicked'], this),
                _0x44d4x5 = _0x44d4x1['proxy'](this['cellHovered'], this),
                _0x44d4x6 = _0x44d4x1['proxy'](this['rangeClicked'], this),
                _0x44d4x7 = _0x44d4x1['proxy'](this['monthSwitchClicked'], this),
                _0x44d4x8 = _0x44d4x1['proxy'](this['yearSwitchClicked'], this);
            if (this['container']['find']('.soluzinkCldr-next')['off']('click')['one']('click', _0x44d4x2), this['container']['find']('.soluzinkCldr-prev')['off']('click')['one']('click', _0x44d4x3), this['container']['find']('.soluzinkCldr-day')['off']('click')['on']('click', _0x44d4x4), this['container']['find']('.soluzinkCldr-day')['off']('mouseover')['on']('mouseover', _0x44d4x5), this['container']['find']('.soluzinkCldr-disabled')['off']('click'), this['container']['find']('.soluzinkCldr-range')['off']('click')['on']('click', _0x44d4x6), this['container']['find']('.soluzinkCldr-month-switch ')['off']('click')['on']('click', _0x44d4x7), this['container']['find']('.soluzinkCldr-year-switch ')['off']('click')['on']('click', _0x44d4x8), !0 === this['globals']['isMobile']) {
                if ('function' == typeof _0x44d4x1['fn']['swiperight']) {
                    this['input']['find']('.soluzinkCldr-calendars')['css']('touch-action', 'none'), this['input']['find']('.soluzinkCldr-calendars')['on']('swipeleft', _0x44d4x2), this['input']['find']('.soluzinkCldr-calendars')['on']('swiperight', _0x44d4x3)
                } else {
                    var _0x44d4x9 = new Hammer(this['input']['find']('.soluzinkCldr-calendars')['get'](0));
                    _0x44d4x9['off']('swipeleft')['on']('swipeleft', _0x44d4x2), _0x44d4x9['off']('swiperight')['on']('swiperight', _0x44d4x3)
                };
                this['$elem']['off']('click')['on']('click', _0x44d4x1['proxy'](function(_0x44d4x1) {
                    this['showDropdown'](_0x44d4x1)
                }, this)), this['globals']['isMobile'] && (this['input']['find']('.soluzinkCldr-cancel')['off']('click')['on']('click', _0x44d4x1['proxy'](function(_0x44d4x1) {
                    this['config']['startDate'] = this['globals']['startDateInitial']['clone'](), this['config']['endDate'] = this['globals']['endDateInitial']['clone'](), this['fetchTimePickerValues'](), this['updateInput'](!1), this['hideDropdown'](_0x44d4x1)
                }, this)), this['input']['find']('.soluzinkCldr-apply')['off']('click')['on']('click', _0x44d4x1['proxy'](function(_0x44d4x1) {
                    this['config']['startDate'] = this['config']['startDate'] || moment(), this['config']['endDate'] = this['config']['endDate'] || moment(), !0 === this['config']['onbeforeselect'](this, this['config']['startDate'], this['config']['endDate']) && !0 === this['checkRangeContinuity']() ? (this['globals']['firstValueSelected'] = !0, this['updateInput'](!0)) : this['fetchInputs'](), this['hideDropdown'](_0x44d4x1)
                }, this)))
            }
        },
        addInitialEvents: function() {
            !1 === this['globals']['isMobile'] && !1 === this['config']['inline'] && (_0x44d4x1(_0x44d4x3)['on']('click', _0x44d4x1['proxy'](function(_0x44d4x3) {
                _0x44d4x3 = _0x44d4x3 || _0x44d4x2['event'], _0x44d4x3['target'] = _0x44d4x3['target'] || _0x44d4x3['srcElement'], 0 === _0x44d4x1(this['container'])['find'](_0x44d4x1(_0x44d4x3['target']))['length'] && !_0x44d4x1(this['elem'])['is'](_0x44d4x3['target']) && _0x44d4x1(this['input'])['is'](':visible') && this['hideDropdown'](_0x44d4x3)
            }, this)), this['$elem']['on']('click', _0x44d4x1['proxy'](function(_0x44d4x1) {
                this['showDropdown'](_0x44d4x1), _0x44d4x1 && _0x44d4x1['hasOwnProperty']('stopPropagation') && (_0x44d4x1['stopPropagation'](), _0x44d4x1['preventDefault']())
            }, this)))
        },
        checkMobile: function() {
            return /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i ['test'](navigator['userAgent'] || navigator['vendor'] || _0x44d4x2['opera']) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i ['test']((navigator['userAgent'] || navigator['vendor'] || _0x44d4x2['opera'])['substr'](0, 4))
        }
    }, _0x44d4x5['defaults'] = _0x44d4x5['prototype']['defaults'], _0x44d4x1['fn']['soluzinkCldr'] = function(_0x44d4x1) {
        return this['each'](function() {
            new _0x44d4x5(this, _0x44d4x1)['init']()
        })
    }
}(jQuery, window, document),
function(_0x44d4x1, _0x44d4x2, _0x44d4x3, _0x44d4x4) {
    'use strict';

    function _0x44d4x5(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        return setTimeout(_0x44d4xa(_0x44d4x1, _0x44d4x3), _0x44d4x2)
    }

    function _0x44d4x6(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        return !!Array['isArray'](_0x44d4x1) && (_0x44d4x7(_0x44d4x1, _0x44d4x3[_0x44d4x2], _0x44d4x3), !0)
    }

    function _0x44d4x7(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        var _0x44d4x5;
        if (_0x44d4x1) {
            if (_0x44d4x1['forEach']) {
                _0x44d4x1['forEach'](_0x44d4x2, _0x44d4x3)
            } else {
                if (_0x44d4x1['length'] !== _0x44d4x4) {
                    for (_0x44d4x5 = 0; _0x44d4x5 < _0x44d4x1['length'];) {
                        _0x44d4x2['call'](_0x44d4x3, _0x44d4x1[_0x44d4x5], _0x44d4x5, _0x44d4x1), _0x44d4x5++
                    }
                } else {
                    for (_0x44d4x5 in _0x44d4x1) {
                        _0x44d4x1['hasOwnProperty'](_0x44d4x5) && _0x44d4x2['call'](_0x44d4x3, _0x44d4x1[_0x44d4x5], _0x44d4x5, _0x44d4x1)
                    }
                }
            }
        }
    }

    function _0x44d4x8(_0x44d4x2, _0x44d4x3, _0x44d4x4) {
        var _0x44d4x5 = 'DEPRECATED METHOD: ' + _0x44d4x3 + '\x0A' + _0x44d4x4 + ' AT \x0A';
        return function() {
            var _0x44d4x3 = new Error('get-stack-trace'),
                _0x44d4x4 = _0x44d4x3 && _0x44d4x3['stack'] ? _0x44d4x3['stack']['replace'](/^[^\(]+?[\n$]/gm, '')['replace'](/^\s+at\s+/gm, '')['replace'](/^Object.<anonymous>\s*\(/gm, '{anonymous}()@') : 'Unknown Stack Trace',
                _0x44d4x6 = _0x44d4x1['console'] && (_0x44d4x1['console']['warn'] || _0x44d4x1['console']['log']);
            return _0x44d4x6 && _0x44d4x6['call'](_0x44d4x1['console'], _0x44d4x5, _0x44d4x4), _0x44d4x2['apply'](this, arguments)
        }
    }

    function _0x44d4x9(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        var _0x44d4x4, _0x44d4x5 = _0x44d4x2['prototype'];
        _0x44d4x4 = _0x44d4x1['prototype'] = Object['create'](_0x44d4x5), _0x44d4x4['constructor'] = _0x44d4x1, _0x44d4x4['_super'] = _0x44d4x5, _0x44d4x3 && _0x44d4x42(_0x44d4x4, _0x44d4x3)
    }

    function _0x44d4xa(_0x44d4x1, _0x44d4x2) {
        return function() {
            return _0x44d4x1['apply'](_0x44d4x2, arguments)
        }
    }

    function _0x44d4xb(_0x44d4x1, _0x44d4x2) {
        return typeof _0x44d4x1 == _0x44d4x45 ? _0x44d4x1['apply'](_0x44d4x2 ? _0x44d4x2[0] || _0x44d4x4 : _0x44d4x4, _0x44d4x2) : _0x44d4x1
    }

    function _0x44d4xc(_0x44d4x1, _0x44d4x2) {
        return _0x44d4x1 === _0x44d4x4 ? _0x44d4x2 : _0x44d4x1
    }

    function _0x44d4xd(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        _0x44d4x7(_0x44d4x11(_0x44d4x2), function(_0x44d4x2) {
            _0x44d4x1['addEventListener'](_0x44d4x2, _0x44d4x3, !1)
        })
    }

    function _0x44d4xe(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        _0x44d4x7(_0x44d4x11(_0x44d4x2), function(_0x44d4x2) {
            _0x44d4x1['removeEventListener'](_0x44d4x2, _0x44d4x3, !1)
        })
    }

    function _0x44d4xf(_0x44d4x1, _0x44d4x2) {
        for (; _0x44d4x1;) {
            if (_0x44d4x1 == _0x44d4x2) {
                return !0
            };
            _0x44d4x1 = _0x44d4x1['parentNode']
        };
        return !1
    }

    function _0x44d4x10(_0x44d4x1, _0x44d4x2) {
        return _0x44d4x1['indexOf'](_0x44d4x2) > -1
    }

    function _0x44d4x11(_0x44d4x1) {
        return _0x44d4x1['trim']()['split'](/\s+/g)
    }

    function _0x44d4x12(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        if (_0x44d4x1['indexOf'] && !_0x44d4x3) {
            return _0x44d4x1['indexOf'](_0x44d4x2)
        };
        for (var _0x44d4x4 = 0; _0x44d4x4 < _0x44d4x1['length'];) {
            if (_0x44d4x3 && _0x44d4x1[_0x44d4x4][_0x44d4x3] == _0x44d4x2 || !_0x44d4x3 && _0x44d4x1[_0x44d4x4] === _0x44d4x2) {
                return _0x44d4x4
            };
            _0x44d4x4++
        };
        return -1
    }

    function _0x44d4x13(_0x44d4x1) {
        return Array['prototype']['slice']['call'](_0x44d4x1, 0)
    }

    function _0x44d4x14(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        for (var _0x44d4x4 = [], _0x44d4x5 = [], _0x44d4x6 = 0; _0x44d4x6 < _0x44d4x1['length'];) {
            var _0x44d4x7 = _0x44d4x2 ? _0x44d4x1[_0x44d4x6][_0x44d4x2] : _0x44d4x1[_0x44d4x6];
            _0x44d4x12(_0x44d4x5, _0x44d4x7) < 0 && _0x44d4x4['push'](_0x44d4x1[_0x44d4x6]), _0x44d4x5[_0x44d4x6] = _0x44d4x7, _0x44d4x6++
        };
        return _0x44d4x3 && (_0x44d4x4 = _0x44d4x2 ? _0x44d4x4['sort'](function(_0x44d4x1, _0x44d4x3) {
            return _0x44d4x1[_0x44d4x2] > _0x44d4x3[_0x44d4x2]
        }) : _0x44d4x4['sort']()), _0x44d4x4
    }

    function _0x44d4x15(_0x44d4x1, _0x44d4x2) {
        for (var _0x44d4x3, _0x44d4x5, _0x44d4x6 = _0x44d4x2[0]['toUpperCase']() + _0x44d4x2['slice'](1), _0x44d4x7 = 0; _0x44d4x7 < _0x44d4x43['length'];) {
            if (_0x44d4x3 = _0x44d4x43[_0x44d4x7], (_0x44d4x5 = _0x44d4x3 ? _0x44d4x3 + _0x44d4x6 : _0x44d4x2) in _0x44d4x1) {
                return _0x44d4x5
            };
            _0x44d4x7++
        };
        return _0x44d4x4
    }

    function _0x44d4x16() {
        return _0x44d4x4b++
    }

    function _0x44d4x17(_0x44d4x2) {
        var _0x44d4x3 = _0x44d4x2['ownerDocument'] || _0x44d4x2;
        return _0x44d4x3['defaultView'] || _0x44d4x3['parentWindow'] || _0x44d4x1
    }

    function _0x44d4x18(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3 = this;
        this['manager'] = _0x44d4x1, this['callback'] = _0x44d4x2, this['element'] = _0x44d4x1['element'], this['target'] = _0x44d4x1['options']['inputTarget'], this['domHandler'] = function(_0x44d4x2) {
            _0x44d4xb(_0x44d4x1['options']['enable'], [_0x44d4x1]) && _0x44d4x3['handler'](_0x44d4x2)
        }, this['init']()
    }

    function _0x44d4x19(_0x44d4x1) {
        var _0x44d4x2 = _0x44d4x1['options']['inputClass'];
        return new(_0x44d4x2 || (_0x44d4x4e ? _0x44d4x27 : _0x44d4x4f ? _0x44d4x2a : _0x44d4x4d ? _0x44d4x2c : _0x44d4x26))(_0x44d4x1, _0x44d4x1a)
    }

    function _0x44d4x1a(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        var _0x44d4x4 = _0x44d4x3['pointers']['length'],
            _0x44d4x5 = _0x44d4x3['changedPointers']['length'],
            _0x44d4x6 = _0x44d4x2 & _0x44d4x55 && _0x44d4x4 - _0x44d4x5 == 0,
            _0x44d4x7 = _0x44d4x2 & (_0x44d4x57 | _0x44d4x58) && _0x44d4x4 - _0x44d4x5 == 0;
        _0x44d4x3['isFirst'] = !!_0x44d4x6, _0x44d4x3['isFinal'] = !!_0x44d4x7, _0x44d4x6 && (_0x44d4x1['session'] = {}), _0x44d4x3['eventType'] = _0x44d4x2, _0x44d4x1b(_0x44d4x1, _0x44d4x3), _0x44d4x1['emit']('hammer.input', _0x44d4x3), _0x44d4x1['recognize'](_0x44d4x3), _0x44d4x1['session']['prevInput'] = _0x44d4x3
    }

    function _0x44d4x1b(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3 = _0x44d4x1['session'],
            _0x44d4x4 = _0x44d4x2['pointers'],
            _0x44d4x5 = _0x44d4x4['length'];
        _0x44d4x3['firstInput'] || (_0x44d4x3['firstInput'] = _0x44d4x1e(_0x44d4x2)), _0x44d4x5 > 1 && !_0x44d4x3['firstMultiple'] ? _0x44d4x3['firstMultiple'] = _0x44d4x1e(_0x44d4x2) : 1 === _0x44d4x5 && (_0x44d4x3['firstMultiple'] = !1);
        var _0x44d4x6 = _0x44d4x3['firstInput'],
            _0x44d4x7 = _0x44d4x3['firstMultiple'],
            _0x44d4x8 = _0x44d4x7 ? _0x44d4x7['center'] : _0x44d4x6['center'],
            _0x44d4x9 = _0x44d4x2['center'] = _0x44d4x1f(_0x44d4x4);
        _0x44d4x2['timeStamp'] = _0x44d4x48(), _0x44d4x2['deltaTime'] = _0x44d4x2['timeStamp'] - _0x44d4x6['timeStamp'], _0x44d4x2['angle'] = _0x44d4x23(_0x44d4x8, _0x44d4x9), _0x44d4x2['distance'] = _0x44d4x22(_0x44d4x8, _0x44d4x9), _0x44d4x1c(_0x44d4x3, _0x44d4x2), _0x44d4x2['offsetDirection'] = _0x44d4x21(_0x44d4x2['deltaX'], _0x44d4x2['deltaY']);
        var _0x44d4xa = _0x44d4x20(_0x44d4x2['deltaTime'], _0x44d4x2['deltaX'], _0x44d4x2['deltaY']);
        _0x44d4x2['overallVelocityX'] = _0x44d4xa['x'], _0x44d4x2['overallVelocityY'] = _0x44d4xa['y'], _0x44d4x2['overallVelocity'] = _0x44d4x47(_0x44d4xa['x']) > _0x44d4x47(_0x44d4xa['y']) ? _0x44d4xa['x'] : _0x44d4xa['y'], _0x44d4x2['scale'] = _0x44d4x7 ? _0x44d4x25(_0x44d4x7['pointers'], _0x44d4x4) : 1, _0x44d4x2['rotation'] = _0x44d4x7 ? _0x44d4x24(_0x44d4x7['pointers'], _0x44d4x4) : 0, _0x44d4x2['maxPointers'] = _0x44d4x3['prevInput'] ? _0x44d4x2['pointers']['length'] > _0x44d4x3['prevInput']['maxPointers'] ? _0x44d4x2['pointers']['length'] : _0x44d4x3['prevInput']['maxPointers'] : _0x44d4x2['pointers']['length'], _0x44d4x1d(_0x44d4x3, _0x44d4x2);
        var _0x44d4xb = _0x44d4x1['element'];
        _0x44d4xf(_0x44d4x2['srcEvent']['target'], _0x44d4xb) && (_0x44d4xb = _0x44d4x2['srcEvent']['target']), _0x44d4x2['target'] = _0x44d4xb
    }

    function _0x44d4x1c(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3 = _0x44d4x2['center'],
            _0x44d4x4 = _0x44d4x1['offsetDelta'] || {},
            _0x44d4x5 = _0x44d4x1['prevDelta'] || {},
            _0x44d4x6 = _0x44d4x1['prevInput'] || {};
        _0x44d4x2['eventType'] !== _0x44d4x55 && _0x44d4x6['eventType'] !== _0x44d4x57 || (_0x44d4x5 = _0x44d4x1['prevDelta'] = {
            x: _0x44d4x6['deltaX'] || 0,
            y: _0x44d4x6['deltaY'] || 0
        }, _0x44d4x4 = _0x44d4x1['offsetDelta'] = {
            x: _0x44d4x3['x'],
            y: _0x44d4x3['y']
        }), _0x44d4x2['deltaX'] = _0x44d4x5['x'] + (_0x44d4x3['x'] - _0x44d4x4['x']), _0x44d4x2['deltaY'] = _0x44d4x5['y'] + (_0x44d4x3['y'] - _0x44d4x4['y'])
    }

    function _0x44d4x1d(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3, _0x44d4x5, _0x44d4x6, _0x44d4x7, _0x44d4x8 = _0x44d4x1['lastInterval'] || _0x44d4x2,
            _0x44d4x9 = _0x44d4x2['timeStamp'] - _0x44d4x8['timeStamp'];
        if (_0x44d4x2['eventType'] != _0x44d4x58 && (_0x44d4x9 > _0x44d4x54 || _0x44d4x8['velocity'] === _0x44d4x4)) {
            var _0x44d4xa = _0x44d4x2['deltaX'] - _0x44d4x8['deltaX'],
                _0x44d4xb = _0x44d4x2['deltaY'] - _0x44d4x8['deltaY'],
                _0x44d4xc = _0x44d4x20(_0x44d4x9, _0x44d4xa, _0x44d4xb);
            _0x44d4x5 = _0x44d4xc['x'], _0x44d4x6 = _0x44d4xc['y'], _0x44d4x3 = _0x44d4x47(_0x44d4xc['x']) > _0x44d4x47(_0x44d4xc['y']) ? _0x44d4xc['x'] : _0x44d4xc['y'], _0x44d4x7 = _0x44d4x21(_0x44d4xa, _0x44d4xb), _0x44d4x1['lastInterval'] = _0x44d4x2
        } else {
            _0x44d4x3 = _0x44d4x8['velocity'], _0x44d4x5 = _0x44d4x8['velocityX'], _0x44d4x6 = _0x44d4x8['velocityY'], _0x44d4x7 = _0x44d4x8['direction']
        };
        _0x44d4x2['velocity'] = _0x44d4x3, _0x44d4x2['velocityX'] = _0x44d4x5, _0x44d4x2['velocityY'] = _0x44d4x6, _0x44d4x2['direction'] = _0x44d4x7
    }

    function _0x44d4x1e(_0x44d4x1) {
        for (var _0x44d4x2 = [], _0x44d4x3 = 0; _0x44d4x3 < _0x44d4x1['pointers']['length'];) {
            _0x44d4x2[_0x44d4x3] = {
                clientX: _0x44d4x46(_0x44d4x1['pointers'][_0x44d4x3]['clientX']),
                clientY: _0x44d4x46(_0x44d4x1['pointers'][_0x44d4x3]['clientY'])
            }, _0x44d4x3++
        };
        return {
            timeStamp: _0x44d4x48(),
            pointers: _0x44d4x2,
            center: _0x44d4x1f(_0x44d4x2),
            deltaX: _0x44d4x1['deltaX'],
            deltaY: _0x44d4x1['deltaY']
        }
    }

    function _0x44d4x1f(_0x44d4x1) {
        var _0x44d4x2 = _0x44d4x1['length'];
        if (1 === _0x44d4x2) {
            return {
                x: _0x44d4x46(_0x44d4x1[0]['clientX']),
                y: _0x44d4x46(_0x44d4x1[0]['clientY'])
            }
        };
        for (var _0x44d4x3 = 0, _0x44d4x4 = 0, _0x44d4x5 = 0; _0x44d4x5 < _0x44d4x2;) {
            _0x44d4x3 += _0x44d4x1[_0x44d4x5]['clientX'], _0x44d4x4 += _0x44d4x1[_0x44d4x5]['clientY'], _0x44d4x5++
        };
        return {
            x: _0x44d4x46(_0x44d4x3 / _0x44d4x2),
            y: _0x44d4x46(_0x44d4x4 / _0x44d4x2)
        }
    }

    function _0x44d4x20(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        return {
            x: _0x44d4x2 / _0x44d4x1 || 0,
            y: _0x44d4x3 / _0x44d4x1 || 0
        }
    }

    function _0x44d4x21(_0x44d4x1, _0x44d4x2) {
        return _0x44d4x1 === _0x44d4x2 ? _0x44d4x59 : _0x44d4x47(_0x44d4x1) >= _0x44d4x47(_0x44d4x2) ? _0x44d4x1 < 0 ? _0x44d4x5a : _0x44d4x5b : _0x44d4x2 < 0 ? _0x44d4x5c : _0x44d4x5d
    }

    function _0x44d4x22(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        _0x44d4x3 || (_0x44d4x3 = _0x44d4x61);
        var _0x44d4x4 = _0x44d4x2[_0x44d4x3[0]] - _0x44d4x1[_0x44d4x3[0]],
            _0x44d4x5 = _0x44d4x2[_0x44d4x3[1]] - _0x44d4x1[_0x44d4x3[1]];
        return Math['sqrt'](_0x44d4x4 * _0x44d4x4 + _0x44d4x5 * _0x44d4x5)
    }

    function _0x44d4x23(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
        _0x44d4x3 || (_0x44d4x3 = _0x44d4x61);
        var _0x44d4x4 = _0x44d4x2[_0x44d4x3[0]] - _0x44d4x1[_0x44d4x3[0]],
            _0x44d4x5 = _0x44d4x2[_0x44d4x3[1]] - _0x44d4x1[_0x44d4x3[1]];
        return 180 * Math['atan2'](_0x44d4x5, _0x44d4x4) / Math['PI']
    }

    function _0x44d4x24(_0x44d4x1, _0x44d4x2) {
        return _0x44d4x23(_0x44d4x2[1], _0x44d4x2[0], _0x44d4x62) + _0x44d4x23(_0x44d4x1[1], _0x44d4x1[0], _0x44d4x62)
    }

    function _0x44d4x25(_0x44d4x1, _0x44d4x2) {
        return _0x44d4x22(_0x44d4x2[0], _0x44d4x2[1], _0x44d4x62) / _0x44d4x22(_0x44d4x1[0], _0x44d4x1[1], _0x44d4x62)
    }

    function _0x44d4x26() {
        this['evEl'] = _0x44d4x64, this['evWin'] = _0x44d4x65, this['pressed'] = !1, _0x44d4x18['apply'](this, arguments)
    }

    function _0x44d4x27() {
        this['evEl'] = _0x44d4x68, this['evWin'] = _0x44d4x69, _0x44d4x18['apply'](this, arguments), this['store'] = this['manager']['session']['pointerEvents'] = []
    }

    function _0x44d4x28() {
        this['evTarget'] = _0x44d4x6b, this['evWin'] = _0x44d4x6c, this['started'] = !1, _0x44d4x18['apply'](this, arguments)
    }

    function _0x44d4x29(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3 = _0x44d4x13(_0x44d4x1['touches']),
            _0x44d4x4 = _0x44d4x13(_0x44d4x1['changedTouches']);
        return _0x44d4x2 & (_0x44d4x57 | _0x44d4x58) && (_0x44d4x3 = _0x44d4x14(_0x44d4x3['concat'](_0x44d4x4), 'identifier', !0)), [_0x44d4x3, _0x44d4x4]
    }

    function _0x44d4x2a() {
        this['evTarget'] = _0x44d4x6e, this['targetIds'] = {}, _0x44d4x18['apply'](this, arguments)
    }

    function _0x44d4x2b(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3 = _0x44d4x13(_0x44d4x1['touches']),
            _0x44d4x4 = this['targetIds'];
        if (_0x44d4x2 & (_0x44d4x55 | _0x44d4x56) && 1 === _0x44d4x3['length']) {
            return _0x44d4x4[_0x44d4x3[0]['identifier']] = !0, [_0x44d4x3, _0x44d4x3]
        };
        var _0x44d4x5, _0x44d4x6, _0x44d4x7 = _0x44d4x13(_0x44d4x1['changedTouches']),
            _0x44d4x8 = [],
            _0x44d4x9 = this['target'];
        if (_0x44d4x6 = _0x44d4x3['filter'](function(_0x44d4x1) {
                return _0x44d4xf(_0x44d4x1['target'], _0x44d4x9)
            }), _0x44d4x2 === _0x44d4x55) {
            for (_0x44d4x5 = 0; _0x44d4x5 < _0x44d4x6['length'];) {
                _0x44d4x4[_0x44d4x6[_0x44d4x5]['identifier']] = !0, _0x44d4x5++
            }
        };
        for (_0x44d4x5 = 0; _0x44d4x5 < _0x44d4x7['length'];) {
            _0x44d4x4[_0x44d4x7[_0x44d4x5]['identifier']] && _0x44d4x8['push'](_0x44d4x7[_0x44d4x5]), _0x44d4x2 & (_0x44d4x57 | _0x44d4x58) && delete _0x44d4x4[_0x44d4x7[_0x44d4x5]['identifier']], _0x44d4x5++
        };
        return _0x44d4x8['length'] ? [_0x44d4x14(_0x44d4x6['concat'](_0x44d4x8), 'identifier', !0), _0x44d4x8] : void(0)
    }

    function _0x44d4x2c() {
        _0x44d4x18['apply'](this, arguments);
        var _0x44d4x1 = _0x44d4xa(this['handler'], this);
        this['touch'] = new _0x44d4x2a(this['manager'], _0x44d4x1), this['mouse'] = new _0x44d4x26(this['manager'], _0x44d4x1), this['primaryTouch'] = null, this['lastTouches'] = []
    }

    function _0x44d4x2d(_0x44d4x1, _0x44d4x2) {
        _0x44d4x1 & _0x44d4x55 ? (this['primaryTouch'] = _0x44d4x2['changedPointers'][0]['identifier'], _0x44d4x2e['call'](this, _0x44d4x2)) : _0x44d4x1 & (_0x44d4x57 | _0x44d4x58) && _0x44d4x2e['call'](this, _0x44d4x2)
    }

    function _0x44d4x2e(_0x44d4x1) {
        var _0x44d4x2 = _0x44d4x1['changedPointers'][0];
        if (_0x44d4x2['identifier'] === this['primaryTouch']) {
            var _0x44d4x3 = {
                x: _0x44d4x2['clientX'],
                y: _0x44d4x2['clientY']
            };
            this['lastTouches']['push'](_0x44d4x3);
            var _0x44d4x4 = this['lastTouches'],
                _0x44d4x5 = function() {
                    var _0x44d4x1 = _0x44d4x4['indexOf'](_0x44d4x3);
                    _0x44d4x1 > -1 && _0x44d4x4['splice'](_0x44d4x1, 1)
                };
            setTimeout(_0x44d4x5, _0x44d4x6f)
        }
    }

    function _0x44d4x2f(_0x44d4x1) {
        for (var _0x44d4x2 = _0x44d4x1['srcEvent']['clientX'], _0x44d4x3 = _0x44d4x1['srcEvent']['clientY'], _0x44d4x4 = 0; _0x44d4x4 < this['lastTouches']['length']; _0x44d4x4++) {
            var _0x44d4x5 = this['lastTouches'][_0x44d4x4],
                _0x44d4x6 = Math['abs'](_0x44d4x2 - _0x44d4x5['x']),
                _0x44d4x7 = Math['abs'](_0x44d4x3 - _0x44d4x5['y']);
            if (_0x44d4x6 <= _0x44d4x70 && _0x44d4x7 <= _0x44d4x70) {
                return !0
            }
        };
        return !1
    }

    function _0x44d4x30(_0x44d4x1, _0x44d4x2) {
        this['manager'] = _0x44d4x1, this['set'](_0x44d4x2)
    }

    function _0x44d4x31(_0x44d4x1) {
        if (_0x44d4x10(_0x44d4x1, _0x44d4x76)) {
            return _0x44d4x76
        };
        var _0x44d4x2 = _0x44d4x10(_0x44d4x1, _0x44d4x77),
            _0x44d4x3 = _0x44d4x10(_0x44d4x1, _0x44d4x78);
        return _0x44d4x2 && _0x44d4x3 ? _0x44d4x76 : _0x44d4x2 || _0x44d4x3 ? _0x44d4x2 ? _0x44d4x77 : _0x44d4x78 : _0x44d4x10(_0x44d4x1, _0x44d4x75) ? _0x44d4x75 : _0x44d4x74
    }

    function _0x44d4x32() {
        if (!_0x44d4x72) {
            return !1
        };
        var _0x44d4x2 = {},
            _0x44d4x3 = _0x44d4x1['CSS'] && _0x44d4x1['CSS']['supports'];
        return ['auto', 'manipulation', 'pan-y', 'pan-x', 'pan-x pan-y', 'none']['forEach'](function(_0x44d4x4) {
            _0x44d4x2[_0x44d4x4] = !_0x44d4x3 || _0x44d4x1['CSS']['supports']('touch-action', _0x44d4x4)
        }), _0x44d4x2
    }

    function _0x44d4x33(_0x44d4x1) {
        this['options'] = _0x44d4x42({}, this['defaults'], _0x44d4x1 || {}), this['id'] = _0x44d4x16(), this['manager'] = null, this['options']['enable'] = _0x44d4xc(this['options']['enable'], !0), this['state'] = _0x44d4x7a, this['simultaneous'] = {}, this['requireFail'] = []
    }

    function _0x44d4x34(_0x44d4x1) {
        return _0x44d4x1 & _0x44d4x7f ? 'cancel' : _0x44d4x1 & _0x44d4x7d ? 'end' : _0x44d4x1 & _0x44d4x7c ? 'move' : _0x44d4x1 & _0x44d4x7b ? 'start' : ''
    }

    function _0x44d4x35(_0x44d4x1) {
        return _0x44d4x1 == _0x44d4x5d ? 'down' : _0x44d4x1 == _0x44d4x5c ? 'up' : _0x44d4x1 == _0x44d4x5a ? 'left' : _0x44d4x1 == _0x44d4x5b ? 'right' : ''
    }

    function _0x44d4x36(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3 = _0x44d4x2['manager'];
        return _0x44d4x3 ? _0x44d4x3['get'](_0x44d4x1) : _0x44d4x1
    }

    function _0x44d4x37() {
        _0x44d4x33['apply'](this, arguments)
    }

    function _0x44d4x38() {
        _0x44d4x37['apply'](this, arguments), this['pX'] = null, this['pY'] = null
    }

    function _0x44d4x39() {
        _0x44d4x37['apply'](this, arguments)
    }

    function _0x44d4x3a() {
        _0x44d4x33['apply'](this, arguments), this['_timer'] = null, this['_input'] = null
    }

    function _0x44d4x3b() {
        _0x44d4x37['apply'](this, arguments)
    }

    function _0x44d4x3c() {
        _0x44d4x37['apply'](this, arguments)
    }

    function _0x44d4x3d() {
        _0x44d4x33['apply'](this, arguments), this['pTime'] = !1, this['pCenter'] = !1, this['_timer'] = null, this['_input'] = null, this['count'] = 0
    }

    function _0x44d4x3e(_0x44d4x1, _0x44d4x2) {
        return _0x44d4x2 = _0x44d4x2 || {}, _0x44d4x2['recognizers'] = _0x44d4xc(_0x44d4x2['recognizers'], _0x44d4x3e['defaults']['preset']), new _0x44d4x3f(_0x44d4x1, _0x44d4x2)
    }

    function _0x44d4x3f(_0x44d4x1, _0x44d4x2) {
        this['options'] = _0x44d4x42({}, _0x44d4x3e['defaults'], _0x44d4x2 || {}), this['options']['inputTarget'] = this['options']['inputTarget'] || _0x44d4x1, this['handlers'] = {}, this['session'] = {}, this['recognizers'] = [], this['oldCssProps'] = {}, this['element'] = _0x44d4x1, this['input'] = _0x44d4x19(this), this['touchAction'] = new _0x44d4x30(this, this['options']['touchAction']), _0x44d4x40(this, !0), _0x44d4x7(this['options']['recognizers'], function(_0x44d4x1) {
            var _0x44d4x2 = this['add'](new _0x44d4x1[0](_0x44d4x1[1]));
            _0x44d4x1[2] && _0x44d4x2['recognizeWith'](_0x44d4x1[2]), _0x44d4x1[3] && _0x44d4x2['requireFailure'](_0x44d4x1[3])
        }, this)
    }

    function _0x44d4x40(_0x44d4x1, _0x44d4x2) {
        var _0x44d4x3 = _0x44d4x1['element'];
        if (_0x44d4x3['style']) {
            var _0x44d4x4;
            _0x44d4x7(_0x44d4x1['options']['cssProps'], function(_0x44d4x5, _0x44d4x6) {
                _0x44d4x4 = _0x44d4x15(_0x44d4x3['style'], _0x44d4x6), _0x44d4x2 ? (_0x44d4x1['oldCssProps'][_0x44d4x4] = _0x44d4x3['style'][_0x44d4x4], _0x44d4x3['style'][_0x44d4x4] = _0x44d4x5) : _0x44d4x3['style'][_0x44d4x4] = _0x44d4x1['oldCssProps'][_0x44d4x4] || ''
            }), _0x44d4x2 || (_0x44d4x1['oldCssProps'] = {})
        }
    }

    function _0x44d4x41(_0x44d4x1, _0x44d4x3) {
        var _0x44d4x4 = _0x44d4x2['createEvent']('Event');
        _0x44d4x4['initEvent'](_0x44d4x1, !0, !0), _0x44d4x4['gesture'] = _0x44d4x3, _0x44d4x3['target']['dispatchEvent'](_0x44d4x4)
    }
    var _0x44d4x42, _0x44d4x43 = ['', 'webkit', 'Moz', 'MS', 'ms', 'o'],
        _0x44d4x44 = _0x44d4x2['createElement']('div'),
        _0x44d4x45 = 'function',
        _0x44d4x46 = Math['round'],
        _0x44d4x47 = Math['abs'],
        _0x44d4x48 = Date['now'];
    _0x44d4x42 = 'function' != typeof Object['assign'] ? function(_0x44d4x1) {
        if (_0x44d4x1 === _0x44d4x4 || null === _0x44d4x1) {
            throw new TypeError('Cannot convert undefined or null to object')
        };
        for (var _0x44d4x2 = Object(_0x44d4x1), _0x44d4x3 = 1; _0x44d4x3 < arguments['length']; _0x44d4x3++) {
            var _0x44d4x5 = arguments[_0x44d4x3];
            if (_0x44d4x5 !== _0x44d4x4 && null !== _0x44d4x5) {
                for (var _0x44d4x6 in _0x44d4x5) {
                    _0x44d4x5['hasOwnProperty'](_0x44d4x6) && (_0x44d4x2[_0x44d4x6] = _0x44d4x5[_0x44d4x6])
                }
            }
        };
        return _0x44d4x2
    } : Object['assign'];
    var _0x44d4x49 = _0x44d4x8(function(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
            for (var _0x44d4x5 = Object['keys'](_0x44d4x2), _0x44d4x6 = 0; _0x44d4x6 < _0x44d4x5['length'];) {
                (!_0x44d4x3 || _0x44d4x3 && _0x44d4x1[_0x44d4x5[_0x44d4x6]] === _0x44d4x4) && (_0x44d4x1[_0x44d4x5[_0x44d4x6]] = _0x44d4x2[_0x44d4x5[_0x44d4x6]]), _0x44d4x6++
            };
            return _0x44d4x1
        }, 'extend', 'Use `assign`.'),
        _0x44d4x4a = _0x44d4x8(function(_0x44d4x1, _0x44d4x2) {
            return _0x44d4x49(_0x44d4x1, _0x44d4x2, !0)
        }, 'merge', 'Use `assign`.'),
        _0x44d4x4b = 1,
        _0x44d4x4c = /mobile|tablet|ip(ad|hone|od)|android/i,
        _0x44d4x4d = 'ontouchstart' in _0x44d4x1,
        _0x44d4x4e = _0x44d4x15(_0x44d4x1, 'PointerEvent') !== _0x44d4x4,
        _0x44d4x4f = _0x44d4x4d && _0x44d4x4c['test'](navigator['userAgent']),
        _0x44d4x50 = 'touch',
        _0x44d4x51 = 'pen',
        _0x44d4x52 = 'mouse',
        _0x44d4x53 = 'kinect',
        _0x44d4x54 = 25,
        _0x44d4x55 = 1,
        _0x44d4x56 = 2,
        _0x44d4x57 = 4,
        _0x44d4x58 = 8,
        _0x44d4x59 = 1,
        _0x44d4x5a = 2,
        _0x44d4x5b = 4,
        _0x44d4x5c = 8,
        _0x44d4x5d = 16,
        _0x44d4x5e = _0x44d4x5a | _0x44d4x5b,
        _0x44d4x5f = _0x44d4x5c | _0x44d4x5d,
        _0x44d4x60 = _0x44d4x5e | _0x44d4x5f,
        _0x44d4x61 = ['x', 'y'],
        _0x44d4x62 = ['clientX', 'clientY'];
    _0x44d4x18['prototype'] = {
        handler: function() {},
        init: function() {
            this['evEl'] && _0x44d4xd(this['element'], this['evEl'], this['domHandler']), this['evTarget'] && _0x44d4xd(this['target'], this['evTarget'], this['domHandler']), this['evWin'] && _0x44d4xd(_0x44d4x17(this['element']), this['evWin'], this['domHandler'])
        },
        destroy: function() {
            this['evEl'] && _0x44d4xe(this['element'], this['evEl'], this['domHandler']), this['evTarget'] && _0x44d4xe(this['target'], this['evTarget'], this['domHandler']), this['evWin'] && _0x44d4xe(_0x44d4x17(this['element']), this['evWin'], this['domHandler'])
        }
    };
    var _0x44d4x63 = {
            mousedown: _0x44d4x55,
            mousemove: _0x44d4x56,
            mouseup: _0x44d4x57
        },
        _0x44d4x64 = 'mousedown',
        _0x44d4x65 = 'mousemove mouseup';
    _0x44d4x9(_0x44d4x26, _0x44d4x18, {
        handler: function(_0x44d4x1) {
            var _0x44d4x2 = _0x44d4x63[_0x44d4x1['type']];
            _0x44d4x2 & _0x44d4x55 && 0 === _0x44d4x1['button'] && (this['pressed'] = !0), _0x44d4x2 & _0x44d4x56 && 1 !== _0x44d4x1['which'] && (_0x44d4x2 = _0x44d4x57), this['pressed'] && (_0x44d4x2 & _0x44d4x57 && (this['pressed'] = !1), this['callback'](this['manager'], _0x44d4x2, {
                pointers: [_0x44d4x1],
                changedPointers: [_0x44d4x1],
                pointerType: _0x44d4x52,
                srcEvent: _0x44d4x1
            }))
        }
    });
    var _0x44d4x66 = {
            pointerdown: _0x44d4x55,
            pointermove: _0x44d4x56,
            pointerup: _0x44d4x57,
            pointercancel: _0x44d4x58,
            pointerout: _0x44d4x58
        },
        _0x44d4x67 = {
            2: _0x44d4x50,
            3: _0x44d4x51,
            4: _0x44d4x52,
            5: _0x44d4x53
        },
        _0x44d4x68 = 'pointerdown',
        _0x44d4x69 = 'pointermove pointerup pointercancel';
    _0x44d4x1['MSPointerEvent'] && !_0x44d4x1['PointerEvent'] && (_0x44d4x68 = 'MSPointerDown', _0x44d4x69 = 'MSPointerMove MSPointerUp MSPointerCancel'), _0x44d4x9(_0x44d4x27, _0x44d4x18, {
        handler: function(_0x44d4x1) {
            var _0x44d4x2 = this['store'],
                _0x44d4x3 = !1,
                _0x44d4x4 = _0x44d4x1['type']['toLowerCase']()['replace']('ms', ''),
                _0x44d4x5 = _0x44d4x66[_0x44d4x4],
                _0x44d4x6 = _0x44d4x67[_0x44d4x1['pointerType']] || _0x44d4x1['pointerType'],
                _0x44d4x7 = _0x44d4x6 == _0x44d4x50,
                _0x44d4x8 = _0x44d4x12(_0x44d4x2, _0x44d4x1['pointerId'], 'pointerId');
            _0x44d4x5 & _0x44d4x55 && (0 === _0x44d4x1['button'] || _0x44d4x7) ? _0x44d4x8 < 0 && (_0x44d4x2['push'](_0x44d4x1), _0x44d4x8 = _0x44d4x2['length'] - 1) : _0x44d4x5 & (_0x44d4x57 | _0x44d4x58) && (_0x44d4x3 = !0), _0x44d4x8 < 0 || (_0x44d4x2[_0x44d4x8] = _0x44d4x1, this['callback'](this['manager'], _0x44d4x5, {
                pointers: _0x44d4x2,
                changedPointers: [_0x44d4x1],
                pointerType: _0x44d4x6,
                srcEvent: _0x44d4x1
            }), _0x44d4x3 && _0x44d4x2['splice'](_0x44d4x8, 1))
        }
    });
    var _0x44d4x6a = {
            touchstart: _0x44d4x55,
            touchmove: _0x44d4x56,
            touchend: _0x44d4x57,
            touchcancel: _0x44d4x58
        },
        _0x44d4x6b = 'touchstart',
        _0x44d4x6c = 'touchstart touchmove touchend touchcancel';
    _0x44d4x9(_0x44d4x28, _0x44d4x18, {
        handler: function(_0x44d4x1) {
            var _0x44d4x2 = _0x44d4x6a[_0x44d4x1['type']];
            if (_0x44d4x2 === _0x44d4x55 && (this['started'] = !0), this['started']) {
                var _0x44d4x3 = _0x44d4x29['call'](this, _0x44d4x1, _0x44d4x2);
                _0x44d4x2 & (_0x44d4x57 | _0x44d4x58) && _0x44d4x3[0]['length'] - _0x44d4x3[1]['length'] == 0 && (this['started'] = !1), this['callback'](this['manager'], _0x44d4x2, {
                    pointers: _0x44d4x3[0],
                    changedPointers: _0x44d4x3[1],
                    pointerType: _0x44d4x50,
                    srcEvent: _0x44d4x1
                })
            }
        }
    });
    var _0x44d4x6d = {
            touchstart: _0x44d4x55,
            touchmove: _0x44d4x56,
            touchend: _0x44d4x57,
            touchcancel: _0x44d4x58
        },
        _0x44d4x6e = 'touchstart touchmove touchend touchcancel';
    _0x44d4x9(_0x44d4x2a, _0x44d4x18, {
        handler: function(_0x44d4x1) {
            var _0x44d4x2 = _0x44d4x6d[_0x44d4x1['type']],
                _0x44d4x3 = _0x44d4x2b['call'](this, _0x44d4x1, _0x44d4x2);
            _0x44d4x3 && this['callback'](this['manager'], _0x44d4x2, {
                pointers: _0x44d4x3[0],
                changedPointers: _0x44d4x3[1],
                pointerType: _0x44d4x50,
                srcEvent: _0x44d4x1
            })
        }
    });
    var _0x44d4x6f = 2500,
        _0x44d4x70 = 25;
    _0x44d4x9(_0x44d4x2c, _0x44d4x18, {
        handler: function(_0x44d4x1, _0x44d4x2, _0x44d4x3) {
            var _0x44d4x4 = _0x44d4x3['pointerType'] == _0x44d4x50,
                _0x44d4x5 = _0x44d4x3['pointerType'] == _0x44d4x52;
            if (!(_0x44d4x5 && _0x44d4x3['sourceCapabilities'] && _0x44d4x3['sourceCapabilities']['firesTouchEvents'])) {
                if (_0x44d4x4) {
                    _0x44d4x2d['call'](this, _0x44d4x2, _0x44d4x3)
                } else {
                    if (_0x44d4x5 && _0x44d4x2f['call'](this, _0x44d4x3)) {
                        return
                    }
                };
                this['callback'](_0x44d4x1, _0x44d4x2, _0x44d4x3)
            }
        },
        destroy: function() {
            this['touch']['destroy'](), this['mouse']['destroy']()
        }
    });
    var _0x44d4x71 = _0x44d4x15(_0x44d4x44['style'], 'touchAction'),
        _0x44d4x72 = _0x44d4x71 !== _0x44d4x4,
        _0x44d4x73 = 'compute',
        _0x44d4x74 = 'auto',
        _0x44d4x75 = 'manipulation',
        _0x44d4x76 = 'none',
        _0x44d4x77 = 'pan-x',
        _0x44d4x78 = 'pan-y',
        _0x44d4x79 = _0x44d4x32();
    _0x44d4x30['prototype'] = {
        set: function(_0x44d4x1) {
            _0x44d4x1 == _0x44d4x73 && (_0x44d4x1 = this['compute']()), _0x44d4x72 && this['manager']['element']['style'] && _0x44d4x79[_0x44d4x1] && (this['manager']['element']['style'][_0x44d4x71] = _0x44d4x1), this['actions'] = _0x44d4x1['toLowerCase']()['trim']()
        },
        update: function() {
            this['set'](this['manager']['options']['touchAction'])
        },
        compute: function() {
            var _0x44d4x1 = [];
            return _0x44d4x7(this['manager']['recognizers'], function(_0x44d4x2) {
                _0x44d4xb(_0x44d4x2['options']['enable'], [_0x44d4x2]) && (_0x44d4x1 = _0x44d4x1['concat'](_0x44d4x2['getTouchAction']()))
            }), _0x44d4x31(_0x44d4x1['join'](' '))
        },
        preventDefaults: function(_0x44d4x1) {
            var _0x44d4x2 = _0x44d4x1['srcEvent'],
                _0x44d4x3 = _0x44d4x1['offsetDirection'];
            if (this['manager']['session']['prevented']) {
                return void(_0x44d4x2['preventDefault']())
            };
            var _0x44d4x4 = this['actions'],
                _0x44d4x5 = _0x44d4x10(_0x44d4x4, _0x44d4x76) && !_0x44d4x79[_0x44d4x76],
                _0x44d4x6 = _0x44d4x10(_0x44d4x4, _0x44d4x78) && !_0x44d4x79[_0x44d4x78],
                _0x44d4x7 = _0x44d4x10(_0x44d4x4, _0x44d4x77) && !_0x44d4x79[_0x44d4x77];
            if (_0x44d4x5) {
                var _0x44d4x8 = 1 === _0x44d4x1['pointers']['length'],
                    _0x44d4x9 = _0x44d4x1['distance'] < 2,
                    _0x44d4xa = _0x44d4x1['deltaTime'] < 250;
                if (_0x44d4x8 && _0x44d4x9 && _0x44d4xa) {
                    return
                }
            };
            return _0x44d4x7 && _0x44d4x6 ? void(0) : _0x44d4x5 || _0x44d4x6 && _0x44d4x3 & _0x44d4x5e || _0x44d4x7 && _0x44d4x3 & _0x44d4x5f ? this['preventSrc'](_0x44d4x2) : void(0)
        },
        preventSrc: function(_0x44d4x1) {
            this['manager']['session']['prevented'] = !0, _0x44d4x1['preventDefault']()
        }
    };
    var _0x44d4x7a = 1,
        _0x44d4x7b = 2,
        _0x44d4x7c = 4,
        _0x44d4x7d = 8,
        _0x44d4x7e = _0x44d4x7d,
        _0x44d4x7f = 16,
        _0x44d4x80 = 32;
    _0x44d4x33['prototype'] = {
        defaults: {},
        set: function(_0x44d4x1) {
            return _0x44d4x42(this['options'], _0x44d4x1), this['manager'] && this['manager']['touchAction']['update'](), this
        },
        recognizeWith: function(_0x44d4x1) {
            if (_0x44d4x6(_0x44d4x1, 'recognizeWith', this)) {
                return this
            };
            var _0x44d4x2 = this['simultaneous'];
            return _0x44d4x1 = _0x44d4x36(_0x44d4x1, this), _0x44d4x2[_0x44d4x1['id']] || (_0x44d4x2[_0x44d4x1['id']] = _0x44d4x1, _0x44d4x1['recognizeWith'](this)), this
        },
        dropRecognizeWith: function(_0x44d4x1) {
            return _0x44d4x6(_0x44d4x1, 'dropRecognizeWith', this) ? this : (_0x44d4x1 = _0x44d4x36(_0x44d4x1, this), delete this['simultaneous'][_0x44d4x1['id']], this)
        },
        requireFailure: function(_0x44d4x1) {
            if (_0x44d4x6(_0x44d4x1, 'requireFailure', this)) {
                return this
            };
            var _0x44d4x2 = this['requireFail'];
            return _0x44d4x1 = _0x44d4x36(_0x44d4x1, this), -1 === _0x44d4x12(_0x44d4x2, _0x44d4x1) && (_0x44d4x2['push'](_0x44d4x1), _0x44d4x1['requireFailure'](this)), this
        },
        dropRequireFailure: function(_0x44d4x1) {
            if (_0x44d4x6(_0x44d4x1, 'dropRequireFailure', this)) {
                return this
            };
            _0x44d4x1 = _0x44d4x36(_0x44d4x1, this);
            var _0x44d4x2 = _0x44d4x12(this['requireFail'], _0x44d4x1);
            return _0x44d4x2 > -1 && this['requireFail']['splice'](_0x44d4x2, 1), this
        },
        hasRequireFailures: function() {
            return this['requireFail']['length'] > 0
        },
        canRecognizeWith: function(_0x44d4x1) {
            return !!this['simultaneous'][_0x44d4x1['id']]
        },
        emit: function(_0x44d4x1) {
            function _0x44d4x2(_0x44d4x2) {
                _0x44d4x3['manager']['emit'](_0x44d4x2, _0x44d4x1)
            }
            var _0x44d4x3 = this,
                _0x44d4x4 = this['state'];
            _0x44d4x4 < _0x44d4x7d && _0x44d4x2(_0x44d4x3['options']['event'] + _0x44d4x34(_0x44d4x4)), _0x44d4x2(_0x44d4x3['options']['event']), _0x44d4x1['additionalEvent'] && _0x44d4x2(_0x44d4x1['additionalEvent']), _0x44d4x4 >= _0x44d4x7d && _0x44d4x2(_0x44d4x3['options']['event'] + _0x44d4x34(_0x44d4x4))
        },
        tryEmit: function(_0x44d4x1) {
            if (this['canEmit']()) {
                return this['emit'](_0x44d4x1)
            };
            this['state'] = _0x44d4x80
        },
        canEmit: function() {
            for (var _0x44d4x1 = 0; _0x44d4x1 < this['requireFail']['length'];) {
                if (!(this['requireFail'][_0x44d4x1]['state'] & (_0x44d4x80 | _0x44d4x7a))) {
                    return !1
                };
                _0x44d4x1++
            };
            return !0
        },
        recognize: function(_0x44d4x1) {
            var _0x44d4x2 = _0x44d4x42({}, _0x44d4x1);
            if (!_0x44d4xb(this['options']['enable'], [this, _0x44d4x2])) {
                return this['reset'](), void((this['state'] = _0x44d4x80))
            };
            this['state'] & (_0x44d4x7e | _0x44d4x7f | _0x44d4x80) && (this['state'] = _0x44d4x7a), this['state'] = this['process'](_0x44d4x2), this['state'] & (_0x44d4x7b | _0x44d4x7c | _0x44d4x7d | _0x44d4x7f) && this['tryEmit'](_0x44d4x2)
        },
        process: function(_0x44d4x1) {},
        getTouchAction: function() {},
        reset: function() {}
    }, _0x44d4x9(_0x44d4x37, _0x44d4x33, {
        defaults: {
            pointers: 1
        },
        attrTest: function(_0x44d4x1) {
            var _0x44d4x2 = this['options']['pointers'];
            return 0 === _0x44d4x2 || _0x44d4x1['pointers']['length'] === _0x44d4x2
        },
        process: function(_0x44d4x1) {
            var _0x44d4x2 = this['state'],
                _0x44d4x3 = _0x44d4x1['eventType'],
                _0x44d4x4 = _0x44d4x2 & (_0x44d4x7b | _0x44d4x7c),
                _0x44d4x5 = this['attrTest'](_0x44d4x1);
            return _0x44d4x4 && (_0x44d4x3 & _0x44d4x58 || !_0x44d4x5) ? _0x44d4x2 | _0x44d4x7f : _0x44d4x4 || _0x44d4x5 ? _0x44d4x3 & _0x44d4x57 ? _0x44d4x2 | _0x44d4x7d : _0x44d4x2 & _0x44d4x7b ? _0x44d4x2 | _0x44d4x7c : _0x44d4x7b : _0x44d4x80
        }
    }), _0x44d4x9(_0x44d4x38, _0x44d4x37, {
        defaults: {
            event: 'pan',
            threshold: 10,
            pointers: 1,
            direction: _0x44d4x60
        },
        getTouchAction: function() {
            var _0x44d4x1 = this['options']['direction'],
                _0x44d4x2 = [];
            return _0x44d4x1 & _0x44d4x5e && _0x44d4x2['push'](_0x44d4x78), _0x44d4x1 & _0x44d4x5f && _0x44d4x2['push'](_0x44d4x77), _0x44d4x2
        },
        directionTest: function(_0x44d4x1) {
            var _0x44d4x2 = this['options'],
                _0x44d4x3 = !0,
                _0x44d4x4 = _0x44d4x1['distance'],
                _0x44d4x5 = _0x44d4x1['direction'],
                _0x44d4x6 = _0x44d4x1['deltaX'],
                _0x44d4x7 = _0x44d4x1['deltaY'];
            return _0x44d4x5 & _0x44d4x2['direction'] || (_0x44d4x2['direction'] & _0x44d4x5e ? (_0x44d4x5 = 0 === _0x44d4x6 ? _0x44d4x59 : _0x44d4x6 < 0 ? _0x44d4x5a : _0x44d4x5b, _0x44d4x3 = _0x44d4x6 != this['pX'], _0x44d4x4 = Math['abs'](_0x44d4x1['deltaX'])) : (_0x44d4x5 = 0 === _0x44d4x7 ? _0x44d4x59 : _0x44d4x7 < 0 ? _0x44d4x5c : _0x44d4x5d, _0x44d4x3 = _0x44d4x7 != this['pY'], _0x44d4x4 = Math['abs'](_0x44d4x1['deltaY']))), _0x44d4x1['direction'] = _0x44d4x5, _0x44d4x3 && _0x44d4x4 > _0x44d4x2['threshold'] && _0x44d4x5 & _0x44d4x2['direction']
        },
        attrTest: function(_0x44d4x1) {
            return _0x44d4x37['prototype']['attrTest']['call'](this, _0x44d4x1) && (this['state'] & _0x44d4x7b || !(this['state'] & _0x44d4x7b) && this['directionTest'](_0x44d4x1))
        },
        emit: function(_0x44d4x1) {
            this['pX'] = _0x44d4x1['deltaX'], this['pY'] = _0x44d4x1['deltaY'];
            var _0x44d4x2 = _0x44d4x35(_0x44d4x1['direction']);
            _0x44d4x2 && (_0x44d4x1['additionalEvent'] = this['options']['event'] + _0x44d4x2), this['_super']['emit']['call'](this, _0x44d4x1)
        }
    }), _0x44d4x9(_0x44d4x39, _0x44d4x37, {
        defaults: {
            event: 'pinch',
            threshold: 0,
            pointers: 2
        },
        getTouchAction: function() {
            return [_0x44d4x76]
        },
        attrTest: function(_0x44d4x1) {
            return this['_super']['attrTest']['call'](this, _0x44d4x1) && (Math['abs'](_0x44d4x1['scale'] - 1) > this['options']['threshold'] || this['state'] & _0x44d4x7b)
        },
        emit: function(_0x44d4x1) {
            if (1 !== _0x44d4x1['scale']) {
                var _0x44d4x2 = _0x44d4x1['scale'] < 1 ? 'in' : 'out';
                _0x44d4x1['additionalEvent'] = this['options']['event'] + _0x44d4x2
            };
            this['_super']['emit']['call'](this, _0x44d4x1)
        }
    }), _0x44d4x9(_0x44d4x3a, _0x44d4x33, {
        defaults: {
            event: 'press',
            pointers: 1,
            time: 251,
            threshold: 9
        },
        getTouchAction: function() {
            return [_0x44d4x74]
        },
        process: function(_0x44d4x1) {
            var _0x44d4x2 = this['options'],
                _0x44d4x3 = _0x44d4x1['pointers']['length'] === _0x44d4x2['pointers'],
                _0x44d4x4 = _0x44d4x1['distance'] < _0x44d4x2['threshold'],
                _0x44d4x6 = _0x44d4x1['deltaTime'] > _0x44d4x2['time'];
            if (this['_input'] = _0x44d4x1, !_0x44d4x4 || !_0x44d4x3 || _0x44d4x1['eventType'] & (_0x44d4x57 | _0x44d4x58) && !_0x44d4x6) {
                this['reset']()
            } else {
                if (_0x44d4x1['eventType'] & _0x44d4x55) {
                    this['reset'](), this['_timer'] = _0x44d4x5(function() {
                        this['state'] = _0x44d4x7e, this['tryEmit']()
                    }, _0x44d4x2['time'], this)
                } else {
                    if (_0x44d4x1['eventType'] & _0x44d4x57) {
                        return _0x44d4x7e
                    }
                }
            };
            return _0x44d4x80
        },
        reset: function() {
            clearTimeout(this._timer)
        },
        emit: function(_0x44d4x1) {
            this['state'] === _0x44d4x7e && (_0x44d4x1 && _0x44d4x1['eventType'] & _0x44d4x57 ? this['manager']['emit'](this['options']['event'] + 'up', _0x44d4x1) : (this['_input']['timeStamp'] = _0x44d4x48(), this['manager']['emit'](this['options']['event'], this._input)))
        }
    }), _0x44d4x9(_0x44d4x3b, _0x44d4x37, {
        defaults: {
            event: 'rotate',
            threshold: 0,
            pointers: 2
        },
        getTouchAction: function() {
            return [_0x44d4x76]
        },
        attrTest: function(_0x44d4x1) {
            return this['_super']['attrTest']['call'](this, _0x44d4x1) && (Math['abs'](_0x44d4x1['rotation']) > this['options']['threshold'] || this['state'] & _0x44d4x7b)
        }
    }), _0x44d4x9(_0x44d4x3c, _0x44d4x37, {
        defaults: {
            event: 'swipe',
            threshold: 10,
            velocity: 0.3,
            direction: _0x44d4x5e | _0x44d4x5f,
            pointers: 1
        },
        getTouchAction: function() {
            return _0x44d4x38['prototype']['getTouchAction']['call'](this)
        },
        attrTest: function(_0x44d4x1) {
            var _0x44d4x2, _0x44d4x3 = this['options']['direction'];
            return _0x44d4x3 & (_0x44d4x5e | _0x44d4x5f) ? _0x44d4x2 = _0x44d4x1['overallVelocity'] : _0x44d4x3 & _0x44d4x5e ? _0x44d4x2 = _0x44d4x1['overallVelocityX'] : _0x44d4x3 & _0x44d4x5f && (_0x44d4x2 = _0x44d4x1['overallVelocityY']), this['_super']['attrTest']['call'](this, _0x44d4x1) && _0x44d4x3 & _0x44d4x1['offsetDirection'] && _0x44d4x1['distance'] > this['options']['threshold'] && _0x44d4x1['maxPointers'] == this['options']['pointers'] && _0x44d4x47(_0x44d4x2) > this['options']['velocity'] && _0x44d4x1['eventType'] & _0x44d4x57
        },
        emit: function(_0x44d4x1) {
            var _0x44d4x2 = _0x44d4x35(_0x44d4x1['offsetDirection']);
            _0x44d4x2 && this['manager']['emit'](this['options']['event'] + _0x44d4x2, _0x44d4x1), this['manager']['emit'](this['options']['event'], _0x44d4x1)
        }
    }), _0x44d4x9(_0x44d4x3d, _0x44d4x33, {
        defaults: {
            event: 'tap',
            pointers: 1,
            taps: 1,
            interval: 300,
            time: 250,
            threshold: 9,
            posThreshold: 10
        },
        getTouchAction: function() {
            return [_0x44d4x75]
        },
        process: function(_0x44d4x1) {
            var _0x44d4x2 = this['options'],
                _0x44d4x3 = _0x44d4x1['pointers']['length'] === _0x44d4x2['pointers'],
                _0x44d4x4 = _0x44d4x1['distance'] < _0x44d4x2['threshold'],
                _0x44d4x6 = _0x44d4x1['deltaTime'] < _0x44d4x2['time'];
            if (this['reset'](), _0x44d4x1['eventType'] & _0x44d4x55 && 0 === this['count']) {
                return this['failTimeout']()
            };
            if (_0x44d4x4 && _0x44d4x6 && _0x44d4x3) {
                if (_0x44d4x1['eventType'] != _0x44d4x57) {
                    return this['failTimeout']()
                };
                var _0x44d4x7 = !this['pTime'] || _0x44d4x1['timeStamp'] - this['pTime'] < _0x44d4x2['interval'],
                    _0x44d4x8 = !this['pCenter'] || _0x44d4x22(this['pCenter'], _0x44d4x1['center']) < _0x44d4x2['posThreshold'];
                this['pTime'] = _0x44d4x1['timeStamp'], this['pCenter'] = _0x44d4x1['center'], _0x44d4x8 && _0x44d4x7 ? this['count'] += 1 : this['count'] = 1, this['_input'] = _0x44d4x1;
                if (0 === this['count'] % _0x44d4x2['taps']) {
                    return this['hasRequireFailures']() ? (this['_timer'] = _0x44d4x5(function() {
                        this['state'] = _0x44d4x7e, this['tryEmit']()
                    }, _0x44d4x2['interval'], this), _0x44d4x7b) : _0x44d4x7e
                }
            };
            return _0x44d4x80
        },
        failTimeout: function() {
            return this['_timer'] = _0x44d4x5(function() {
                this['state'] = _0x44d4x80
            }, this['options']['interval'], this), _0x44d4x80
        },
        reset: function() {
            clearTimeout(this._timer)
        },
        emit: function() {
            this['state'] == _0x44d4x7e && (this['_input']['tapCount'] = this['count'], this['manager']['emit'](this['options']['event'], this._input))
        }
    }), _0x44d4x3e['VERSION'] = '2.0.8', _0x44d4x3e['defaults'] = {
        domEvents: !1,
        touchAction: _0x44d4x73,
        enable: !0,
        inputTarget: null,
        inputClass: null,
        preset: [
            [_0x44d4x3b, {
                enable: !1
            }],
            [_0x44d4x39, {
                    enable: !1
                },
                ['rotate']
            ],
            [_0x44d4x3c, {
                direction: _0x44d4x5e
            }],
            [_0x44d4x38, {
                    direction: _0x44d4x5e
                },
                ['swipe']
            ],
            [_0x44d4x3d],
            [_0x44d4x3d, {
                    event: 'doubletap',
                    taps: 2
                },
                ['tap']
            ],
            [_0x44d4x3a]
        ],
        cssProps: {
            userSelect: 'none',
            touchSelect: 'none',
            touchCallout: 'none',
            contentZooming: 'none',
            userDrag: 'none',
            tapHighlightColor: 'rgba(0,0,0,0)'
        }
    };
    var _0x44d4x81 = 2;
    _0x44d4x3f['prototype'] = {
        set: function(_0x44d4x1) {
            return _0x44d4x42(this['options'], _0x44d4x1), _0x44d4x1['touchAction'] && this['touchAction']['update'](), _0x44d4x1['inputTarget'] && (this['input']['destroy'](), this['input']['target'] = _0x44d4x1['inputTarget'], this['input']['init']()), this
        },
        stop: function(_0x44d4x1) {
            this['session']['stopped'] = _0x44d4x1 ? _0x44d4x81 : 1
        },
        recognize: function(_0x44d4x1) {
            var _0x44d4x2 = this['session'];
            if (!_0x44d4x2['stopped']) {
                this['touchAction']['preventDefaults'](_0x44d4x1);
                var _0x44d4x3, _0x44d4x4 = this['recognizers'],
                    _0x44d4x5 = _0x44d4x2['curRecognizer'];
                (!_0x44d4x5 || _0x44d4x5 && _0x44d4x5['state'] & _0x44d4x7e) && (_0x44d4x5 = _0x44d4x2['curRecognizer'] = null);
                for (var _0x44d4x6 = 0; _0x44d4x6 < _0x44d4x4['length'];) {
                    _0x44d4x3 = _0x44d4x4[_0x44d4x6], _0x44d4x2['stopped'] === _0x44d4x81 || _0x44d4x5 && _0x44d4x3 != _0x44d4x5 && !_0x44d4x3['canRecognizeWith'](_0x44d4x5) ? _0x44d4x3['reset']() : _0x44d4x3['recognize'](_0x44d4x1), !_0x44d4x5 && _0x44d4x3['state'] & (_0x44d4x7b | _0x44d4x7c | _0x44d4x7d) && (_0x44d4x5 = _0x44d4x2['curRecognizer'] = _0x44d4x3), _0x44d4x6++
                }
            }
        },
        get: function(_0x44d4x1) {
            if (_0x44d4x1 instanceof _0x44d4x33) {
                return _0x44d4x1
            };
            for (var _0x44d4x2 = this['recognizers'], _0x44d4x3 = 0; _0x44d4x3 < _0x44d4x2['length']; _0x44d4x3++) {
                if (_0x44d4x2[_0x44d4x3]['options']['event'] == _0x44d4x1) {
                    return _0x44d4x2[_0x44d4x3]
                }
            };
            return null
        },
        add: function(_0x44d4x1) {
            if (_0x44d4x6(_0x44d4x1, 'add', this)) {
                return this
            };
            var _0x44d4x2 = this['get'](_0x44d4x1['options']['event']);
            return _0x44d4x2 && this['remove'](_0x44d4x2), this['recognizers']['push'](_0x44d4x1), _0x44d4x1['manager'] = this, this['touchAction']['update'](), _0x44d4x1
        },
        remove: function(_0x44d4x1) {
            if (_0x44d4x6(_0x44d4x1, 'remove', this)) {
                return this
            };
            if (_0x44d4x1 = this['get'](_0x44d4x1)) {
                var _0x44d4x2 = this['recognizers'],
                    _0x44d4x3 = _0x44d4x12(_0x44d4x2, _0x44d4x1); - 1 !== _0x44d4x3 && (_0x44d4x2['splice'](_0x44d4x3, 1), this['touchAction']['update']())
            };
            return this
        },
        on: function(_0x44d4x1, _0x44d4x2) {
            if (_0x44d4x1 !== _0x44d4x4 && _0x44d4x2 !== _0x44d4x4) {
                var _0x44d4x3 = this['handlers'];
                return _0x44d4x7(_0x44d4x11(_0x44d4x1), function(_0x44d4x1) {
                    _0x44d4x3[_0x44d4x1] = _0x44d4x3[_0x44d4x1] || [], _0x44d4x3[_0x44d4x1]['push'](_0x44d4x2)
                }), this
            }
        },
        off: function(_0x44d4x1, _0x44d4x2) {
            if (_0x44d4x1 !== _0x44d4x4) {
                var _0x44d4x3 = this['handlers'];
                return _0x44d4x7(_0x44d4x11(_0x44d4x1), function(_0x44d4x1) {
                    _0x44d4x2 ? _0x44d4x3[_0x44d4x1] && _0x44d4x3[_0x44d4x1]['splice'](_0x44d4x12(_0x44d4x3[_0x44d4x1], _0x44d4x2), 1) : delete _0x44d4x3[_0x44d4x1]
                }), this
            }
        },
        emit: function(_0x44d4x1, _0x44d4x2) {
            this['options']['domEvents'] && _0x44d4x41(_0x44d4x1, _0x44d4x2);
            var _0x44d4x3 = this['handlers'][_0x44d4x1] && this['handlers'][_0x44d4x1]['slice']();
            if (_0x44d4x3 && _0x44d4x3['length']) {
                _0x44d4x2['type'] = _0x44d4x1, _0x44d4x2['preventDefault'] = function() {
                    _0x44d4x2['srcEvent']['preventDefault']()
                };
                for (var _0x44d4x4 = 0; _0x44d4x4 < _0x44d4x3['length'];) {
                    _0x44d4x3[_0x44d4x4](_0x44d4x2), _0x44d4x4++
                }
            }
        },
        destroy: function() {
            this['element'] && _0x44d4x40(this, !1), this['handlers'] = {}, this['session'] = {}, this['input']['destroy'](), this['element'] = null
        }
    }, _0x44d4x42(_0x44d4x3e, {
        INPUT_START: _0x44d4x55,
        INPUT_MOVE: _0x44d4x56,
        INPUT_END: _0x44d4x57,
        INPUT_CANCEL: _0x44d4x58,
        STATE_POSSIBLE: _0x44d4x7a,
        STATE_BEGAN: _0x44d4x7b,
        STATE_CHANGED: _0x44d4x7c,
        STATE_ENDED: _0x44d4x7d,
        STATE_RECOGNIZED: _0x44d4x7e,
        STATE_CANCELLED: _0x44d4x7f,
        STATE_FAILED: _0x44d4x80,
        DIRECTION_NONE: _0x44d4x59,
        DIRECTION_LEFT: _0x44d4x5a,
        DIRECTION_RIGHT: _0x44d4x5b,
        DIRECTION_UP: _0x44d4x5c,
        DIRECTION_DOWN: _0x44d4x5d,
        DIRECTION_HORIZONTAL: _0x44d4x5e,
        DIRECTION_VERTICAL: _0x44d4x5f,
        DIRECTION_ALL: _0x44d4x60,
        Manager: _0x44d4x3f,
        Input: _0x44d4x18,
        TouchAction: _0x44d4x30,
        TouchInput: _0x44d4x2a,
        MouseInput: _0x44d4x26,
        PointerEventInput: _0x44d4x27,
        TouchMouseInput: _0x44d4x2c,
        SingleTouchInput: _0x44d4x28,
        Recognizer: _0x44d4x33,
        AttrRecognizer: _0x44d4x37,
        Tap: _0x44d4x3d,
        Pan: _0x44d4x38,
        Swipe: _0x44d4x3c,
        Pinch: _0x44d4x39,
        Rotate: _0x44d4x3b,
        Press: _0x44d4x3a,
        on: _0x44d4xd,
        off: _0x44d4xe,
        each: _0x44d4x7,
        merge: _0x44d4x4a,
        extend: _0x44d4x49,
        assign: _0x44d4x42,
        inherit: _0x44d4x9,
        bindFn: _0x44d4xa,
        prefixed: _0x44d4x15
    }), (void(0) !== _0x44d4x1 ? _0x44d4x1 : 'undefined' != typeof self ? self : {})['Hammer'] = _0x44d4x3e, 'function' == typeof define && define['amd'] ? define(function() {
        return _0x44d4x3e
    }) : 'undefined' != typeof module && module['exports'] ? module['exports'] = _0x44d4x3e : _0x44d4x1[_0x44d4x3] = _0x44d4x3e
}(window, document, 'Hammer')