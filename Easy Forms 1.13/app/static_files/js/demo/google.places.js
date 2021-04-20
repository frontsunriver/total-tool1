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
     * Google Places
     *
     * Display a Google Places search box in any 'text' field
     * @link https://developers.google.com/maps/documentation/javascript/places
     */
    $.when(
        $.getScript( "//maps.googleapis.com/maps/api/js?sensor=false&libraries=places" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        var input = $("input[type='text']")[0];
        var options = {
            componentRestrictions: {
                country: 'us'
            }
        };
        new google.maps.places.Autocomplete(input, options);
    });
});
