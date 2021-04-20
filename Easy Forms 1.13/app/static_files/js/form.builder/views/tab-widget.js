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
    , "models/component"
    , "views/widget", "views/temp-widget"
    , "helper/pubsub"
], function(
    $, _, Backbone
    , ComponentModel
    , WidgetView, TempWidgetView
    , PubSub
    ){
    return WidgetView.extend({
        events:{
            "mousedown" : "mouseDownHandler",
            "mousemove" : "mouseMoveHandler",
            "mouseup"   : "mouseUpHandler",
            "click"     : "clickHandler"
        }
        , mouseDownHandler: function(mouseDownEvent){
            mouseDownEvent.preventDefault();
            mouseDownEvent.stopPropagation();
            this.flag = 1;
            this.mouseDownEvent = mouseDownEvent;
        }
        , mouseMoveHandler: function (mouseMoveEvent) {
            if (this.flag === 1) {
                // hide all popovers
                $(".popover").hide();
                $("body").append(new TempWidgetView({model: new ComponentModel($.extend(true,{},this.model.attributes))}).render());
                PubSub.trigger("newTempPostRender", this.mouseDownEvent);
                this.flag = 2;
            }
        }
        , mouseUpHandler: function(mouseUpEvent) {
            this.flag = 0;
            this.mouseDownEvent = null;
        }
        , clickHandler: function (clickEvent) {
            PubSub.trigger("widgetClick",
                clickEvent,
                new ComponentModel($.extend(true,{},this.model.attributes)));
        }
    });
});