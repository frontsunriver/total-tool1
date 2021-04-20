/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.6.6
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * jQuery UI Datepicker (Dutch language)
     * Select a date from a popup or inline calendar on any 'date' field
     *
     * @link https://jqueryui.com/datepicker/
     */

    $.when(
        $('head').append('<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $('body').css('padding-bottom', '200px'); // Set up min bottom padding for show the datepicker
        $.datepicker.regional['nl'] = {clearText: 'Effacer', clearStatus: '',
            closeText: 'sluiten', closeStatus: 'Onveranderd sluiten ',
            prevText: '<vorige', prevStatus: 'Zie de vorige maand',
            nextText: 'volgende>', nextStatus: 'Zie de volgende maand',
            currentText: 'Huidige', currentStatus: 'Bekijk de huidige maand',
            monthNames: ['januari','februari','maart','april','mei','juni',
                'juli','augustus','september','oktober','november','december'],
            monthNamesShort: ['jan','feb','mrt','apr','mei','jun',
                'jul','aug','sep','okt','nov','dec'],
            monthStatus: 'Bekijk een andere maand', yearStatus: 'Bekijk nog een jaar',
            weekHeader: 'Sm', weekStatus: '',
            dayNames: ['zondag','maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag'],
            dayNamesShort: ['zo', 'ma','di','wo','do','vr','za'],
            dayNamesMin: ['zo', 'ma','di','wo','do','vr','za'],
            dayStatus: 'Gebruik DD als de eerste dag van de week', dateStatus: 'Kies DD, MM d',
            dateFormat: 'dd/mm/yy', firstDay: 1,
            initStatus: 'Kies een datum', isRTL: false};
        $.datepicker.setDefaults($.datepicker.regional['nl']);
        $('input[type=date]').each(function () {
            var that = this;
            $(that).attr('type', 'text')
                .after($(that).clone().attr('id', that.id + '_alt').attr('name', that.id + '_alt')
                    .datepicker({
                        // Consistent format with the HTML5 picker
                        dateFormat: 'mm/dd/yy',
                        changeMonth: true,
                        changeYear: true,
                        // yearRange: "1970:2060",
                        // isRTL: true,
                        altField: this,
                        altFormat: "yy-mm-dd"
                    }).on('change', function () {
                        $(that).trigger('change');
                    }))
                .hide();
        });
    });

});
