
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.11
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * jQuery UI Datepicker (French language)
     * Select a date from a popup or inline calendar on any 'date' field
     *
     * @link https://jqueryui.com/datepicker/
     */

    $.when(
        $('head').append('<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" type="text/css" />'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $('body').css('padding-bottom', '200px'); // Set up min bottom padding for show the datepicker
        $.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
            closeText: 'Fermer',
            prevText: '&#x3c;PrÃ©c',
            nextText: 'Suiv&#x3e;',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
                'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
            monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
                'Jul','Aou','Sep','Oct','Nov','Dec'],
            dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
            dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
            weekHeader: 'Sm',
            dateFormat: 'dd-mm-yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',
            minDate: 0,
            maxDate: '+120M +0D',
            numberOfMonths: 1,
            showButtonPanel: true};
        $.datepicker.setDefaults($.datepicker.regional['fr']);
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