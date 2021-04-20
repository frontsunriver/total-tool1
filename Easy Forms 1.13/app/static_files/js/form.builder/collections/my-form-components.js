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
    "jquery" , "underscore" , "backbone"
    , "models/component"
    , "collections/components"
    , "views/my-form-component"
], function(
    $, _, Backbone
    , ComponentModel
    , ComponentsCollection
    , FormComponentView
    ){
    return ComponentsCollection.extend({
        model: ComponentModel
        , initialize: function() {
            this.bind("add", this.giveUniqueId);
            this._views = {};
            this._indexByModel = {};
        }
        , giveUniqueId: function(component){
            if (!component.get("fresh")) {
                return;
            }

            var componentName = component.get("name");
            var componentID = componentName + "_" + _.size(this.componentsByName(componentName));

            // Same Component ID detected
            if (_.size(this.componentsByFieldID(componentID)) > 0) {
                var randomNumber = Math.floor((Math.random() * 1000000) + 1); // Random number between 1 and 1000000
                componentID = componentName + "_" + randomNumber;
            }

            component.setField("id", componentID);
            component.set("fresh", false);
        }
        , componentsByFieldID: function (componentID) {
            return this.filter(function(component){
                return component.getField("id") === componentID;
            });
        }
        , componentsByName: function (componentName) {
            return this.filter(function(component){
                return component.get("name") === componentName;
            });
        }
        , pageBreaks: function(){
            return this.filter(function(component){
                return component.get("name") === "pagebreak"
            });
        }
        , containsFileType: function(){
            return !(typeof this.find(function(component){
                return component.get("name") === "file"
            }) === "undefined");
        }
        , containsRecaptcha: function () {
            return !(typeof this.find(function(component){
                return component.get("name") === "recaptcha"
            }) === "undefined");
        }
        , findViewByCid: function (cid) {
            return this._views[cid];
        }
        , findViewByModelCid: function(modelCid){
            var viewCid = this._indexByModel[modelCid];
            return this.findViewByCid(viewCid);
        }
        , findViewByModel: function(model){
            return this.findViewByModelCid(model.cid);
        }
        , loadViews: function () {
            var that = this;
            // Close old views to improve performance
            _.each(this._views, function(component){
                component.close();
            });
            // Clean
            this._views = {};
            this._indexByModel = {};
            // Load
            this.map(function(model) {
                that.addViewByModel(model);
            });
        }
        , removeViewByModel: function (model) {
            var view = this.findViewByModel(model);
            // Remove view from DOM and stop listening events
            view.close();
            delete this._views[this._indexByModel[model.cid]];
            delete this._indexByModel[model.cid];
            return this;
        }
        , addViewByModel: function (model) {
            var view = new FormComponentView({model: model});
            this._views[view.cid] = view;
            this._indexByModel[model.cid] = view.cid;
        }
    });
});