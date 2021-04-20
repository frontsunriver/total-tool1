/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

if (typeof EasyForms !== 'function') {

    function EasyForms() {

        'use strict';

        /************************************************************
         * Private data
         ************************************************************/

        // default settings
        var options = {
            id: 0,
            sid: 0,
            container: "c0",
            width: "100%",
            height: 0,
            autoResize: !0,
            addToOffsetTop: 0,
            theme: 1,
            customJS: 1,
            record: 1,
            form: "",
            frameUrl: "",
            defaultValues: !1 // JSON Object
        };

        /************************************************************
         * Private methods
         ************************************************************/

        /**
         * Get Domain
         *
         * URI Parsing with Javascript
         * @returns {string}
         */
        function getDomain(url) {
            // See: https://gist.github.com/jlong/2428561
            var parser = document.createElement('a');
            parser.href = url;
            return parser.hostname + (parser.port ? ':' + parser.port: '');
        }

        /**
         * Create New Event
         *
         * @param eventName
         * @returns {Event}
         */
        function createNewEvent(eventName) {
            var event;
            if (typeof(Event) === 'function') {
                event = new Event(eventName);
            } else {
                event = document.createEvent('Event');
                event.initEvent(eventName, true, true);
            }
            return event;
        }

        /**
         * Resize the Form iFrame
         *
         * @param height
         */
        function resizeIframe(height) {
            if(options.autoResize) {
                // Get iframe element
                var i = document.getElementById(options.container+"i"+options.id);
                i.style.height= height + "px";
                window.dispatchEvent(createNewEvent('resize'));
            }
        }

        /**
         * Redirect to URL
         *
         * @param url
         */
        function redirect(url) {
            window.location.href = url ? url : '/';
        }

        /**
         * Returns the url of the iframe containing the form.
         *
         * @returns {string}
         */
        function getFrameUrl() {
            var url = document.URL, title = document.title, refer = document.referrer;
            var prefix = ( options.form.indexOf('?') >= 0 ? '&' : '?' );
            var src = options.form + prefix + queryParams({
                    id: options.id,
                    sid: options.sid,
                    t: options.theme ,
                    js: options.customJS,
                    rec: options.record
                });
            src += "&parentUrl=" + encodeURIComponent(url);
            options.record && (src += "&title=" + encodeURIComponent(title));
            options.record && (src += "&url=" + encodeURIComponent(url));
            options.record && (src += "&referrer=" + encodeURIComponent(refer));
            options.defaultValues && (src += "&defaultValues=" + encodeURIComponent(JSON.stringify(options.defaultValues)));
            options.frameUrl = src;
            return src;
        }

        /**
         * iFrame Markup Generator
         *
         * @returns {Element}
         */
        function generateFrameMarkup() {
            var i = document.createElement("iframe");
            i.id = i.name = options.container + "i" + options.id;
            i.src = getFrameUrl();
            i.scrolling = "no";
            i.frameBorder = "0";
            i.allowTransparency = "true";
            i.style.width = options.width;
            if (!options.autoResize) { i.style.height = options.height; }
            if (typeof scrollToTop.bind !== 'undefined') { i.onload = i.onreadystatechange = scrollToTop.bind(i); }
            return i;
        }

        /**
         * Create a serialized representation of an array or a plain object
         * for use in a URL query string or Ajax request
         *
         * @param source
         * @returns {string}
         */
        function queryParams(source) {
            var array = [];

            for(var key in source) {
                array.push(encodeURIComponent(key) + "=" + encodeURIComponent(source[key]));
            }

            return array.join("&");
        }

        /**
         * Finds 'y' value of give object
         * @param obj
         * @returns {*[]}
         */
        function findPosition(obj) {
            var curtop = 0;
            if (obj.offsetParent) {
                do {
                    curtop += obj.offsetTop;
                } while (obj = obj.offsetParent);
                curtop = curtop + options.addToOffsetTop;
                return [curtop];
            }
        }

        /**
         * Scroll to the top of the page or top of the form container
         */
        function scrollToTop (elem){
            if (elem === 'page') {
                window.scrollTo(0, 1);
            } else if (elem === 'container') {
                window.scroll(0, findPosition(document.getElementById(options.container)));
                var modal = document.getElementsByClassName('ef-modal');
                if (modal.length > 0) {
                    modal[0].scrollTop = 0
                }
            }
        }

        /**
         * Cross-browser function to add form iframe event handler
         * to rezise its height
         */
        function addIframeListener() {
            // See: http://davidwalsh.name/window-iframe
            // Create IE + others compatible event handler
            var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
            var eventer = window[eventMethod];
            var messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";
            var childDomain = getDomain(options.frameUrl);
            // Listen to message from child window
            eventer(messageEvent,function(e) {
                var originDomain = getDomain(e.origin);
                if (!e.origin) {
                    originDomain = e.hostname + (e.port ? ':' + e.port: '');
                }
                if (originDomain.indexOf(childDomain) !== -1) {
                    try {
                        var data = JSON.parse(e.data);
                        if ((typeof data.formID !== "undefined" && data.formID === options.id)
                            || (typeof data.hashId !== "undefined" && data.hashId === options.id)) {
                            if (typeof data.height !== "undefined") {
                                resizeIframe(data.height);
                            } else if (typeof data.scrollToTop !== "undefined") {
                                scrollToTop(data.scrollToTop);
                            } else if (typeof data.url !== "undefined") {
                                redirect(data.url);
                            }
                        }
                    } catch (err) {}
                }
            }, false);
        }

        /************************************************************
         * Public data and methods
         ************************************************************/

        this.initialize = function ( opts ) {
            // Overwrite default options
            for ( var opt in opts ) {
                if (opt in options) options[opt] = opts[opt];
            }
            return this;
        };

        // Display form
        this.display = function () {
            var c = document.getElementById(options.container),
                i = generateFrameMarkup();
            c.innerHTML = '';
            c.appendChild(i);
            addIframeListener();
            return this;
        };
    }
}

if (typeof FormWidget !== 'object') {
    FormWidget = new EasyForms();
}
