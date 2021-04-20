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
    "jquery", "underscore", "backbone", "tinyMCE", "simplebar",
    "views/component",
    "helper/pubsub"
], function (
    $, _, Backbone, tinyMCE, SimpleBar,
    ComponentView,
    PubSub
    ) {
    return ComponentView.extend({
        events:{
            "click"   : "preventPropagation" // stops checkbox / radio reacting.
            , "mousedown" : "mouseDownHandler"
            , "mouseup"   : "mouseUpHandler"
        }

        , mouseDownHandler : function (mouseDownEvent) {
            mouseDownEvent.stopPropagation();
            mouseDownEvent.preventDefault();
            var that = this;

            // Close any popover
            $(".popover").remove();

            that.$el.popover({
                trigger: 'manual',
                placement: function () {
                    if (window.GridColumns === 8 || window.GridColumns === 12) {
                        return 'bottom';
                    }
                    return 'right';
                },
                html: true,
                sanitize: false,
                content: function () {
                    return that.getPopoverContent();
                }
            });

            that.$el.popover("show");

            // Add scope to improve performance
            var $popover = $(".popover");

            $popover.find("#save").on("click", that.saveHandler(that));
            $popover.find("#copy").on("click", that.copyHandler(that));
            $popover.find("#delete").on("click", that.deleteHandler(that));
            $popover.find("#cancel").on("click", that.cancelHandler(that));

            // Add Scrollbar
            new SimpleBar($popover.find(".popover-content-settings")[0]);

            // Component Type
            var componentType = that.model.getType();

            // Required by Matrix, Checkbox, Radio Button and Select List
            var isSelectList = componentType === 'selectlist';
            var isCheckbox = componentType === 'checkbox';
            var isRadioButton = componentType === 'radio';
            var isMatrix = componentType === 'matrix';

            if (isSelectList || isCheckbox || isRadioButton || isMatrix) {

                if (isSelectList || isMatrix || isRadioButton) {

                    if (!$popover.find("#multiple").is(":checked")) {
                        $popover.on("click", '.selected-choice', function () {
                            $popover.find('.selected-choice').not(this).prop('checked', false);
                        });
                    }

                    if (isSelectList || isMatrix) {

                        $popover.find(".for-show-images").hide();

                        if (isSelectList) {
                            $popover.find("#multiple").on("change", function (e) {
                                e.preventDefault();
                                $('.selected-choice').prop('checked', false);
                                if (!$(e.currentTarget).is(":checked")) {
                                    $popover.on("click", '.selected-choice', function () {
                                        $('.selected-choice').not(this).prop('checked', false);
                                    });
                                } else {
                                    $popover.off("click", '.selected-choice');
                                }
                            });
                        }

                        if (isMatrix) {
                            var toggle = function(inputType) {
                                inputType = inputType || $popover.find("#inputType").val();
                                // All
                                $popover.find("#questions .for-show-values").hide();
                                $popover.find("#questions .checkbox").hide();
                                // Radio and Checkbox options
                                if (_.contains(["radio", "checkbox"], inputType)) {
                                    $popover.find("#answers .checkbox").show();
                                } else {
                                    $popover.find("#answers .checkbox").hide();
                                }
                                // Number & Date options
                                if (_.contains(["number", "range", "date",
                                    "datetime-local", "time", "month", "week"], inputType)) {
                                    $popover.find("#min, #max, #step").closest(".form-group").show();
                                } else {
                                    $popover.find("#min, #max, #step").closest(".form-group").hide();
                                }
                                // Text, Email & Text Area options
                                if (_.contains(["text", "url",
                                    "tel", "password", "email", "textarea"], inputType)) {
                                    $popover.find("#minlength, #maxlength").closest(".form-group").show();
                                } else {
                                    $popover.find("#minlength, #maxlength").closest(".form-group").hide();
                                }
                                // Text, Email & Numbers options
                                if (_.contains(["text", "url",
                                    "tel", "password", "email", "number", "range"], inputType)) {
                                    $popover.find("#pattern").closest(".form-group").show();
                                } else {
                                    $popover.find("#pattern").closest(".form-group").hide();
                                }
                                // Select List options
                                if (_.contains(["select"], inputType)) {
                                    $popover.find("#multiple").closest(".checkbox").show();
                                } else {
                                    $popover.find("#multiple").closest(".checkbox").hide();
                                }
                            }
                            var $inputType = $popover.find("#inputType");
                            // When popover is shown
                            toggle($inputType.val());
                            // When input type changes
                            $inputType.change(function (e) {
                                toggle($(this).val());
                            });
                            // When a new choice is added
                            $popover.on("added-choice", function (e) {
                                toggle();
                            });
                        }
                    }
                }

                var bulkChoicesCache = [];

                $popover.on("click", ".bulk-editor", function (e) {
                    e.preventDefault();
                    var $scope = $(e.currentTarget).closest('.form-group');
                    var scopeID = $scope.attr('id');
                    $scope.find(".bulk-cancel").show();
                    $scope.find(".bulk-choices").show();
                    $scope.find(".show-options").hide();
                    $scope.find(".choices").hide();
                    $(this).hide();
                    bulkChoicesCache[scopeID] = $scope.find(".bulk-choices").val();
                });

                $popover.on("click", ".bulk-cancel", function (e) {
                    e.preventDefault();
                    var $scope = $(e.currentTarget).closest('.form-group');
                    var scopeID = $scope.attr('id');
                    $scope.find(".bulk-editor").show();
                    $scope.find(".show-options").show();
                    $scope.find(".choices").show();
                    $scope.find(".bulk-choices").hide();
                    $(this).hide();
                    if (!_.isUndefined(bulkChoicesCache[scopeID])) {
                        $scope.find(".bulk-choices").val(bulkChoicesCache[scopeID]);
                    }
                });

                $popover.on("click", ".add-choice", function (e) {
                    e.preventDefault();
                    var aColumns = "col-xs-8";
                    var vDisplay = "display: none";
                    var iDisplay = "display: none";
                    if ($("#show-values").is(":checked")) {
                        aColumns = "col-xs-4";
                        vDisplay = "display: inline-block";
                    }
                    if ($("#show-images").is(":checked")) {
                        iDisplay = "display: inline-block";
                    }
                    $(e.currentTarget)
                        .closest('.choice')
                        .after(
                            '<div class="row row-no-gutters choice">' +
                            ' <div class="col-xs-1">' +
                            '   <div class="checkbox">' +
                            '     <input type="checkbox"{{ if(selected) { }} checked{{ } }} name="selected[]" class="selected-choice" />' +
                            '   </div>' +
                            ' </div>' +
                            ' <div class="' + aColumns + ' no-padding choice-answer">' +
                            '   <input type="text" class="form-control input-sm" placeholder="Choice" value="" name="answer[]">' +
                            ' </div>' +
                            ' <div class="col-xs-4 no-padding-right choice-value" style="'+ vDisplay +'">' +
                            '   <input type="text" class="form-control input-sm" placeholder="Value" value="" name="value[]">' +
                            ' </div>' +
                            ' <div class="col-xs-2 no-padding">' +
                            '   <small class="actions">' +
                            '     <span class="glyphicon glyphicon-plus-sign add-choice"></span>' +
                            '     <span class="glyphicon glyphicon-minus-sign text-danger remove-choice"></span>' +
                            '   </small>' +
                            ' </div> ' +
                            ' <div class="col-xs-8 col-xs-offset-1 choice-image" style="'+ iDisplay +'">' +
                            '   <input type="text" class="form-control input-sm" placeholder="'+ polyglot.t('popover.image') +'" name="image[]" />' +
                            ' </div>' +
                            '</div>');
                    $popover.trigger("added-choice");
                });

                $popover.on("click", ".remove-choice", function (e) {
                    e.preventDefault();
                    $(e.currentTarget).closest('.row').remove();
                });

                $popover.on("click", ".show-values", function (e) {
                    var $scope = $(e.currentTarget).closest('.form-group');
                    if ($(this).is(":checked")) {
                        $scope.find(".choice-answer")
                            .removeClass()
                            .addClass("col-xs-4 no-padding choice-answer");
                        $scope.find(".choice-value")
                            .show();
                    } else {
                        $scope.find(".choice-answer")
                            .removeClass()
                            .addClass("col-xs-8 no-padding choice-answer");
                        $scope.find(".choice-value")
                            .hide();
                    }
                });

                $popover.on("click", ".show-images", function (e) {
                    var $scope = $(e.currentTarget).closest('.form-group');
                    if ($(this).is(":checked")) {
                        // Show images
                        $scope.find(".choice-image")
                            .show();
                    } else {
                        $scope.find(".choice-image")
                            .hide();
                    }
                });
            }

            // Add drag event for all
            $("body").on("mousemove", function (mouseMoveEvent) {
                if ( Math.abs(mouseDownEvent.pageX - mouseMoveEvent.pageX) > 10 ||
                    Math.abs(mouseDownEvent.pageY - mouseMoveEvent.pageY) > 10 )
                {
                    that.$el.popover('destroy');
                    $(".popover").remove();
                    PubSub.trigger("myComponentDrag", mouseDownEvent, that.model);
                    that.mouseUpHandler();
                }
            });
        }

        , preventPropagation: function (e) {
            e.stopPropagation();
            e.preventDefault();
        }

        , mouseUpHandler : function (mouseUpEvent) {
            // Add Wysiwyg editor
            var config = {
                selector: '#snippet',
                base_url: options.libUrl + 'tinymce',
                suffix: '.min',
                plugins: 'advlist autolink link image lists charmap hr anchor ' +
                    'searchreplace visualblocks visualchars code fullscreen insertdatetime nonbreaking ' +
                    'save table directionality paste',
                toolbar: 'undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | fullscreen code',
                convert_urls: false,
                table_default_attributes: {
                    class: 'table'
                },
                table_class_list: [
                    {title: 'None', value: ''},
                    {title: 'Table', value: 'table'},
                    {title: 'Condensed', value: 'table table-condensed'},
                    {title: 'Striped', value: 'table table-striped'},
                    {title: 'Bordered', value: 'table table-bordered'},
                    {title: 'Hover', value: 'table table-hover'},
                    {title: 'Striped & Hover', value: 'table table-stripped table-hover'},
                    {title: 'Bordered & Hover', value: 'table table-bordered table-hover'},
                    {title: 'Bordered, Stripped & Hover', value: 'table table-bordered table-hover'}
                ],
                setup: function (editor) {
                    editor.on('FullscreenStateChanged', function (e) {
                        $(editor.editorContainer).find(".tox-toolbar").toggleClass("tox-toolbar-fullscreen")
                    });
                }
            };

            // Removes editor
            if (tinyMCE.get(0)) {
                tinyMCE.remove();
            }

            // Add editor
            tinyMCE.init(config)
                .then(function (editors) {});

            $("body").off("mousemove");
        }

        , saveHandler : function (boundContext) {
            return function (mouseEvent) {
                mouseEvent.preventDefault();
                // Save editor's content
                if (tinyMCE.get(0)) {
                    // tinyMCE.get(0).save();
                    tinyMCE.triggerSave();
                }
                var fields = $(".popover .field");
                _.each(fields, function (e) {

                    var $e = $(e)
                        , type = $e.attr("data-type")
                        , name = $e.attr("id");

                    switch(type) {
                        case "checkbox":
                            boundContext.model.setField(name, $e.is(":checked"));
                            break;
                        case "input":
                            boundContext.model.setField(name, $e.val());
                            break;
                        case "number":
                            boundContext.model.setField(name, $e.val());
                            break;
                        case "textarea":
                            boundContext.model.setField(name, $e.val());
                            break;
                        case "textarea-split":
                            boundContext.model.setField(name,
                                _.chain($e.val().split("\n"))
                                    .map(function (t) {return $.trim(t)})
                                    .filter(function (t) {return t.length > 0})
                                    .value()
                            );
                            break;
                        case "select":
                            var valarr = _.map($e.find("option"), function (e) {
                                return {value: e.value, selected: e.selected, label:$(e).text()};
                            });
                            boundContext.model.setField(name, valarr);
                            break;
                        case "choice":
                            var oldChoices = boundContext.model.getField(name);
                            var bulkChoices = _.chain($e.find(".bulk-choices").val().split("\n"))
                                .map(function (t) {return $.trim(t)})
                                .filter(function (t) {return t.length > 0})
                                .value();
                            if (bulkChoices.length && !_.isEqual(oldChoices, bulkChoices)) {
                                boundContext.model.setField(name, bulkChoices);
                            } else {
                                boundContext.model.setField(name, $e.find(".choice")
                                    .map(function () {
                                        var answer = $(this).find("input[name='answer[]']").val();
                                        var value = $(this).find("input[name='value[]']").val();
                                        var image = $(this).find("input[name='image[]']").val();
                                        var selected = $(this).find("input[name='selected[]']").is(':checked') ? 'selected' : null;
                                        if (image.length > 0 && value.length < 1) {
                                            value = answer;
                                        }
                                        return [answer, value, image, selected]
                                            .map(function (t) {return $.trim(t)})
                                            .filter(function (t) {return t.length > 0})
                                            .join('|');
                                    })
                                    .get());
                            }
                            break;
                    }
                });
                boundContext.model.trigger("change");
                boundContext.$el.popover("destroy");
                $(".popover").remove();
            }
        }

        , copyHandler : function (boundContext) {
            return function (mouseEvent) {
                mouseEvent.preventDefault();
                // Copy model
                var originalModel = boundContext.model;
                var copiedModel = originalModel.clone();
                copiedModel.attributes = $.extend(true, {}, copiedModel.attributes);
                copiedModel.set('fresh', true);
                originalModel.trigger("change");
                PubSub.trigger("myComponentCopy", copiedModel, originalModel);
                boundContext.$el.popover("destroy");
                $(".popover").remove();

            };
        }

        // Delete Model and Hide Popover
        , deleteHandler : function (boundContext) {
            return function (mouseEvent) {
                mouseEvent.preventDefault();
                if (confirm(polyglot.t('alert.confirmToDeleteField'))) {
                    boundContext.$el.popover("destroy");
                    $(".popover").remove();
                    PubSub.trigger("myComponentDelete", boundContext.model);
                }
            };
        }

        // Hide Popover
        , cancelHandler : function (boundContext) {
            return function (mouseEvent) {
                mouseEvent.preventDefault();
                boundContext.$el.popover("destroy");
                $(".popover").remove();
            };
        }

    });
});