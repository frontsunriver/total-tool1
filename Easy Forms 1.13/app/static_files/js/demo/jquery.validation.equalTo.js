/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.9
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
$( document ).ready(function() {

    /**
     * jQuery Validation
     * Match Two fields to pass validation and enable submit button
     *
     * @link https://jqueryvalidation.org/
     */

    $.when(
        $.getScript( "//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" ),
        $.Deferred(function( deferred ){
            $( deferred.resolve );
        })
    ).done(function(){
        $.validator.messages.equalTo = 'Please enter the same value again.';
        $.validator.addClassRules('second_field', {
            equalTo: ".first_field"
        });
        // Validate form on keyup
        formEl.validate({
            validClass: "",
            errorElement: "div",
            errorClass: "help-block error-block",
            highlight: function(element, errorClass, validClass) {
                // Add `has-error` class to the field group
                var fieldGroup = $(element).parent(".form-group");
                fieldGroup.addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                // Remove `has-error` class to the field group
                var fieldGroup = $(element).parent(".form-group");
                fieldGroup.removeClass("has-error");
                // Remove error message
                fieldGroup.find(".error-block").remove();
            }
        });
        // Handle submit button
        $('button[type=submit]').on('click', function(e){
            e.preventDefault();
            if (formEl.valid()) {
                formEl.submit();
            }
        });
    });
});
