/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 *
 * Based on Business Rules (MIT license)
 * Copyright 2013 Chris Powers
 */
(function($) {
    $.fn.actionsBuilder = function(options) {
        if(options == "data") {
            var builder = $(this).eq(0).data("actionsBuilder");
            return builder.collectData();
        } else {
            return $(this).each(function() {
                var builder = new ActionsBuilder(this, options);
                $(this).data("actionsBuilder", builder);
            });
        }
    };

    function ActionsBuilder(element, options) {
        this.element = $(element);
        this.options = options || {};
        this.init();
    }

    ActionsBuilder.prototype = {
        init: function() {
            this.fields = this.options.actions;
            //this.fields.unshift({label: "Choose an Action...", name: ""});
            this.data = this.options.data || [];
            var actions = this.buildActions(this.data);
            this.element.html(actions);
        },

        buildActions: function(data) {
            var container = $("<div>", {"class": "actions"});
            var buttons = $("<div>", {"class": "action-buttons"});
            buttons.append($("<span>", {text: options.i18n.followingActions, style: "margin-right:20px;display:inline-block"}));
            var addIcon = $("<span>", {"class": "glyphicon glyphicon-plus", "text": " "});
            var addButton = $("<a>", {"href": "#", "class": "add btn btn-success btn-xs", "text": options.i18n.addAction });
            addButton.prepend(addIcon);
            var _this = this;

            addButton.click(function(e) {
                e.preventDefault();
                container.append(_this.buildAction({}));
            });

            buttons.append(addButton);
            container.append(buttons);

            for(var i=0; i < data.length; i++) {
                var actionObj = data[i];
                var actionDiv = this.buildAction(actionObj);

                // Add values to fields
                var fields = [actionObj];
                var field;
                while(field = fields.shift()) {
                    actionDiv.find(":input[name='" + field.name + "']").val(field.value).change();
                    if(field.fields) fields = fields.concat(field.fields);
                }
                container.append(actionDiv);
            }
            return container;
        },

        buildAction: function(data) {
            var field = this._findField(data.name);
            var div = $("<div>", {"class": "action"});
            var fieldsDiv = $("<div>", {"class": "subfields"});
            var select = $("<select>", {"class": "action-select form-control", "name": "action-select"});

            for(var i=0; i < this.fields.length; i++) {
                var possibleField = this.fields[i];
                var option = $("<option>", {"text": possibleField.label, "value": possibleField.name});
                select.append(option);
            }

            var _this = this;
            select.change(function() {
                var val = $(this).val();
                var newField = _this._findField(val);
                fieldsDiv.empty();

                if(newField.fields) {
                    for(var i=0; i < newField.fields.length; i++) {
                        fieldsDiv.append(_this.buildField(newField.fields[i]));
                    }
                }

                div.attr("class", "action " + val);
            });

            var removeIcon = $("<span>", {"class": "glyphicon glyphicon-remove", "text": " "});
            var removeLink = $("<a>", {"href": "#", "class": "remove btn btn-danger btn-xs", "text": options.i18n.deleteText });
            removeLink.prepend(removeIcon);
            removeLink.click(function(e) {
                e.preventDefault();
                // Trigger remove event
                $(this).trigger( "remove" );
                div.remove();
            });

            if ( field ) {
                select.val(field.name);
                select.change();
                if ( data.fields ) {
                    for (i = 0; i < data.fields.length; i++) {
                        fieldsDiv.find(':input[name=' + data.fields[i].name + ']').val(data.fields[i].label);
                    }
                }
            }
            else{
                select.change();
            }

            div.append(select);
            div.append(fieldsDiv);
            div.append(removeLink);
            return div;
        },

        buildField: function(field) {
            var div = $("<div>", {"class": "field"});
            var subfields = $("<div>", {"class": "subfields"});
            var _this = this;

            var label = $("<label>", {"class":"control-label", "text": field.label});
            div.append(label);

            if(field.fieldType == "select") {
                var label = $("<label>", {"class":"control-label", "text": field.label});
                var select = $("<select>", {"class":"form-control", "name": field.name});

                for(var i=0; i < field.options.length; i++) {
                    var optionData = field.options[i];
                    var option = $("<option>", {"text": optionData.label, "value": optionData.name});
                    option.data("optionData", optionData);
                    select.append(option);
                }

                select.change(function() {
                    var option = $(this).find("> :selected");
                    var optionData = option.data("optionData");
                    subfields.empty();
                    if(typeof optionData !== "undefined" && typeof optionData.fields !== "undefined") {
                        for(var i=0; i < optionData.fields.length; i++) {
                            var f = optionData.fields[i];
                            subfields.append(_this.buildField(f));
                        }
                    }
                });

                select.change();
                div.append(select);
            }
            else if(field.fieldType == "select_multiple") {
                var label = $("<label>", {"class":"control-label", "text": field.label});
                var select = $("<select></select>", {"class":"form-control", "name": field.name, multiple: true});

                for(var i=0; i < field.options.length; i++) {
                    var optionData = field.options[i];
                    var option = $("<option>", {"text": optionData.label, "value": optionData.name});
                    option.data("optionData", optionData);
                    select.append(option);
                }

                select.change(function() {
                    var option = $(this).find("> :selected");
                    var optionData = option.data("optionData");
                    subfields.empty();
                    if(typeof optionData !== "undefined" && typeof optionData.fields !== "undefined") {
                        for(var i=0; i < optionData.fields.length; i++) {
                            var f = optionData.fields[i];
                            subfields.append(_this.buildField(f));
                        }
                    }
                });

                select.change();
                div.append(select);
            }
            else if(field.fieldType == "text") {
                var input = $("<input>", {"class":"form-control", "type": "text", "name": field.name});
                div.append(input);
            }
            else if(field.fieldType == "textarea") {
                var id = "textarea-" + Math.floor(Math.random() * 100000);
                var area = $("<textarea>", {"class":"form-control", "name": field.name, "id": id});
                div.append(area);
            }

            if(field.hint) {
                div.append($("<p>", {"class": "hint", "text": field.hint}));
            }

            div.append(subfields);
            return div;
        },


        collectData: function(fields) {
            var _this = this;

            fields = fields || this.element.find(".action");
            var out = [];
            fields.each(function() {
                var input = $(this).find("> :input, > .jstEditor > :input");
                var subfields = $(this).find("> .subfields > .field");
                var action = {name: input.attr("name"), value: input.val()};
                if(subfields.length > 0) {
                    action.fields = _this.collectData(subfields);
                }
                out.push(action);
            });
            return out;
        },

        _findField: function(fieldName) {
            for(var i=0; i < this.fields.length; i++) {
                var field = this.fields[i];
                if(field.name == fieldName) {
                    return field;
                }
            }
        }
    };

})(jQuery);