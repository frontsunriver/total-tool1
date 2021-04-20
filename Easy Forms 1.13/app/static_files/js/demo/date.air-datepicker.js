/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.6.9
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * Air Datepicker for Date
     *
     * Replace any 'date' field with a lightweight cross-browser jQuery datepicker
     *
     * @link https://github.com/t1m0n/air-datepicker
     */
    $.when(
        $('head').append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.min.css" type="text/css" />'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $('body').css('padding-bottom', '200px'); // Set up min bottom padding for show the datepicker
        $.fn.datepicker.language['en'] = {
            days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            months: ['January','February','March','April','May','June', 'July','August','September','October','November','December'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            today: 'Today',
            clear: 'Clear',
            dateFormat: 'mm/dd/yyyy',
            timeFormat: 'hh:ii aa',
            firstDay: 0
        };
        $('input[type=date]').each(function () {
            var that = this;
            $(that).attr('type', 'text')
                .after($(that).clone().attr('id', that.id + '_alt').attr('name', that.id + '_alt')
                    .datepicker({
                        language: 'en',
                        // Consistent format with the HTML5 picker
                        altField: this,
                        altFormat: "yyyy-mm-dd"
                    }).on('change', function () {
                        $(that).trigger('change');
                    }))
                .hide();
        });
    });

});