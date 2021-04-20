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
     * Bootstrap Star Rating
     *
     * Display a Star Rating widget on any field with the '.star-rating' css class
     * @link http://plugins.krajee.com/star-rating
     */
    $.when(
        $('head').append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.1/css/star-rating.min.css" type="text/css" />'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.1/js/star-rating.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $(".star-rating").rating({min:1, max:10, step:2, size:'lg'});
    });

});
