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
    var dateChart = dc.lineChart("#date-chart");
    var hourChart = dc.barChart("#hour-chart");
    var isMobileChart = dc.pieChart("#ismobile-chart");
    var browserChart = dc.rowChart("#browser-chart");
    var osChart = dc.pieChart("#os-chart");
    var deviceChart = dc.pieChart("#device-chart");
    var referrerChart = dc.pieChart("#referrer-chart");
    var domainChart = dc.rowChart("#domain-chart");
    var worldChart = dc.geoChoroplethChart("#world-chart");
    var cityChart = dc.rowChart("#city-chart");
    var sessionsChart = dc.rowChart("#sessions-chart");

    d3.csv(options.endPoint, function (data) {

        // Time Formats
        var yearFormat = d3.time.format("%Y");
        var monthNameFormat = d3.time.format("%B");
        var dayNameFormat = d3.time.format("%A");
        var hourFormat = d3.time.format("%H");
        var dayFormat = d3.time.format("%m/%d/%Y");

        // Format data
        data.forEach(function(d){
            d.time = +d.collector_tstamp;
            d.date = new Date(+d.time * 1000);
            d.year   = yearFormat(d.date);
            d.day = dayFormat(d.date);
            d.hour   = +hourFormat(d.date);
            d.monthName   = monthNameFormat(d.date);
            d.dayName   = dayNameFormat(d.date);
        });

        /**
         * Dimensions and Groups
         */

        // Run the data through crossfilter and load our 'facts'
        var facts = crossfilter(data);
        var all = facts.groupAll();

        // Time Dimension
        var timeDimension = facts.dimension(function (d) {
            return d.time;
        });

        // Date Dimension
        var dayDim = facts.dimension(function (d) {
            return d3.time.day.floor(d.date); // Rounds down the specified date
        });

        var dayGroup = dayDim.group();

        // Hour Dimension
        var hourDim = facts.dimension(function (d) {
            return d.hour;
        });

        var hourGroup = hourDim.group();

        // isMobile Dimension
        var isMobileDim = facts.dimension(function (d) {
            var isMobile = +d.dvce_ismobile;
            return isMobile ? options.i18n.yes : options.i18n.no;
        });
        // isMobile Group
        var isMobileGroup = isMobileDim.group();

        // Browser Dimension
        var browserDim = facts.dimension(function (d) {
            return d.br_family;
        });
        // Browser Group
        var browserGroup = browserDim.group();

        // OS Dimension
        var osDim = facts.dimension(function (d) {
            return d.os_family;
        });
        // OS Group
        var osGroup = osDim.group();

        // OS Dimension
        var deviceDim = facts.dimension(function (d) {
            return d.dvce_type;
        });
        // OS Group
        var deviceGroup = deviceDim.group();

        // Referrer Dimension
        var referrerDim = facts.dimension(function (d) {
            return d.refr_medium;
        });
        // Referrer Group
        var referrerGroup = referrerDim.group();

        // Domain Dimension
        var domainDim = facts.dimension(function (d) {
            return d.refr_urlhost;
        });
        // Domain Group
        var domainGroup = domainDim.group();

        // Country Dimension
        var countryDim = facts.dimension(function (d) {
            return d.geo_country;
        });
        // Country Group
        var countryGroup = countryDim.group();

        // City Dimension
        var cityDim = facts.dimension(function (d) {
            return d.geo_city;
        });
        // City Group
        var cityGroup = cityDim.group();

        // Session Before Submission Dimension
        var sessionsDim = facts.dimension(function (d) {

            var sessions;

            if ( d.domain_sessionidx < 2) {
                sessions = '1';
            } else if ( d.domain_sessionidx < 3 ) {
                sessions = '2';
            } else if ( d.domain_sessionidx < 4 ) {
                sessions = '3';
            } else if ( d.domain_sessionidx < 5 ) {
                sessions = '4';
            } else if ( d.domain_sessionidx < 6 ) {
                sessions = '5';
            } else if ( d.domain_sessionidx < 7 ) {
                sessions = '6';
            } else if ( d.domain_sessionidx < 8 ) {
                sessions = '7';
            } else {
                sessions = '8 +';
            }

            return sessions;
        });

        var sessionsGroup = sessionsDim.group();

        /**
         * Setup the charts
         */

        // Count all the facts
        dc.dataCount(".data-count")
            .dimension(facts)
            .group(all);

        // Min/Max day for x labels
        var minDay = (typeof dayDim.bottom(1)[0] != 'undefined') ? d3.time.day.floor(dayDim.bottom(1)[0].date) : 0;
        var maxDay = (typeof dayDim.top(1)[0] != 'undefined') ? d3.time.day.floor(dayDim.top(1)[0].date) : 0;

        dateChart
            .width($("#date").width())
            .height(250)
            .x(d3.time.scale().domain([minDay,maxDay]))
            .elasticX(true)
            .elasticY(true)
            .renderHorizontalGridLines(true)
            .brushOn(false)
            .renderDataPoints(true)
            .ordinalColors(colors)
            .clipPadding(10)
            .dimension(dayDim)
            .group(dayGroup);

        hourChart
            .width($("#hour").width())
            .height(250)
            .x(d3.scale.linear().domain([0,24]))
            .renderHorizontalGridLines(true)
            .brushOn(false)
            .ordinalColors(colors)
            .dimension(hourDim)
            .group(hourGroup);

         // isMobile Pie Chart
        isMobileChart
            .width($("#ismobile").width())
            .height(220)
            .radius(100)
            .dimension(isMobileDim)
            .ordinalColors(colors)
            .group(isMobileGroup)
            .label(function (d) {
                if (isMobileChart.hasFilter() && !isMobileChart.hasFilter(d.key)) {
                    return d.key + ' (0%)';
                }
                var label = d.key;
                if (all.value()) {
                    label += ' (' + Math.floor(d.value / all.value() * 100) + '%)';
                }
                return label;
            })
            .renderLabel(true);

        // Browser Pie Chart
        browserChart
            .width($("#browser").width())
            .height(230)
            .margins({top: 0, left: 10, right: 10, bottom: 20})
            .dimension(browserDim)
            .group(browserGroup)
            .ordinalColors(colors)
            .elasticX(true)
            .xAxis().ticks(4);

        // OS Pie Chart
        osChart
            .width($("#os").width())
            .height(220)
            .radius(100)
            //.innerRadius(50)
            .dimension(osDim)
            .ordinalColors(colors)
            .group(osGroup)
            .renderLabel(true);

        // Device Pie Chart
        deviceChart
            .width($("#device").width())
            .height(220)
            .radius(100)
            //.innerRadius(50)
            .dimension(deviceDim)
            .ordinalColors(colors)
            .group(deviceGroup)
            .renderLabel(true);

        // Referrer Pie Chart
        var referrerWidth = $("#referrer").width();
        referrerChart
            .width(referrerWidth)
            .height(230)
            .radius(100)
            .innerRadius(75)
            .dimension(referrerDim)
            .ordinalColors(colors)
            .group(referrerGroup)
            .renderLabel(false)
            .renderTitle(true)
            .legend(dc.legend().x(Math.round((referrerWidth * 50 / 100) - 24)).y(80).itemHeight(13).gap(5));

        // Domain Pie Chart
        domainChart
            .width($("#domain").width())
            .height(230)
            .margins({top: 0, left: 10, right: 10, bottom: 20})
            .dimension(domainDim)
            .group(domainGroup)
            .ordinalColors(colors)
            .elasticX(true)
            .data(function (domainGroup) {
                return domainGroup.top(8);
            })
            .xAxis().ticks(4);

        // City Row Chart
        cityChart
            .width($("#city").width())
            .height(440)
            .margins({top: 0, left: 10, right: 10, bottom: 20})
            .group(cityGroup)
            .dimension(cityDim)
            .ordinalColors(colors)
            .elasticX(true)
            .data(function (cityGroup) {
                return cityGroup.top(10);
            })
            .xAxis().ticks(4);

        // Sessions Row Chart
        sessionsChart
            .width($("#sessions").width())
            .height(240)
            .margins({top: 0, left: 10, right: 10, bottom: 20})
            .group(sessionsGroup)
            .dimension(sessionsDim)
            .ordinalColors(colors)
            .elasticX(true)
            .xAxis().ticks(4);

        // Country GeoChoropleth Chart
        d3.json(options.countriesJSON, function (countriesJson) {

            // Calculate the dimensions of the map from the width of its container
            var worldWidth = $("#world").width();
            var worldHeight = Math.round( worldWidth * 60 / 100 );
            var worldScale = Math.round( worldWidth * 13 / 100 );
            var worldTranslateW = Math.round( worldWidth * 45 / 100 );
            var worldTranslateH = Math.round( worldHeight * 50 / 100 );

            var projection = d3.geo.mercator()
                .center([0,40])
                .scale(worldScale)
                .translate([worldTranslateW,worldTranslateH])
                .rotate([-12,0]);

            worldChart
                .width(worldWidth)
                .height(worldHeight)
                .dimension(countryDim)
                .group(countryGroup)
                .projection(projection)
                .colors(d3.scale.quantize().range(["#BAD1FF", "#ADC4FE", "#94ABE5", "#7A91CB", "#6178B2", "#475E98", "#2E457F", "#142B65", "#00124C", "#000032"]))
                .colorDomain([0, 200])
                .colorCalculator(function (d) {
                    return d ? worldChart.colors()(d) : '#CCC';
                })
                .overlayGeoJson(countriesJson.features, "state", function (d) {
                    return d.properties.name;
                })
                .title(function (d) {
                    var title = options.i18n.noData;
                    if (d.value && d.value > 0) {
                        title = d.key + ": " + d.value;
                    } else {
                        title = d.key + ": 0";
                    }
                    return title;
                });

            dc.renderAll();

        });

    });

});
