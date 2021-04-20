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
    'jquery', 'underscore', 'backbone', 'cssjson', 'simplebar', 'grapick'
    , "helper/pubsub"
    , "text!data/google-fonts.json"
    , "text!data/web-gradients.json"
    , "text!data/patterns.json"
    , "text!data/design-properties.json"
    , "text!templates/app/styles.html"
    , "text!templates/styles/color.html"
    , "text!templates/styles/background-image.html"
    , "text!templates/styles/background-size.html"
    , "text!templates/styles/background-repeat.html"
    , "text!templates/styles/background-position.html"
    , "text!templates/styles/border-style.html"
    , "text!templates/styles/border-width.html"
    , "text!templates/styles/border-radius.html"
    , "text!templates/styles/box-shadow.html"
    , "text!templates/styles/margin.html"
    , "text!templates/styles/padding.html"
    , "text!templates/styles/width.html"
    , "text!templates/styles/height.html"
    , "text!templates/styles/float.html"
    , "text!templates/styles/text-align.html"
    , "text!templates/styles/font-family.html"
    , "text!templates/styles/font-size.html"
    , "text!templates/styles/font-weight.html"
    , "text!templates/styles/text-transform.html"
    , "text!templates/styles/text-decoration.html"
    , "text!templates/styles/line-height.html"
    , "text!templates/styles/text-shadow.html"
    , "text!templates/styles/letter-spacing.html"
    , "text!templates/styles/transition.html"
    , "text!templates/styles/display.html"

], function($, _, Backbone, CSSJSON, SimpleBar, Grapick
    , PubSub
    , _fonts
    , _gradients
    , _patterns
    , _properties
    , _styles
    , _stylesColor
    , _stylesBackgroundImage
    , _stylesBackgroundSize
    , _stylesBackgroundRepeat
    , _stylesBackgroundPosition
    , _stylesBorderStyle
    , _stylesBorderWidth
    , _stylesBorderRadius
    , _stylesBoxShadow
    , _stylesMargin
    , _stylesPadding
    , _stylesWidth
    , _stylesHeight
    , _stylesFloat
    , _stylesTextAlign
    , _stylesFontFamily
    , _stylesFontSize
    , _stylesFontWeight
    , _stylesTextTransform
    , _stylesTextDecoration
    , _stylesLineHeight
    , _stylesTextShadow
    , _stylesLetterSpacing
    , _stylesTransition
    , _stylesDisplay
){
    return Backbone.View.extend({
        tagName: "div"
        , className: ""
        , initialize: function(options) {
            this.options = options;
            this.id = this.options.id;
            // CSS Properties
            this.properties = JSON.parse(_properties);
            // Google Fonts
            var fonts = JSON.parse(_fonts);
            this.fonts = [];
            if (!_.isUndefined(fonts.items)) {
                var that = this;
                _.each(fonts.items, function (font) {
                    that.fonts.push(font.replace(/ /g, '+'));
                })
            }
            // Web Patterns
            var patterns = JSON.parse(_patterns);
            this.patterns = !_.isUndefined(patterns.patterns) ? patterns.patterns : [];
            // Web Gradients
            var gradients = [];
            _.each(JSON.parse(_gradients), function (_gradient) {
                if (!_.isUndefined(_gradient.gradient)) {
                    var g = _gradient.gradient;
                    var colors = _.pluck(g, 'color');
                    var positions = _.pluck(g, 'pos');
                    var direction = _gradient.deg+'deg';
                    var background;
                    switch (g.length) {
                        case 2:
                            background = 'linear-gradient('+ direction +', '+ g[0].color +' '+ g[0].pos +'%, '+ g[1].color +' '+ g[1].pos +'%)';
                            break;
                        case 3:
                            background = 'linear-gradient('+ direction +', '+ g[0].color +' '+ g[0].pos +'%, '+ g[1].color +' '+ g[1].pos +'%, '+ g[2].color +' '+ g[2].pos +'%)';
                            break;
                        case 4:
                            background = 'linear-gradient('+ direction +', '+ g[0].color +' '+ g[0].pos +'%, '+ g[1].color +' '+ g[1].pos +'%, '+ g[2].color +' '+ g[2].pos +'%, '+ g[3].color +' '+ g[3].pos +'%)';
                            break;
                        case 5:
                            background = 'linear-gradient('+ direction +', '+ g[0].color +' '+ g[0].pos +'%, '+ g[1].color +' '+ g[1].pos +'%, '+ g[2].color +' '+ g[2].pos +'%, '+ g[3].color +' '+ g[3].pos +'%, '+ g[4].color +' '+ g[4].pos +'%)';
                            break;
                        default:
                    }

                    if (!_.isUndefined(background) && !_.isEmpty(background)) {
                        gradients.push({
                            background: background,
                            colors: colors,
                            positions: positions,
                            direction: direction
                        });
                    }
                }
            });
            this.gradients = gradients;
            // Templates
            this.template = _.template(_styles);
            this.colorTemplate = _.template(_stylesColor);
            this.backgroundImageTemplate = _.template(_stylesBackgroundImage);
            this.backgroundSizeTemplate = _.template(_stylesBackgroundSize);
            this.backgroundRepeatTemplate = _.template(_stylesBackgroundRepeat);
            this.backgroundPositionTemplate = _.template(_stylesBackgroundPosition);
            this.borderStyleTemplate = _.template(_stylesBorderStyle);
            this.borderWidthTemplate = _.template(_stylesBorderWidth);
            this.borderRadiusTemplate = _.template(_stylesBorderRadius);
            this.boxShadowTemplate = _.template(_stylesBoxShadow);
            this.marginTemplate = _.template(_stylesMargin);
            this.paddingTemplate = _.template(_stylesPadding);
            this.widthTemplate = _.template(_stylesWidth);
            this.heightTemplate = _.template(_stylesHeight);
            this.floatTemplate = _.template(_stylesFloat);
            this.textAlignTemplate = _.template(_stylesTextAlign);
            this.fontFamilyTemplate = _.template(_stylesFontFamily);
            this.fontSizeTemplate = _.template(_stylesFontSize);
            this.fontWeightTemplate = _.template(_stylesFontWeight);
            this.textTransformTemplate = _.template(_stylesTextTransform);
            this.textDecorationTemplate = _.template(_stylesTextDecoration);
            this.lineHeightTemplate = _.template(_stylesLineHeight);
            this.textShadowTemplate = _.template(_stylesTextShadow);
            this.letterSpacingTemplate = _.template(_stylesLetterSpacing);
            this.transitionTemplate = _.template(_stylesTransition);
            this.displayTemplate = _.template(_stylesDisplay);
            this.render();
        }
        , getAvailableCssProperties: function (name) {
            var availableCssProperties = [
                'background-color',
                'background-image',
                'background-position',
                'background-repeat',
                'background-size',
                'border-color',
                'border-radius',
                'border-style',
                'border-width',
                'box-shadow',
                'color',
                'display',
                'float',
                'font-family',
                'font-size',
                'font-weight',
                'height',
                'letter-spacing',
                'line-height',
                'margin',
                'padding',
                'text-align',
                'text-decoration',
                'text-shadow',
                'text-transform',
                'transition',
                'width'
            ];

            // var obj = _.findWhere(this.properties, {name: name});
            var obj = this.properties.filter(function (prop) {
                return prop.name === name;
            })[0];

            if (typeof obj !== "undefined") {
                availableCssProperties = obj.properties;
            }

            return availableCssProperties;
        }
        , renderCSS: function (selector, properties, id) {
            var attributes = {};
            _.each(properties, function (val, prop) {
                if (val !== ''){
                    attributes[prop] = val;
                }
            });
            var jsonStyles = {
                "children": {},
                "attributes": {}
            };
            jsonStyles["children"][selector] = {
                "children": {},
                "attributes": attributes
            };

            var cssStyles = CSSJSON.toCSS(jsonStyles);
            var styleNode = CSSJSON.toHEAD(cssStyles, id, true);
            return typeof styleNode !== "undefined" ? styleNode.id : id;
        }
        , renderColorPicker: function($wrapper, $config) {
            var palette = [["rgb(0, 0, 0)","rgb(67, 67, 67)","rgb(102, 102, 102)"]];
            var config = {
                showInput: true,
                showInitial: true,
                showPalette: false,
                showSelectionPalette: true,
                showAlpha: true,
                allowEmpty: true,
                preferredFormat: "hex",
                cancelText: polyglot.t('style.cancel'),
                chooseText: polyglot.t('style.choose'),
                theme: "sp-krajee",
                palette: palette
            };
            $wrapper.html(this.colorTemplate($config));
            var input = $config.name;
            var $el = $wrapper.find("#"+input);
            if ($el.data('spectrum')) { $el.spectrum('destroy'); }
            config['change'] = function(tinyColor) {
                var value = _.isNull(tinyColor) ? '' : tinyColor.toString();
                $el.val(value);
                $el.trigger('change', tinyColor);
            };
            config['move'] = function(tinyColor) {
                var value = _.isNull(tinyColor) ? '' : tinyColor.toString();
                $el.val(value);
                $el.trigger('change', tinyColor);
            };
            $.when($wrapper.find("#"+input+"-source").spectrum(config))
                .done(function() {
                    $wrapper.find("#"+input+"-source").spectrum('set', $el.val());
                    $wrapper.find("#"+input+"-cont").removeClass('kv-center-loading')
                });
            return $el;
        }
        , renderGoogleFontsSelector: function ($wrapper, $config) {
            $wrapper.html(this.fontFamilyTemplate($config));
            var input = $config.name;
            var $el = $wrapper.find("#"+input);
            var that = this;
            var fontOptions = {
                placeholder: $config.placeholder,
                searchable: true
            };
            if (that.fonts.length > 0) {
                $el.fontselect($.extend({}, fontOptions, { googleFonts: that.fonts }));
            } else {
                $.getJSON("https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBulCGAb4s71G7ScneWgUUyQvfIQWToz9Y")
                    .done(function (fonts) {
                        if (!_.isUndefined(fonts.items)) {
                            for (var i = 0; i < fonts.items.length; i++) {
                                if (!_.isUndefined(fonts.items[i].family)) {
                                    that.fonts.push(fonts.items[i].family.replace(/ /g, '+'));
                                }
                            }
                            $el.fontselect($.extend({}, fontOptions, { googleFonts: that.fonts }));
                        } else {
                            $el.fontselect(fontOptions);
                        }
                    }).fail(function () {
                        $el.fontselect(fontOptions);
                    });
            }
            return $el;
        }
        , render: function(){
            // var t0 = performance.now();
            var that = this;
            var $html = $(this.template());
            this.collection.each(function (model) {
                var name = model.get('name');
                var selector = model.get('selector');
                var properties = model.get('properties');
                var styleID = that.renderCSS(selector, properties);
                var availableCssProperties = that.getAvailableCssProperties(name);
                _.each(availableCssProperties, function (prop) {
                    var input = name + '-' + prop;
                    var val = typeof properties[prop] !== "undefined" ? properties[prop] : "";
                    var $wrapper = $html.find("#"+input+"-wrapper");
                    if ($wrapper.length) {
                        if (prop === 'background-color') {
                            that.renderColorPicker($wrapper, {
                                name: input,
                                label: polyglot.t('style.backgroundColor'),
                                placeholder: polyglot.t('style.selectColor'),
                                value: val
                            }).change(function (e, tinyColor) {
                                properties["background-color"] = !_.isUndefined(tinyColor) ? tinyColor.toString() : $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'color') {
                            that.renderColorPicker($wrapper, {
                                name: input,
                                label: polyglot.t('style.color'),
                                placeholder: polyglot.t('style.selectColor'),
                                value: val
                            }).change(function (e, tinyColor) {
                                properties["color"] = !_.isUndefined(tinyColor) ? tinyColor.toString() : $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'background-image') {
                            $wrapper.html(that.backgroundImageTemplate({
                                scope: name,
                                name: input,
                                label: polyglot.t('style.backgroundImageGradient'),
                                placeholder: 'none',
                                value: val,
                                patterns: that.patterns,
                                gradients: that.gradients,
                                homeUrl: options.homeUrl
                            }));
                            var $el = $wrapper.find("#"+input);
                            // Type Selector
                            $wrapper.find('input[name=bg-image-type]').on('change', function () {
                                var selectedType = $(this).val();
                                if (selectedType === 'gradient') {
                                    $wrapper.find('.gradients').show();
                                    $wrapper.find('.patterns').hide();
                                    $wrapper.find('.others').hide();
                                } else if (selectedType === 'pattern') {
                                    $wrapper.find('.gradients').hide();
                                    $wrapper.find('.patterns').show();
                                    $wrapper.find('.others').hide();
                                } else if (selectedType === 'other') {
                                    $wrapper.find('.gradients').hide();
                                    $wrapper.find('.patterns').hide();
                                    $wrapper.find('.others').show();
                                } else {
                                    $wrapper.find('.gradients').hide();
                                    $wrapper.find('.patterns').hide();
                                    $wrapper.find('.others').hide();
                                }
                            });
                            $wrapper.find('.pattern-item').on('click', function () {
                                $wrapper.find('.pattern-item').removeClass('selected');
                                $(this).addClass('selected');
                                $el.val($(this).data('src'));
                                $el.trigger('change');
                            });
                            $wrapper.data('loaded', false);
                            var loadPatterns = function (scrollTop){
                                if ($wrapper.data('loaded')) {
                                    return;
                                }
                                if (scrollTop === null){
                                    scrollTop = $wrapper.find(".pattern-group").scrollTop();
                                }
                                var start = Math.round(scrollTop / 50);
                                var end = start * 16;
                                if (end === 0) {
                                    end = 24;
                                }
                                var $pattern;
                                for (var i = start; i < end; i++) {
                                    $pattern = $wrapper.find(".pattern-item:nth-child("+i+")");
                                    $pattern.css("backgroundImage", "url(" + $pattern.data("src") + ")");
                                    if (i > 387) {
                                        $wrapper.data('loaded', true);
                                    }
                                }
                            };
                            // Select pattern
                            if (val.length > 0) {
                                $wrapper.find('.pattern-item').removeClass('selected');
                                $wrapper.find('.pattern-item').filter(function(){
                                    var src = $wrapper.find(this).data("src");
                                    return src === val || 'url('+src+')' === val;
                                }).addClass('selected');
                            }
                            // Delay
                            setTimeout(function(){
                                var selectedPattern = 0;
                                loadPatterns(selectedPattern);
                            },10);
                            $wrapper.find(".pattern-group").on("scroll",function(){
                                loadPatterns(null);
                            });
                            if ($wrapper.find('#gp-'+ input).length) {
                                var gp = new Grapick({
                                    el: $wrapper.find('#gp-'+ input)[0],
                                    colorEl: '<input id="gp-cp-'+ input +'"/>',
                                    direction: 'to right',
                                    min: 1,
                                    max: 99
                                });
                                gp.setColorPicker(function (handler) {
                                    var el = handler.getEl().querySelector('#gp-cp-'+input);
                                    $wrapper.find(el).spectrum({
                                        color: handler.getColor(),
                                        showInput:true,
                                        showInitial:true,
                                        showPalette:false,
                                        showSelectionPalette:true,
                                        showAlpha:true,
                                        allowEmpty:true,
                                        preferredFormat:"hex",
                                        theme:"sp-krajee",
                                        change: function change(color) {
                                            handler.setColor(color.toRgbString());
                                        },
                                        move: function move(color) {
                                            handler.setColor(color.toRgbString(), 0);
                                        }
                                    });
                                });
                                gp.on('change', function(complete) {
                                    $el.val(gp.getSafeValue());
                                    $el.trigger('change');
                                });
                                var $swType = $wrapper.find('#switch-type-'+input);
                                var $swAngle = $wrapper.find('#switch-angle-'+input);
                                var type = '';
                                var direction = '';
                                $swType.change(function () {
                                    gp.setType($(this).val());
                                    type = $(this).val();
                                });
                                $swAngle.change(function () {
                                    gp.setDirection($(this).val());
                                    type = $(this).val();
                                });
                                $wrapper.find('.gradient').on('click', function () {
                                    $wrapper.find('.gradient').removeClass('selected');
                                    $(this).addClass('selected');
                                    gp.clear();
                                    gp.setValue($(this).data('background'));
                                    if (!_.isEmpty(type)) {
                                        gp.setType(type);
                                    }
                                    if (!_.isEmpty(direction)) {
                                        gp.setDirection(direction);
                                    }
                                    gp.emit('change');
                                });
                                var updateGradientEditor = function (bgImg) {
                                    var typeFound;
                                    var types = ['repeating-linear', 'repeating-radial', 'linear', 'radial'];
                                    types.forEach(function (name) {
                                        if (bgImg.indexOf(name + "-gradient(") > -1 && !typeFound) {
                                            typeFound = 1;
                                            gp.setValue(bgImg);
                                        }
                                    });
                                };
                                if (val.length > 0) {
                                    updateGradientEditor(val);
                                }
                                $el.keyup(function (e) {
                                    var vKey = 86;
                                    var bgImg = $(this).val();
                                    if (e.keyCode === vKey) {
                                        updateGradientEditor(bgImg)
                                    }
                                });
                            }
                            $el.change(function () {
                                var bgImg = $(this).val();
                                if (bgImg.indexOf("http") === 0) {
                                    bgImg = "url(" + bgImg + ")";
                                }
                                properties["background-image"] = bgImg;
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'background-size') {
                            $wrapper.html(that.backgroundSizeTemplate({
                                name: input,
                                label: polyglot.t('style.bgSize'),
                                placeholder: '100% 100%',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["background-size"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'background-repeat') {
                            $wrapper.html(that.backgroundRepeatTemplate({
                                name: input,
                                label: polyglot.t('style.bgRepeat'),
                                placeholder: 'repeat',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["background-repeat"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'background-position') {
                            $wrapper.html(that.backgroundPositionTemplate({
                                name: input,
                                label: polyglot.t('style.backgroundPosition'),
                                placeholder: 'initial',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["background-position"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'border-style') {
                            $wrapper.html(that.borderStyleTemplate({
                                name: input,
                                label: polyglot.t('style.borderStyle'),
                                placeholder: 'solid',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["border-style"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'border-width') {
                            $wrapper.html(that.borderWidthTemplate({
                                name: input,
                                label: polyglot.t('style.borderWidth'),
                                placeholder: '1px',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["border-width"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                            var data = [
                                {'label': polyglot.t('style.none'), 'value': '0'}
                            ];
                            _.each(_.range(1, 100, 1), function(number) {
                                data.push({'label': number + 'px', 'value': number + 'px'})
                            });
                            _.each(_.range(1, 50, 1), function(number) {
                                data.push({'label': number + '%', 'value': number + '5'})
                            });
                            $wrapper.find("#"+input).flexdatalist({
                                minLength: 0,
                                valueProperty: 'value',
                                visibleProperties: ["label"],
                                searchIn: 'label',
                                noResultsText: '',
                                maxShownResults: 200,
                                data: data
                            });
                        } else if (prop === 'border-color') {
                            that.renderColorPicker($wrapper, {
                                name: input,
                                label: polyglot.t('style.borderColor'),
                                placeholder: polyglot.t('style.selectColor'),
                                value: val
                            }).change(function (e, tinyColor) {
                                properties["border-color"] = typeof tinyColor !== 'undefined' ? tinyColor.toString() : $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'border-radius') {
                            $wrapper.html(that.borderRadiusTemplate({
                                name: input,
                                label: polyglot.t('style.borderRadius'),
                                placeholder: '4px',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["border-radius"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'box-shadow') {
                            $wrapper.html(that.boxShadowTemplate({
                                name: input,
                                label: polyglot.t('style.boxShadow'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["box-shadow"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'text-shadow') {
                            $wrapper.html(that.textShadowTemplate({
                                name: input,
                                label: polyglot.t('style.textShadow'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["text-shadow"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                            $wrapper.find("#"+input).flexdatalist({
                                minLength: 0,
                                valueProperty: 'value',
                                visibleProperties: ["label"],
                                searchIn: 'label',
                                noResultsText: '',
                                data: [
                                    {'label': polyglot.t('style.none'), 'value': 'none'},
                                    {'label': polyglot.t('style.basic'), 'value': '2px 4px 3px rgba(0,0,0,0.3)'},
                                    {'label': polyglot.t('style.hard'), 'value': '6px 6px 0px rgba(0,0,0,0.2)'},
                                    {'label': polyglot.t('style.double'), 'value': '4px 3px 0px #fff, 9px 8px 0px rgba(0,0,0,0.15)'},
                                    {'label': polyglot.t('style.downAndDistant'), 'value': '0px 3px 0px #b2a98f, 0px 14px 10px rgba(0,0,0,0.15), 0px 24px 2px rgba(0,0,0,0.1), 0px 34px 30px rgba(0,0,0,0.1);'},
                                    {'label': polyglot.t('style.closeAndHeavy'), 'value': '0px 4px 3px rgba(0,0,0,0.4), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1)'},
                                    {'label': '3D', 'value': '0 1px 0 #ccc, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25), 0 10px 10px rgba(0,0,0,.2), 0 20px 20px rgba(0,0,0,.15)'},
                                    {'label': polyglot.t('style.glowing'), 'value': '0px 0px 6px rgba(255,255,255,0.7)'},
                                    {'label': polyglot.t('style.superhero'), 'value': '-10px 10px 0px #00e6e6, -20px 20px 0px #01cccc, -30px 30px 0px #00bdbd;'},
                                    {'label': polyglot.t('style.multipleLightSources'), 'value': '0px 15px 5px rgba(0,0,0,0.1), 10px 20px 5px rgba(0,0,0,0.05), -10px 20px 5px rgba(0,0,0,0.05)'},
                                    {'label': polyglot.t('style.softEmboss'), 'value': '2px 8px 6px rgba(0,0,0,0.2), 0px -5px 35px rgba(255,255,255,0.3)'},
                                    {'label': '2px 2px #ff0000', 'value': '2px 2px #ff0000'}
                                ]
                            });
                        } else if (prop === 'margin') {
                            $wrapper.html(that.marginTemplate({
                                name: input,
                                label: polyglot.t('style.margin'),
                                placeholder: '15px',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["margin"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'padding') {
                            $wrapper.html(that.paddingTemplate({
                                name: input,
                                label: polyglot.t('style.padding'),
                                placeholder: '15px',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["padding"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'width') {
                            $wrapper.html(that.widthTemplate({
                                name: input,
                                label: polyglot.t('style.width'),
                                placeholder: '100%',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["width"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'height') {
                            $wrapper.html(that.heightTemplate({
                                name: input,
                                label: polyglot.t('style.height'),
                                placeholder: 'auto',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["height"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'float') {
                            $wrapper.html(that.floatTemplate({
                                name: input,
                                label: polyglot.t('style.float'),
                                placeholder: 'none',
                                value: val
                            }));
                            $wrapper.find("#"+input).change(function () {
                                properties["float"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'text-align') {
                            $wrapper.html(that.textAlignTemplate({
                                name: input,
                                label: polyglot.t('style.textAlignment'),
                                placeholder: 'right',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["text-align"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'font-family') {
                            that.renderGoogleFontsSelector($wrapper, {
                                name: input,
                                label: polyglot.t('style.fontFamily'),
                                placeholder: polyglot.t('style.selectFont'),
                                value: val.replace(/ /g, '+').replace(/"/g, '')
                            }).change(function () {
                                var font = this.value;
                                // Replace + signs with spaces for css
                                font = font.replace(/\+/g, ' ');
                                // Split font into family and weight
                                font = font.split(':');
                                var fontFamily = font[0];
                                // Update
                                properties["font-family"] = /\s/.test(fontFamily) ? '"' + fontFamily + '"' : fontFamily;
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'font-size') {
                            $wrapper.html(that.fontSizeTemplate({
                                name: input,
                                label: polyglot.t('style.fontSize'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["font-size"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'font-weight') {
                            $wrapper.html(that.fontWeightTemplate({
                                name: input,
                                label: polyglot.t('style.fontWeight'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["font-weight"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'text-transform') {
                            $wrapper.html(that.textTransformTemplate({
                                name: input,
                                label: polyglot.t('style.textTransform'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["text-transform"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'text-decoration') {
                            $wrapper.html(that.textDecorationTemplate({
                                name: input,
                                label: polyglot.t('style.textDecoration'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["text-decoration"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'line-height') {
                            $wrapper.html(that.lineHeightTemplate({
                                name: input,
                                label: polyglot.t('style.lineHeight'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["line-height"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'letter-spacing') {
                            $wrapper.html(that.letterSpacingTemplate({
                                name: input,
                                label: polyglot.t('style.letterSpacing'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["letter-spacing"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'transition') {
                            $wrapper.html(that.transitionTemplate({
                                name: input,
                                label: polyglot.t('style.transition'),
                                placeholder: '',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["transition"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        } else if (prop === 'display') {
                            $wrapper.html(that.displayTemplate({
                                name: input,
                                label: polyglot.t('style.display'),
                                placeholder: 'none',
                                value: val
                            }));
                            $wrapper.find("#"+input).val(val);
                            $wrapper.find("#"+input).change(function () {
                                properties["display"] = $(this).val();
                                that.renderCSS(selector, properties, styleID);
                            });
                        }
                    }
                });
            });

            // Add data lists
            $html.find('.data-list').flexdatalist({
                minLength: 0,
                noResultsText: ''
            });

            var stylesEl = document.getElementById('styles');
            this.$el.empty();
            this.$el.append($html);
            this.$el.appendTo(stylesEl); // Add fieldset to form
            new SimpleBar(stylesEl); // Add scrollbar
            // var t1 = performance.now();
            // console.log("Call to styles:render took", (t1 - t0), "milliseconds. With", this.collection.length, "components.");
        }
    });
});