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
    $.fn.conditionsBuilder = function(options) {
        if(options == "data") {
            var builder = $(this).eq(0).data("conditionsBuilder");
            return builder.collectData();
        } else {
            return $(this).each(function() {
                var builder = new ConditionsBuilder(this, options);
                $(this).data("conditionsBuilder", builder);
            });
        }
    };

    function ConditionsBuilder(element, options) {
        this.element = $(element);
        this.options = options || {};
        this.init();
    }

    ConditionsBuilder.prototype = {
        init: function() {
            this.fields = this.denormalizeOperators(
                this.options.variables, this.options.variable_type_operators);
            this.data = this.options.data || {"all": []};
            var rules = this.buildRules(this.data);
            this.element.html(rules);
        },

        denormalizeOperators: function(variablesData, operators) {
            return $.map(variablesData, function(variable) {
                variable.operators = operators[variable.fieldType];
                return variable;
            });
        },

        collectData: function() {
            return this.collectDataFromNode(this.element.find("> .conditional"));
        },

        collectDataFromNode: function(element) {
            var klass = null;
            var _this = this;
            if(element.is(".conditional")) {
                klass = element.find("> .all-any-none-wrapper > .all-any-none").val();
            }

            if(klass) {
                var out = {};
                out[klass] = [];
                element.find("> .conditional, > .rule").each(function() {
                    out[klass].push(_this.collectDataFromNode($(this)));
                });
                return out;
            }
            else {
                return {
                    name: element.find(".field").val(),
                    operator: element.find(".operator").val(),
                    value: element.find(".value").val()
                };
            }
        },

        buildRules: function(ruleData) {
            return this.buildConditional(ruleData) || this.buildRule(ruleData);
        },

        buildConditional: function(ruleData) {
            var kind;
            if(ruleData.all) { kind = "all"; }
            else if(ruleData.any) { kind = "any"; }
            else if (ruleData.none) { kind = "none"; }
            if(!kind) { return; }

            var div = $("<div>", {"class": "conditional " + kind});
            var selectWrapper = $("<div>", {"class": "all-any-none-wrapper"});
            var select = $("<select>", {"class": "all-any-none form-control"});
            select.append($("<option>", {"value": "all", "text": options.i18n.all, "selected": kind == "all"}));
            select.append($("<option>", {"value": "any", "text": options.i18n.any, "selected": kind == "any"}));
            select.append($("<option>", {"value": "none", "text": options.i18n.none, "selected": kind == "none"}));
            selectWrapper.append(select);
            selectWrapper.append($("<span>", {text: options.i18n.followingConditions }));
            div.append(selectWrapper);

            var addRuleIcon = $("<span>", {"class": "glyphicon glyphicon-plus", "text": " "});
            var addRuleLink = $("<a>", {"href": "#", "class": "add-rule btn btn-warning btn-xs", "text": options.i18n.addCondition });
            addRuleLink.prepend(addRuleIcon);
            addRuleLink.prepend(addRuleIcon);
            var _this = this;
            addRuleLink.click(function(e) {
                e.preventDefault();
                var f = _this.fields[0];
                var newField = {name: f.value, operator: f.operators[0], value: null};
                div.append(_this.buildRule(newField));
            });
            div.append(addRuleLink);

            var addConditionIcon = $("<span>", {"class": "glyphicon glyphicon-plus", "text": " "});
            var addConditionLink = $("<a>", {"href": "#", "class": "add-condition btn btn-warning btn-xs", "text": options.i18n.addGroup });
            addConditionLink.prepend(addConditionIcon);
            addConditionLink.click(function(e) {
                e.preventDefault();
                var f = _this.fields[0];
                var newField = {"all": [{name: f.value, operator: f.operators[0], value: null}]};
                div.append(_this.buildConditional(newField));
            });
            div.append(addConditionLink);

            var removeIcon = $("<span>", {"class": "glyphicon glyphicon-remove", "text": " "});
            var removeLink = $("<a>", {"class": "remove btn btn-danger btn-xs", "href": "#", "text": options.i18n.deleteText });
            removeLink.prepend(removeIcon);
            removeLink.click(function(e) {
                e.preventDefault();
                // Trigger remove event
                $(this).trigger( "remove" );
                div.remove();
            });
            div.append(removeLink);

            var rules = ruleData[kind];
            for(var i=0; i<rules.length; i++) {
                div.append(this.buildRules(rules[i]));
            }
            return div;
        },

        buildRule: function(ruleData) {
            var ruleDiv = $("<div>", {"class": "rule"});
            var fieldSelect = getFieldSelect(this.fields, ruleData);
            var operatorSelect = getOperatorSelect();

            fieldSelect.change(onFieldSelectChanged.call(this, operatorSelect, ruleData));

            ruleDiv.append(fieldSelect);
            ruleDiv.append(operatorSelect);
            ruleDiv.append(removeLink());

            fieldSelect.change();
            ruleDiv.find("> .value").val(ruleData.value);
            return ruleDiv;
        },

        operatorsFor: function(fieldName) {
            for(var i=0; i < this.fields.length; i++) {
                var field = this.fields[i];
                if(field.name == fieldName) {
                    return field.operators;
                }
            }
        }
    };

    function getFieldSelect(fields, ruleData) {
        var select = $("<select>", {"class": "field form-control"});
        for(var i=0; i < fields.length; i++) {
            var field = fields[i];
            var option = $("<option>", {
                text: field.label,
                value: field.name,
                selected: ruleData.name == field.name
            });
            option.data("options", field.options);
            select.append(option);
        }
        return select;
    }

    function getOperatorSelect() {
        var select = $("<select>", {"class": "operator form-control"});
        select.change(onOperatorSelectChange);
        return select;
    }

    function removeLink() {
        var removeIcon = $("<span>", {"class": "glyphicon glyphicon-remove", "text": " "});
        var removeLink = $("<a>", {"class": "remove btn btn-danger btn-xs", "href": "#", "text": options.i18n.deleteText });
        removeLink.prepend(removeIcon);
        removeLink.click(onRemoveLinkClicked);
        return removeLink;
    }

    function onRemoveLinkClicked(e) {
        e.preventDefault();
        var $link = $(e.currentTarget);
        var $condition = $link.parents(".rule");
        // Trigger remove event
        $link.trigger("remove");
        $condition.remove();
    }

    function onFieldSelectChanged(operatorSelect, ruleData) {
        var builder = this;
        return function(e) {
            var operators = builder.operatorsFor($(e.target).val());
            operatorSelect.empty();
            for(var i=0; i < operators.length; i++) {
                var operator = operators[i];
                var option = $("<option>", {
                    text: operator.label || operator.name,
                    value: operator.name,
                    selected: ruleData.operator == operator.name
                });
                option.data("fieldType", operator.fieldType);
                operatorSelect.append(option);
            }
            operatorSelect.change();
        }
    }

    function onOperatorSelectChange(e) {
        var $this = $(this);
        var option = $this.find("> :selected");
        var container = $this.parents(".rule");
        var fieldSelect = container.find(".field");
        var currentValue = container.find(".value");
        var val = currentValue.val();

        switch(option.data("fieldType")) {
            case "none":
                $this.after($("<input>", {"type": "hidden", "class": "value form-control"}));
                break;
            case "text":
                $this.after($("<input>", {"type": "text", "class": "value form-control"}));
                break;
            case "email":
                $this.after($("<input>", {"type": "email", "class": "value form-control"}));
                break;
            case "number":
                $this.after($("<input>", {"type": "number", "class": "value form-control"}));
                break;
            case "color":
                $this.after($("<input>", {"type": "color", "class": "value form-control"}));
                break;
            case "range":
                $this.after($("<input>", {"type": "range", "class": "value form-control"}));
                break;
            case "textarea":
                $this.after($("<textarea>", {"class": "value form-control"}));
                break;
            case "select":
                var select = $("<select>", {"class": "value form-control"});
                var options = fieldSelect.find("> :selected").data("options");
                for(var i=0; i < options.length; i++) {
                    var opt = options[i];
                    select.append($("<option>", {"text": opt.label || opt.value, "value": opt.value}));
                }
                $this.after(select);
                break;
            case "select_multiple":
                var options = fieldSelect.find("> :selected").data("options");
                var selectLength = options.length > 10 ? 10 : options.length;
                var select = $("<select class='value form-control' multiple size='" + selectLength + "''></select>");
                for(var i=0; i < options.length; i++) {
                    var opt = options[i];
                    select.append($("<option>", {"text": opt.label || opt.value, "value": opt.value}));
                }
                $this.after(select);
                break;
        }
        currentValue.remove();
    }

})(jQuery);
