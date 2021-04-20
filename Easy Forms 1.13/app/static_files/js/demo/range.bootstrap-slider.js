/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.5
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2017 Baluart.COM
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * Bootstrap-Slider for range
     *
     * A range slider without bloat.
     * It offers a ton off features, and it is
     * as small, lightweight and minimal as possible
     *
     * @link https://github.com/seiyria/bootstrap-slider
     */
    $.when(
        $('head')
            .append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.min.css" type="text/css" />')
            .append('<style>body{padding: 0 15px;} .slider{ display: block; text-align: center } .slider-horizontal{width: 100% !important; margin: 5px auto} .tooltip-inner{padding: 4px 8px}</style>'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $('input[type="range"]').each(function () {
            $(this)
                .attr('data-slider-min', this.min)
                .attr('data-slider-max', this.max)
                .attr('data-slider-step', this.step)
                .attr('data-slider-value', this.value)
                .attr('data-slider-enabled', !$(this).is(':disabled'))
                .removeAttr('min')
                .removeAttr('max')
                .removeAttr('step')
                .removeAttr('value')
                .slider();
        });
    });

});