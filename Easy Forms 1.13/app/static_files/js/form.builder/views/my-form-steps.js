/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @description JavaScript Form Builder for Easy Forms
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

define([
    "jquery", "underscore", "backbone"
    , "helper/pubsub"
    , "text!templates/app/formSteps.html"
    , "text!templates/popover/popover-main-steps.html"
    , "text!templates/popover/popover-input.html"
    , "text!templates/popover/popover-select.html"
    , "text!templates/popover/popover-textarea.html"
    , "text!templates/popover/popover-textarea-split.html"
    , "text!templates/popover/popover-checkbox.html"
], function(
    $, _, Backbone
    , PubSub
    , _pageHeader
    , _PopoverMain
    , _PopoverInput
    , _PopoverSelect
    , _PopoverTextArea
    , _PopoverTextAreaSplit
    , _PopoverCheckbox
    ){
    return Backbone.View.extend({
        tagName: "div"
        , id: "form-steps"
        , events: {
            "click"   : "preventPropagation" //stops checkbox / radio reacting.
            , "mousedown" : "mouseDownHandler"
            , "mouseup"   : "mouseUpHandler"
        }
        , initialize: function(options) {
            this.template = _.template(_pageHeader);
            this.popoverTemplates = {
                "input" : _.template(_PopoverInput)
                , "select" : _.template(_PopoverSelect)
                , "textarea" : _.template(_PopoverTextArea)
                , "textarea-split" : _.template(_PopoverTextAreaSplit)
                , "checkbox" : _.template(_PopoverCheckbox)
            };
            // Init view, one time
            this.options = options;
            this.htmlCode = '';
        }
        , close: function () {
            this.undelegateEvents();
            this.$el.removeData().unbind();
            this.remove();
        }
        , render: function(withAttributes) {
            if (withAttributes) { // For builder preview
                this.$el.html(
                    this.template(this.model.getValues())
                ).attr({
                    "class"             : "component component-form-steps col-xs-12"
                    , "data-title"      : "Form Steps"
                    , "data-trigger"    : "manual"
                    , "data-placement"  : "right"
                    , "data-container"  : "body"
                    , "data-html"       : true
                });
            } else {
                // If not, parse the component with the component data
                this.htmlCode = this.template(this.model.getValues());
            }
            return this;
        }
        , getPopoverContent: function () {
            var that = this;
            // Divide fields in basic and advanced
            var basicFields = {};
            var advancedFields = {};
            _.map(this.model.get('fields'), function(field, key) {
                if (field.advanced === true) {
                    advancedFields[key] = field;
                } else {
                    basicFields[key] = field;
                }
            });

            // HTML of the basic and advanced fields
            var basicFieldsHtml = _.reduce(basicFields, function(str, v, k){
                v["name"] = k;
                return str + that.popoverTemplates[v["type"]](v);
            }, "");
            var advancedFieldsHtml = _.reduce(advancedFields, function(str, v, k){
                v["name"] = k;
                return str + that.popoverTemplates[v["type"]](v);
            }, "");

            // Return the HTML of the popover
            return _.template(_PopoverMain)({
                "title": that.model.get('title'),
                "basicFields" : basicFieldsHtml,
                "advancedFields" : advancedFieldsHtml
            });
        }
        , mouseDownHandler: function(mouseDownEvent){
            mouseDownEvent.stopPropagation();
            mouseDownEvent.preventDefault();
            var that = this;
            // Popover
            $(".popover").remove();
            this.$el.popover({
                trigger: 'manual',
                placement: function () {
                    if (window.GridColumns === 8 || window.GridColumns === 12) {
                        return 'bottom';
                    }
                    return 'right';
                },
                html: true,
                sanitize: false,
                content: function() {
                    return that.getPopoverContent();
                }
            });
            this.$el.popover("show");
            $(".popover #save").on("click", this.saveHandler(that));
            $(".popover #cancel").on("click", this.cancelHandler(that));
        }

        , preventPropagation: function(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        , mouseUpHandler : function(mouseUpEvent) {
            $("body").off("mousemove");
        }

        , saveHandler : function(boundContext) {
            return function(mouseEvent) {
                mouseEvent.preventDefault();
                var fields = $(".popover .field");
                _.each(fields, function(e){

                    var $e = $(e)
                        , type = $e.attr("data-type")
                        , name = $e.attr("id");

                    switch(type) {
                        case "checkbox":
                            boundContext.model.setField(name, $e.is(":checked"));
                            break;
                        case "input":
                            boundContext.model.setField(name, $e.val());
                            break;
                        case "textarea":
                            boundContext.model.setField(name, $e.val());
                            break;
                        case "textarea-split":
                            boundContext.model.setField(name,
                                _.chain($e.val().split("\n"))
                                    .map(function(t){return $.trim(t)})
                                    .filter(function(t){return t.length > 0})
                                    .value()
                            );
                            break;
                        case "select":
                            var valarr = _.map($e.find("option"), function(e){
                                return {value: e.value, selected: e.selected, label:$(e).text()};
                            });
                            boundContext.model.setField(name, valarr);
                            break;
                    }
                });
                // Send trigger to form in construction
                PubSub.trigger("changeFormSteps", boundContext.model);
                $(".popover").remove();
            }
        }

        , cancelHandler : function(boundContext) {
            return function(mouseEvent) {
                mouseEvent.preventDefault();
                $(".popover").remove();
            }
        }

    });
});