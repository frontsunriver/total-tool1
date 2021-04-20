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
    "jquery", "underscore"
    , "views/widget"
    , "text!templates/app/temp.html"
    , "helper/pubsub"
], function(
    $, _
    , WidgetView
    , _tempTemplate
    , PubSub
    ){
    return WidgetView.extend({
        initialize: function(){
            PubSub.on("newTempPostRender", this.postRender, this);
            PubSub.on("cancelTempPostRender", this.cancelPostRender, this);
            this.constructor.__super__.initialize.call(this);
            this.tempTemplate = _.template(_tempTemplate);
        }
        , className: "temp"
        , render: function() {
            return this.$el.html(this.tempTemplate({text: this.constructor.__super__.render.call(this).html()}));
        }
        , close: function () {
            this.undelegateEvents();
            this.$el.removeData().unbind();
            PubSub.off('newTempPostRender');
            PubSub.off('cancelTempPostRender');
            this.remove();

        }
        , postRender: function (mouseEvent) {
            this.tempForm  = this.$el.find("form")[0];
            this.halfHeight = Math.floor(this.tempForm.clientHeight/2);
            this.halfWidth  = Math.floor(this.tempForm.clientWidth/2);
            this.centerOnEvent(mouseEvent);
        }
        , events: {
            "mousemove": "mouseMoveHandler",
            "mouseup" : "mouseUpHandler"
        }
        , centerOnEvent: function (mouseEvent) {
            var mouseX     = mouseEvent.pageX;
            var mouseY     = mouseEvent.pageY;
            this.tempForm.style.top = (mouseY - this.halfHeight) + "px";
            this.tempForm.style.left = (mouseX - this.halfWidth) + "px";
            // Make sure the element has been drawn and
            // has height in the dom before triggering.
            PubSub.trigger("tempMove", mouseEvent, this.model);
        }
        , mouseMoveHandler: function (mouseEvent) {
            mouseEvent.preventDefault();
            this.centerOnEvent(mouseEvent);
        }
        , mouseUpHandler: function (mouseEvent) {
            mouseEvent.preventDefault();
            PubSub.trigger("tempDrop", mouseEvent, this.model);
            this.close();
        }
        , cancelPostRender: function (e) {
            // If "ESC" key is pressed
            if (!_.isUndefined(e.keyCode) && e.keyCode === 27) {
                PubSub.trigger("cancelTempMove", this.model);
                this.close();
            }
        }
    });
});