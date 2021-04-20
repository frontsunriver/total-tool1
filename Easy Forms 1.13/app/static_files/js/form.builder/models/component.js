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
    'jquery', 'underscore', 'backbone'
], function($, _, Backbone) {
    return Backbone.Model.extend({
        initialize: function() {
            // Only to new components
            if(!this.has("fresh")) {
                this.set("fresh", true);
            }
        }
        , getValues: function(){
            return _.reduce(this.get("fields"), function(o, v, k){
                if (v["type"] == "select") {
                    o[k] = _.find(v["value"], function(o){return o.selected})["value"];
                } else {
                    o[k]  = v["value"];
                }
                return o;
            }, {});
        }
        , setField: function(name, value) {
            var fields = this.get("fields");
            fields[name]["value"] = value;
            this.set("fields", fields);
        }
        , getField: function(name) {
            var fields = this.get("fields");
            return _.isUndefined(fields[name]) || _.isUndefined(fields[name]["value"]) ? '' : fields[name]["value"];
        }
        , getType: function () {
            return this.getField('id').split("_", 1).shift();
        }
    });
});