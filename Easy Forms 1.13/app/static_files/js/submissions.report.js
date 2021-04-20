/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

// Override template settings
_.templateSettings = {
    evaluate: /\{\{(.+?)\}\}/g,
    interpolate: /\{\{=(.+?)\}\}/g,
    escape: /\{\{-(.+?)\}\}/g
};

/**
 * Global variables
 */

// Grid jQuery Object
var gridEl,
// GridStack Object
gridStack,
// Charts array
charts;

$( document ).ready(function() {

    d3.json(options.endPoint, function (data) {

        /**
         * Init
         */
        gridEl = $('.grid-stack');
        gridEl.gridstack({
            cell_height: 90,
            vertical_margin: 10
        });
        gridStack = gridEl.data('gridstack');
        charts = [];

        var color1 = "#475e98";
        var color2 = "#9B59B6";
        var color3 = "#F8B700";
        var color4 = "#78CC00";
        var color5 = "#7B71C5";
        var color6 = "#56B2EA";
        var color7 = "#E064CD";
        var colors = [
            color1,color2,color3,color4,color5,color6, color7,
            color1,color2,color3,color4,color5,color6, color7
        ];

        /**
         * Flag if a widget was resized
         *
         * @type {boolean}
         */
        var widgetResized = false;

        /**
         * Dimensions and Groups
         */

        data.forEach(function (d) {
            // Parse date column
            var milliseconds = d.created_at * 1000;
            d.date = new Date(milliseconds);
        });

        // Run the data through crossfilter and load our 'facts'
        var facts = crossfilter(data);
        var all = facts.groupAll();

        // Show data count
        var dataCount = dc.dataCount(".data-count")
            .dimension(facts)
            .group(all);
        dataCount.render();

        // Date filter
        var dateDim = facts.dimension(function (d) { return d.date; });

        // Reset all filters
        $("#reset-all").on("click", function (e) {
            e.preventDefault();
            dateDim.filter(null);
            dc.filterAll(null);
            dc.renderAll();
        });

        // Date Range Filter
        $("#report-filter").on("submit", function (e) {
            e.preventDefault();
            var fromDate = $("#from-date-disp").val();
            var toDate = $("#to-date-disp").val();
            if (fromDate.length > 0 && toDate.length > 0) {
                dateDim.filter(dc.filters.RangedFilter(new Date(fromDate), new Date(toDate)));
                dc.redrawAll();
            } else if (fromDate.length === 0 && toDate.length === 0) {
                dateDim.filter(null);
                dc.redrawAll();
            }
        });

        /**
         * Methods
         */

        // Add widget to grid
        var addWidget = function(title, type, name, label, x, y, w, h){
            // load template text
            var widget = $('#widget').html();
            // complie widget and bind context
            var widget_html = _.template(widget)({
                title: title,
                type: type,
                name: name,
                label: label
            });
            // Add widget
            gridStack.add_widget($(widget_html),
                x, y, w, h);
        };

        // Draw Chart inside widget
        var drawChart = function(chartName, chartType){

            // Temporal dimension
            var tmpDim = facts.dimension(function(d) {
                return d[chartName];
            });

            // Temporal group
            var tmpGroup = tmpDim.group();

            // Widget
            var widget = $("div").find("[data-name='" + chartName + "']");
            var width = widget.width();
            var height = widget.height();

            if(chartType === "pie") {
                // Build pie chart
                charts[chartName] = dc.pieChart("#"+chartName);
                charts[chartName]
                    .width(width - 80)
                    .height(height - 80)
                    .ordinalColors(colors)
                    .slicesCap(4)
                    .renderTitle(true)
                    .legend(dc.legend())
                    .renderLabel(false)
                    .dimension(tmpDim)
                    .group(tmpGroup);
            } else if(chartType === "donut") {
                // Build donut chart
                charts[chartName] = dc.pieChart("#"+chartName);
                charts[chartName]
                    .width(width - 80)
                    .height(height - 80)
                    .ordinalColors(colors)
                    .dimension(tmpDim)
                    .group(tmpGroup)
                    .innerRadius(Math.round((height - 80) * 20 / 100))
                    .renderLabel(true)
                    .renderTitle(true);
            } else if(chartType === "row") {
                // Build row chart
                charts[chartName] = dc.rowChart("#"+chartName);
                charts[chartName]
                    .width(width - 40)
                    .height(height - 80)
                    .ordinalColors(colors)
                    .dimension(tmpDim)
                    .group(tmpGroup)
                    .elasticX(true);
            } else if(chartType === "bar") {
                // Build bar chart
                charts[chartName] = dc.barChart("#"+chartName);
                charts[chartName]
                    .width(width - 10)
                    .height(height - 80)
                    .ordinalColors(colors)
                    .x(d3.scale.ordinal())
                    .xUnits(dc.units.ordinal)
                    .brushOn(false)
                    .dimension(tmpDim)
                    .barPadding(0.1)
                    .outerPadding(0.05)
                    .on('renderlet', function(chart){
                        chart.selectAll("rect").attr("fill", function(d, i){
                            return colors[i];
                        });
                    })
                    .group(tmpGroup);
            }

            // Render chart
            charts[chartName].render();
        };

        // Show alert message
        var showMessage = function( container, txt, type ) {
            var message  = '<div class="alert alert-'+type+'" role="alert">';
                message += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                message += '<span aria-hidden="true">&times;</span>';
                message += '</button>';
                message += '<p><span class="glyphicon glyphicon-ok-sign"></span> '+ txt +'</p>';
                message += '</div>';
            $(container).append(message);
        };

        // Hide alert message
        var hideMessage = function( container ){
            $(container).empty();
        };

        /**
         * Draw report
         */

        // For each chart, add new widget and draw its chart
        _.each(options.charts, function(chart) {
            // Add new widget
            addWidget(chart.title, chart.type, chart.name, chart.label,
                chart.gsX, chart.gsY, chart.gsW, chart.gsH);
            // Draw its chart
            drawChart(chart.name, chart.type);
        });

        gridStack.disable(); // Disable customization by default

        /**
         * Add Event Handlers
         */

        // This event handler listen the end of a resize operation
        gridEl.on('resizestop', function () {
            // One widget was resized
            widgetResized = true;
        });

        // Occurs after adding/removing widgets or existing widgets change their position/size
        gridEl.on('change', function (e, items) {
            // Execute only when a widget was resized
            if( widgetResized) {
                // By default, the first widget is resized
                var widget = _.first(items).el;
                // Extract data
                var chartName = widget.data("name");
                var chartType = widget.data("type");
                var width = widget.width();
                var height = widget.height();
                // Redraw chart
                if( chartType === "bar" ) {
                    charts[chartName]
                        .width(width  - 10)
                        .height(height - 80)
                        .rescale()
                        .redraw();
                } else if( chartType === "row" ) {
                    charts[chartName]
                        .width(width  - 40)
                        .height(height - 80)
                        .redraw();
                } else if( chartType === "donut" ) {
                    charts[chartName]
                        .width(width - 80)
                        .height(height - 80)
                        .innerRadius(Math.round((height - 80) * 20 / 100))
                        .redraw();
                } else {
                    charts[chartName]
                        .width(width - 80)
                        .height(height - 80)
                        .redraw();
                }
            }

            // Set flag to false
            widgetResized = false;
        });

        // Delete chart
        window.deleteChart = function(el) {
            var name = $(el).data('name');
            var widget = $("div").find("[data-name='" + name + "']");
            gridStack.remove_widget(widget);
        };

        // Enable customization
        $('#enable').click(function(e){
            e.preventDefault();
            gridStack.enable();
            gridEl.addClass('grid-editable');
            $(".btn-for-toggle").toggle();
        });

        // Disable customization
        $('#disable').click(function(e){
            e.preventDefault();
            gridStack.disable();
            gridEl.removeClass('grid-editable');
            $(".btn-for-toggle").toggle();
        });

        // Reset report
        $('#reset').click(function(e){
            e.preventDefault();
            gridStack.remove_all();
        });

        $('#formModal').on('show.bs.modal', function (event) {
            var target = $(event.relatedTarget); // Element that triggered the modal
            var title = target.data('title'); // Extract info from data-* attributes
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            if ( typeof title === 'undefined' ) {
                // Add chart -> Reset fields
                modal.find('#chartTitle').val('');
                modal.find('#chartType option:eq(0)').prop('selected', true);
                modal.find('#field option:eq(0)').prop('selected', true);
                modal.find('#field').prop('disabled', false);
            } else {
                // Edit chart -> Fill fields
                var name = target.data('name');
                var label = target.data('label');
                var type = target.data('type');
                modal.find('#chartTitle').val(title);
                modal.find('#chartType option[value="'+type+'"]').prop('selected', true);
                modal.find('#field option[value="'+name+'"]').prop('selected', true);
                modal.find('#field').prop('disabled', true);
            }
        });

        // Save chart
        $( "#saveChart" ).on( "click", function(e) {

            e.preventDefault();

            var chartTitle = $('#chartTitle').val();
            var chartType = $('#chartType').val();
            var fieldEl = $('#field');
            var chartName = fieldEl.val();
            var chartLabel = fieldEl.children(":selected").text();

            // Check if the chart already exist
            if ( $("#"+chartName).length ) {
                // Get widget data
                var widget = $("div").find("[data-name='" + chartName + "']");
                var x = widget.data('gs-x');
                var y = widget.data('gs-y');
                var w = widget.data('gs-width');
                var h = widget.data('gs-height');

                // Remove old widget
                gridStack.remove_widget(widget);
                // Add new widget
                addWidget(chartTitle, chartType, chartName, chartLabel,
                    x, y, w, h);
                // Redraw chart
                drawChart(chartName, chartType);

            } else {

                if( chartTitle.length === 0 ) {
                    hideMessage( '#modal-messages' );
                    showMessage( '#modal-messages',
                        '<strong>'+ options.i18n.error +'</strong> ' + options.i18n.errorMessage,
                        'danger' );
                    return false;
                }

                // Add widget
                addWidget(chartTitle, chartType, chartName, chartLabel,
                    0, 0, 3, 3);
                // Draw chart
                drawChart(chartName, chartType);

            }
        });

        // Save report
        $('#saveReport').click(function(e){

            e.preventDefault();

            // Serialize the report
            var report = _.map($('.grid-stack .grid-stack-item:visible'), function (el) {

                el = $(el);
                var node = el.data('_gridstack_node');

                return {
                    name: el.attr('data-name'),
                    label: el.attr('data-label'),
                    title: el.attr('data-title'),
                    type: el.attr('data-type'),
                    width: 120,
                    height: 120,
                    gsX: node.x,
                    gsY: node.y,
                    gsW: node.width,
                    gsH: node.height
                };
            });

            var data = {
                report: JSON.stringify(report), // Prepare report to POST as JSON
                _csrf : options._csrf // Add csfr token
            };

            // Send report to the server
            var jqxhr = $.ajax({
                    method: "POST",
                    url: options.endPoint,
                    dataType: 'json',
                    data: data
                })
                .done(function( data ) {
                    if( data.success && data.id > 0) {
                        // Hide all alerts
                        hideMessage('#messages');
                        // Show success message
                        showMessage( '#messages',
                            '<strong>' + options.i18n.success + '</strong> ' + options.i18n.updatedMessage,
                            'success' );
                    } else {
                        // Hide all alerts
                        hideMessage('#messages');
                        // Show error message
                        showMessage( '#messages',
                            '<strong>' + options.i18n.error + '</strong> ' + options.i18n.errorOnUpdate,
                            'danger' );
                    }
                })
                .fail(function( msg ) {
                    // Hide all alerts
                    hideMessage('#messages');
                    // Show error message
                    showMessage( '#messages',
                        '<strong>' + options.i18n.success + '</strong>' + options.i18n.errorOnUpdate,
                        'danger' );
                    //$("#reportNotSaved").show();
                    console.error( msg );
                });

        });

    });

});