/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.11
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 *
 * Based on jQuery Calculate (MIT license)
 * Copyright (c) 2015 Pablo Brasero Moreno
 *
 * Changes:
 * - Compatibility with Math.js last version
 * - Compatibility with Easy Forms Rule Engine
 * - Parse advanced functions
 */
(function ($) {

    $.fn.evaluate = function (stringOrFunction, opts) {
        opts = $.extend({}, $.evaluate.defaults(), opts || {});
        var api = new Api(this, opts);

        if (typeof stringOrFunction === 'string') {
            api.formula(stringOrFunction);
        } else {
            stringOrFunction.bind(this).call(stringOrFunction, api);
        }

        return this;
    }

    $.evaluate = {
        inputParser: function(rawVal) { return rawVal },

        outputFormatter: function(result) { return result },

        options: function(opts) {
            if (opts.inputParser) {
                this.inputParser = opts.inputParser;
            }
            if (opts.outputFormatter) {
                this.outputFormatter = opts.outputFormatter;
            }
        },

        defaults: function() {
            return {
                inputParser: this.inputParser,
                outputFormatter: this.outputFormatter
            }
        }
    }

    if (typeof math["import"] !== "undefined") {
        if (typeof dateFns !== "undefined") {
            math["import"](dateFns, {wrap: true, silent: true});
            math["import"]({
                now: function() {
                    return new Date();
                }
            })
        }
    }

    function Api(base, opts) {
        this.base = $(base);
        this.details = null;
        this.opts = opts || {};
        this.events = [];
    }

    Api.prototype = {
        formula: function(val) {
            priv.compile(this, val);
            priv.updateEvents(this);
            this.run();
        },

        run: function() {
            var that = this;
            this.base.each(function() {
                that.runOne($(this));
            });
        },

        runOne: function(base) {
            var values = readValues(this.details.operands, base, this.opts.inputParser);
            var result = this.compiled.evaluate(values);
            var formattedResult = this.opts.outputFormatter(result);
            base.find(this.details.resultSelector)
                .val(formattedResult);
        }
    }

    var priv = {
        compile: function(self, formula) {
            self.details = parseFormula(formula);
            var tree = math.parse(self.details.rside);
            self.compiled = tree.compile(math);
        },

        updateEvents: function(self) {
            priv.removeEvents(self);
            priv.setEvents(self);
        },

        removeEvents: function(self) {
            self.events.forEach(function(evt) {
                evt.query.off(evt.name, evt.handler);
            });
            self.events = [];
        },

        setEvents: function(self) {
            Object.keys(self.details.operands).forEach(function(selector) {
                self.base.each(function() {
                    var singleBase = $(this);
                    var field = singleBase.find(selector);
                    priv.setEvent(
                        self,
                        field,
                        'change',
                        function() { self.runOne(singleBase) }
                    );
                });
            });
        },

        setEvent: function(self, query, name, handler) {
            var evt = {
                query: query,
                name: name,
                handler: handler
            }
            evt.query.on(evt.name, evt.handler);
            self.events.push(evt);
        }
    };

    function parseFormula(str) {
        var formula = {
            operands: {},
        };

        var sides = str.match(/^\s*([^=\s]+)\s*=\s*(.*)$/);
        formula.rside = assignVariablesToSelectors(sides[2], formula.operands);
        formula.resultSelector = readFirstSelector(sides[1]);

        return formula;
    }

    var formulaSelectorsRegexp = '\{\{([^\}]+)\}\}';

    function assignVariablesToSelectors(formula, dict) {
        var re = new RegExp(formulaSelectorsRegexp, 'g');
        return formula.replace(re, function (_, capture) {
            var existing = dict[capture];
            if (existing) {
                return existing;
            }
            return dict[capture] = generateVarName();
        });
    }

    function readFirstSelector(formula) {
        var re = new RegExp(formulaSelectorsRegexp);
        return re.exec(formula)[1];
    }

    var generateVarName_count = 0;

    function generateVarName(index) {
        return 'X' + (generateVarName_count++);
    }

    function readValues(operands, element, inputParser) {
        var values = {};
        var base = $(element);
        $.each(asPairs(operands), function() {
            var selector = this[0],
                varName = this[1],
                matches = base.find(selector);
            values[varName] = matches.toArray().reduce(function(sum, el) {
                var rawVal = $(el).val(),
                    val = sum + inputParser(rawVal)*1;
                if (Number.isNaN(val)) {
                    if (typeof rawVal === "string") {
                        val = rawVal;
                    }
                }
                return val;
            }, 0);
        });
        return values;
    }

    function asPairs(obj) {
        var pairs = [];
        Object.keys(obj).forEach(function (key) {
            pairs.push([key, obj[key]]);
        });
        return pairs;
    }

})(jQuery);