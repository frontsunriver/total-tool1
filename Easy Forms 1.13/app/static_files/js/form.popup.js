/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.5
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2017 Baluart.COM
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
(function(w, modal) {

    w.EasyForms = modal();

})(window, function () {

    var transitionEvent = whichTransitionEvent();

    /**
     * Set default options
     *
     * @param options
     * @constructor
     */
    function Modal(options) {

        var defaults = {
            autoOpen: false,
            closeButton: true,
            cssClass: [],
            closeLabel: 'Close',
            closeMethods: ['overlay', 'button', 'escape'],
            onClose: null,
            onOpen: null,
            beforeClose: null
        };

        // Extend default options
        this.options = extendDefaults({}, defaults, options);

        // Initialize
        this.init();
    }

    /**
     * Insert Modal in DOM
     */
    Modal.prototype.init = function() {
        if (this.modal) {
            return;
        }

        _build.call(this);
        _initializeEvents.call(this);

        document.body.insertBefore(this.modal, document.body.firstChild);

        if (this.options.autoOpen === true) {
            this.open();
        }
    };

    /**
     * Destroy the Modal component
     */
    Modal.prototype.destroy = function() {
        if (this.modal === null) {
            return;
        }

        // Unbind all events
        _unbindEvents.call(this);

        // Remove modal from dom
        this.modal.parentNode.removeChild(this.modal);

        this.modal = null;
    };


    /**
     * Create the Modal component
     */
    Modal.prototype.open = function() {

        if (this.modal.style.removeProperty) {
            this.modal.style.removeProperty('display');
        } else {
            this.modal.style.removeAttribute('display');
        }

        // Prevent double scroll
        document.body.classList.add('ef-enabled');

        // Show modal
        this.modal.classList.add('ef-modal--open');

        // Add onOpen event
        var self = this;

        if (transitionEvent) {
            this.modal.addEventListener(transitionEvent, function handler() {
                if (typeof self.options.onOpen === 'function') {
                    self.options.onOpen.call(self);
                }

                // detach event after transition end (so it doesn't fire multiple onOpen)
                self.modal.removeEventListener(transitionEvent, handler, false);

            }, false);
        } else {
            if (typeof self.options.onOpen === 'function') {
                self.options.onOpen.call(self);
            }
        }

        // Check if modal is bigger than screen height
        this.checkOverflow();
    };

    /**
     * Return true if the Modal component is Open
     *
     * @returns {boolean}
     */
    Modal.prototype.isOpen = function() {
        return !!this.modal.classList.contains("ef-modal--open");
    };

    Modal.prototype.close = function() {

        //  Before close
        if (typeof this.options.beforeClose === "function") {
            var close = this.options.beforeClose.call(this);
            if (!close) return;
        }

        document.body.classList.remove('ef-enabled');

        this.modal.classList.remove('ef-modal--open');

        // TODO Refactorizar
        //Using similar setup as onOpen
        //Reference to the Modal that's created
        var self = this;

        if (transitionEvent) {
            //Track when transition is happening then run onClose on complete
            this.modal.addEventListener(transitionEvent, function handler() {
                // detach event after transition end (so it doesn't fire multiple onClose)
                self.modal.removeEventListener(transitionEvent, handler, false);

                // self.modal.style.display = 'none';

                // on close callback
                if (typeof self.options.onClose === "function") {
                    self.options.onClose.call(this);
                }

            }, false);
        } else {
            // self.modal.style.display = 'none';
            // on close callback
            if (typeof self.options.onClose === "function") {
                self.options.onClose.call(this);
            }
        }
    };

    /**
     * Set Modal Content
     *
     * @param content
     */
    Modal.prototype.setContent = function(content) {
        // check type of content : String or Node
        if (typeof content === 'string') {
            this.modalBoxContent.innerHTML = content;
        } else {
            this.modalBoxContent.innerHTML = "";
            this.modalBoxContent.appendChild(content);
        }
    };

    /**
     * Get Modal Content
     *
     * @returns {Element|*}
     */
    Modal.prototype.getContent = function() {
        return this.modalBoxContent;
    };

    /**
     * Check if the Modal Overflows the Window
     *
     * @returns {boolean}
     */
    Modal.prototype.isOverflow = function() {
        var viewportHeight = window.innerHeight;
        var modalHeight = this.modalBox.clientHeight;

        return modalHeight >= viewportHeight;
    };

    /**
     * Add CSS class if the Modal Overflows the Window
     */
    Modal.prototype.checkOverflow = function() {
        if (this.modal.classList.contains('ef-modal--open')) {
            if (this.isOverflow()) {
                this.modal.classList.add('ef-modal--overflow');
            } else {
                this.modal.classList.remove('ef-modal--overflow');
            }
        }
    };

    /**
     * Paint the Modal
     *
     * @private
     */
    function _build() {

        // wrapper
        this.modal = document.createElement('div');
        this.modal.classList.add('ef-modal');

        // remove cusor if no overlay close method
        if (this.options.closeMethods.length === 0 || this.options.closeMethods.indexOf('overlay') === -1) {
            this.modal.classList.add('ef-modal--noOverlayClose');
        }

        // this.modal.style.display = 'none';

        // custom class
        this.options.cssClass.forEach(function(item) {
            if (typeof item === 'string') {
                this.modal.classList.add(item);
            }
        }, this);

        // close btn
        if (this.options.closeMethods.indexOf('button') !== -1) {
            this.modalCloseBtn = document.createElement('button');
            this.modalCloseBtn.classList.add('ef-modal__close');

            this.modalCloseBtnIcon = document.createElement('span');
            this.modalCloseBtnIcon.classList.add('ef-modal__closeIcon');
            this.modalCloseBtnIcon.innerHTML = '×';

            this.modalCloseBtnLabel = document.createElement('span');
            this.modalCloseBtnLabel.classList.add('ef-modal__closeLabel');
            this.modalCloseBtnLabel.innerHTML = this.options.closeLabel;

            this.modalCloseBtn.appendChild(this.modalCloseBtnIcon);
            this.modalCloseBtn.appendChild(this.modalCloseBtnLabel);
        }

        // modal
        this.modalBox = document.createElement('div');
        this.modalBox.classList.add('ef-modal-box');

        // modal box content
        this.modalBoxContent = document.createElement('div');
        this.modalBoxContent.classList.add('ef-modal-box__content');

        this.modalBox.appendChild(this.modalBoxContent);

        if (this.options.closeMethods.indexOf('button') !== -1) {
            this.modal.appendChild(this.modalCloseBtn);
        }

        this.modal.appendChild(this.modalBox);

    }

    /**
     * Initialize Events
     *
     * @private
     */
    function _initializeEvents() {

        this._events = {
            clickCloseBtn: this.close.bind(this),
            clickOverlay: _handleClickOutside.bind(this),
            resize: this.checkOverflow.bind(this),
            keyboardNav: _handleKeyboardNav.bind(this)
        };

        if (this.options.closeMethods.indexOf('button') !== -1) {
            this.modalCloseBtn.addEventListener('click', this._events.clickCloseBtn);
        }

        this.modal.addEventListener('mousedown', this._events.clickOverlay);
        window.addEventListener('resize', this._events.resize);
        document.addEventListener("keydown", this._events.keyboardNav);
    }

    /**
     * Handle Keyboard Navigation
     *
     * @param event
     * @private
     */
    function _handleKeyboardNav(event) {
        if (this.options.closeMethods.indexOf('escape') !== -1 && event.which === 27 && this.isOpen()) {
            this.close();
        }
    }

    /**
     * Handle Clicks outside the Modal
     * @param event
     * @private
     */
    function _handleClickOutside(event) {
        if (this.options.closeMethods.indexOf('overlay') !== -1 && !_findAncestor(event.target, 'ef-modal') &&
            event.clientX < this.modal.clientWidth) {
            this.close();
        }
    }

    /**
     * Find Modal's Parent Element
     *
     * @param el
     * @param cls
     * @returns {*}
     * @private
     */
    function _findAncestor(el, cls) {
        while ((el = el.parentElement) && !el.classList.contains(cls)) {}
        return el;
    }

    /**
     * Unbind Events
     *
     * @private
     */
    function _unbindEvents() {
        if (this.options.closeMethods.indexOf('button') !== -1) {
            this.modalCloseBtn.removeEventListener('click', this._events.clickCloseBtn);
        }
        this.modal.removeEventListener('mousedown', this._events.clickOverlay);
        window.removeEventListener('resize', this._events.resize);
        document.removeEventListener("keydown", this._events.keyboardNav);
    }

    /**
     * Extend Default Options
     *
     * @returns {*}
     */
    function extendDefaults() {
        for (var i = 1; i < arguments.length; i++) {
            for (var key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key)) {
                    arguments[0][key] = arguments[i][key];
                }
            }
        }
        return arguments[0];
    }

    /**
     * Set Transition
     *
     * @returns {*}
     */
    function whichTransitionEvent() {
        var t;
        var el = document.createElement('ef-transition');
        var transitions = {
            'transition': 'transitionend',
            'OTransition': 'oTransitionEnd',
            'MozTransition': 'transitionend',
            'WebkitTransition': 'webkitTransitionEnd'
        };

        for (t in transitions) {
            if (el.style[t] !== undefined) {
                return transitions[t];
            }
        }
    }

    return {
        Modal: Modal
    };
});