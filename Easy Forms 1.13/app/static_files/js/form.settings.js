/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

// Rule Builder Url
var ruleBuilderURL = FormSettings.ruleBuilderURL;
// Preview URL
var previewURL = FormSettings.previewURL;
// Set form id
var formID = FormSettings.formID;
// Set iframe id
var iID = FormSettings.iframe;
// Set iframe height
var iH = FormSettings.iHeight;
// Boolean iframe is in the DOM
var iExists = false;

/**
 * When a no one theme is selected
 *
 * @param e
 * @returns {boolean}
 */
var previewUnselected = function (e) {
    e.preventDefault();
    // Hide container
    $("#preview-container").hide();
    // Remove iframe
    $('#'+iID).remove();
    return iExists = false;
};

/**
 * When a theme is selected
 *
 * @param e
 * @returns {boolean}
 */
var previewSelected = function(e) {
    e.preventDefault();
    // Show container
    $("#preview-container").show();

    // Load iframe
    var themeID = $(e.currentTarget).val();
    var prefix = ( previewURL.indexOf('?') >= 0 ? '&' : '?' );
    var src = previewURL + prefix + $.param({
        id: formID,
        theme_id: themeID
    }, true );
    if( iExists === true ) {
        // If iframe exists, only change its src
        $('#'+iID).attr("src", src);
    } else {
        // Create iframe
        var i = $('<iframe></iframe>').attr({
            src: src,
            id: iID,
            frameborder: 0,
            width: '100%',
            height: iH
        });
        // Add iframe to div preview
        $("#preview").html(i);
        // Flag to true
        return iExists = true;
    }
};

/**
 * Resize iframe
 */
$("#resizeFull").click(function(e) {
    e.preventDefault();
    if(iExists) {
        // To expand
        var iEl = $("#"+iID);
        iEl.height( iEl.contents().find("html").height() );
        $(".toogleButton").toggle();
    }
});
$("#resizeSmall").click(function(e) {
    e.preventDefault();
    if(iExists) {
        // To contract
        $("#"+iID).height( iH );
        $(".toogleButton").toggle();
    }
});

