/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

// Patch Model and Collection so they emit a 'fetch' event when starting to fetch data
_.each(["Model", "Collection"], function(name) {
    // Cache Backbone constructor.
    var ctor = Backbone[name];
    // Cache original fetch.
    var fetch = ctor.prototype.fetch;

    // Override the fetch method to emit a fetch event.
    ctor.prototype.fetch = function() {
        // Trigger the fetch event on the instance.
        this.trigger("fetch", this);

        // Pass through to original fetch.
        return fetch.apply(this, arguments);
    };
});

// PubSub
var PubSub = _.extend({}, Backbone.Events);

// Patch View, add a close method
Backbone.View.prototype.close = function(){
    this.remove();
    this.unbind();
    if (this.onClose){
        this.onClose();
    }
};

//******************
// Underscore
//******************

// Override template settings
_.templateSettings = {
    evaluate: /\{\{(.+?)\}\}/g,
    interpolate: /\{\{=(.+?)\}\}/g,
    escape: /\{\{-(.+?)\}\}/g
};

//******************
// App
//******************

var App = App || {};

App.Data = {
    "variables": options.variables,
    "actions": [
        {
            "name": "toShow",
            "label": options.i18n.show,
            "fields": [{"label": "", "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}]
        },
        {
            "name": "toHide",
            "label": options.i18n.hide,
            "fields": [{"label": "", "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}]
        },
        {
            "name": "toEnable",
            "label": options.i18n.enable,
            "fields": [{"label": "", "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}]
        },
        {
            "name": "toDisable",
            "label": options.i18n.disable,
            "fields": [{"label": "", "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}]
        },
        {label: options.i18n.copy, name: "copy", fields: [
            {"label": options.i18n.from, "name": "original", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "originalField", "fieldType": "select_multiple", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "originalElement", "fieldType": "text"}
                ]}
            ]},
            {"label": options.i18n.to, "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}
        ]},
        {label: options.i18n.math, name: "performArithmeticOperations", fields: [
            {"label": options.i18n.perform, "name": "operator", "fieldType": "select", "options": [
                {label: options.i18n.addition, name: "+"},
                {label: options.i18n.subtraction, name: "-"},
                {label: options.i18n.multiplication, name: "*"},
                {label: options.i18n.division, name: "/"},
                {label: options.i18n.remainder, name: "%"}
            ]},
            {"label": options.i18n.of, "name": "operands", "fieldType": "select_multiple", "options": options.fields},
            {"label": options.i18n.andSetResultTo, "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}
        ]},
        {label: options.i18n.evaluate, name: "evaluateMathFormula", fields: [
            {"label": options.i18n.formula, "name": "formula", "fieldType": "textarea"},
            {"label": options.i18n.andSetResultTo, "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}
        ]},
        {
            "name": "formatNumber",
            "label": options.i18n.formatNumber,
            "fields": [{"label": options.i18n.of, "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]}, {"label": "As", "name": "format", "fieldType": "text"}
            ]
        },
        {label: options.i18n.formatText, name: "formatText", fields: [
            {"label": options.i18n.from, "name": "original", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                    {"label": "", "name": "originalField", "fieldType": "select_multiple", "options": options.fields}
                ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "originalElement", "fieldType": "text"}
                ]}
            ]},
            {"label": options.i18n.to, "name": "target", "fieldType": "select", "options": [
                {"label": options.i18n.field, "name": "field", "fields": [
                        {"label": "", "name": "targetField", "fieldType": "select", "options": options.fields}
                    ]},
                {"label": options.i18n.element, "name": "element", "fields": [
                    {"label": "", "name": "targetElement", "fieldType": "text"}
                ]}
            ]},
            {"label": options.i18n.as, "name": "format", "fieldType": "textarea"}
        ]},
        {
            "name": "skip",
            "label": options.i18n.skip,
            "fields": [{
                "name": "step",
                "label": options.i18n.toStep,
                "fieldType": "select",
                "options": options.steps
            }]
        },
        {
            "name": "form",
            "label": options.i18n.form,
            "fields": [{
                "label": options.i18n.action,
                "name": "action",
                "fieldType": "select",
                "options": [
                    {
                        "label": options.i18n.submit,
                        "name": "submit"
                    },
                    {
                        "label": options.i18n.reset,
                        "name": "reset"
                    },
                    {
                        "label": options.i18n.nextStep,
                        "name": "nextStep"
                    },
                    {
                        "label": options.i18n.previousStep,
                        "name": "previousStep"
                    }
                ]
            }]
        }
    ],
    "variable_type_operators": {

        // Text component
        "text": textOperators,
        "tel": textOperators,
        "color": colorOperators,
        "url": textOperators,
        "password": textOperators,

        // Number component
        "number": numberOperators,
        "range": numberOperators,

        // Date component
        "date": dateOperators,
        "datetime-local": dateOperators,
        "time": dateOperators,
        "month": dateOperators,
        "week": dateOperators,

        // Email component
        "email": emailOperators,

        // TextArea component
        "textarea": textOperators,

        // Select List component
        "select": selectOperators,

        // Checkbox component
        "checkbox": checkboxOperators,

        // Radio component
        "radio": radioOperators,

        // Signature component
        "signature": signatureOperators,

        // Hidden component
        "hidden": hiddenOperators,

        // File component
        "file": fileOperators,

        // Button component
        "button": buttonOperators,

        // Form
        "form": formOperators
    }
};

//******************
// App Views
//******************

App.ActionsView = Backbone.View.extend({
    template: _.template($('#actions-template').html()),
    events: {
        'click button#add-rule': function(event) {
            event.preventDefault();
            this.collection.add(
                {
                    form_id: options.formID,
                    status: 1,
                    opposite: 1
                }
            );
        }
    },
    render: function(){
        // clean views before rendering new ones
        this.el.innerHTML = this.template();
        return this;
    }
});

App.RulesView = Backbone.View.extend({
    className: 'rule-builder',
    subViews: {},
    template: _.template($('#rules-template').html()),
    events: {
        'update-sort': 'updateSort'
    },
    initialize: function(){
        // Event Listeners
        this.listenTo(this.collection, 'add', this.onAdd);
        this.listenTo(this.collection, 'destroy', this.onDestroy);
        PubSub.on("rule:duplicated", this.onDuplicate, this);
        $(this.el).sortable({
            placeholder: "ui-sortable-placeholder",
            cancel: 'input,textarea,button,select,option,a,span,.rule-builder-conditions,.rule-builder-actions,[contenteditable]',
            stop: function(event, ui) {
                ui.item.trigger('drop', ui.item.index());
            }
        });
        $("body").on('click', 'textarea[name="format"], textarea[name="formula"]', function (e) {
            // Add autocomplete suggestions to text format
            var currentTarget = $(e.currentTarget);
            currentTarget
                .textcomplete('destroy');
            currentTarget
                .textcomplete([
                    {
                        match: function () {
                            return /(\.*){(\w*)$/;
                        },
                        search: function (term, callback, match) {
                            $.post(options.fieldListUrl, {
                                id: options.formID,
                                term: _.isUndefined(match[2]) ? '' : match[2],
                                _csrf: $('meta[name=csrf-token]').attr('content')
                            })
                                .done(function(response) {
                                    if (!_.isUndefined(response.data) && _.isObject(response.data)) {
                                        var data = Object.keys(response.data).map(function(key) {
                                            var val = {};
                                            val[key] = "<span>" + key + "</span>" + response.data[key];
                                            return val;
                                        });
                                        callback($.map(data, function (f) {
                                            var value = f[Object.keys(f)[0]];
                                            return value.indexOf(term) === 0 ? f : null;
                                        }));
                                    } else {
                                        callback([]);
                                    }
                                });
                        },
                        template: function (f) {
                            return f[Object.keys(f)[0]];
                        },
                        index: 1,
                        replace: function (f) {
                            var key = Object.keys(f)[0];
                            return '{{' + key + '}} ';
                        }
                    }
                ], {
                    zIndex: 1500,
                    maxCount: -1
                });
        });
    },
    updateSort: function(event, model, position) {
        this.collection.remove(model, {silent: true});
        this.collection.add(model, {at: position, silent: true});

        // to update ordinals on server:
        var ids = this.collection.pluck('id');
        var data = {
            form_id: options.formID,
            ids: ids
        };

        $.ajax({
            data: data,
            type: 'POST',
            url: options.positionEndPoint
        }).done(function () {
            $.notify({
                // options
                icon: 'glyphicon glyphicon-ok',
                message: options.i18n.orderUpdated
            },{
                // settings
                type: 'success',
                placement: {
                    from: "bottom",
                    align: "center"
                },
                delay: 1000,
                template: '<div data-notify="container" class="col-xs-9 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
            });
        });
    },
    onAdd: function(model){
        this.addSubview(model);
    },
    onDuplicate: function (model) {
        this.collection.add(model.toJSON());
    },
    onDestroy: function(model){
        this.subViews[model.cid].close();
    },
    addSubview: function( model ) {
        // Add rule view
        this.subViews[model.cid] = new App.RuleView({ model: model });
        this.$el.append(this.subViews[model.cid].render().el);
    },
    closeSubviews: function() {
        // Call destroy method for each view
        _.invoke(this.subViews, 'close');
    },
    onClose: function() {
        // Destroy subViews
        this.closeSubviews();
        // Destroy this view
        this.undelegateEvents();
        this.$el.removeData().unbind();
        // Remove view from DOM
        this.remove();
        Backbone.View.prototype.remove.call(this);
    },
    render: function(){
        // clean views before rendering new ones
        this.closeSubviews();
        this.el.innerHTML = this.template();
        this.collection.each(this.addSubview.bind(this));
        return this;
    }
});

App.RuleView = Backbone.View.extend({
    template: _.template($('#rule-template').html()),
    tagName: 'div',
    className: 'rules-group-container',
    events: {
        'click form .btn': 'changeModel',
        'remove .remove': 'changeModel',
        'change :input': 'changeModel',
        'click .save-rule': 'saveModel',
        'click .duplicate-rule': 'duplicateModel',
        'click .delete-rule': 'deleteModel',
        'drop' : 'drop'
    },
    initialize: function(){
        // Event Listeners
        this.listenTo(this.model, 'change', this.onChange);
    },
    drop: function(event, index) {
        this.$el.trigger('update-sort', [this.model, index]);
    },
    onChange: function(){
        // Update the view
        this.render();
    },
    changeModel: function(event) {
        event.preventDefault();
        // Show unsaved changes message
        this.$(".label-warning").show();
    },
    saveModel: function(event){
        event.preventDefault();
        // Save on DB
        var name = this.$("#" + this.model.cid + "name").val();
        var conditions = this.$("#" + this.model.cid + "conditions");
        var actions = this.$("#" + this.model.cid + "actions");
        var status = this.$("#" + this.model.cid + "status").is(':checked') ? 1 : 0;
        var opposite = this.$("#" + this.model.cid + "opposite").is(':checked') ? 1 : 0;
        this.model.set({
            'name': name,
            'conditions': JSON.stringify(conditions.conditionsBuilder('data')),
            'actions': JSON.stringify(actions.actionsBuilder('data')),
            'status': status,
            'opposite': opposite,
            'ordinal': this.model.collection.indexOf(this.model)
        });
        var that = this;
        this.model.save(null, {
            success: function(model){
                var index = model.collection.indexOf(model);
                that.$el.trigger('update-sort', [model, index]);
            }
        });
    },
    duplicateModel: function (event) {
        event.preventDefault();
        // Duplicate model
        var duplicatedModel = this.model.clone();
        duplicatedModel.unset('id');
        PubSub.trigger('rule:duplicated', duplicatedModel);
    },
    deleteModel: function(event){
        event.preventDefault();
        if( this.model.isNew() ) {
            this.model.destroy();
        } else {
            // Delete on DB
            if(confirm(options.i18n.areYouSureDeleteItem)) {
                this.model.destroy();
            }
        }
        return false;
    },
    onClose: function() {
        // Destroy this view
        this.undelegateEvents();
        this.$el.removeData().unbind();
        // Remove view from DOM
        this.remove();
        Backbone.View.prototype.remove.call(this);
    },
    displayRuleBuilder: function () {
        // Initialize Rule Builder
        var conditions = this.$("#" + this.model.cid + "conditions");
        var actions = this.$("#" + this.model.cid + "actions");

        // Update conditions data and pass to builder
        if(this.model.has('conditions') && _.isString(this.model.get("conditions"))) {
            conditions.conditionsBuilder($.extend( {}, App.Data, {
                data: JSON.parse(this.model.get("conditions"))
            } ));
        } else {
            conditions.conditionsBuilder(App.Data);
        }

        // Update actions data and pass to builder
        if(this.model.has('actions') && _.isString(this.model.get("actions"))) {
            actions.actionsBuilder($.extend( {}, App.Data, {
                data: JSON.parse(this.model.get("actions"))
            } ));
        } else {
            actions.actionsBuilder(App.Data);
        }

        // Initialize Rule Name
        var name = this.$(".rule-name");
        var fieldName = this.$("#" + this.model.cid + "name");
        name.editable({
            multiline: false,
            exitKeys: ["escape", "enter", "tab"],
            save: function(c) {
                fieldName.val(name.text().trim()).trigger('change');
            },
            validate: function(c) {
                return name.text().trim().length < 255;
            }
        });
    },
    render: function(){

        this.el.innerHTML = this.template({
            cid: this.model.cid,
            rule: this.model.toJSON()
        });

        // Display unsaved changes warning
        if(this.model.isNew()) {
            this.$(".label-warning").show();
        }

        // Display rule builder
        this.displayRuleBuilder();

        return this;
    }
});

//******************
// App Router
//******************

var Router = Backbone.Router.extend({
    views:{},
    initialize: function(options){
        this.main = options.main;
        this.rules = options.rules;
    },
    routes: {
        '': 'index'
    },
    closeViews: function() {
        // Call close method for each view
        _.invoke(this.views, 'close');
    },
    index: function(){
        this.closeViews();
        this.views['rulesView'] = new App.RulesView({ collection: this.rules });
        this.main.append(this.views['rulesView'].render().el);
        this.views['actionsView'] = new App.ActionsView({ collection: this.rules });
        this.main.append(this.views['actionsView'].render().el);
    }
});

//******************
// App Collections
//******************

var Rule = Backbone.Model.extend({
    url: function() {
        var base = _.result(this, 'urlRoot') || _.result(this.collection, 'url') || urlError();
        if (this.isNew()) return base;
        return base + (base.charAt(base.length - 1) === '/' ? '' : '&id=') + encodeURIComponent(this.id);
    },
    methodUrl: function(method){
        if(method == "delete"){
            return options.deleteEndPoint + "&id=" + this.attributes.id;
        }else if(method == "update"){
            return options.updateEndPoint + "&id=" + this.attributes.id;
        }else if(method == "create"){
            return options.createEndPoint + "&id=" + this.attributes.id;
        }
        return false;
    },
    sync: function(method, model, options) {
        if (model.methodUrl && model.methodUrl(method.toLowerCase())) {
            options = options || {};
            options.url = model.methodUrl(method.toLowerCase());
        }
        Backbone.sync(method, model, options);
    },
    initialize: function(){
    }
});

var Rules = Backbone.Collection.extend({
    url: options.endPoint,
    model: Rule,
    initialize: function() {
        if (options.hasPrettyUrls) {
            this.model = Backbone.Model;
        }
    },
    comparator: function(model) {
        return model.get('ordinal');
    },
    parse: function(resp) {
        this.pager = resp._meta;
        return resp.items;
    },
    fetchPage: function() {
        var self = this;
        return this.fetch({
            data: $.param({ id: options.formID }),
            reset: true,
            success:function(){
                self.trigger("sync:page")
            }
        });
    }
});

//******************
// App Init
//******************

App.init = function(){

    // Server Data
    App.Rules = new Rules();
    return App.Rules.fetchPage().then(function(){
        App.Router = new Router({
            main: $("#main"),
            rules: App.Rules
        });
        Backbone.history.start();
    });

};

//******************
// App run
//******************

$(function() {

    App.init();

});

