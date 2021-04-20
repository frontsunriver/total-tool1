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
    , "text!templates/popover/popover-main.html"
    , "text!templates/popover/popover-input.html"
    , "text!templates/popover/popover-select.html"
    , "text!templates/popover/popover-textarea.html"
    , "text!templates/popover/popover-textarea-split.html"
    , "text!templates/popover/popover-checkbox.html"
    , "../templates/widget/templates"
    , "bootstrap"
], function(
    $, _, Backbone
    , _PopoverMain
    , _PopoverInput
    , _PopoverSelect
    , _PopoverTextArea
    , _PopoverTextAreaSplit
    , _PopoverCheckbox
    , _widgetTemplates
    ){
    return Backbone.View.extend({
        tagName: "div"
        , className: "widget"
        , initialize: function(){
            this.template = _.template(_widgetTemplates[this.model.get('name')]);
        }
        , render: function(){
            var that = this;
            return this.$el.html(
                that.template(that.model.getValues())
            )
        }
    });
});