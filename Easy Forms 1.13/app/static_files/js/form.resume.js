/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 *
 * Based on jQuery Elephant - localStorage (MIT license)
 * Copyright (c) Don Burks
 *
 * Changes:
 * - Check if localStorage exists
 * - Exclude Fields
 * - onStored event
 * - Destroy localStorage after
 * - Form submit or reset
 */
;(function(window, $, undefined) {
    var defaults = {
            'key': 'form_resume',
            'excludeFields': [],
            'onStored': function(field){}
        },
        params = {};

    var elephFns = {
        form: null,
        formData: {},
        save: function() {
            localStorage.setItem(params.key, JSON.stringify(elephFns.formData));
        },
        load: function() {
            elephFns.formData = JSON.parse(localStorage.getItem(params.key));
            if (elephFns.formData) {
                $.each(Object.keys(elephFns.formData), elephFns.defaultValues);
            } else {
                elephFns.formData = {};
            }
        },
        destroy: function() {
            localStorage.removeItem( params.key );
        },
        storeData: function() {
            var box = $(this),
                label = box.attr('name');

            // Exclude file fields by default and selected fields
            if (box.is(':file') || $.inArray( label, params.excludeFields ) !== -1 ) {
                return false;
            }

            if (box.is(':checkbox') || box.is(':radio')) {
                var values = [];

                values.push(box.val());
                box.siblings(':checked').each(function() {
                    values.push($(this).val());
                });

                elephFns.formData[label] = values;
            } else {
                elephFns.formData[label] = box.val();
            }

            elephFns.save();

            // trigger custom user function when data is stored
            params.onStored( box );

        },
        defaultValues: function(key, value) {
            var box = elephFns.form.find('[name="'+value+'"]'),
                value = elephFns.formData[value];

            if (typeof box == 'Array') {
                box.filter('[value="' + value + '"]').prop("checked", true);
            } else {
                if (!box.is(':submit')) {
                    box.val(value);
                }
            }
        }
    };

    $.fn.resume = function(val) {
        val = val || {};
        params = $.extend(defaults, val);
        // If there is no localStorage, no need to go further
        if( typeof localStorage === 'undefined' ){
            return false;
        }
        elephFns.form = $(this);
        elephFns.load();

        elephFns.form.find('input, select, textarea').on('change', elephFns.storeData);
        elephFns.form.on( 'submit reset' , elephFns.destroy );
        return $(this);
    };
})(window, jQuery);