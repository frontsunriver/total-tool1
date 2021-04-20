$( document ).ready(function() {

    $.when(
        $('head').append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.7/css/intlTelInput.css" type="text/css" />'),
        $.getScript("//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.7/js/intlTelInput.min.js"),
        $.getScript("//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.7/js/utils.js"),
        $('head').append('<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />'),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" ),
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.js" ),
        $.getScript( "//vitalets.github.io/combodate/combodate.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $('input[type=tel]').each(function () {
            var that = this;
            var altID = this.id + '_alt';
            $(this).after(
                $(this).clone().attr('id', altID).attr('name', altID)
            ).hide();
            $("#" + altID).change(function () {
                $(that).val($(this).intlTelInput("getNumber"));
            }).intlTelInput();
        });
        $('input[type=date]').each(function () {
            $(this).attr('type', 'text')
                .after($(this).clone().attr('id', this.id + '_alt').attr('name', this.id + '_alt')
                    .datepicker({
                        // Consistent format with the HTML5 picker
                        dateFormat: 'mm/dd/yy',
                        changeMonth: true,
                        changeYear: true,
                        // yearRange: "1970:2060",
                        // isRTL: true,
                        altField: this,
                        altFormat: "yy-mm-dd"
                    }))
                .hide();
        });
        $('form').attr('novalidate', true);
        var style = $('<style>.combodate { display: block } .form-control-date { display: inline-block; }</style>');
        $('input[type="datetime-local"]')
            .attr('type','text')
            .append(style)
            .combodate({
                customClass: 'form-control form-control-date',
                format: 'YYYY-MM-DD h:mm:ss',
                template: 'DD / MM / YYYY     HH : mm : ss',
                minYear: 2019,
                maxYear: 2020,
                value: new Date()
            });
        // CSS Fixes
        $('.intl-tel-input').css('display', 'inherit');
    });

});