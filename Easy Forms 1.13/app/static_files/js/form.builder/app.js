/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @description JavaScript Form Builder for Easy Forms
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 *
 * Based on:
 * Bootstrap 2.3.1 Form Builder
 * Copyright (C) 2012 Adam Moore
 * Licensed under MIT (https://github.com/minikomi/Bootstrap-Form-Builder/blob/gh-pages/LICENSE)
 */

define([
    "jquery" , "underscore" , "backbone", "polyglot"
    , "collections/components" , "collections/my-form-components" , "collections/my-form-styles"
    , "views/tab" , "views/tab-content" , "views/my-form", "views/styles"
    , "text!data/components.json", "text!data/i18n.json"
    , "text!data/init-form.json"
    , "text!data/css-rules.json"
    , "text!data/css-properties.json"
    , "text!templates/app/render.html"
    , "helper/pubsub"
    , "jquery.fontselect", "jquery.flexdatalist", "jquery.cookie", "jquery.bsAlerts", "spectrum", "spectrum-kv"
], function(
    $, _, Backbone, Polyglot
    , ComponentsCollection, MyFormComponentsCollection, MyFormStylesCollection
    , TabView, TabContentView, MyFormView, StylesView
    , components, i18n
    , initForm
    , cssRules
    , cssProperties
    , renderTab
    , PubSub
    ){
    return {

        csrfParam: '',
        csrfToken: '',

        initialize: function() {

            _.templateSettings = {
                evaluate:    /\{\{(.+?)\}\}/g,
                interpolate: /\{\{=(.+?)\}\}/g,
                escape: /\{\{-(.+?)\}\}/g
            };

            // Global variables
            window.FormBuilder = {
                data: "",
                html: ""
            };

            /**
             * Grid Columns
             * @type {number}
             */
            window.GridColumns = 5;

            // Collapse Styles
            $('#ef-styles')
                .on('click', '#ef-styles-collapse-all', function () {
                    $('#accordion').find('.panel-collapse').collapse('hide');
                })
                .on('click', '#ef-styles-expand-all', function () {
                    $('#accordion').find('.panel-collapse').collapse('show');
                });

            // Default values
            window.polyglot = new Polyglot(JSON.parse(i18n));
            initForm = JSON.parse(initForm);
            components = JSON.parse(components);
            cssRules = JSON.parse(cssRules);
            _.each(cssRules, function (cssRule) {
                cssRule['properties'] = JSON.parse(cssProperties);
            });

            // CSRF configuration
            this.csrfParam = $('meta[name="csrf-param"]').attr('content');
            this.csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Local variables
            var that = this;

            /**
             * Server Requests
             */

            $.when(
                $.ajax(options.i18nUrl),
                $.ajax(options.componentsUrl),
                $.ajax(options.initPoint)
            ).then(function (i18nData, componentsData, formData) {
                    // Replace default values
                    polyglot.replace(i18nData[0].phrases);
                    components = componentsData[0];
                    initForm = formData[0];
                    // Overwrite default css rules
                    if (!_.isUndefined(initForm['styles'])) {
                        // Note: New rules should be appended at the end of css-rules.json
                        cssRules = _.extend(cssRules, initForm['styles']);
                    }
                    that.render();
                }, function (){});
        },

        render: function() {

            // Local variables
            var that = this;

            /**
             * Tabs
             */

            new TabView({
                id: "fields"
                , title: polyglot.t('tab.fields')
                , collection: new ComponentsCollection(components)
            });
            new TabView({
                id: "settings"
                , title: polyglot.t('tab.settings')
                , isForm: true
                , settings: initForm.settings
            });
            new TabView({
                id: "code"
                , title: polyglot.t('tab.code')
                , content: renderTab
            });

            // Make the first tab active
            var formTabs = $("#formtabs");
            formTabs.find("li").first().addClass("active");
            formTabs.find("li .dropdown-menu li").first().addClass("active");
            $("#widgets").find(".tab-pane").first().addClass("active");

            // Hide Left Sidebar
            $("#ef-switcher-side-left").click(function (e) {
                e.preventDefault();
                $("#ef-widgets").hide();
                window.GridColumns = window.GridColumns + 4;
                $("#ef-main").removeClass().addClass("col-xs-12 col-md-" + window.GridColumns);
                $("#ef-switcher-main-left").show();
                PubSub.trigger('renderForm');
            });

            // Show Left Sidebar
            $("#ef-switcher-main-left").click(function (e) {
                e.preventDefault();
                $("#ef-widgets").show();
                window.GridColumns = window.GridColumns - 4;
                $("#ef-main").removeClass().addClass("col-xs-12 col-md-" + window.GridColumns);
                $("#ef-switcher-side-left").show();
                $(this).hide();
                PubSub.trigger('renderForm');
            });

            // Hide Right Sidebar
            $("#ef-switcher-side-right").click(function (e) {
                e.preventDefault();
                $("#ef-styles").hide();
                window.GridColumns = window.GridColumns + 3;
                $("#ef-main").removeClass().addClass("col-xs-12 col-md-" + window.GridColumns);
                $("#ef-switcher-main-right").show();
                PubSub.trigger('renderForm');
            });

            // Show Right Sidebar
            $("#ef-switcher-main-right").click(function (e) {
                e.preventDefault();
                $("#ef-styles").show();
                window.GridColumns = window.GridColumns - 3;
                $("#ef-main").removeClass().addClass("col-xs-12 col-md-" + window.GridColumns);
                $("#ef-switcher-side-right").show();
                $(this).hide();
                PubSub.trigger('renderForm');
            });

            /**
             * Hide Alert
             */

            // Grab your button (based on your posted html)
            $('.close').click(function(e) {
                // Do not perform default action when button is clicked
                e.preventDefault();
                // If you just want the cookie for a session don't provide an expires
                // Set the path as root, so the cookie will be valid across the whole site
                $.cookie('alert-box', 'closed');
            });

            // Check if alert has been closed
            if ($.cookie('alert-box') !== 'closed') {
                $('.alert').addClass("in").show();
            } else {
                $('.alert').removeClass("in").hide();
            }

            /**
             * Logout link
             */

            $("ul").find("[data-method='post']").click(function(e){
                e.preventDefault();
                var _csrfToken = {};
                _csrfToken[that.csrfParam] = that.csrfToken;
                $.ajax({
                    method: "POST",
                    url: $(this).attr('href'),
                    dataType: 'json',
                    data: _csrfToken
                }).always(function () {
                    location.reload();
                });
            });

            /**
             * Build Init Form
             */

            // New component collection
            var componentsCollection = new MyFormComponentsCollection();
            // Add each field to the collection (Component Model)
            componentsCollection.add(initForm.initForm);
            // Render "My Form View" with the collection of components.
            var formView = new MyFormView({
                settings: initForm.settings,
                collection: componentsCollection
            });

            /**
             * Form Designer
             */
            // New style collection
            var stylesCollection = new MyFormStylesCollection();
            // Add each style to the collection (Style Model)
            stylesCollection.add(cssRules);
            // Render "form Designer" with the collection of css styles.
            var stylesView = new StylesView({
                id: "design"
                , title: "Design"
                , collection: stylesCollection
            });

            /**
             * Save Form
             */

            PubSub.on("tempDrop", function () {
                // Prevent that user lost his data
                $(window).off('beforeunload').on('beforeunload', function(){
                    return polyglot.t('alert.unsavedChanges');
                });
            });

            $('#actions').find('.saveForm').click(function( e ){
                // Do not perform default action when button is clicked
                e.preventDefault();
                // Replace default values
                var target = $(e.target);
                options.endPoint = !_.isUndefined(target.data('endpoint')) &&
                    target.data('endpoint') !== '' ? target.data('endpoint') : options.endPoint;
                options.afterSave = !_.isUndefined(target.data('aftersave')) &&
                    target.data('aftersave') !== '' ? target.data('aftersave') : options.afterSave;
                options.redirectTo = !_.isUndefined(target.data('redirectto')) &&
                    target.data('redirectto') !== '' ? target.data('redirectto') : options.redirectTo;

                // Remove prevention
                $(window).off('beforeunload');

                // Save data in FormBuilder
                window.FormBuilder.data = {
                    settings: formView.options.settings,
                    initForm: componentsCollection.toJSON(),
                    styles: stylesCollection.toJSON(),
                    height: $("#my-form").find("fieldset").height()
                };

                // Prepare FormBuilder to POST as JSON
                var data = {
                    FormBuilder: JSON.stringify(window.FormBuilder)
                };
                data[that.csrfParam] = that.csrfToken; // Add csrf token

                // Send Form Data
                $.ajax({
                    method: "POST",
                    url: options.endPoint, // From external file configuration
                    dataType: 'json',
                    data: data
                }).done(function( data ) {

                    if( data.success && data.id > 0) {

                        // Redirect to another page
                        if (options.afterSave === 'redirect' && !_.isUndefined(options.redirectTo)) {

                            window.location.href = options.redirectTo;

                        } else { // Show a success message

                            // Set id in hidden field
                            $("#formId").val(data.id);

                            // If the action is create
                            if(data.action === "create") {
                                // Set update link
                                var toUpdate = $('#toUpdate');
                                var toUpdateUrl = toUpdate.attr("href");
                                var prefix = ( toUpdateUrl.indexOf('?') >= 0 ? '&' : '?' );
                                var toUpdateNewUrl = toUpdateUrl + prefix + "id=" + data.id;
                                toUpdate.attr("href", toUpdateNewUrl);
                                // Set publish link
                                var toPublish = $('#toPublish');
                                var toPublishUrl = toPublish.attr("href");
                                    prefix = ( toPublishUrl.indexOf('?') >= 0 ? '&' : '?' );
                                var toPublishNewUrl = toPublishUrl + prefix + "id=" + data.id;
                                toPublish.attr("href", toPublishNewUrl);
                                // Set form config link
                                var toSettings = $('#toSettings');
                                var toSettingsUrl = toSettings.attr("href");
                                    prefix = ( toSettingsUrl.indexOf('?') >= 0 ? '&' : '?' );
                                var toSettingsNewUrl = toSettingsUrl + prefix + "id=" + data.id;
                                toSettings.attr("href", toSettingsNewUrl);
                            }

                            // Show success message
                            $('#saved').modal('show');
                        }
                    } else {

                        // Show error message
                        $(document).trigger("add-alerts", [
                            {
                                'message': "<strong>" + polyglot.t('alert.warning') + "</strong> " + data.message,
                                'priority': 'warning'
                            }
                        ]);

                    }
                }).fail(function(msg){

                    // Show error message
                    $(document).trigger("add-alerts", [
                        {
                            'message': "<strong>" + polyglot.t('alert.warning') + "</strong> " + polyglot.t('alert.errorSavingData'),
                            'priority': 'warning'
                        }
                    ]);

                }).always(function(){
                });

            });

            /**
             * Show Form Builder
             */
            $("#ef-form-builder").show();
            setTimeout(function(){
                $("#ef-loading").hide();
            }, 10);

        }
    }
});