/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.7.2
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

$( document ).ready(function() {

    /**
     * Select2
     * Automatically  select list replacement
     */

    $.when(
        $('head').append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css" type="text/css" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" type="text/css" />'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $.fn.select2.defaults.set("theme", "bootstrap");
        $('select').select2({
            width: '99.8%'
        });
    });

});
