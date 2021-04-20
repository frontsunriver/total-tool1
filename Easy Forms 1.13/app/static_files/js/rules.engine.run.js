/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

$(document).ready(function () {
    /**
     * String.Format()
     */
    if (!String.prototype.format) {
        String.prototype.format = function () {
            "use strict";
            var str = this.toString();
            if (arguments.length) {
                var t = typeof arguments[0];
                var key;
                var args = ("string" === t || "number" === t) ?
                    Array.prototype.slice.call(arguments)
                    : arguments[0];

                for (key in args) {
                    str = str.replace(new RegExp("\\{\\{" + key + "\\}\\}", "gi"), args[key]);
                    str = str.replace(new RegExp("\\{\\{ " + key + " \\}\\}", "gi"), args[key]);
                }
            }

            return str;
        };
    }

    /**
     * Find and return a element (jQuery object)
     *
     * @param selector
     * @returns {*|jQuery|HTMLElement}
     */
    var findElement = function (selector) {
        return $(selector);
    };

    /**
     * Find and return a field (jQuery object)
     *
     * @param fieldName
     * @returns {*}
     */
    var findField = function (fieldName) {
        var field; // jQuery object
        if (fieldName) {
            var componentType = fieldName.split("_", 1).shift();
            if (componentType === "checkbox"){
                field = $("input[name*='"+fieldName+"[]']");
            } else if (componentType === "radio"){
                field = $("input[name*='"+fieldName+"']");
            } else if (componentType === "matrix") {
                field = $("#" + fieldName).find('input');
            } else {
                field = $("#" + fieldName);
            }
        }
        return field;
    };

    /**
     * Returns an active jQuery object by name of the component
     *
     * @param name
     * @returns {*}
     */
    var activeField = function (name) {
        var field; // jQuery object
        var componentType; // string
        // Multiple names
        // return all active fields
        if (name instanceof Array) {
            var i;
            var selectors = [];
            for (i = 0; i < name.length; i++) {
                var selector;
                componentType = name[i].split("_", 1).shift();
                if (componentType === "radio") {
                    // Get checked radio buttons
                    selector = "input[name='"+name[i]+"']:checked";
                } else if (componentType === "checkbox") {
                    // Get checked checkbox fields
                    selector = "input[name*='"+name[i]+"[]']:checked";
                } else if (componentType === "matrix") {
                    // Get matrix fields
                    var $table = $("#" + name[i]);
                    if ($table.attr("data-matrix-type") === "radio") {
                        selector = "#" + name[i] + " input[type='radio']:checked";
                    } else if ($table.attr("data-matrix-type") === "checkbox") {
                        selector = "#" + name[i] + " input[type='checkbox']:checked";
                    } else {
                        selector = "#" + name[i] + " :input";
                    }
                } else {
                    // Get other fields
                    selector = "#" + name[i];
                }
                selectors.push(selector);
            }
            field = $(selectors.join(", "))
        } else {
            componentType = name.split("_", 1).shift();
            if (componentType === "radio") {
                // Get checked radio buttons
                field = $("input[name='"+name+"']:checked");
            } else if(componentType === "checkbox") {
                // Get checked checkbox fields
                field = $("input[name*='"+name+"[]']:checked");
            } else if(componentType === "matrix") {
                // Get matrix fields
                var $table = $("#" + name);
                if ($table.attr("data-matrix-type") === "radio") {
                    field = $table.find("input[type='radio']:checked");
                } else if ($table.attr("data-matrix-type") === "checkbox") {
                    field = $table.find("input[type='checkbox']:checked");
                } else {
                    field = $table.find(":input");
                }
            } else {
                // Get other fields
                field = $("#" + name);
            }
        }
        return field;
    };

    /**
     * Returns a active field or element
     *
     * @param data
     * @returns {*|jQuery|HTMLElement}
     */
    var getOriginalElement = function (data) {
        return  (data.find("original") === "field") ?
            activeField(data.find("original", "originalField")) : findElement(data.find("original", "originalElement"));
    };

    /**
     * Set value of target element
     *
     * @param data
     * @param originalElement
     */
    var setTargetElement = function (data, originalElement) {

        var target = (data.find("target") === "field") ?
            findField(data.find("target", "targetField")) : findElement(data.find("target", "targetElement")),
            value = (originalElement.is(':input')) ? originalElement.val() : originalElement.html();

        // Replace default value, if original element has several elements
        if (originalElement.size() > 1) {
            value = originalElement.map(function () {
                return $( this).is(':input') ? $( this ).val() : $( this ).text();
            }).get().filter(Boolean).join( ", " );
        }

        // If target has several elements
        if (target.size() > 1) {
            if(target.is(':radio, :checkbox')){
                if (originalElement.size() > 1) {
                    $(":checkbox[name*='"+target.attr("name")+"']").prop('checked', false);
                    $.each(originalElement, function () {
                        if($(this).is(':checkbox')){
                            value = $(this).val();
                            $(":checkbox[name*='"+target.attr("name")+"'][value*='"+value+"']").prop('checked', true);
                        }
                    });
                } else {
                    $(":input[name*='"+target.attr("name")+"']").prop('checked', false);
                    $(":input[name*='"+target.attr("name")+"'][value*='"+value+"']").prop('checked', true);
                }
            } else if (target.is(":input")) {
                target.val(value);
            } else {
                target.text( value );
            }
        } else {
            if(target.is(':radio, :checkbox')){
                $(":input[name*='"+target.attr("name")+"']").prop('checked', false);
                $(":input[name*='"+target.attr("name")+"'][value*='"+value+"']").prop('checked', true);
            } else if (target.is(":input")) {
                target.val(value);
            } else {
                target.html(value);
            }
        }

    };

    /**
     * Set formatted value of target element
     *
     * @param data
     * @param originalElement
     */
    var formatTargetElement = function (data, originalElement) {
        var target = (data.find("target") === "field") ?
            findField(data.find("target", "targetField")) : findElement(data.find("target", "targetElement"));
        var valueObj = {};
        originalElement.map(function (i) {
            valueObj[i] = $(this).is(':input') ? $(this).val() : $(this).text();
            var id = $(this).attr('id');
            if ($(this).is(':radio')){
                id = $(this).attr('name');
            } else if ($(this).is(':checkbox')){
                id = $(this).attr('name').replace("[]", "");
            }
            if (id.length > 1) {
                valueObj[id] = $(this).is(':input') ? $(this).val() : $(this).text();
                if ($(this).is(':checkbox')) {
                    valueObj[id] = $(":input[name*='"+$(this).attr("name")+"']:checked").map(function () {
                        return $(this).is(':input') ? $(this).val() : $(this).text();
                    }).get().filter(Boolean).join( ", " );
                }
            }
            var alias = $(this).data('alias');
            var matrixId = $(this).data('matrix-id');
            if (alias && alias.length > 1) {
                if (matrixId && matrixId.length > 1) {
                    var parts = alias.split("_");
                    if (parts.length > 1) {
                        alias = parts[0] + '_' + parts[1];
                    }
                }
                valueObj[alias] = valueObj[id];
            }
        });
        // Formatted value
        var formattedValue = data.find("format").format(valueObj);
        // If target is a checkbox or radio button, do nothing
        if(target.is(':radio, :checkbox')){
        } else if (target.is(":input")) {
            target.val(formattedValue);
        } else {
            target.html(formattedValue);
        }
    };

    /**
     * Set value in target field or element
     *
     * @param data
     * @param value
     */
    var setTargetValue = function (data, value) {
        if (data.find("target") === "field") {
            findField(data.find("target", "targetField")).val(value);
        } else if (data.find("target") === "element") {
            var target = findElement(data.find("target", "targetElement"));
            if (target.size() > 1) {
                $.each(target, function () {
                    if ($(this).is(":input")) {
                        $(this).val(value);
                    } else {
                        $(this).text(value);
                    }
                })
            } else {
                if (target.is(":input")) {
                    target.val(value);
                } else {
                    target.text(value);
                }
            }
        }
    };

    /**
     * Used to perform arithmetic operations on fields values
     * and displays the result in a target field or element
     *
     * @param data
     * @returns {number}
     */
    var performArithmeticOperations = function (data) {
        var operator = data.find("operator");
        var operands = data.find("operands");
        var result = NaN; // Initial value
        if (!!operator){
            if ($.isArray(operands)) {
                $.each(operands, function (index, operand) {
                    var component = activeField(operand);
                    if (component.size() > 1) { // Used by checkbox components
                        $.each(component, function (subindex, _element) {
                            var number = parseFloat($(_element).val());
                            if(!isNaN(number)){
                                if(isNaN(result)) { // First number
                                    result = number
                                } else {
                                    // Assignment Operators
                                    switch(operator){
                                        case '+':
                                            result += number;
                                            break;
                                        case '-':
                                            result -= number;
                                            break;
                                        case '*':
                                            result *= number;
                                            break;
                                        case '/':
                                            result /= number;
                                            break;
                                        case '%':
                                            result %= number;
                                            break;
                                    }
                                }
                            }
                        });
                    } else if (component.size() === 1) { // All components
                        var number = parseFloat(component.val());
                        // Check if a valid number
                        if(!isNaN(number)){
                            if( isNaN(result) ) { // First number
                                result = number;
                            } else {
                                // Assignment Operators
                                switch(operator){
                                    case '+':
                                        result += number;
                                        break;
                                    case '-':
                                        result -= number;
                                        break;
                                    case '*':
                                        result *= number;
                                        break;
                                    case '/':
                                        result /= number;
                                        break;
                                    case '%':
                                        result %= number;
                                        break;
                                }
                            }
                        }
                    }
                });
            }
            // Replace NaN result
            if (isNaN(result)){
                result = 0;
            }
            // Show result in target field or element
            setTargetValue(data, result);
        }
        return 0;
    };

    var evaluateMathFormula = function (data) {
        var formula = data.find("formula"),
            expression = "",
            target = "";
        // Fix formula
        var check = /\{\{([a-zA-Z_0-9]+)\}\}/gm
        if (check.test(formula)) {
            formula = formula.replace(check, "{{#$1}}");
        }

        // Build math expression
        if (data.find("target") === "field") {
            target = data.find("target", "targetField");
            if (target.length > 0 && formula.length) {
                expression = "{{#"+target+"}} = " + formula
            }
        } else if (data.find("target") === "element") {
            target = data.find("target", "targetElement");
            if (target.length > 0 && formula.length) {
                expression = "{{"+target+"}} = " + formula
            }
        }
        // Calculate
        if (expression.length > 0) {
            $('form').evaluate(expression);
        }
    }

    /**
     * Executes each rule,
     * first when the page is loaded,
     * then when the user change any value to the form elements
     */
    var rules = function () {
        var conditionsAdapter = {},
            body = $("body"),
            oldOuterHeight = body.outerHeight(true);

        $.each(options.fieldIds, function (index, id) {
            var $field = $("#" + id);
            var name = $field.attr("name");
            var type = $field.attr('type') || $field.get(0).tagName.toLowerCase();

            if (type === "checkbox") {
                conditionsAdapter[id] = $field.is(":checked");
            } else if (type === "radio") {
                conditionsAdapter[name] = $("input[name='" + name + "']:checked").val();
            } else if (type === "button") {
                conditionsAdapter[id] = $field.data('clicked');
            } else if (type === "select") {
                conditionsAdapter[id] = $field.val();
            } else {
                conditionsAdapter[id] = $field.val();
            }
        });

        var actionsAdapter = {
            toShow: function (data) {
                if (data.find("target") === "field") {
                    var field = findField(data.find("target", "targetField")).show(); // Show field
                    if (field.is(':radio, :checkbox')) {
                        field.css("display", "inline-block")
                    } else {
                        field.show();
                    }
                    field.parent().closest('div.form-group').show(); // Show label
                } else if (data.find("target") === "element") {
                    findElement(data.find("target", "targetElement")).show();
                }
            },
            toHide: function (data) {
                if (data.find("target") === "field") {
                    var field = findField(data.find("target", "targetField")).hide(); // Hide field
                        field.parent().closest('div.form-group').hide(); // Hide label
                } else if (data.find("target") === "element") {
                    findElement(data.find("target", "targetElement")).hide();
                }
            },
            toEnable: function (data) {
                if (data.find("target") === "field") {
                    var field = findField(data.find("target", "targetField")).prop('disabled', false); // Enable field
                } else if (data.find("target") === "element") {
                    findElement(data.find("target", "targetElement")).prop('disabled', false);
                }
            },
            toDisable: function (data) {
                if (data.find("target") === "field") {
                    var field = findField(data.find("target", "targetField")).prop('disabled', true); // Disable field
                } else if (data.find("target") === "element" ) {
                    findElement(data.find("target", "targetElement")).prop('disabled', true);
                }
            },
            performArithmeticOperations: function (data) {
                performArithmeticOperations(data);
            },
            evaluateMathFormula: function (data) {
                evaluateMathFormula(data);
            },
            resetResult: function (data) {
                // Don't reset the result, if the form has been submitted
                if (options.submitted) return false;
                setTargetValue(data, 0);
            },
            copy: function (data) {
                var fields = getOriginalElement(data);
                setTargetElement(data, fields);
            },
            skip: function (data, ruleID) {
                var skip = $.grep(options.skips, function (e){ return e.id === ruleID; });
                if (skip.length === 0) {
                    options.skips.push({
                        id: ruleID,
                        from: null,
                        to: parseInt(data.find("step"))
                    });
                }
            },
            resetSkip: function (data, ruleID) {
                options.skips = $.grep(options.skips, function (e) { return e.id !== ruleID; });
            },
            formatNumber: function (data) {
                if (data.find("target") === "field") {
                    var field = findField(data.find("target", "targetField")); // field
                    if (field) {
                        var fieldValue = numeral(field.val()).format(data.find("format"));
                        field.val(fieldValue);
                    }
                } else if (data.find("target") === "element") {
                    var element = findElement(data.find("target", "targetElement"));
                    if (element) {
                        var elementValue = numeral(element.text()).format(data.find("format"));
                        element.text(elementValue);
                    }
                }
            },
            formatText: function (data) {
                var fields = getOriginalElement(data);
                formatTargetElement(data, fields);
            },
            form: function (data) {
                var action = data.find("action");
                if (action === "submit") {
                    formEl.submit();
                } else if (action === "reset") {
                    formEl.get(0).reset();
                } else if (action === "nextStep") {
                    nextStep();
                } else if (action === "previousStep") {
                    previousStep()
                }
            }
        };
        $.each(options.rules, function (index, rule) {
            var engine = new RuleEngine({
                conditions: JSON.parse(rule.conditions),
                actions: JSON.parse(rule.actions)
            });
            var oppositeAdapter = rule.opposite ? {
                toShow: "toHide",
                toHide: "toShow",
                toEnable: "toDisable",
                toDisable: "toEnable",
                performArithmeticOperations: "resetResult",
                skip: "resetSkip"
            } : {};
            engine.run(conditionsAdapter, actionsAdapter, oppositeAdapter);
        });
        // After run, send the new form height to the parent window
        var newOuterHeight = body.outerHeight(true);
        if (oldOuterHeight !== newOuterHeight) {
            Utils.postMessage({
                height: newOuterHeight
            });
        }
    };

    $( window ).load(function () {
        rules();
    });

    var formEl = $("form");

    formEl.find(":input").on('keyup change click input', function () {
        rules();
    });

    formEl.on("view success", function () {
        rules();
    });

    formEl.find(":button").mousedown(function () {
        $(this).data('clicked', true);
    });
});