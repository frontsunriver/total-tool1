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
    'jquery', 'underscore', 'backbone'
    , "helper/pubsub"
    , "text!templates/app/tab-nav.html"
    , "text!templates/app/settingsForm.html"

], function($, _, Backbone
    , PubSub
    , _tabNavTemplate
    , _settingsForm){
    return Backbone.View.extend({
        tagName: "div"
        , className: "tab-pane"
        , initialize: function(options) {
            this.options = options;
            this.id = this.options.id;
            this.tabNavTemplate = _.template(_tabNavTemplate);
            if (this.id === "settings") { // Tab title minified
                this.renderForm = _.template(_settingsForm);
            }
            this.render();
        }
        , render: function(){
            // Render Widget Views
            var that = this;
            if (!_.isUndefined(that.collection)) {
                _.each(that.collection.renderAllAsWidgets(), function(widget){
                    that.$el.append(widget);
                });
            } else if (that.options.content){
                if(that.id === "code") {
                    that.$el.append($("<label></label>").text(polyglot.t('form.sourceCode')));
                    that.$el.append($("<button type='button' id='copy-source-code' class='btn-clipboard'></button>")
                        .text(polyglot.t('form.copy'))
                        .attr("title", polyglot.t('form.copyToClipboard')));
                    that.$el.append(that.options.content);
                }
            }
            // Render & append nav for tab
            $("#formtabs").append(this.tabNavTemplate({title: this.options.title, id: this.id}));
            // Render tab
            this.$el.attr("id", this.id);
            this.$el.attr("role", "tabpanel");
            this.$el.appendTo(".tab-content");

            // Render form settings
            if (this.id === "settings") { // Tab title minified

                this.$el.append(that.renderForm({
                    name: that.options.settings.name,
                    disabledFieldset: that.options.settings.disabledFieldset,
                    layouts: that.options.settings.layouts,
                    layoutSelected: that.options.settings.layoutSelected
                }));

                // Add Events to "Form Settings"

                // Disable form submit on enter keypress
                $("#settings-form-name").on("keyup keypress", function(e) {
                    var code = e.keyCode || e.which;
                    if (code === 13) {
                        e.preventDefault();
                        return false;
                    }
                });
                // Add onChange event handler
                $("#settings").find(":input").on("change", function(e){
                    e.preventDefault();
                    // Get selected values
                    var name = $("#settings-form-name").val();
                    var disabledFieldset = $("#settings-form-disabled-fieldset").is(":checked");
                    var layoutSelected = $("#settings-form-layout-selected").val();
                    var formSettings = {
                        name: name,
                        disabledFieldset: disabledFieldset,
                        layoutSelected: layoutSelected
                    };

                    // Send trigger to form in construction
                    PubSub.trigger("changeFormSettings", formSettings);
                });
            }

            this.delegateEvents();
        }
    });
});