/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.7.3
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    $.when(
        $('head').append('<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $('body').css('padding-bottom', '200px'); // Set up min bottom padding for show the datepicker
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
                    })
                    .datepicker("setDate", new Date()) // Display Current Dat by default
                    .on('change', function () {
                        $(that).trigger('change');
                    }))
                .hide();
        });
    });

});