$( document ).ready(function() {

    /**
     * Show Wysiwyg editor
     */
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#formconfirmation-mail_message, #formemail-message',
            height: 300,
            plugins: 'advlist autolink link image lists charmap print preview hr anchor ' +
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking ' +
                'save table directionality paste',
            toolbar: 'insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | preview fullscreen code',
            convert_urls: false,
            setup: function (editor) {
                editor.ui.registry.addAutocompleter('field-list', {
                    ch: '{',
                    minChars: 0,
                    columns: 1,
                    fetch: function (pattern) {
                        var matchedChars = FormSettings.fieldList.filter(function (character) {
                            return character.text.indexOf(pattern) !== -1;
                        });

                        return new tinymce.util.Promise(function (resolve) {
                            var results = matchedChars.map(function (character) {
                                return {
                                    value: "{{ " + character.value + " }} ",
                                    text: character.text,
                                    icon: character.value
                                }
                            });
                            resolve(results);
                        });
                    },
                    onAction: function (autocompleteApi, rng, value) {
                        editor.selection.setRng(rng);
                        editor.insertContent(value);
                        autocompleteApi.hide();
                    }
                });
            }
        });
    }

    /**
     * Autocomplete
     */
    $('body').on('click', '.placeholder-autocomplete', function (e) {
        // Add autocomplete suggestions to text format
        var currentTarget = $(e.currentTarget);
        currentTarget
            .textcomplete('destroy');
        currentTarget
            .textcomplete([
                {
                    match: function () {
                        return /(\.*){(\w*)$/;
                    },
                    search: function (term, callback, match) {
                        $.post(FormSettings.fieldListUrl, {
                            id: FormSettings.formID,
                            term: typeof match[2] === "undefined" ? '' : match[2],
                            _csrf: $('meta[name=csrf-token]').attr('content')
                        })
                            .done(function(response) {
                                if (typeof response.data === "object") {
                                    var data = Object.keys(response.data).map(function(key) {
                                        var val = {};
                                        val[key] = "<span>" + key + "</span>" + response.data[key];
                                        return val;
                                    });
                                    callback($.map(data, function (f) {
                                        var value = f[Object.keys(f)[0]];
                                        return value.indexOf(term) === 0 ? f : null;
                                    }));
                                } else {
                                    callback([]);
                                }
                            });
                    },
                    template: function (f) {
                        return f[Object.keys(f)[0]];
                    },
                    index: 1,
                    replace: function (f) {
                        var key = Object.keys(f)[0];
                        return '{{ ' + key + ' }} ';
                    }
                }
            ], {
                zIndex: 1500,
                maxCount: -1
            });
    });

    /**
     * Show/Hide Forms fields Events Handlers
     */

    // Handlers
    toggleShared = function (e) {
        if(e.val() === "0" || e.val() === "1") {
            $('.field-form-users').hide();
        } else if (e.val() === "2") {
            $('.field-form-users').show();
        }
    };
    toggleEditable = function (e) {
        if(e.val() === "0") {
            $('.submission-editable-settings').hide();
        } else {
            $('.submission-editable-settings').show();
        }
    };
    toggleSchedule = function (e) {
        if(e.val() === "0") {
            $('.field-form-schedule_start_date').hide();
            $('.field-form-schedule_end_date').hide();
        } else {
            $('.field-form-schedule_start_date').show();
            $('.field-form-schedule_end_date').show();
        }
    };
    togglePassword = function (e) {
        if($("#form-use_password").is(":checked") === false) {
            $('.field-form-password').hide();
        } else {
            $('.field-form-password').show();
        }
    };
    toggleUrls = function (e) {
        if($("#form-authorized_urls").is(":checked") === false) {
            $('.field-form-urls').hide();
        } else {
            $('.field-form-urls').show();
        }
    };
    toggleTotalLimit = function (e) {
        if(e.val() === "0") {
            $('.field-form-total_limit_number').hide();
            $('.field-form-total_limit_time_unit').hide();
        } else {
            $('.field-form-total_limit_number').show();
            $('.field-form-total_limit_time_unit').show();
        }
    };
    toggleUserLimit = function (e) {
        if(e.val() === "0") {
            $('.field-form-user_limit_type').hide();
            $('.field-form-user_limit_number').hide();
            $('.field-form-user_limit_time_unit').hide();
        } else {
            $('.field-form-user_limit_type').show();
            $('.field-form-user_limit_number').show();
            $('.field-form-user_limit_time_unit').show();
        }
    };
    toggleFormConfirmationFields = function (e) {
        if(e.val() === "0" || e.val() === "1") {
            $('.field-formconfirmation-message').show();
            $('.field-formconfirmation-url').hide();
            $('.field-formconfirmation-seconds').hide();
            $('.field-formconfirmation-append').hide();
            $('.field-formconfirmation-alias').hide();
        } else if (e.val() === "2") {
            $('.field-formconfirmation-message').hide();
            $('.field-formconfirmation-url').show();
            $('.field-formconfirmation-seconds').show();
            $('.field-formconfirmation-append').show();
            $('.field-formconfirmation-alias').show();
        }
    };
    toggleFormConfirmationRuleFields = function (e) {
        if(e.val() === "0" || e.val() === "1") {
            e.parents('.item').find('.message').show();
            e.parents('.item').find('.url').hide();
        } else if (e.val() === "2") {
            e.parents('.item').find('.message').hide();
            e.parents('.item').find('.url').show();
        }
    };
    toggleFormConfirmationEmailFields = function (e) {
        if(e.val() === "0") {
            $('.field-formconfirmation-mail_to').hide();
            $('.field-formconfirmation-mail_from').hide();
            $('.field-formconfirmation-mail_from_name').hide();
            $('.field-formconfirmation-mail_cc').hide();
            $('.field-formconfirmation-mail_bcc').hide();
            $('.field-formconfirmation-mail_subject').hide();
            $('.field-formconfirmation-mail_message').hide();
            $('.field-formconfirmation-mail_receipt_copy').hide();
            $('.field-formconfirmation-mail_attach').hide();
            $('.field-formconfirmation-opt_in').hide();
            $('.field-formconfirmation-opt_in_type').hide();
            $('.field-formconfirmation-opt_in_message').hide();
            $('.field-formconfirmation-opt_in_url').hide();
        } else if (e.val() === "1") {
            $('.field-formconfirmation-mail_to').show();
            $('.field-formconfirmation-mail_from').show();
            $('.field-formconfirmation-mail_from_name').show();
            $('.field-formconfirmation-mail_cc').show();
            $('.field-formconfirmation-mail_bcc').show();
            $('.field-formconfirmation-mail_subject').show();
            $('.field-formconfirmation-mail_message').show();
            $('.field-formconfirmation-mail_receipt_copy').show();
            $('.field-formconfirmation-mail_attach').show();
            $('.field-formconfirmation-opt_in').show();
            toggleFormConfirmationOptInFields($("#formconfirmation-opt_in").is(":checked"));
        }
    };
    toggleFormConfirmationOptInFields = function (isChecked) {
        if (isChecked) {
            $('.field-formconfirmation-opt_in_type').show();
            toggleFormConfirmationOptInTypeFields($('[name$="FormConfirmation[opt_in_type]"]:checked'))
        } else {
            $('.field-formconfirmation-opt_in_type').hide();
            $('.field-formconfirmation-opt_in_message').hide();
            $('.field-formconfirmation-opt_in_url').hide();
        }
    };
    toggleFormConfirmationOptInTypeFields = function (e) {
        if (e.val() === "1") {
            $('.field-formconfirmation-opt_in_message').hide();
            $('.field-formconfirmation-opt_in_url').show();
        } else {
            $('.field-formconfirmation-opt_in_message').show();
            $('.field-formconfirmation-opt_in_url').hide();
        }
    };
    toggleFormEmailFields = function (e) {
        if(e.val() === "2") {
            $('.field-formemail-message').show();
        } else {
            $('.field-formemail-message').hide();
        }
    };

    // Events
    $('#form-shared').find( ".btn" ).on('click', function(e) {
        toggleShared($(this).children());
    });
    $('#form-submission_editable').find( ".btn" ).on('click', function(e) {
        toggleEditable($(this).children());
    });
    $('#form-schedule').find( ".btn" ).on('click', function(e) {
        toggleSchedule($(this).children());
    });
    $('#form-total_limit').find( ".btn" ).on('click', function(e) {
        toggleTotalLimit($(this).children());
    });
    $('#form-user_limit').find( ".btn" ).on('click', function(e) {
        toggleUserLimit($(this).children());
    });
    $('#formconfirmation-type').find( ".btn" ).on('click', function(e) {
        toggleFormConfirmationFields($(this).children());
    });
    $('#formconfirmation-rules').on('click', '.btn-group .btn', function(e) {
        toggleFormConfirmationRuleFields($(this).children());
    });
    $('#formconfirmation-send_email').find( ".btn" ).on('click', function(e) {
        toggleFormConfirmationEmailFields($(this).children());
    });
    $('#formconfirmation-opt_in').on('click', function(e) {
        toggleFormConfirmationOptInFields($(this).is(':checked'));
    });
    $('#formconfirmation-opt_in_type').find( ".btn" ).on('click', function(e) {
        toggleFormConfirmationOptInTypeFields($(this).children());
    });
    $('#formemail-type').find( ".btn" ).on('click', function(e) {
        toggleFormEmailFields($(this).children());
    });

    // Init
    toggleShared($('[name$="Form[shared]"]:checked'));
    toggleEditable($('[name$="Form[submission_editable]"]:checked'));
    toggleSchedule($('[name$="Form[schedule]"]:checked'));
    togglePassword();
    toggleUrls();
    toggleTotalLimit($('[name$="Form[total_limit]"]:checked'));
    toggleUserLimit($('[name$="Form[user_limit]"]:checked'));
    toggleFormConfirmationFields($('[name$="FormConfirmation[type]"]:checked'));
    toggleFormConfirmationEmailFields($('[name$="FormConfirmation[send_email]"]:checked'));
    toggleFormEmailFields($('[name$="FormEmail[type]"]:checked'));

    /**
     * Submission Editable Conditions Builder
     */

    $('#submission-editable-conditions-builder')
        .conditionsWidget({
            'field': '#form-submission_editable_conditions',
            'url': ruleBuilderURL,
            'initialize': true
        })
        .end()

    /**
     * Confirmation Settings with Conditional Logic
     */

    var regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    var regexName = /(^.+?)([\[\d{1,}\]]{1,})(\[.+\]$)/i;

    var _updateAttrID = function(element, index) {
        var id            = element.attr('id');
        var newID         = id;

        if (id !== undefined) {
            var matches = id.match(regexID);
            if (matches && matches.length === 4) {
                matches[2] = matches[2].substring(1, matches[2].length - 1);
                var identifiers = matches[2].split('-');
                identifiers[0] = index;

                if (identifiers.length > 1) {
                    for (var i = identifiers.length - 1; i >= 1; i--) {
                        identifiers[i] = element.closest('.item').index();
                    }
                }

                newID = matches[1] + '-' + identifiers.join('-') + '-' + matches[3];
                element.attr('id', newID);
            } else {
                newID = id + index;
                element.attr('id', newID);
            }
        }

        if (id !== newID) {
            element.closest('.item').find("label[for='" + id + "']").attr('for', newID);
        }

        return newID;
    };

    var _updateAttrName = function(element, index) {
        var name = element.attr('name');

        if (name !== undefined) {
            var matches = name.match(regexName);

            if (matches && matches.length === 4) {
                matches[2] = matches[2].replace(/\]\[/g, "-").replace(/\]|\[/g, '');
                var identifiers = matches[2].split('-');
                identifiers[0] = index;

                if (identifiers.length > 1) {
                    for (var i = identifiers.length - 1; i >= 1; i--) {
                        identifiers[i] = element.closest('.item').index();
                    }
                }

                name = matches[1] + '[' + identifiers.join('][') + ']' + matches[3];
                element.attr('name', name);
            }
        }

        return name;
    };

    var _removeAttrDisabled = function(element, index) {
        element.removeAttr('disabled');
    };

    var _updateAttributes = function() {
        $('.item').each(function(index) {
            var item = $(this);
            $(this).find('*').each(function() {
                // update "id" attribute
                _updateAttrID($(this), index);

                // update "name" attribute
                _updateAttrName($(this), index);

                // remove "disabled" attribute
                _removeAttrDisabled($(this), index);
            });
        });
    };

    _updateAttributes();

    $('.item').each(function(index) {
        // Toggle Action fields
        toggleFormConfirmationRuleFields($(this).find('[name$="FormConfirmationRule['+index+'][action]"]:checked'));
        // Load Conditions Widget
        $(this)
            .find('.rule-builder-conditions')
            .attr('id', 'conditions-builder-' + index)
            .conditionsWidget({
                'field': '#formconfirmationrule-' + index + '-conditions',
                'url': ruleBuilderURL,
                'initialize': true
            })
            .end()
    });

    $('form')
        // Add button click handler
        .on('click', '.add-item', function() {
            var item = $('.item').size();

            var template = $('#itemTemplate'),
                cloned = template
                    .clone()
                    .removeClass('hide')
                    .addClass('item')
                    .removeAttr('id')
                    .insertBefore(template);

            cloned
                .find('#formconfirmationrule-action')
                .attr('id', 'formconfirmationrule-action-' + item)
                .end()
                .find('#formconfirmationrule-action-' + item + ' .btn:first')
                .click()
                .end()
                .find('[name="FormConfirmationRule[action]"]')
                .attr('name', 'FormConfirmationRule[' + item + '][action]')
                .attr('id', 'formconfirmationrule-' + item + '-action')
                .removeAttr('disabled')
                .end()
                .find('[name="FormConfirmationRule[conditions]"]')
                .attr('name', 'FormConfirmationRule[' + item + '][conditions]')
                .attr('id', 'formconfirmationrule-' + item + '-conditions')
                .removeAttr('disabled')
                .end()
                .find('[name="FormConfirmationRule[message]"]')
                .attr('name', 'FormConfirmationRule[' + item + '][message]')
                .attr('id', 'formconfirmationrule-' + item + '-message')
                .removeAttr('disabled')
                .end()
                .find('[name="FormConfirmationRule[url]"]')
                .attr('name', 'FormConfirmationRule[' + item + '][url]')
                .attr('id', 'formconfirmationrule-' + item + '-url')
                .removeAttr('disabled')
                .end()
                .find('label[for="formconfirmationrule-append"]')
                .attr('for', 'formconfirmationrule-' + item + '-append')
                .end()
                .find('[name="FormConfirmationRule[append]"]')
                .attr('name', 'FormConfirmationRule[' + item + '][append]')
                .attr('id', 'formconfirmationrule-' + item + '-append')
                .removeAttr('disabled')
                .end()
                .find('label[for="formconfirmationrule-alias"]')
                .attr('for', 'formconfirmationrule-' + item + '-alias')
                .end()
                .find('[name="FormConfirmationRule[alias]"]')
                .attr('name', 'FormConfirmationRule[' + item + '][alias]')
                .attr('id', 'formconfirmationrule-' + item + '-alias')
                .removeAttr('disabled')
                .end()
                .find('[name="FormConfirmationRule[seconds]"]')
                .attr('name', 'FormConfirmationRule[' + item + '][seconds]')
                .attr('id', 'formconfirmationrule-' + item + '-seconds')
                .removeAttr('disabled')
                .end()
                .find('.rule-builder-conditions')
                .attr('id', 'conditions-builder-' + item)
                .conditionsWidget({
                    'field': '#formconfirmationrule-' + item + '-conditions',
                    'url': ruleBuilderURL,
                    'initialize': true
                })
                .end();

            item++;
        })
        // Remove button click handler
        .on('click', '.copy-item', function() {
            var fieldset = $(this).closest('fieldset');
            var actionButton = fieldset
                .find("label.btn.active");
            var cloned = fieldset
                    .clone()
                    .removeAttr('id')
                    .insertAfter(fieldset);
            _updateAttributes();
            var item = cloned.index();
            cloned
                .find('.rule-builder-conditions')
                .attr('id', 'conditions-builder-' + item)
                .conditionsWidget({
                    'field': '#formconfirmationrule-' + item + '-conditions',
                    'url': ruleBuilderURL
                })
                .end()
            actionButton.click();
        })
        // Remove button click handler
        .on('click', '.remove-item', function() {
            var fieldset = $(this).closest('fieldset');
            fieldset.remove();
            _updateAttributes();
        });

});
