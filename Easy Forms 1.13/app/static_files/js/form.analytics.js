/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

$( document ).ready(function() {

    //var color1 = "#3182bd";
    //var color2 = "#6baed6";
    //var color3 = "#9ecae1";
    //var color4 = "#c6dbef";
    //var color5 = "#dadaeb";
    //var colors = [color1,color2,color3,color4,color5];

    //var color1 = "#56B2EA";
    //var color2 = "#E064CD";
    //var color3 = "#F8B700";
    //var color4 = "#78CC00";
    //var color5 = "#7B71C5";
    //var colors = [color1,color2,color3,color4,color5];

    var color1 = "#475e98";
    var color2 = "#9B59B6";
    var color3 = "#F8B700";
    var color4 = "#78CC00";
    var color5 = "#7B71C5";
    var color6 = "#56B2EA";
    var color7 = "#E064CD";
    var colors = [color1,color2,color3,color4,color5,color6, color7];

    // Create the dc.js chart objects & link to div
    var overviewChart = dc.compositeChart("#overview-chart");
    var yearChart   = dc.pieChart("#year-chart");
    var monthChart  = dc.barChart("#month-chart");
    var dayOfWeekChart = dc.rowChart('#day-of-week-chart');
    var conversionTimeChart = dc.barChart('#conversion-time-chart');
    var conversionTimeLineChart = dc.compositeChart("#conversion-time-line-chart");
    var abandonmentChart = dc.pieChart('#abandonment-chart');
    var abandonmentTimeChart = dc.compositeChart("#abandonment-time-chart");

    d3.csv(options.endPoint, function (data) {

        var parseDate = d3.time.format("%Y-%m-%d").parse;
        var formatMinute = d3.time.format("%M:%S"); // Add %H: to show hours

        data.forEach(function(d) {

            d.users = +d.users;
            d.fills = +d.fills;
            d.conversions = +d.conversions;
            d.conversionTime = +d.conversionTime;
            d.abandonments = d.fills - d.conversions;

            // Individual rates
            d.abandonmentRate = Math.round((d.abandonments) / d.users * 100);

            // Dates
            d.date  = parseDate(d.day);
            d.year  = d.date.getFullYear();
        });

        /**
         * Fields
         */
        function reduceFieldsAdd(fields) {
            return function(p, v) {
                fields.forEach(function(f) {
                    p[f] += v[f];
                });
                return p;
            };
        }
        function reduceFieldsRemove(fields) {
            return function(p, v) {
                fields.forEach(function(f) {
                    p[f] -= v[f];
                });
                return p;
            };
        }
        function reduceFieldsInitial(fields) {
            return function() {
                var ret = {};
                fields.forEach(function(f) {
                    ret[f] = 0;
                });
                return ret;
            };
        }
        var fields = ['users', 'fills', 'conversions'];

        /**
         * Dimensions and Groups
         */

        // Run the data through crossfilter and load our 'facts'
        var facts = crossfilter(data);
        var all = facts.groupAll();
        var dateDim = facts.dimension(function(d) {
            return d.date;
        });
        var usersGroup = dateDim.group().reduceSum(function(d) {
            return d.users;
        });
        var fillsGroup = dateDim.group().reduceSum(function(d) {
            return d.fills;
        });
        var conversionsGroup = dateDim.group().reduceSum(function(d) {
            return d.conversions;
        });
        var yearDim  = facts.dimension(function(d) {
            return d.year;
        });
        var yearTotal = yearDim.group().reduce(reduceFieldsAdd(fields), reduceFieldsRemove(fields), reduceFieldsInitial(fields));
        var months = options.i18n.months;
        var monthOfYear = facts.dimension(function (d) {
            var month = d.date.getMonth();
            return months[month];
        });
        var monthGroup = monthOfYear.group().reduce(reduceFieldsAdd(fields), reduceFieldsRemove(fields), reduceFieldsInitial(fields));
        var dayOfWeek = facts.dimension(function (d) {
            var day = d.date.getDay();
            var name = options.i18n.days;
            return day + '.' + name[day];
        });
        var dayOfWeekGroup = dayOfWeek.group().reduce(reduceFieldsAdd(fields), reduceFieldsRemove(fields), reduceFieldsInitial(fields));
        var conversionTime = facts.dimension(function (d) {

            var interval;

            if ( d.conversionTime < 120) {
                interval = '0 - 2';
            } else if ( d.conversionTime < 240 ) {
                interval = '2 - 4';
            } else if ( d.conversionTime < 360 ) {
                interval = '4 - 6';
            } else if ( d.conversionTime < 600 ) {
                interval = '6 - 10';
            } else {
                interval = '+ 10';
            }

            return interval;
        });
        var conversionTimeGroup = conversionTime.group().reduceSum(function(d) {
            return d.conversions;
        });
        var conversionTimeLineGroup = dateDim.group().reduceSum(function(d) {
            return d.conversionTime;
        });
        // Create "fake groups" and "fake dimensions"
        function regroup(dim, cols) {
            var _groupAll = dim.groupAll().reduce(
                function(p, v) { // add
                    cols.forEach(function(c) {
                        p[c] += v[c];
                    });
                    return p;
                },
                function(p, v) { // remove
                    cols.forEach(function(c) {
                        p[c] -= v[c];
                    });
                    return p;
                },
                function() { // init
                    var p = {};
                    cols.forEach(function(c) {
                        p[c] = 0;
                    });
                    return p;
                });
            return {
                all: function() {
                    // or _.pairs, anything to turn the object into an array
                    return d3.map(_groupAll.value()).entries();
                }
            };
        }
        var vsDim = facts.dimension(function(r) { return r.a; });
        var vsGroup = regroup(vsDim, ['conversions', 'abandonments']);
        var abandonmentGroup = dateDim.group().reduceSum(function(d) {
            return d.abandonmentRate;
        });
        /**
         * Chart Listener
         * Rewrite numbers and rates
         */
        function chartListener()
        {
            var objs = dateDim.top(Infinity);
            var usersSum = 0, fillsSum = 0, conversionsSum = 0;
            // Sum all values of each column
            $.each(objs, function(index, obj){
                $.each( obj, function( key, value ) {
                    if ( key === "users" ) {
                        usersSum += value;
                    } else if ( key === "fills" ){
                        fillsSum += value;
                    } else if ( key === "conversions" ) {
                        conversionsSum += value;
                    }
                });
            });
            // Percents

            var fillsRate = isNaN(Math.round(fillsSum/usersSum * 100)) ? 0 : Math.round(fillsSum/usersSum * 100),
                completitionRate = isNaN(Math.round(conversionsSum/fillsSum * 100)) ? 0 : Math.round(conversionsSum/fillsSum * 100),
                conversionsRate = isNaN(Math.round(conversionsSum/usersSum * 100)) ? 0 : Math.round(conversionsSum/usersSum * 100);
            // Print Sums
            $("#users-number").text(usersSum);
            $("#fills-number").text(fillsSum);
            $("#conversions-number").text(conversionsSum);
            // Print Rates
            $("#fills-rate").text(fillsRate);
            $("#completition-rate").text(completitionRate);
            $("#conversion-rate").text(conversionsRate);

        }

        /**
         * Charts
         */
        // Data count
        dc.dataCount(".data-count")
            .dimension(facts)
            .group(all);

        // Min/Max date for x labels
        var minDate = (typeof dateDim.bottom(1)[0] != 'undefined') ? dateDim.bottom(1)[0].date : 0;
        var maxDate = (typeof dateDim.top(1)[0] != 'undefined') ? dateDim.top(1)[0].date : 0;

        // Overview - Composite Chart
        overviewChart
            .width($("#overview").width())
            .height(280)
            .x(d3.time.scale().domain([minDate,maxDate]))
            .elasticY(true)
            .elasticX(true)
            .yAxisPadding(10)
            .legend(dc.legend().x(50).y(20).itemHeight(13).gap(5))
            .renderHorizontalGridLines(true)
            .title(function (d) {
                var newKey = (d.key.getMonth() + 1) + "/" + d.key.getDate() + "/" + d.key.getFullYear();
                return " " + newKey + " \n " + d.value;
            })
            .on("preRender", chartListener)
            .brushOn(false)
            .compose([
                dc.lineChart(overviewChart)
                    .dimension(dateDim)
                    .colors(color1)
                    .renderArea(false)
                    .group(usersGroup, options.i18n.users),
                dc.lineChart(overviewChart)
                    .dimension(dateDim)
                    .colors(color2)
                    .renderArea(false)
                    .dashStyle([15,10])
                    .group(fillsGroup, options.i18n.beganFilling),
                dc.lineChart(overviewChart)
                    .dimension(dateDim)
                    .colors(color3)
                    .renderArea(true)
                    .group(conversionsGroup, options.i18n.conversions)
            ])
            .render();

        // Year - Pie Chart
        var yearWidth = $("#year").width();
        yearChart
            .width(yearWidth).height(230)
            .dimension(yearDim)
            .group(yearTotal)
            .valueAccessor(function (d) {
                return d.value.conversions;
            })
            .innerRadius(75)
            .renderLabel(false)
            .renderTitle(true)
            .title(function (d) {
                var title  = d.key + " \n";
                title += d.value.users + " " + options.i18n.users + " \n";
                title += d.value.fills + " " + options.i18n.beganFilling + " \n";
                title += d.value.conversions + " " + options.i18n.conversions;
                return title;
            })
            .ordinalColors(colors)
            .legend(dc.legend().x(Math.round((yearWidth * 50 / 100) - 18)).y(95).itemHeight(13).gap(5))
            .on("filtered", chartListener);

        // Month - Bar Chart
        monthChart
            .width($("#month").width())
            .height(250)
            .dimension(monthOfYear)
            .group(monthGroup)
            .valueAccessor(function (d) {
                return d.value.conversions;
            })
            .title(function (d) {
                var title  = d.key + " \n";
                title += d.value.users + " " + options.i18n.users + " \n";
                title += d.value.fills + " " + options.i18n.beganFilling + " \n";
                title += d.value.conversions + " " + options.i18n.conversions;
                return title;
            })
            .brushOn(false)
            .ordinalColors(colors)
            .on('filtered', chartListener)
            .x(d3.scale.ordinal().domain(months))
            .xUnits(dc.units.ordinal)
            .elasticY(true);

        // Day - Row Chart
        dayOfWeekChart
            .width($("#week").width())
            .height(240)
            .margins({top: 0, left: 10, right: 10, bottom: 20})
            .dimension(dayOfWeek)
            .group(dayOfWeekGroup)
            .valueAccessor(function (d) {
                return d.value.conversions;
            })
            .ordinalColors(colors)
            .label(function (d) {
                return d.key.split('.')[1];
            })
            .title(function (d) {
                var title  = d.key.split('.')[1] + " \n";
                title += d.value.users + " " + options.i18n.users + " \n";
                title += d.value.fills + " " + options.i18n.beganFilling + " \n";
                title += d.value.conversions + " " + options.i18n.conversions;
                return title;
            })
            .on('filtered', chartListener)
            .elasticX(true)
            .xAxis().ticks(4);

        // Conversion Time - Bar Chart
        conversionTimeChart
            .width($("#conversion-time").width())
            .height(253)
            .group(conversionTimeGroup)
            .dimension(conversionTime)
            .ordinalColors(colors)
            .brushOn(false)
            .on('filtered', chartListener)
            .x(d3.scale.ordinal().domain(['0 - 2', '2 - 4', '4 - 6', '6 - 10', '+ 10']))
            .xAxisLabel(options.i18n.minutes)
            .xUnits(dc.units.ordinal)
            .elasticY(true);

        // Conversion Time - Line Chart
        conversionTimeLineChart
            .width($("#conversion-time-line").width())
            .height(240)
            .x(d3.time.scale().domain([minDate,maxDate]))
            .elasticY(true)
            .elasticX(true)
            .yAxisPadding(50)
            .yAxisLabel('')
            .legend(dc.legend().x(50).y(20).itemHeight(13).gap(5))
            .renderHorizontalGridLines(true)
            .title(function (d) {
                var newKey = (d.key.getMonth() + 1) + "/" + d.key.getDate() + "/" + d.key.getFullYear();
                return " " + newKey + " \n " + formatMinute(new Date(2015, 0, 1, 0, 0, d.value));
            })
            .on("preRender", chartListener)
            .brushOn(false)
            .compose([
                dc.lineChart(conversionTimeLineChart)
                    .dimension(dateDim)
                    .colors(color2)
                    .renderArea(true)
                    .group(conversionTimeLineGroup, options.i18n.medianPerDay)
            ])
            .render();

        // Customize x axis tick format
        conversionTimeLineChart.yAxis().tickFormat(function(v) {
            return formatMinute(new Date(2015, 0, 1, 0, 0, v));
        });

        // Conversion vs Abandonment - Pie Chart
        var abandonmentWidth = $("#abandonment").width();
        abandonmentChart
            .width(abandonmentWidth)
            .height(230)
            .dimension(vsDim)
            .group(vsGroup)
            .innerRadius(75)
            .renderLabel(false)
            .renderTitle(true)
            .ordinalColors(colors)
            .title(function (d) {
                return d.value + " " + d.key;
            })
            .legend(dc.legend().x(Math.round((abandonmentWidth * 50 / 100) - 43)).y(95).itemHeight(13).gap(5));

        // Disable filter
        abandonmentChart.filter = function() {};

        // Abandonment rate - Line Chart
        abandonmentTimeChart
            .width($("#abandonment-time").width())
            .height(240)
            .x(d3.time.scale().domain([minDate,maxDate]))
            .elasticY(true)
            .elasticX(true)
            .yAxisPadding(50)
            .legend(dc.legend().x(50).y(20).itemHeight(13).gap(5))
            .renderHorizontalGridLines(true)
            .title(function (d) {
                var newKey = (d.key.getMonth() + 1) + "/" + d.key.getDate() + "/" + d.key.getFullYear();
                return newKey + "\n" + d.value + "%";
            })
            .on("preRender", chartListener)
            .brushOn(false)
            .compose([
                dc.lineChart(abandonmentTimeChart)
                    .dimension(dateDim)
                    .colors(color1)
                    .renderArea(true)
                    .group(abandonmentGroup, options.i18n.medianPerDay)
            ])
            .render();

        // customize x axis tick format
        abandonmentTimeChart.yAxis().tickFormat(function(v) {return v + "%";});

        dc.renderAll();

    });

});
