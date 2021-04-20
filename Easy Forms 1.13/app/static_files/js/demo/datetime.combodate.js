/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3.7
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * Combodate for DateTime-Local
     *
     * Replace any 'datetime-local' field with dropdown elements to pick day, month, year, hour, minutes and seconds
     *
     * @link http://vitalets.github.io/combodate/
     */
    $.when(
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.js" ),
        $.getScript( "//vitalets.github.io/combodate/combodate.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $('form').attr('novalidate', true);
        var style = $('<style>.combodate { display: block } .form-control-date { display: inline-block; }</style>');
        $('input[type="datetime-local"]')
            .attr('type','text')
            .append(style)
            .combodate({
                customClass: 'form-control form-control-date',
                format: 'YYYY-MM-DD h:mm:ss',
                template: 'DD / MM / YYYY     HH : mm : ss',
                // minYear: 2012,
                // maxYear: moment().format('YYYY'),
                value: new Date()
            });
    });

});
