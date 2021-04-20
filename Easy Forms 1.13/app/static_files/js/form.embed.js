/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

$(document).ready(function () {

    window.formEl = $(options.name); // Get the form element
    var progressEl = $('#progress');
    var barEl = $('#bar');
    var percentEl = $('#percent');
    var fieldset = $("fieldset");
    var current_fs, next_fs, previous_fs; // Used in form multi steps
    var beganFilling = false;
    var startTime = 0;
    var fp = null;
    var lat = null;
    var lng = null;

    formEl.attr("role", "form"); // Add bootstrap role to form

    // Add csrf token to form
    $('<input>').attr({
        type: 'hidden',
        id: '_csrf',
        name: '_csrf',
        value: options._csrf
    }).appendTo(formEl);

    // Text direction
    if (options.text_direction === "rtl") {
        formEl.find(':input').attr('dir', 'rtl');
    }

    // Enable / Disable browser autocomplete
    if (options.autocomplete) {
        formEl.attr("autocomplete", "on");
    } else {
        formEl.attr("autocomplete", "off");
    }

    // Enable / Disable browser validation
    if (options.novalidate) {
        formEl.attr("novalidate", "novalidate");
    } else {
        if (formEl.attr("novalidate") !== "novalidate") {
            formEl.removeAttr("novalidate");
        }
    }

    // Enable Save & Resume Later
    if (options.resume) {
        formEl.resume({
            key: 'form_app_' + options.id
        });
    }

    // Enable fingerprint
    if (options.fingerprint) {
        Fingerprint2.get(function(components) {
            fp = Fingerprint2.x64hash128(components.map(function (pair) { return pair.value }).join(), 31);
        })
    }

    // Enable browser geolocation
    if (options.geolocation && navigator && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            // Latitude and Longitude
            lat = position.coords.latitude;
            lng = position.coords.longitude;
        });
    }

    // Fire resize event only when resizing is finished
    setInterval(doneResizing, 100); // 500 for better performance
    var oHeight;

    function doneResizing() {
        var nHeight = Math.max(
            window.document.body.scrollHeight,
            window.document.body.offsetHeight,
            window.document.documentElement.offsetHeight
        );
        if (oHeight !== nHeight) {
            // Send new height to parent window
            Utils.postMessage({
                height: nHeight
            });
            oHeight = nHeight;
        }
    }

    // After the form page loaded
    $(window).load(function () {

        // Preview mode
        if (options.mode === "preview") {
            return false;
        }

        // Load Signature Field
        var canvasElement = $('canvas');
        if (canvasElement.length > 0) {
            //Refactor to take multiple canvas
            for (var countCanvas = 0; countCanvas < canvasElement.length; countCanvas++) {
                (function (canvasEl) {
                    var signaturePad = new SignaturePad(canvasEl),
                        canvasID = signaturePad.canvas.id,
                        fieldID = "#hidden_" + canvasID,
                        resetID = "#clear_" + canvasID,
                        undoID = "#undo_" + canvasID;
                    var updateSignature = function () {
                        var data = signaturePad.toData();
                        if (data.length > 0) {
                            var signature = {
                                data: signaturePad.toData(),
                                dataURL: signaturePad.toDataURL()
                            };
                            $(fieldID).val(JSON.stringify(signature));
                        } else {
                            $(fieldID).val("");
                        }
                        $(fieldID).trigger('change');
                    };
                    signaturePad.onEnd = function () {
                        updateSignature();
                    };
                    // Color
                    var penColor = $('#' + canvasID).data('color');
                    if (penColor && penColor.length > 0 && penColor !== 'black') {
                        signaturePad.penColor = penColor;
                    }
                    // Reset
                    $(resetID).on("click", function () {
                        signaturePad.clear();
                        updateSignature();
                    });
                    // Undo
                    $(undoID).on("click", function () {
                        var data = signaturePad.toData();
                        if (data) {
                            data.pop(); // remove the last dot or line
                            signaturePad.fromData(data);
                            updateSignature();
                        }
                    });
                    // Success submit
                    formEl.on('success', function () {
                        signaturePad.clear();
                        updateSignature();
                    });
                })(canvasElement[countCanvas]);
            }
        }

        // Pre-fill form fields by query strings
        var parentUrl = Utils.getUrlVars()['parentUrl'];
        parentUrl = parentUrl && parentUrl.length > 0 ? decodeURIComponent(parentUrl) : window.location.href;
        if (parentUrl && parentUrl.length > 0) {
            formEl.find(':input').each(function () {
                var fieldEl = $(this);
                var value = Utils.getUrlVars(parentUrl)[fieldEl.attr('id')];
                if (!value && fieldEl.data("alias") && fieldEl.data("alias").length > 0) {
                    value = Utils.getUrlVars(parentUrl)[fieldEl.data("alias")];
                }
                if (fieldEl.attr('type') === 'checkbox' || fieldEl.attr('type') === 'radio') {
                    if (value === 'true' || value === 'false') {
                        fieldEl.prop('checked', (value === 'true')).trigger('change');
                    }
                } else {
                    if (value) {
                        value = decodeURIComponent(value);
                        fieldEl.val(value).trigger('change');
                    }
                }
            });
        }

        // Pre-fill default values
        if (options.defaultValues) {
            options.defaultValues = JSON.parse(options.defaultValues);
            $.each(options.defaultValues, function (field, value) {
                var fieldType = field.split("_", 1).shift();
                var fieldEl = $("#" + field);
                if (fieldType === "checkbox" || fieldType === "radio") {
                    fieldEl.prop('checked', value).trigger('change');
                } else {
                    fieldEl.val(value).trigger('change');
                }
            });
        }

        // Pre-fill with submission data
        if (options.submissionData && options.fields) {
            var data = JSON.parse(options.submissionData);
            var keys = $.map(options.fields, function(field, index) {
                return field['name'];
            });
            $.each(keys, function(index, key) {
                var parts = key.split("_", 1);
                var componentType = parts[0];
                if (componentType === "selectlist") {
                    var selected = data[key];
                    // Remove default values
                    $('select[name="' + key + '[]"] option:selected').prop("selected", false);
                    $('select[name="'+key+'[]"]').each(function() {
                        var elem = $(this);
                        if (typeof selected === 'string') {
                            $('select[name="'+key+'[]"]' + " option[value=\"" + selected + "\"]").prop("selected", true);
                        } else if (Array.isArray(selected)) {
                            $.each(selected, function(i, val) {
                                $('select[name="'+key+'[]"]' + " option[value=\"" + val + "\"]").prop("selected", true);
                            });
                        }
                    });
                } else if (componentType === "checkbox") {
                    var checks = data[key];
                    // Remove default values
                    $('input[name="'+key+'[]"]').prop('checked', false).each(function() {
                        var elem = $(this);
                        if (typeof checks !== "undefined") {
                            $.each(checks, function(i, val){
                                if (elem.val() === val) {
                                    elem.prop('checked', true);
                                }
                            });
                        }
                    });
                } else if (componentType === "radio") {
                    $('input[name="'+key+'"]').each(function(i, val) {
                        var elem = $(val);
                        if (elem.val() === data[key]) {
                            elem.prop('checked', true);
                        }
                    });
                } else if (componentType === "matrix"){
                    // Find Field
                    var field = $('#'+key);
                    if (field.length === 0 || (field.not("input") && !field.is("select") && !field.is("textarea"))) {
                        // Radio
                        field = $('input[name="'+key+'"]');
                        // Checkbox
                        if (field.length === 0) {
                            field = $('input[name="'+key+'[]"]');
                        }
                    }
                    // Populate
                    if (field.is("select")) {
                        var selected = data[key];
                        // Remove default values
                        $('select[name="' + key + '[]"] option:selected').prop("selected", false);
                        $('select[name="'+key+'[]"]').each(function() {
                            var elem = $(this);
                            if (typeof selected === 'string') {
                                $('select[name="'+key+'[]"]' + " option[value=\"" + selected + "\"]").prop("selected", true);
                            } else if (Array.isArray(selected)) {
                                $.each(selected, function(i, val) {
                                    $('select[name="'+key+'[]"]' + " option[value=\"" + val + "\"]").prop("selected", true);
                                });
                            }
                        });
                    } else if (field.is(":radio")) {
                        field.each(function(i, val) {
                            var elem = $(val);
                            if (elem.val() === data[key]) {
                                elem.prop('checked', true);
                            }
                        });
                    } else if (field.is(":checkbox")) {
                        var checks = data[key];
                        // Remove default values
                        $('input[name="'+key+'[]"]').prop('checked', false).each(function() {
                            var elem = $(this);
                            $.each(checks, function(i, val){
                                if (elem.val() === val) {
                                    elem.prop('checked', true);
                                }
                            });
                        });
                    } else {
                        field.val(data[key]);
                    }
                } else if (key.substring(0, 16) === "hidden_signature") {
                    var canvasElement = $('canvas');
                    if (canvasElement.length > 0) {
                        //Refactor to take multiple canvas
                        for (var countCanvas=0; countCanvas < canvasElement.length; countCanvas++) {
                            (function(canvasEl){
                                var signaturePad = new SignaturePad(canvasEl);
                                // Draws signature image from data.
                                if (typeof data[key] !== 'undefined' && data[key]) {
                                    var signature = JSON.parse(data[key]);
                                    signaturePad.fromData(signature['data']);
                                }
                                var canvasID = signaturePad.canvas.id;
                                var fieldID = "#hidden_"+canvasID;
                                var resetID= "#clear_"+canvasID;
                                var undoID = "#undo_"+canvasID;
                                var saveData = function() {
                                    var signature = {
                                        data: signaturePad.toData(),
                                        dataURL: signaturePad.toDataURL()
                                    };
                                    $(fieldID).val(JSON.stringify(signature));
                                };

                                // Find the Hidden Element with canvas name
                                $(fieldID).val(data[key]);
                                signaturePad.onEnd = function(){
                                    saveData();
                                };
                                // Color
                                var penColor = $('#'+canvasID).data('color');
                                if (penColor && penColor.length > 0 && penColor !== 'black') {
                                    signaturePad.penColor = penColor;
                                }
                                // Clear
                                $(resetID).on("click",function() {
                                    signaturePad.clear();
                                    $(fieldID).val("");
                                });
                                // Undo
                                $(undoID).on("click",function() {
                                    var data = signaturePad.toData();
                                    if (Array.isArray(data) && data.length) {
                                        data.pop(); // remove the last dot or line
                                        signaturePad.fromData(data);
                                        saveData();
                                    }
                                });
                            })(canvasElement[countCanvas]);
                        }
                    }
                } else {
                    $('#'+key).val(data[key]);
                }
            });
        }

        // Trigger event
        formEl.trigger("view");

        /**
         * One Change handler
         * @type {boolean}
         */
        formEl.find(':input').each(function () {
            $(this).one("change", function () {
                if (beganFilling === false) {

                    // Preview mode
                    if (options.mode === "preview") {
                        return false;
                    }

                    // Start timing
                    startTime = (new Date()).getTime();

                    // Trigger event
                    formEl.trigger("fill");
                }
                beganFilling = true;
            });
        });
    });

    /**
     * Pagination handlers
     */
    window.nextStep = function () {
        var hasError = false; // Flag to prevent go to next page
        current_fs = formEl.find('fieldset:visible');
        next_fs = current_fs.next();
        if (options.skips.length > 0) {
            for (var i = 0; i < options.skips.length; i++) {
                if (fieldset.index(current_fs) < options.skips[i].to) {
                    var tmp_next_fs = fieldset.eq(options.skips[i].to);
                    if (fieldset.index(current_fs) < fieldset.index(tmp_next_fs)) {
                        if (options.skips[i].from == null || options.skips[i].from == fieldset.index(current_fs)) {
                            options.skips[i].from = fieldset.index(current_fs);
                            next_fs = tmp_next_fs;
                        }
                        break;
                    }
                }
            }
        }
        // Check if next step exists
        if (next_fs.is('fieldset')) {
            // Perform validations
            $.ajax({
                url: options.validationUrl,
                type: 'post',
                data: formEl.serialize(),
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json"
                },
                complete: function (jqXHR, textStatus) {
                },
                beforeSend: function (jqXHR, settings) {
                    var requiredFile = current_fs.find('input:file[required]');
                    if (requiredFile.size() > 0) {
                        $.each(requiredFile, function () {
                            if ($(this).val()) {
                                settings.data = settings.data + '&' + $(this).attr('name') + '=1';
                            }
                        });
                    }
                    settings.data = settings.data + '&current_page=' + fieldset.index(current_fs);
                },
                success: function (errors) {
                    if (errors !== null && typeof errors === 'object') {

                        // Clean previous errors and messages of te current field set
                        current_fs.find(".error-block").remove();
                        current_fs.find(".form-group").removeClass('has-error');

                        // Show validation errors
                        $.each(errors, function (key, error) {
                            var fieldGroup = current_fs.find("#" + key).closest(".form-group");
                            if (fieldGroup.size() > 0) {
                                hasError = true;
                                fieldGroup.addClass("has-error");
                                // add the actual error message under the input
                                var errorBlock = $("<div>", {"class": "help-block error-block", "html": error});
                                fieldGroup.append(errorBlock);
                            }
                        });

                    }

                    if (!hasError) {
                        current_fs.hide();
                        var steps = $(".steps");
                        if (steps.size() > 0) {
                            // De-activate current step
                            steps.find(".step").eq(fieldset.index(current_fs)).removeClass("current");
                            // Add success to current and previous steps
                            steps.find(".step").eq(fieldset.index(next_fs)).prevAll().addClass("success");
                            // Activate next step
                            steps.find(".step").eq(fieldset.index(next_fs)).addClass("current");
                        } else {
                            // Find progress bar elements
                            var progress = $(".progress").first();
                            var progressBar = progress.find(".progress-bar");
                            var percent = progressBar.find(".percent");
                            var title = progressBar.find(".title");
                            // Update title
                            var titles = progressBar.data("titles");
                            if (typeof titles !== "undefined") {
                                titles = titles.split(",");
                                var next_title = titles[fieldset.index(next_fs)];
                                title.html(next_title);
                            }
                            // Update percent
                            var new_percent = Math.round(100 / fieldset.size() * fieldset.index(next_fs)) + "%";
                            percent.text(new_percent);
                            // Update bar
                            progressBar.width(new_percent);
                        }

                        if (next_fs.is('fieldset')) {
                            // Show next fieldset
                            next_fs.show();
                            // Save previous_fs in cache
                            previous_fs = current_fs;
                        }
                    }

                    // Trigger event
                    formEl.trigger("nextStep");
                    // Scroll to Top of the form container
                    Utils.postMessage({
                        scrollToTop: 'container'
                    });
                },
                error: function () {
                    // Show error message
                    Utils.showMessage('#messages',
                        options.i18n.unexpectedError,
                        'danger');
                    // Hide form
                    formEl.hide();
                    // Scroll to Top in the parent window
                    Utils.postMessage({
                        scrollToTop: 'container'
                    });
                }
            });
        }
    };

    window.previousStep = function () {
        // Check if previous step exists
        if (previous_fs.is('fieldset')) {
            current_fs = formEl.find('fieldset:visible');
            for (var i = 0; i < options.skips.length; i++) {
                if (fieldset.index(current_fs) == options.skips[i].to) {
                    previous_fs = fieldset.eq(options.skips[i].from);
                    break;
                }
            }
            var steps = $(".steps");
            if (steps.size() > 0) {
                // Remove success to all steps
                steps.find(".step").removeClass("success");
                // De-activate current step
                steps.find(".step").eq(fieldset.index(current_fs)).removeClass("current");
                // Add success to previous steps
                steps.find(".step").eq(fieldset.index(previous_fs)).prevAll().addClass("success");
                // Activate previous step
                steps.find(".step").eq(fieldset.index(previous_fs)).addClass("current");
            } else {
                // Find progress bar elements
                var progress = $(".progress").first();
                var progressBar = progress.find(".progress-bar");
                var percent = progressBar.find(".percent");
                var title = progressBar.find(".title");
                // Update title
                var titles = progressBar.data("titles");
                if (typeof titles !== "undefined") {
                    titles = titles.split(",");
                    var previous_title = titles[fieldset.index(previous_fs)];
                    title.html(previous_title);
                }
                // Update percent
                var new_percent = Math.round(100 / fieldset.size() * fieldset.index(previous_fs)) + "%";
                percent.text(new_percent);
                // Update bar
                progressBar.width(new_percent);
            }
            // Show previous fieldset
            current_fs.hide();
            previous_fs.show();
            previous_fs = previous_fs.prev();
            // Trigger event
            formEl.trigger("previousStep");
            // Scroll to Top in the parent window
            Utils.postMessage({
                scrollToTop: 'container'
            });
        }
    };

    $('input').on("keypress", function (e) {
        // Enter pressed
        if (e.keyCode == 13) {
            // Check if is a multi-step form
            var next = $(e.currentTarget).parents('fieldset').find(".next");
            // var next = $(".next").filter(":visible");
            if (next.size() > 0) {
                e.preventDefault();
                next.click();
                return false;
            }
        }
    });

    $(".next").click(nextStep);

    $(".prev").click(previousStep);

    /**
     * Submit form
     */
    formEl.ajaxForm({
        url: options.actionUrl,
        type: "post",
        dataType: 'json',
        beforeSend: function (xhr) {
            if (fp) {
                xhr.setRequestHeader('fp', fp);
            }
            if (lat && lng) {
                xhr.setRequestHeader('lat', lat);
                xhr.setRequestHeader('lng', lng);
            }
        },
        beforeSubmit: function (formData, jqForm, opts) {

            // Preview mode
            if (options.mode === "preview") {
                return false;
            }

            // Show progress bar
            var showProgressBar = false;
            $.each(jqForm.find('input[type="file"]'), function (index, fileInput) {
                if ($(fileInput).val()) {
                    showProgressBar = true;
                }
            });
            if (showProgressBar) {
                progressEl.show();
                var percentVal = '0%';
                barEl.css("width", percentVal);
                percentEl.html(percentVal + " " + options.i18n.complete);
            }

            formEl.find(':submit').attr("disabled", true); // Disable submit buttons

            // Trigger event
            formEl.trigger("beforeSubmit");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            barEl.css("width", percentVal);
            percentEl.html(percentVal + " " + options.i18n.complete);
        },
        success: function (data) {
            if (data.success) {
                // Reset for to init values
                cleanFormUI();
                successHandler(data);
            } else {
                errorHandler(data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {

            // Show error message
            Utils.showMessage('#messages',
                options.i18n.unexpectedError,
                'danger');
            // Hide the form
            formEl.hide();
            // Scroll to Top in the parent window
            Utils.postMessage({
                scrollToTop: 'container'
            });

        }
    });

    /**
     * Clean ui from error messages
     */
    function removeErrorMessages() {
        // Remove all error blocks
        $(".error-block").remove();
        // Remove css class
        $(".form-group").removeClass('has-error');
    }

    /**
     * Clean form UI
     */
    function cleanFormUI() {
        removeErrorMessages();
        // Enable submit buttons
        formEl.find(':submit').attr("disabled", false);
        // Reset form when we are not editing a form submission
        if (!(options.submissionData && options.fields)) {
            formEl.resetForm();
        }
        // Hide progress bar
        progressEl.hide();
    }

    /**
     * Execute when the form was successfully sent
     */
    function successHandler(data) {

        // Change Flag
        options.submitted = true;

        // Completion time
        var endTime = (new Date()).getTime();
        var completionTime = endTime - startTime; // In milliseconds

        // Trigger event
        formEl.trigger("success", [data, completionTime]);

        // Form Steps
        if (fieldset.size() > 1) {
            var steps = $(".steps");
            if (steps.size() > 0) {
                // Add success to all steps
                steps.find(".step").addClass("success");
            } else {
                // Find progress bar elements
                var progress = $(".progress").first();
                var progressBar = progress.find(".progress-bar");
                var percent = progressBar.find(".percent");
                var title = progressBar.find(".title");
                // Update title
                title.html("Complete");
                // Update percent
                percent.text("100%");
                // Update bar
                progressBar.width("100%");
            }
        }

        // Performs an action according to the indications
        if (typeof data.addon !== 'undefined') {
            if (typeof data.addon.redirectTo !== 'undefined') {
                // Redirect to URL
                var url = data.addon.redirectTo;
                if (window.location !== window.parent.location) {
                    Utils.postMessage({
                        url: url
                    });
                } else {
                    window.location.href = url ? url : '/';
                }
            }
        }

        // Performs an action according to the Confirmation type
        var confirmationType = typeof data.confirmationType === 'undefined' ? options.confirmationType : data.confirmationType;
        var confirmationMessage = typeof data.message === 'undefined' ? options.confirmationMessage : data.message;
        var confirmationUrl = typeof data.confirmationUrl === 'undefined' ? options.confirmationUrl : data.confirmationUrl;
        var confirmationSeconds = typeof data.confirmationSeconds === 'undefined' ? options.confirmationSeconds : data.confirmationSeconds;
        var confirmationRedirectToUrl = typeof data.redirectToUrl === 'undefined' ? options.redirectToUrl : data.redirectToUrl;
        var confirmationShowOnlyMessage = typeof data.showOnlyMessage === 'undefined' ? options.showOnlyMessage : data.showOnlyMessage;

        var redirectToUrl = function () {
            // Redirect to URL
            if (window.location !== window.parent.location) {
                Utils.postMessage({
                    url: confirmationUrl
                });
            } else {
                window.location.href = confirmationUrl ? confirmationUrl : '/';
            }
        };

        var showMessage = function () {
            // Hide old messages
            Utils.hideMessage('#messages');

            // Show success message
            Utils.showMessage('#messages', confirmationMessage, 'success');

            // Hide the form according to type of confirmation
            if (confirmationType === confirmationShowOnlyMessage) {
                // Hide the form
                formEl.hide();
            }

            // Scroll to Top in the parent window
            Utils.postMessage({
                scrollToTop: 'container'
            });
        };

        if (confirmationType === confirmationRedirectToUrl) {
            var seconds = parseInt(confirmationSeconds, 10);
            if (seconds > 0) {
                showMessage();
                setTimeout(function(){
                    redirectToUrl();
                },seconds * 1000);
            } else {
                redirectToUrl();
            }
        } else {
            showMessage();
        }
    }


    /**
     * Execute each time the form has errors
     *
     * @param data
     */
    function errorHandler(data) {

        // Hide old messages
        Utils.hideMessage('#messages');

        // Show error message
        if (typeof data.message !== 'undefined') {
            Utils.showMessage('#messages',
                data.message,
                'danger');
        }

        // Scroll to Top in the parent window
        Utils.postMessage({
            scrollToTop: 'container'
        });

        // Hide old validation errors
        removeErrorMessages();

        // Show validation errors
        if (typeof data.errors !== 'undefined' && data.errors.length > 0) {
            var errors = data.errors;
            for (k = 0; k < errors.length; k++) {
                var fieldGroup = $("#" + errors[k].field).closest(".form-group");
                fieldGroup.addClass("has-error");
                for (i = 0; i < errors[k].messages.length; i++) {
                    // add the actual error message under the input
                    var errorBlock = $("<div>", {"class": "help-block error-block", "html": errors[k].messages[i]});
                    fieldGroup.append(errorBlock);
                }
            }
        }

        // Enable submit buttons
        formEl.find(":submit").removeAttr("disabled");

        // Trigger event
        formEl.trigger("error", data);

    }

    /**
     * Post Messages
     */
    formEl.on('view', function (event) {
        Utils.postMessage({
            action: 'view',
        });
    });

    formEl.on('fill', function (event) {
        Utils.postMessage({
            action: 'fill',
        });
    });

    formEl.on('nextStep', function (event) {
        Utils.postMessage({
            action: 'nextStep',
        });
    });

    formEl.on('previousStep', function (event) {
        Utils.postMessage({
            action: 'previousStep',
        });
    });

    formEl.on('beforeSubmit', function(){
        Utils.postMessage({
            action: 'beforeSubmit',
        });
    });

    formEl.on('error', function (event, data) {
        Utils.postMessage({
            action: 'error',
            data: data,
        });
    });

    formEl.on('success', function (event, data, completionTime) {
        Utils.postMessage({
            action: 'success',
            data: data,
            completionTime: completionTime
        });
    });

    /**
     * Form Tracker
     */

    if (options.analytics) {
        // Init
        (function (p, l, o, w, i, n, g) {
            if (!p[i]) {
                p.FA = p.FA || [];
                p.FA.push(i);
                p[i] = function () {
                    (p[i].q = p[i].q || []).push(arguments)
                };
                p[i].q = p[i].q || [];
                n = l.createElement(o);
                g = l.getElementsByTagName(o)[0];
                n.async = 1;
                n.src = w;
                g.parentNode.insertBefore(n, g)
            }
        }(window, document, "script", options.tracker, "tracker"));

        window.tracker('newTracker', 't' + options.id, options.app, {
            encodeBase64: false,
            appId: options.id
        });

        // Track form page view
        formEl.on('view', function (event) {
            window.tracker('setCustomUrl', decodeURIComponent(Utils.getUrlVars()["url"]));  // Override the page URL
            window.tracker('setReferrerUrl', decodeURIComponent(Utils.getUrlVars()["referrer"]));  // Override the referrer URL
            window.tracker('trackPageView', decodeURIComponent(Utils.getUrlVars()["title"])); // Track the page view with custom title
        });

        // Track fill
        formEl.on('fill', function (event) {
            window.tracker('trackStructEvent', 'form', 'fill', 'start', null, null);
        });

        // Track validation error
        formEl.on('error', function (event) {
            window.tracker('trackStructEvent', 'form', 'error', null, null, null);
        });

        // Track submit with success
        formEl.on('success', function (event, submission, completionTime) {
            window.tracker('trackStructEvent', 'form', 'submit', submission.id, 'time', completionTime);
        });

    }

});
