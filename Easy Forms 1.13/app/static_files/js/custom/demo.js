$( document ).ready(function() {
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

    var map;
    $.when(
        $('head').append('<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" type="text/css" />'),
        $.getScript( "//unpkg.com/leaflet@1.5.1/dist/leaflet.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        map = L.map('map').setView([32.78595849999999, -79.93684619999999], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([32.78595849999999, -79.93684619999999]).addTo(map)
            .bindPopup('<p><strong>Francis Marion Hotel</strong><br>387 King St, Charleston, SC 29403, United States.</p>')
            .openPopup();
    });

});
