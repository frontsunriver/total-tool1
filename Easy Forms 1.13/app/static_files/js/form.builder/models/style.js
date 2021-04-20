/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @description JavaScript Form Builder for Easy Forms
 * @since 1.9
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

define([
    'jquery', 'underscore', 'backbone'
], function($, _, Backbone) {
    return Backbone.Model.extend({
        setAttribute: function(name, value) {
            var attributes = this.get("attributes");
            attributes[name] = value;
            this.set("attributes", attributes);
        }
        , getAttributes: function(name) {
            var styles = this.get("styles");
            return styles["attributes"];
        }
        , getAttribute: function(name) {
            var styles = this.get("styles");
            return styles["attributes"][name];
        }
    });
});