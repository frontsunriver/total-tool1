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
    "jquery" , "underscore" , "backbone"
    , "models/style"
], function(
    $, _, Backbone
    , StyleModel
    ) {
    return Backbone.Collection.extend({
        model: StyleModel
        , initialize: function() {
        }
    });
});