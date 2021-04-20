/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/scripts.js":
/*!****************************************!*\
  !*** ./resources/assets/js/scripts.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*!
 * fancyBox - jQuery Plugin
 * version: 2.1.5 (Fri, 14 Jun 2013)
 * @requires jQuery v1.6 or later
 *
 * Examples at http://fancyapps.com/fancybox/
 * License: www.fancyapps.com/fancybox/#license
 *
 * Copyright 2012 Janis Skarnelis - janis@fancyapps.com
 *
 */
(function (window, document, $, undefined) {
  "use strict";

  var H = $("html"),
      W = $(window),
      D = $(document),
      F = $.fancybox = function () {
    F.open.apply(this, arguments);
  },
      IE = navigator.userAgent.match(/msie/i),
      didUpdate = null,
      isTouch = document.createTouch !== undefined,
      isQuery = function isQuery(obj) {
    return obj && obj.hasOwnProperty && obj instanceof $;
  },
      isString = function isString(str) {
    return str && $.type(str) === "string";
  },
      isPercentage = function isPercentage(str) {
    return isString(str) && str.indexOf('%') > 0;
  },
      isScrollable = function isScrollable(el) {
    return el && !(el.style.overflow && el.style.overflow === 'hidden') && (el.clientWidth && el.scrollWidth > el.clientWidth || el.clientHeight && el.scrollHeight > el.clientHeight);
  },
      getScalar = function getScalar(orig, dim) {
    var value = parseInt(orig, 10) || 0;

    if (dim && isPercentage(orig)) {
      value = F.getViewport()[dim] / 100 * value;
    }

    return Math.ceil(value);
  },
      getValue = function getValue(value, dim) {
    return getScalar(value, dim) + 'px';
  };

  $.extend(F, {
    // The current version of fancyBox
    version: '2.1.5',
    defaults: {
      padding: 15,
      margin: 20,
      width: 800,
      height: 600,
      minWidth: 100,
      minHeight: 100,
      maxWidth: 9999,
      maxHeight: 9999,
      pixelRatio: 1,
      // Set to 2 for retina display support
      autoSize: true,
      autoHeight: false,
      autoWidth: false,
      autoResize: true,
      autoCenter: !isTouch,
      fitToView: true,
      aspectRatio: false,
      topRatio: 0.5,
      leftRatio: 0.5,
      scrolling: 'auto',
      // 'auto', 'yes' or 'no'
      wrapCSS: '',
      arrows: true,
      closeBtn: true,
      closeClick: false,
      nextClick: false,
      mouseWheel: true,
      autoPlay: false,
      playSpeed: 3000,
      preload: 3,
      modal: false,
      loop: true,
      ajax: {
        dataType: 'html',
        headers: {
          'X-fancyBox': true
        }
      },
      iframe: {
        scrolling: 'auto',
        preload: true
      },
      swf: {
        wmode: 'transparent',
        allowfullscreen: 'true',
        allowscriptaccess: 'always'
      },
      keys: {
        next: {
          13: 'left',
          // enter
          34: 'up',
          // page down
          39: 'left',
          // right arrow
          40: 'up' // down arrow

        },
        prev: {
          8: 'right',
          // backspace
          33: 'down',
          // page up
          37: 'right',
          // left arrow
          38: 'down' // up arrow

        },
        close: [27],
        // escape key
        play: [32],
        // space - start/stop slideshow
        toggle: [70] // letter "f" - toggle fullscreen

      },
      direction: {
        next: 'left',
        prev: 'right'
      },
      scrollOutside: true,
      // Override some properties
      index: 0,
      type: null,
      href: null,
      content: null,
      title: null,
      // HTML templates
      tpl: {
        wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
        image: '<img class="fancybox-image" src="{href}" alt="" />',
        iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + (IE ? ' allowtransparency="true"' : '') + '></iframe>',
        error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
        closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
        next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
        prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
      },
      // Properties for each animation type
      // Opening fancyBox
      openEffect: 'fade',
      // 'elastic', 'fade' or 'none'
      openSpeed: 250,
      openEasing: 'swing',
      openOpacity: true,
      openMethod: 'zoomIn',
      // Closing fancyBox
      closeEffect: 'fade',
      // 'elastic', 'fade' or 'none'
      closeSpeed: 250,
      closeEasing: 'swing',
      closeOpacity: true,
      closeMethod: 'zoomOut',
      // Changing next gallery item
      nextEffect: 'elastic',
      // 'elastic', 'fade' or 'none'
      nextSpeed: 250,
      nextEasing: 'swing',
      nextMethod: 'changeIn',
      // Changing previous gallery item
      prevEffect: 'elastic',
      // 'elastic', 'fade' or 'none'
      prevSpeed: 250,
      prevEasing: 'swing',
      prevMethod: 'changeOut',
      // Enable default helpers
      helpers: {
        overlay: true,
        title: true
      },
      // Callbacks
      onCancel: $.noop,
      // If canceling
      beforeLoad: $.noop,
      // Before loading
      afterLoad: $.noop,
      // After loading
      beforeShow: $.noop,
      // Before changing in current item
      afterShow: $.noop,
      // After opening
      beforeChange: $.noop,
      // Before changing gallery item
      beforeClose: $.noop,
      // Before closing
      afterClose: $.noop // After closing

    },
    //Current state
    group: {},
    // Selected group
    opts: {},
    // Group options
    previous: null,
    // Previous element
    coming: null,
    // Element being loaded
    current: null,
    // Currently loaded element
    isActive: false,
    // Is activated
    isOpen: false,
    // Is currently open
    isOpened: false,
    // Have been fully opened at least once
    wrap: null,
    skin: null,
    outer: null,
    inner: null,
    player: {
      timer: null,
      isActive: false
    },
    // Loaders
    ajaxLoad: null,
    imgPreload: null,
    // Some collections
    transitions: {},
    helpers: {},

    /*
     *	Static methods
     */
    open: function open(group, opts) {
      if (!group) {
        return;
      }

      if (!$.isPlainObject(opts)) {
        opts = {};
      } // Close if already active


      if (false === F.close(true)) {
        return;
      } // Normalize group


      if (!$.isArray(group)) {
        group = isQuery(group) ? $(group).get() : [group];
      } // Recheck if the type of each element is `object` and set content type (image, ajax, etc)


      $.each(group, function (i, element) {
        var obj = {},
            href,
            title,
            content,
            type,
            rez,
            hrefParts,
            selector;

        if ($.type(element) === "object") {
          // Check if is DOM element
          if (element.nodeType) {
            element = $(element);
          }

          if (isQuery(element)) {
            obj = {
              href: element.data('fancybox-href') || element.attr('href'),
              title: element.data('fancybox-title') || element.attr('title'),
              isDom: true,
              element: element
            };

            if ($.metadata) {
              $.extend(true, obj, element.metadata());
            }
          } else {
            obj = element;
          }
        }

        href = opts.href || obj.href || (isString(element) ? element : null);
        title = opts.title !== undefined ? opts.title : obj.title || '';
        content = opts.content || obj.content;
        type = content ? 'html' : opts.type || obj.type;

        if (!type && obj.isDom) {
          type = element.data('fancybox-type');

          if (!type) {
            rez = element.prop('class').match(/fancybox\.(\w+)/);
            type = rez ? rez[1] : null;
          }
        }

        if (isString(href)) {
          // Try to guess the content type
          if (!type) {
            if (F.isImage(href)) {
              type = 'image';
            } else if (F.isSWF(href)) {
              type = 'swf';
            } else if (href.charAt(0) === '#') {
              type = 'inline';
            } else if (isString(element)) {
              type = 'html';
              content = element;
            }
          } // Split url into two pieces with source url and content selector, e.g,
          // "/mypage.html #my_id" will load "/mypage.html" and display element having id "my_id"


          if (type === 'ajax') {
            hrefParts = href.split(/\s+/, 2);
            href = hrefParts.shift();
            selector = hrefParts.shift();
          }
        }

        if (!content) {
          if (type === 'inline') {
            if (href) {
              content = $(isString(href) ? href.replace(/.*(?=#[^\s]+$)/, '') : href); //strip for ie7
            } else if (obj.isDom) {
              content = element;
            }
          } else if (type === 'html') {
            content = href;
          } else if (!type && !href && obj.isDom) {
            type = 'inline';
            content = element;
          }
        }

        $.extend(obj, {
          href: href,
          type: type,
          content: content,
          title: title,
          selector: selector
        });
        group[i] = obj;
      }); // Extend the defaults

      F.opts = $.extend(true, {}, F.defaults, opts); // All options are merged recursive except keys

      if (opts.keys !== undefined) {
        F.opts.keys = opts.keys ? $.extend({}, F.defaults.keys, opts.keys) : false;
      }

      F.group = group;
      return F._start(F.opts.index);
    },
    // Cancel image loading or abort ajax request
    cancel: function cancel() {
      var coming = F.coming;

      if (!coming || false === F.trigger('onCancel')) {
        return;
      }

      F.hideLoading();

      if (F.ajaxLoad) {
        F.ajaxLoad.abort();
      }

      F.ajaxLoad = null;

      if (F.imgPreload) {
        F.imgPreload.onload = F.imgPreload.onerror = null;
      }

      if (coming.wrap) {
        coming.wrap.stop(true, true).trigger('onReset').remove();
      }

      F.coming = null; // If the first item has been canceled, then clear everything

      if (!F.current) {
        F._afterZoomOut(coming);
      }
    },
    // Start closing animation if is open; remove immediately if opening/closing
    close: function close(event) {
      F.cancel();

      if (false === F.trigger('beforeClose')) {
        return;
      }

      F.unbindEvents();

      if (!F.isActive) {
        return;
      }

      if (!F.isOpen || event === true) {
        $('.fancybox-wrap').stop(true).trigger('onReset').remove();

        F._afterZoomOut();
      } else {
        F.isOpen = F.isOpened = false;
        F.isClosing = true;
        $('.fancybox-item, .fancybox-nav').remove();
        F.wrap.stop(true, true).removeClass('fancybox-opened');
        F.transitions[F.current.closeMethod]();
      }
    },
    // Manage slideshow:
    //   $.fancybox.play(); - toggle slideshow
    //   $.fancybox.play( true ); - start
    //   $.fancybox.play( false ); - stop
    play: function play(action) {
      var clear = function clear() {
        clearTimeout(F.player.timer);
      },
          set = function set() {
        clear();

        if (F.current && F.player.isActive) {
          F.player.timer = setTimeout(F.next, F.current.playSpeed);
        }
      },
          stop = function stop() {
        clear();
        D.unbind('.player');
        F.player.isActive = false;
        F.trigger('onPlayEnd');
      },
          start = function start() {
        if (F.current && (F.current.loop || F.current.index < F.group.length - 1)) {
          F.player.isActive = true;
          D.bind({
            'onCancel.player beforeClose.player': stop,
            'onUpdate.player': set,
            'beforeLoad.player': clear
          });
          set();
          F.trigger('onPlayStart');
        }
      };

      if (action === true || !F.player.isActive && action !== false) {
        start();
      } else {
        stop();
      }
    },
    // Navigate to next gallery item
    next: function next(direction) {
      var current = F.current;

      if (current) {
        if (!isString(direction)) {
          direction = current.direction.next;
        }

        F.jumpto(current.index + 1, direction, 'next');
      }
    },
    // Navigate to previous gallery item
    prev: function prev(direction) {
      var current = F.current;

      if (current) {
        if (!isString(direction)) {
          direction = current.direction.prev;
        }

        F.jumpto(current.index - 1, direction, 'prev');
      }
    },
    // Navigate to gallery item by index
    jumpto: function jumpto(index, direction, router) {
      var current = F.current;

      if (!current) {
        return;
      }

      index = getScalar(index);
      F.direction = direction || current.direction[index >= current.index ? 'next' : 'prev'];
      F.router = router || 'jumpto';

      if (current.loop) {
        if (index < 0) {
          index = current.group.length + index % current.group.length;
        }

        index = index % current.group.length;
      }

      if (current.group[index] !== undefined) {
        F.cancel();

        F._start(index);
      }
    },
    // Center inside viewport and toggle position type to fixed or absolute if needed
    reposition: function reposition(e, onlyAbsolute) {
      var current = F.current,
          wrap = current ? current.wrap : null,
          pos;

      if (wrap) {
        pos = F._getPosition(onlyAbsolute);

        if (e && e.type === 'scroll') {
          delete pos.position;
          wrap.stop(true, true).animate(pos, 200);
        } else {
          wrap.css(pos);
          current.pos = $.extend({}, current.dim, pos);
        }
      }
    },
    update: function update(e) {
      var type = e && e.type,
          anyway = !type || type === 'orientationchange';

      if (anyway) {
        clearTimeout(didUpdate);
        didUpdate = null;
      }

      if (!F.isOpen || didUpdate) {
        return;
      }

      didUpdate = setTimeout(function () {
        var current = F.current;

        if (!current || F.isClosing) {
          return;
        }

        F.wrap.removeClass('fancybox-tmp');

        if (anyway || type === 'load' || type === 'resize' && current.autoResize) {
          F._setDimension();
        }

        if (!(type === 'scroll' && current.canShrink)) {
          F.reposition(e);
        }

        F.trigger('onUpdate');
        didUpdate = null;
      }, anyway && !isTouch ? 0 : 300);
    },
    // Shrink content to fit inside viewport or restore if resized
    toggle: function toggle(action) {
      if (F.isOpen) {
        F.current.fitToView = $.type(action) === "boolean" ? action : !F.current.fitToView; // Help browser to restore document dimensions

        if (isTouch) {
          F.wrap.removeAttr('style').addClass('fancybox-tmp');
          F.trigger('onUpdate');
        }

        F.update();
      }
    },
    hideLoading: function hideLoading() {
      D.unbind('.loading');
      $('#fancybox-loading').remove();
    },
    showLoading: function showLoading() {
      var el, viewport;
      F.hideLoading();
      el = $('<div id="fancybox-loading"><div></div></div>').click(F.cancel).appendTo('body'); // If user will press the escape-button, the request will be canceled

      D.bind('keydown.loading', function (e) {
        if ((e.which || e.keyCode) === 27) {
          e.preventDefault();
          F.cancel();
        }
      });

      if (!F.defaults.fixed) {
        viewport = F.getViewport();
        el.css({
          position: 'absolute',
          top: viewport.h * 0.5 + viewport.y,
          left: viewport.w * 0.5 + viewport.x
        });
      }
    },
    getViewport: function getViewport() {
      var locked = F.current && F.current.locked || false,
          rez = {
        x: W.scrollLeft(),
        y: W.scrollTop()
      };

      if (locked) {
        rez.w = locked[0].clientWidth;
        rez.h = locked[0].clientHeight;
      } else {
        // See http://bugs.jquery.com/ticket/6724
        rez.w = isTouch && window.innerWidth ? window.innerWidth : W.width();
        rez.h = isTouch && window.innerHeight ? window.innerHeight : W.height();
      }

      return rez;
    },
    // Unbind the keyboard / clicking actions
    unbindEvents: function unbindEvents() {
      if (F.wrap && isQuery(F.wrap)) {
        F.wrap.unbind('.fb');
      }

      D.unbind('.fb');
      W.unbind('.fb');
    },
    bindEvents: function bindEvents() {
      var current = F.current,
          keys;

      if (!current) {
        return;
      } // Changing document height on iOS devices triggers a 'resize' event,
      // that can change document height... repeating infinitely


      W.bind('orientationchange.fb' + (isTouch ? '' : ' resize.fb') + (current.autoCenter && !current.locked ? ' scroll.fb' : ''), F.update);
      keys = current.keys;

      if (keys) {
        D.bind('keydown.fb', function (e) {
          var code = e.which || e.keyCode,
              target = e.target || e.srcElement; // Skip esc key if loading, because showLoading will cancel preloading

          if (code === 27 && F.coming) {
            return false;
          } // Ignore key combinations and key events within form elements


          if (!e.ctrlKey && !e.altKey && !e.shiftKey && !e.metaKey && !(target && (target.type || $(target).is('[contenteditable]')))) {
            $.each(keys, function (i, val) {
              if (current.group.length > 1 && val[code] !== undefined) {
                F[i](val[code]);
                e.preventDefault();
                return false;
              }

              if ($.inArray(code, val) > -1) {
                F[i]();
                e.preventDefault();
                return false;
              }
            });
          }
        });
      }

      if ($.fn.mousewheel && current.mouseWheel) {
        F.wrap.bind('mousewheel.fb', function (e, delta, deltaX, deltaY) {
          var target = e.target || null,
              parent = $(target),
              canScroll = false;

          while (parent.length) {
            if (canScroll || parent.is('.fancybox-skin') || parent.is('.fancybox-wrap')) {
              break;
            }

            canScroll = isScrollable(parent[0]);
            parent = $(parent).parent();
          }

          if (delta !== 0 && !canScroll) {
            if (F.group.length > 1 && !current.canShrink) {
              if (deltaY > 0 || deltaX > 0) {
                F.prev(deltaY > 0 ? 'down' : 'left');
              } else if (deltaY < 0 || deltaX < 0) {
                F.next(deltaY < 0 ? 'up' : 'right');
              }

              e.preventDefault();
            }
          }
        });
      }
    },
    trigger: function trigger(event, o) {
      var ret,
          obj = o || F.coming || F.current;

      if (!obj) {
        return;
      }

      if ($.isFunction(obj[event])) {
        ret = obj[event].apply(obj, Array.prototype.slice.call(arguments, 1));
      }

      if (ret === false) {
        return false;
      }

      if (obj.helpers) {
        $.each(obj.helpers, function (helper, opts) {
          if (opts && F.helpers[helper] && $.isFunction(F.helpers[helper][event])) {
            F.helpers[helper][event]($.extend(true, {}, F.helpers[helper].defaults, opts), obj);
          }
        });
      }

      D.trigger(event);
    },
    isImage: function isImage(str) {
      return isString(str) && str.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i);
    },
    isSWF: function isSWF(str) {
      return isString(str) && str.match(/\.(swf)((\?|#).*)?$/i);
    },
    _start: function _start(index) {
      var coming = {},
          obj,
          href,
          type,
          margin,
          padding;
      index = getScalar(index);
      obj = F.group[index] || null;

      if (!obj) {
        return false;
      }

      coming = $.extend(true, {}, F.opts, obj); // Convert margin and padding properties to array - top, right, bottom, left

      margin = coming.margin;
      padding = coming.padding;

      if ($.type(margin) === 'number') {
        coming.margin = [margin, margin, margin, margin];
      }

      if ($.type(padding) === 'number') {
        coming.padding = [padding, padding, padding, padding];
      } // 'modal' propery is just a shortcut


      if (coming.modal) {
        $.extend(true, coming, {
          closeBtn: false,
          closeClick: false,
          nextClick: false,
          arrows: false,
          mouseWheel: false,
          keys: null,
          helpers: {
            overlay: {
              closeClick: false
            }
          }
        });
      } // 'autoSize' property is a shortcut, too


      if (coming.autoSize) {
        coming.autoWidth = coming.autoHeight = true;
      }

      if (coming.width === 'auto') {
        coming.autoWidth = true;
      }

      if (coming.height === 'auto') {
        coming.autoHeight = true;
      }
      /*
       * Add reference to the group, so it`s possible to access from callbacks, example:
       * afterLoad : function() {
       *     this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
       * }
       */


      coming.group = F.group;
      coming.index = index; // Give a chance for callback or helpers to update coming item (type, title, etc)

      F.coming = coming;

      if (false === F.trigger('beforeLoad')) {
        F.coming = null;
        return;
      }

      type = coming.type;
      href = coming.href;

      if (!type) {
        F.coming = null; //If we can not determine content type then drop silently or display next/prev item if looping through gallery

        if (F.current && F.router && F.router !== 'jumpto') {
          F.current.index = index;
          return F[F.router](F.direction);
        }

        return false;
      }

      F.isActive = true;

      if (type === 'image' || type === 'swf') {
        coming.autoHeight = coming.autoWidth = false;
        coming.scrolling = 'visible';
      }

      if (type === 'image') {
        coming.aspectRatio = true;
      }

      if (type === 'iframe' && isTouch) {
        coming.scrolling = 'scroll';
      } // Build the neccessary markup


      coming.wrap = $(coming.tpl.wrap).addClass('fancybox-' + (isTouch ? 'mobile' : 'desktop') + ' fancybox-type-' + type + ' fancybox-tmp ' + coming.wrapCSS).appendTo(coming.parent || 'body');
      $.extend(coming, {
        skin: $('.fancybox-skin', coming.wrap),
        outer: $('.fancybox-outer', coming.wrap),
        inner: $('.fancybox-inner', coming.wrap)
      });
      $.each(["Top", "Right", "Bottom", "Left"], function (i, v) {
        coming.skin.css('padding' + v, getValue(coming.padding[i]));
      });
      F.trigger('onReady'); // Check before try to load; 'inline' and 'html' types need content, others - href

      if (type === 'inline' || type === 'html') {
        if (!coming.content || !coming.content.length) {
          return F._error('content');
        }
      } else if (!href) {
        return F._error('href');
      }

      if (type === 'image') {
        F._loadImage();
      } else if (type === 'ajax') {
        F._loadAjax();
      } else if (type === 'iframe') {
        F._loadIframe();
      } else {
        F._afterLoad();
      }
    },
    _error: function _error(type) {
      $.extend(F.coming, {
        type: 'html',
        autoWidth: true,
        autoHeight: true,
        minWidth: 0,
        minHeight: 0,
        scrolling: 'no',
        hasError: type,
        content: F.coming.tpl.error
      });

      F._afterLoad();
    },
    _loadImage: function _loadImage() {
      // Reset preload image so it is later possible to check "complete" property
      var img = F.imgPreload = new Image();

      img.onload = function () {
        this.onload = this.onerror = null;
        F.coming.width = this.width / F.opts.pixelRatio;
        F.coming.height = this.height / F.opts.pixelRatio;

        F._afterLoad();
      };

      img.onerror = function () {
        this.onload = this.onerror = null;

        F._error('image');
      };

      img.src = F.coming.href;

      if (img.complete !== true) {
        F.showLoading();
      }
    },
    _loadAjax: function _loadAjax() {
      var coming = F.coming;
      F.showLoading();
      F.ajaxLoad = $.ajax($.extend({}, coming.ajax, {
        url: coming.href,
        error: function error(jqXHR, textStatus) {
          if (F.coming && textStatus !== 'abort') {
            F._error('ajax', jqXHR);
          } else {
            F.hideLoading();
          }
        },
        success: function success(data, textStatus) {
          if (textStatus === 'success') {
            coming.content = data;

            F._afterLoad();
          }
        }
      }));
    },
    _loadIframe: function _loadIframe() {
      var coming = F.coming,
          iframe = $(coming.tpl.iframe.replace(/\{rnd\}/g, new Date().getTime())).attr('scrolling', isTouch ? 'auto' : coming.iframe.scrolling).attr('src', coming.href); // This helps IE

      $(coming.wrap).bind('onReset', function () {
        try {
          $(this).find('iframe').hide().attr('src', '//about:blank').end().empty();
        } catch (e) {}
      });

      if (coming.iframe.preload) {
        F.showLoading();
        iframe.one('load', function () {
          $(this).data('ready', 1); // iOS will lose scrolling if we resize

          if (!isTouch) {
            $(this).bind('load.fb', F.update);
          } // Without this trick:
          //   - iframe won't scroll on iOS devices
          //   - IE7 sometimes displays empty iframe


          $(this).parents('.fancybox-wrap').width('100%').removeClass('fancybox-tmp').show();

          F._afterLoad();
        });
      }

      coming.content = iframe.appendTo(coming.inner);

      if (!coming.iframe.preload) {
        F._afterLoad();
      }
    },
    _preloadImages: function _preloadImages() {
      var group = F.group,
          current = F.current,
          len = group.length,
          cnt = current.preload ? Math.min(current.preload, len - 1) : 0,
          item,
          i;

      for (i = 1; i <= cnt; i += 1) {
        item = group[(current.index + i) % len];

        if (item.type === 'image' && item.href) {
          new Image().src = item.href;
        }
      }
    },
    _afterLoad: function _afterLoad() {
      var coming = F.coming,
          previous = F.current,
          placeholder = 'fancybox-placeholder',
          current,
          content,
          type,
          scrolling,
          href,
          embed;
      F.hideLoading();

      if (!coming || F.isActive === false) {
        return;
      }

      if (false === F.trigger('afterLoad', coming, previous)) {
        coming.wrap.stop(true).trigger('onReset').remove();
        F.coming = null;
        return;
      }

      if (previous) {
        F.trigger('beforeChange', previous);
        previous.wrap.stop(true).removeClass('fancybox-opened').find('.fancybox-item, .fancybox-nav').remove();
      }

      F.unbindEvents();
      current = coming;
      content = coming.content;
      type = coming.type;
      scrolling = coming.scrolling;
      $.extend(F, {
        wrap: current.wrap,
        skin: current.skin,
        outer: current.outer,
        inner: current.inner,
        current: current,
        previous: previous
      });
      href = current.href;

      switch (type) {
        case 'inline':
        case 'ajax':
        case 'html':
          if (current.selector) {
            content = $('<div>').html(content).find(current.selector);
          } else if (isQuery(content)) {
            if (!content.data(placeholder)) {
              content.data(placeholder, $('<div class="' + placeholder + '"></div>').insertAfter(content).hide());
            }

            content = content.show().detach();
            current.wrap.bind('onReset', function () {
              if ($(this).find(content).length) {
                content.hide().replaceAll(content.data(placeholder)).data(placeholder, false);
              }
            });
          }

          break;

        case 'image':
          content = current.tpl.image.replace('{href}', href);
          break;

        case 'swf':
          content = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + href + '"></param>';
          embed = '';
          $.each(current.swf, function (name, val) {
            content += '<param name="' + name + '" value="' + val + '"></param>';
            embed += ' ' + name + '="' + val + '"';
          });
          content += '<embed src="' + href + '" type="application/x-shockwave-flash" width="100%" height="100%"' + embed + '></embed></object>';
          break;
      }

      if (!(isQuery(content) && content.parent().is(current.inner))) {
        current.inner.append(content);
      } // Give a chance for helpers or callbacks to update elements


      F.trigger('beforeShow'); // Set scrolling before calculating dimensions

      current.inner.css('overflow', scrolling === 'yes' ? 'scroll' : scrolling === 'no' ? 'hidden' : scrolling); // Set initial dimensions and start position

      F._setDimension();

      F.reposition();
      F.isOpen = false;
      F.coming = null;
      F.bindEvents();

      if (!F.isOpened) {
        $('.fancybox-wrap').not(current.wrap).stop(true).trigger('onReset').remove();
      } else if (previous.prevMethod) {
        F.transitions[previous.prevMethod]();
      }

      F.transitions[F.isOpened ? current.nextMethod : current.openMethod]();

      F._preloadImages();
    },
    _setDimension: function _setDimension() {
      var viewport = F.getViewport(),
          steps = 0,
          canShrink = false,
          canExpand = false,
          wrap = F.wrap,
          skin = F.skin,
          inner = F.inner,
          current = F.current,
          width = current.width,
          height = current.height,
          minWidth = current.minWidth,
          minHeight = current.minHeight,
          maxWidth = current.maxWidth,
          maxHeight = current.maxHeight,
          scrolling = current.scrolling,
          scrollOut = current.scrollOutside ? current.scrollbarWidth : 0,
          margin = current.margin,
          wMargin = getScalar(margin[1] + margin[3]),
          hMargin = getScalar(margin[0] + margin[2]),
          wPadding,
          hPadding,
          wSpace,
          hSpace,
          origWidth,
          origHeight,
          origMaxWidth,
          origMaxHeight,
          ratio,
          width_,
          height_,
          maxWidth_,
          maxHeight_,
          iframe,
          body; // Reset dimensions so we could re-check actual size

      wrap.add(skin).add(inner).width('auto').height('auto').removeClass('fancybox-tmp');
      wPadding = getScalar(skin.outerWidth(true) - skin.width());
      hPadding = getScalar(skin.outerHeight(true) - skin.height()); // Any space between content and viewport (margin, padding, border, title)

      wSpace = wMargin + wPadding;
      hSpace = hMargin + hPadding;
      origWidth = isPercentage(width) ? (viewport.w - wSpace) * getScalar(width) / 100 : width;
      origHeight = isPercentage(height) ? (viewport.h - hSpace) * getScalar(height) / 100 : height;

      if (current.type === 'iframe') {
        iframe = current.content;

        if (current.autoHeight && iframe.data('ready') === 1) {
          try {
            if (iframe[0].contentWindow.document.location) {
              inner.width(origWidth).height(9999);
              body = iframe.contents().find('body');

              if (scrollOut) {
                body.css('overflow-x', 'hidden');
              }

              origHeight = body.outerHeight(true);
            }
          } catch (e) {}
        }
      } else if (current.autoWidth || current.autoHeight) {
        inner.addClass('fancybox-tmp'); // Set width or height in case we need to calculate only one dimension

        if (!current.autoWidth) {
          inner.width(origWidth);
        }

        if (!current.autoHeight) {
          inner.height(origHeight);
        }

        if (current.autoWidth) {
          origWidth = inner.width();
        }

        if (current.autoHeight) {
          origHeight = inner.height();
        }

        inner.removeClass('fancybox-tmp');
      }

      width = getScalar(origWidth);
      height = getScalar(origHeight);
      ratio = origWidth / origHeight; // Calculations for the content

      minWidth = getScalar(isPercentage(minWidth) ? getScalar(minWidth, 'w') - wSpace : minWidth);
      maxWidth = getScalar(isPercentage(maxWidth) ? getScalar(maxWidth, 'w') - wSpace : maxWidth);
      minHeight = getScalar(isPercentage(minHeight) ? getScalar(minHeight, 'h') - hSpace : minHeight);
      maxHeight = getScalar(isPercentage(maxHeight) ? getScalar(maxHeight, 'h') - hSpace : maxHeight); // These will be used to determine if wrap can fit in the viewport

      origMaxWidth = maxWidth;
      origMaxHeight = maxHeight;

      if (current.fitToView) {
        maxWidth = Math.min(viewport.w - wSpace, maxWidth);
        maxHeight = Math.min(viewport.h - hSpace, maxHeight);
      }

      maxWidth_ = viewport.w - wMargin;
      maxHeight_ = viewport.h - hMargin;

      if (current.aspectRatio) {
        if (width > maxWidth) {
          width = maxWidth;
          height = getScalar(width / ratio);
        }

        if (height > maxHeight) {
          height = maxHeight;
          width = getScalar(height * ratio);
        }

        if (width < minWidth) {
          width = minWidth;
          height = getScalar(width / ratio);
        }

        if (height < minHeight) {
          height = minHeight;
          width = getScalar(height * ratio);
        }
      } else {
        width = Math.max(minWidth, Math.min(width, maxWidth));

        if (current.autoHeight && current.type !== 'iframe') {
          inner.width(width);
          height = inner.height();
        }

        height = Math.max(minHeight, Math.min(height, maxHeight));
      } // Try to fit inside viewport (including the title)


      if (current.fitToView) {
        inner.width(width).height(height);
        wrap.width(width + wPadding); // Real wrap dimensions

        width_ = wrap.width();
        height_ = wrap.height();

        if (current.aspectRatio) {
          while ((width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight) {
            if (steps++ > 19) {
              break;
            }

            height = Math.max(minHeight, Math.min(maxHeight, height - 10));
            width = getScalar(height * ratio);

            if (width < minWidth) {
              width = minWidth;
              height = getScalar(width / ratio);
            }

            if (width > maxWidth) {
              width = maxWidth;
              height = getScalar(width / ratio);
            }

            inner.width(width).height(height);
            wrap.width(width + wPadding);
            width_ = wrap.width();
            height_ = wrap.height();
          }
        } else {
          width = Math.max(minWidth, Math.min(width, width - (width_ - maxWidth_)));
          height = Math.max(minHeight, Math.min(height, height - (height_ - maxHeight_)));
        }
      }

      if (scrollOut && scrolling === 'auto' && height < origHeight && width + wPadding + scrollOut < maxWidth_) {
        width += scrollOut;
      }

      inner.width(width).height(height);
      wrap.width(width + wPadding);
      width_ = wrap.width();
      height_ = wrap.height();
      canShrink = (width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight;
      canExpand = current.aspectRatio ? width < origMaxWidth && height < origMaxHeight && width < origWidth && height < origHeight : (width < origMaxWidth || height < origMaxHeight) && (width < origWidth || height < origHeight);
      $.extend(current, {
        dim: {
          width: getValue(width_),
          height: getValue(height_)
        },
        origWidth: origWidth,
        origHeight: origHeight,
        canShrink: canShrink,
        canExpand: canExpand,
        wPadding: wPadding,
        hPadding: hPadding,
        wrapSpace: height_ - skin.outerHeight(true),
        skinSpace: skin.height() - height
      });

      if (!iframe && current.autoHeight && height > minHeight && height < maxHeight && !canExpand) {
        inner.height('auto');
      }
    },
    _getPosition: function _getPosition(onlyAbsolute) {
      var current = F.current,
          viewport = F.getViewport(),
          margin = current.margin,
          width = F.wrap.width() + margin[1] + margin[3],
          height = F.wrap.height() + margin[0] + margin[2],
          rez = {
        position: 'absolute',
        top: margin[0],
        left: margin[3]
      };

      if (current.autoCenter && current.fixed && !onlyAbsolute && height <= viewport.h && width <= viewport.w) {
        rez.position = 'fixed';
      } else if (!current.locked) {
        rez.top += viewport.y;
        rez.left += viewport.x;
      }

      rez.top = getValue(Math.max(rez.top, rez.top + (viewport.h - height) * current.topRatio));
      rez.left = getValue(Math.max(rez.left, rez.left + (viewport.w - width) * current.leftRatio));
      return rez;
    },
    _afterZoomIn: function _afterZoomIn() {
      var current = F.current;

      if (!current) {
        return;
      }

      F.isOpen = F.isOpened = true;
      F.wrap.css('overflow', 'visible').addClass('fancybox-opened');
      F.update(); // Assign a click event

      if (current.closeClick || current.nextClick && F.group.length > 1) {
        F.inner.css('cursor', 'pointer').bind('click.fb', function (e) {
          if (!$(e.target).is('a') && !$(e.target).parent().is('a')) {
            e.preventDefault();
            F[current.closeClick ? 'close' : 'next']();
          }
        });
      } // Create a close button


      if (current.closeBtn) {
        $(current.tpl.closeBtn).appendTo(F.skin).bind('click.fb', function (e) {
          e.preventDefault();
          F.close();
        });
      } // Create navigation arrows


      if (current.arrows && F.group.length > 1) {
        if (current.loop || current.index > 0) {
          $(current.tpl.prev).appendTo(F.outer).bind('click.fb', F.prev);
        }

        if (current.loop || current.index < F.group.length - 1) {
          $(current.tpl.next).appendTo(F.outer).bind('click.fb', F.next);
        }
      }

      F.trigger('afterShow'); // Stop the slideshow if this is the last item

      if (!current.loop && current.index === current.group.length - 1) {
        F.play(false);
      } else if (F.opts.autoPlay && !F.player.isActive) {
        F.opts.autoPlay = false;
        F.play();
      }
    },
    _afterZoomOut: function _afterZoomOut(obj) {
      obj = obj || F.current;
      $('.fancybox-wrap').trigger('onReset').remove();
      $.extend(F, {
        group: {},
        opts: {},
        router: false,
        current: null,
        isActive: false,
        isOpened: false,
        isOpen: false,
        isClosing: false,
        wrap: null,
        skin: null,
        outer: null,
        inner: null
      });
      F.trigger('afterClose', obj);
    }
  });
  /*
   *	Default transitions
   */

  F.transitions = {
    getOrigPosition: function getOrigPosition() {
      var current = F.current,
          element = current.element,
          orig = current.orig,
          pos = {},
          width = 50,
          height = 50,
          hPadding = current.hPadding,
          wPadding = current.wPadding,
          viewport = F.getViewport();

      if (!orig && current.isDom && element.is(':visible')) {
        orig = element.find('img:first');

        if (!orig.length) {
          orig = element;
        }
      }

      if (isQuery(orig)) {
        pos = orig.offset();

        if (orig.is('img')) {
          width = orig.outerWidth();
          height = orig.outerHeight();
        }
      } else {
        pos.top = viewport.y + (viewport.h - height) * current.topRatio;
        pos.left = viewport.x + (viewport.w - width) * current.leftRatio;
      }

      if (F.wrap.css('position') === 'fixed' || current.locked) {
        pos.top -= viewport.y;
        pos.left -= viewport.x;
      }

      pos = {
        top: getValue(pos.top - hPadding * current.topRatio),
        left: getValue(pos.left - wPadding * current.leftRatio),
        width: getValue(width + wPadding),
        height: getValue(height + hPadding)
      };
      return pos;
    },
    step: function step(now, fx) {
      var ratio,
          padding,
          value,
          prop = fx.prop,
          current = F.current,
          wrapSpace = current.wrapSpace,
          skinSpace = current.skinSpace;

      if (prop === 'width' || prop === 'height') {
        ratio = fx.end === fx.start ? 1 : (now - fx.start) / (fx.end - fx.start);

        if (F.isClosing) {
          ratio = 1 - ratio;
        }

        padding = prop === 'width' ? current.wPadding : current.hPadding;
        value = now - padding;
        F.skin[prop](getScalar(prop === 'width' ? value : value - wrapSpace * ratio));
        F.inner[prop](getScalar(prop === 'width' ? value : value - wrapSpace * ratio - skinSpace * ratio));
      }
    },
    zoomIn: function zoomIn() {
      var current = F.current,
          startPos = current.pos,
          effect = current.openEffect,
          elastic = effect === 'elastic',
          endPos = $.extend({
        opacity: 1
      }, startPos); // Remove "position" property that breaks older IE

      delete endPos.position;

      if (elastic) {
        startPos = this.getOrigPosition();

        if (current.openOpacity) {
          startPos.opacity = 0.1;
        }
      } else if (effect === 'fade') {
        startPos.opacity = 0.1;
      }

      F.wrap.css(startPos).animate(endPos, {
        duration: effect === 'none' ? 0 : current.openSpeed,
        easing: current.openEasing,
        step: elastic ? this.step : null,
        complete: F._afterZoomIn
      });
    },
    zoomOut: function zoomOut() {
      var current = F.current,
          effect = current.closeEffect,
          elastic = effect === 'elastic',
          endPos = {
        opacity: 0.1
      };

      if (elastic) {
        endPos = this.getOrigPosition();

        if (current.closeOpacity) {
          endPos.opacity = 0.1;
        }
      }

      F.wrap.animate(endPos, {
        duration: effect === 'none' ? 0 : current.closeSpeed,
        easing: current.closeEasing,
        step: elastic ? this.step : null,
        complete: F._afterZoomOut
      });
    },
    changeIn: function changeIn() {
      var current = F.current,
          effect = current.nextEffect,
          startPos = current.pos,
          endPos = {
        opacity: 1
      },
          direction = F.direction,
          distance = 200,
          field;
      startPos.opacity = 0.1;

      if (effect === 'elastic') {
        field = direction === 'down' || direction === 'up' ? 'top' : 'left';

        if (direction === 'down' || direction === 'right') {
          startPos[field] = getValue(getScalar(startPos[field]) - distance);
          endPos[field] = '+=' + distance + 'px';
        } else {
          startPos[field] = getValue(getScalar(startPos[field]) + distance);
          endPos[field] = '-=' + distance + 'px';
        }
      } // Workaround for http://bugs.jquery.com/ticket/12273


      if (effect === 'none') {
        F._afterZoomIn();
      } else {
        F.wrap.css(startPos).animate(endPos, {
          duration: current.nextSpeed,
          easing: current.nextEasing,
          complete: F._afterZoomIn
        });
      }
    },
    changeOut: function changeOut() {
      var previous = F.previous,
          effect = previous.prevEffect,
          endPos = {
        opacity: 0.1
      },
          direction = F.direction,
          distance = 200;

      if (effect === 'elastic') {
        endPos[direction === 'down' || direction === 'up' ? 'top' : 'left'] = (direction === 'up' || direction === 'left' ? '-' : '+') + '=' + distance + 'px';
      }

      previous.wrap.animate(endPos, {
        duration: effect === 'none' ? 0 : previous.prevSpeed,
        easing: previous.prevEasing,
        complete: function complete() {
          $(this).trigger('onReset').remove();
        }
      });
    }
  };
  /*
   *	Overlay helper
   */

  F.helpers.overlay = {
    defaults: {
      closeClick: true,
      // if true, fancyBox will be closed when user clicks on the overlay
      speedOut: 200,
      // duration of fadeOut animation
      showEarly: true,
      // indicates if should be opened immediately or wait until the content is ready
      css: {},
      // custom CSS properties
      locked: !isTouch,
      // if true, the content will be locked into overlay
      fixed: true // if false, the overlay CSS position property will not be set to "fixed"

    },
    overlay: null,
    // current handle
    fixed: false,
    // indicates if the overlay has position "fixed"
    el: $('html'),
    // element that contains "the lock"
    // Public methods
    create: function create(opts) {
      opts = $.extend({}, this.defaults, opts);

      if (this.overlay) {
        this.close();
      }

      this.overlay = $('<div class="fancybox-overlay"></div>').appendTo(F.coming ? F.coming.parent : opts.parent);
      this.fixed = false;

      if (opts.fixed && F.defaults.fixed) {
        this.overlay.addClass('fancybox-overlay-fixed');
        this.fixed = true;
      }
    },
    open: function open(opts) {
      var that = this;
      opts = $.extend({}, this.defaults, opts);

      if (this.overlay) {
        this.overlay.unbind('.overlay').width('auto').height('auto');
      } else {
        this.create(opts);
      }

      if (!this.fixed) {
        W.bind('resize.overlay', $.proxy(this.update, this));
        this.update();
      }

      if (opts.closeClick) {
        this.overlay.bind('click.overlay', function (e) {
          if ($(e.target).hasClass('fancybox-overlay')) {
            if (F.isActive) {
              F.close();
            } else {
              that.close();
            }

            return false;
          }
        });
      }

      this.overlay.css(opts.css).show();
    },
    close: function close() {
      var scrollV, scrollH;
      W.unbind('resize.overlay');

      if (this.el.hasClass('fancybox-lock')) {
        $('.fancybox-margin').removeClass('fancybox-margin');
        scrollV = W.scrollTop();
        scrollH = W.scrollLeft();
        this.el.removeClass('fancybox-lock');
        W.scrollTop(scrollV).scrollLeft(scrollH);
      }

      $('.fancybox-overlay').remove().hide();
      $.extend(this, {
        overlay: null,
        fixed: false
      });
    },
    // Private, callbacks
    update: function update() {
      var width = '100%',
          offsetWidth; // Reset width/height so it will not mess

      this.overlay.width(width).height('100%'); // jQuery does not return reliable result for IE

      if (IE) {
        offsetWidth = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);

        if (D.width() > offsetWidth) {
          width = D.width();
        }
      } else if (D.width() > W.width()) {
        width = D.width();
      }

      this.overlay.width(width).height(D.height());
    },
    // This is where we can manipulate DOM, because later it would cause iframes to reload
    onReady: function onReady(opts, obj) {
      var overlay = this.overlay;
      $('.fancybox-overlay').stop(true, true);

      if (!overlay) {
        this.create(opts);
      }

      if (opts.locked && this.fixed && obj.fixed) {
        if (!overlay) {
          this.margin = D.height() > W.height() ? $('html').css('margin-right').replace("px", "") : false;
        }

        obj.locked = this.overlay.append(obj.wrap);
        obj.fixed = false;
      }

      if (opts.showEarly === true) {
        this.beforeShow.apply(this, arguments);
      }
    },
    beforeShow: function beforeShow(opts, obj) {
      var scrollV, scrollH;

      if (obj.locked) {
        if (this.margin !== false) {
          $('*').filter(function () {
            return $(this).css('position') === 'fixed' && !$(this).hasClass("fancybox-overlay") && !$(this).hasClass("fancybox-wrap");
          }).addClass('fancybox-margin');
          this.el.addClass('fancybox-margin');
        }

        scrollV = W.scrollTop();
        scrollH = W.scrollLeft();
        this.el.addClass('fancybox-lock');
        W.scrollTop(scrollV).scrollLeft(scrollH);
      }

      this.open(opts);
    },
    onUpdate: function onUpdate() {
      if (!this.fixed) {
        this.update();
      }
    },
    afterClose: function afterClose(opts) {
      // Remove overlay if exists and fancyBox is not opening
      // (e.g., it is not being open using afterClose callback)
      //if (this.overlay && !F.isActive) {
      if (this.overlay && !F.coming) {
        this.overlay.fadeOut(opts.speedOut, $.proxy(this.close, this));
      }
    }
  };
  /*
   *	Title helper
   */

  F.helpers.title = {
    defaults: {
      type: 'float',
      // 'float', 'inside', 'outside' or 'over',
      position: 'bottom' // 'top' or 'bottom'

    },
    beforeShow: function beforeShow(opts) {
      var current = F.current,
          text = current.title,
          type = opts.type,
          title,
          target;

      if ($.isFunction(text)) {
        text = text.call(current.element, current);
      }

      if (!isString(text) || $.trim(text) === '') {
        return;
      }

      title = $('<div class="fancybox-title fancybox-title-' + type + '-wrap">' + text + '</div>');

      switch (type) {
        case 'inside':
          target = F.skin;
          break;

        case 'outside':
          target = F.wrap;
          break;

        case 'over':
          target = F.inner;
          break;

        default:
          // 'float'
          target = F.skin;
          title.appendTo('body');

          if (IE) {
            title.width(title.width());
          }

          title.wrapInner('<span class="child"></span>'); //Increase bottom margin so this title will also fit into viewport

          F.current.margin[2] += Math.abs(getScalar(title.css('margin-bottom')));
          break;
      }

      title[opts.position === 'top' ? 'prependTo' : 'appendTo'](target);
    }
  }; // jQuery plugin initialization

  $.fn.fancybox = function (options) {
    var index,
        that = $(this),
        selector = this.selector || '',
        run = function run(e) {
      var what = $(this).blur(),
          idx = index,
          relType,
          relVal;

      if (!(e.ctrlKey || e.altKey || e.shiftKey || e.metaKey) && !what.is('.fancybox-wrap')) {
        relType = options.groupAttr || 'data-fancybox-group';
        relVal = what.attr(relType);

        if (!relVal) {
          relType = 'rel';
          relVal = what.get(0)[relType];
        }

        if (relVal && relVal !== '' && relVal !== 'nofollow') {
          what = selector.length ? $(selector) : that;
          what = what.filter('[' + relType + '="' + relVal + '"]');
          idx = what.index(this);
        }

        options.index = idx; // Stop an event from bubbling if everything is fine

        if (F.open(what, options) !== false) {
          e.preventDefault();
        }
      }
    };

    options = options || {};
    index = options.index || 0;

    if (!selector || options.live === false) {
      that.unbind('click.fb-start').bind('click.fb-start', run);
    } else {
      D.undelegate(selector, 'click.fb-start').delegate(selector + ":not('.fancybox-item, .fancybox-nav')", 'click.fb-start', run);
    }

    this.filter('[data-fancybox-start=1]').trigger('click');
    return this;
  }; // Tests that need a body at doc ready


  D.ready(function () {
    var w1, w2;

    if ($.scrollbarWidth === undefined) {
      // http://benalman.com/projects/jquery-misc-plugins/#scrollbarwidth
      $.scrollbarWidth = function () {
        var parent = $('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body'),
            child = parent.children(),
            width = child.innerWidth() - child.height(99).innerWidth();
        parent.remove();
        return width;
      };
    }

    if ($.support.fixedPosition === undefined) {
      $.support.fixedPosition = function () {
        var elem = $('<div style="position:fixed;top:20px;"></div>').appendTo('body'),
            fixed = elem[0].offsetTop === 20 || elem[0].offsetTop === 15;
        elem.remove();
        return fixed;
      }();
    }

    $.extend(F.defaults, {
      scrollbarWidth: $.scrollbarWidth(),
      fixed: $.support.fixedPosition,
      parent: $('body')
    }); //Get real width of page scroll-bar

    w1 = $(window).width();
    H.addClass('fancybox-lock-test');
    w2 = $(window).width();
    H.removeClass('fancybox-lock-test');
    $("<style type='text/css'>.fancybox-margin{margin-right:" + (w2 - w1) + "px;}</style>").appendTo("head");
  });
})(window, document, jQuery);
/*!
	Zoom 1.7.18
	license: MIT
	http://www.jacklmoore.com/zoom
*/


(function (o) {
  var t = {
    url: !1,
    callback: !1,
    target: !1,
    duration: 120,
    on: "mouseover",
    touch: !0,
    onZoomIn: !1,
    onZoomOut: !1,
    magnify: 1
  };
  o.zoom = function (t, n, e, i) {
    var u,
        c,
        a,
        r,
        m,
        l,
        s,
        f = o(t),
        h = f.css("position"),
        d = o(n);
    return t.style.position = /(absolute|fixed)/.test(h) ? h : "relative", t.style.overflow = "hidden", e.style.width = e.style.height = "", o(e).addClass("zoomImg").css({
      position: "absolute",
      top: 0,
      left: 0,
      opacity: 0,
      width: e.width * i,
      height: e.height * i,
      border: "none",
      maxWidth: "none",
      maxHeight: "none"
    }).appendTo(t), {
      init: function init() {
        c = f.outerWidth(), u = f.outerHeight(), n === t ? (r = c, a = u) : (r = d.outerWidth(), a = d.outerHeight()), m = (e.width - c) / r, l = (e.height - u) / a, s = d.offset();
      },
      move: function move(o) {
        var t = o.pageX - s.left,
            n = o.pageY - s.top;
        n = Math.max(Math.min(n, a), 0), t = Math.max(Math.min(t, r), 0), e.style.left = t * -m + "px", e.style.top = n * -l + "px";
      }
    };
  }, o.fn.zoom = function (n) {
    return this.each(function () {
      var e = o.extend({}, t, n || {}),
          i = e.target && o(e.target)[0] || this,
          u = this,
          c = o(u),
          a = document.createElement("img"),
          r = o(a),
          m = "mousemove.zoom",
          l = !1,
          s = !1;

      if (!e.url) {
        var f = u.querySelector("img");
        if (f && (e.url = f.getAttribute("data-src") || f.currentSrc || f.src), !e.url) return;
      }

      c.one("zoom.destroy", function (o, t) {
        c.off(".zoom"), i.style.position = o, i.style.overflow = t, a.onload = null, r.remove();
      }.bind(this, i.style.position, i.style.overflow)), a.onload = function () {
        function t(t) {
          f.init(), f.move(t), r.stop().fadeTo(o.support.opacity ? e.duration : 0, 1, o.isFunction(e.onZoomIn) ? e.onZoomIn.call(a) : !1);
        }

        function n() {
          r.stop().fadeTo(e.duration, 0, o.isFunction(e.onZoomOut) ? e.onZoomOut.call(a) : !1);
        }

        var f = o.zoom(i, u, a, e.magnify);
        "grab" === e.on ? c.on("mousedown.zoom", function (e) {
          1 === e.which && (o(document).one("mouseup.zoom", function () {
            n(), o(document).off(m, f.move);
          }), t(e), o(document).on(m, f.move), e.preventDefault());
        }) : "click" === e.on ? c.on("click.zoom", function (e) {
          return l ? void 0 : (l = !0, t(e), o(document).on(m, f.move), o(document).one("click.zoom", function () {
            n(), l = !1, o(document).off(m, f.move);
          }), !1);
        }) : "toggle" === e.on ? c.on("click.zoom", function (o) {
          l ? n() : t(o), l = !l;
        }) : "mouseover" === e.on && (f.init(), c.on("mouseenter.zoom", t).on("mouseleave.zoom", n).on(m, f.move)), e.touch && c.on("touchstart.zoom", function (o) {
          o.preventDefault(), s ? (s = !1, n()) : (s = !0, t(o.originalEvent.touches[0] || o.originalEvent.changedTouches[0]));
        }).on("touchmove.zoom", function (o) {
          o.preventDefault(), f.move(o.originalEvent.touches[0] || o.originalEvent.changedTouches[0]);
        }).on("touchend.zoom", function (o) {
          o.preventDefault(), s && (s = !1, n());
        }), o.isFunction(e.callback) && e.callback.call(a);
      }, a.src = e.url;
    });
  }, o.fn.zoom.defaults = t;
})(window.jQuery); // Trigger
// jQuery(function () {
//   var $range = jQuery(".js-range-slider"),
//       $inputFrom = jQuery(".js-input-from"),
//       $inputTo = jQuery(".js-input-to"),
//       instance,
//       min = 0,
//       max = 1000000,
//       from = 0,
//       to = 0;
//   $range.ionRangeSlider({
//       type: "double",
//       min: min,
//       max: max,
//       from: 0,
//       to: 500000,
//     prefix: 'Rp. ',
//       onStart: updateInputs,
//       onChange: updateInputs,
//       step: 50000,
//       prettify_enabled: true,
//       prettify_separator: ".",
//     values_separator: " - ",
//     force_edges: true
//   });
//   instance = $range.data("ionRangeSlider");
//   function updateInputs (data) {
//       from = data.from;
//       to = data.to;
//       $inputFrom.prop("value", from);
//       $inputTo.prop("value", to); 
//   }
//   $inputFrom.on("input", function () {
//       var val = $(this).prop("value");
//       // validate
//       if (val < min) {
//           val = min;
//       } else if (val > to) {
//           val = to;
//       }
//       instance.update({
//           from: val
//       });
//   });
//   $inputTo.on("input", function () {
//       var val = $(this).prop("value");
//       // validate
//       if (val < from) {
//           val = from;
//       } else if (val > max) {
//           val = max;
//       }
//       instance.update({
//           to: val
//       });
//   });
//       });
//sticky header


window.onscroll = function () {
  myFunction();
};

var header = document.getElementById("stickyHeader");

function myFunction() {
  if (window.pageYOffset > 100) {
    header.classList.add("sticky-header");
  } else {
    header.classList.remove("sticky-header");
  }
}

function notificationWishlist() {
  jQuery('#notificationWishlist').show();
  setTimeout(function () {
    jQuery('#notificationWishlist').hide('slow');
  }, 2000);
} // Tooltip


jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip();
});
jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.tab-carousel-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: false,
          // variableWidth: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 4,
          slidesToScroll: item || 4,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          }, {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }, {
            breakpoint: 768,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // popular section

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.popular-carousel-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 2,
          slidesToScroll: item || 2,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // blog section

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.blog-carousel-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: true,
          autoplay: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 3,
          slidesToScroll: item || 3,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // aboutus section

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.aboutus-carousel-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: true,
          autoplay: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 4,
          slidesToScroll: item || 1,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // aboutus section

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.insta-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: false,
          infinite: true,
          autoplay: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 4,
          slidesToScroll: item || 1,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // modal section

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.modal-carousel-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 1,
          slidesToScroll: item || 1,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // product page section

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.product-carousel-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: true,
          autoplay: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 4,
          slidesToScroll: item || 1,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // product page3 section

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.product-carousel-js3');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: true,
          autoplay: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 2,
          slidesToScroll: item || 2,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // product page5 section   

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.product-carousel-js5');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: false,
          infinite: true,
          autoplay: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 1,
          slidesToScroll: item || 1,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
});

(function (jQuery) {
  var tabCarouselContent = jQuery('#tabCarousel');
  jQuery('a[data-toggle="tab"]').length && jQuery('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
    jQuery('.slick-slider').each(function () {
      jQuery(this).slick("getSlick").refresh();
    });
  });
})(jQuery);

jQuery(document).ready(function () {
  (function (jQuery) {
    var tabCarousel = jQuery('.product-m-carousel-js');

    if (tabCarousel.length) {
      tabCarousel.each(function () {
        var thisCarousel = jQuery(this),
            item = jQuery(this).data('item'),
            itemmobile = jQuery(this).data('itemmobile');
        thisCarousel.slick({
          lazyLoad: 'progressive',
          dots: false,
          arrows: true,
          infinite: true,
          autoplay: true,
          //rtl:true,
          speed: 300,
          slidesToShow: item || 1,
          slidesToScroll: item || 1,
          adaptiveHeight: true,
          responsive: [{
            breakpoint: 1025,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 791,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 650,
            settings: {
              slidesToShow: itemmobile || 1,
              slidesToScroll: itemmobile || 1
            }
          }]
        });
      });
    }

    ;
  })(jQuery);
}); // Scroll to top

if (jQuery('#back-to-top').length) {
  var scrollTrigger = 100,
      // px
  backToTop = function backToTop() {
    var scrollTop = jQuery(window).scrollTop();

    if (scrollTop > scrollTrigger) {
      jQuery('#back-to-top').addClass('show');
    } else {
      jQuery('#back-to-top').removeClass('show');
    }
  };

  backToTop();
  jQuery(window).on('scroll', function () {
    backToTop();
  });
  jQuery('#back-to-top').on('click', function (e) {
    e.preventDefault();
    jQuery('html,body').animate({
      scrollTop: 0
    }, 700);
  });
} // Menu dropdown opens on Hover


jQuery('body').on('mouseenter mouseleave', '.dropdown.open', function (e) {
  var _d = jQuery(e.target).closest('.dropdown');

  _d.addClass('show');

  setTimeout(function () {
    _d[_d.is(':hover') ? 'addClass' : 'removeClass']('show');
  }, 300);
  jQuery('.dropdown-menu', _d).attr('aria-expanded', _d.is(':hover'));
}); // Home Tabs Active

jQuery('.nav-index').on('show.bs.tab', function (e) {
  console.log('fire');
  e.target; // newly activated tab

  e.relatedTarget; // previous active tab

  jQuery('.tab-overlay').show();
});
jQuery('.nav-index').on('hidden.bs.tab', function (e) {
  console.log('expire');
  e.target; // newly activated tab

  e.relatedTarget; // previous active tab

  jQuery('.tab-overlay').hide();
}); // Mobile Menu

jQuery(document).ready(function () {
  var targetElement = document.getElementById("popup"); //only popup can scroll

  jQuery('.navigation-mobile-toggler').on('click', function () {
    jQuery('#navigation-mobile').toggleClass('navigation-active');
    jQuery('.mobile-overlay').addClass('active'); //put this when popup opens, to stop body scrolling
    //bodyScrollLock.disableBodyScroll(targetElement);

    jQuery('html').css('overflow', 'hidden');
    jQuery('body').css('overflow', 'hidden');
  });
  jQuery('.mobile-overlay').on('click', function () {
    jQuery('#navigation-mobile').removeClass('navigation-active');
    jQuery('.mobile-overlay').removeClass('active'); //put this when close popup and show scrollbar in body
    // bodyScrollLock.enableBodyScroll(targetElement);

    jQuery('html').css('overflow', 'auto');
    jQuery('body').css('overflow', 'auto');
  });
}); //Display grid/list 4 Column

jQuery(document).ready(function () {
  jQuery('#list_4column').on('click', function () {
    jQuery('#swap .col-12').removeClass('griding');
    jQuery('#swap .col-12').removeClass('col-lg-3');
    jQuery('#swap .col-12').removeClass('col-md-6');
    jQuery('#swap .col-12').addClass('listing');
    jQuery(this).addClass('active');
    jQuery('#grid_4column').removeClass('active');
  });
  jQuery('#grid_4column').on('click', function () {
    jQuery('#swap .col-12').removeClass('listing');
    jQuery('#swap .col-12').addClass('col-lg-3');
    jQuery('#swap .col-12').addClass('col-md-6');
    jQuery('#swap .col-12').addClass('griding');
    jQuery(this).addClass('active');
    jQuery('#list_4column').removeClass('active');
  });
});
jQuery(document).ready(function () {
  jQuery('#list_3column').on('click', function () {
    jQuery('#swap .col-12').removeClass('griding');
    jQuery('#swap .col-12').removeClass('col-lg-4');
    jQuery('#swap .col-12').removeClass('col-md-6');
    jQuery('#swap .col-12').addClass('listing');
    jQuery(this).addClass('active');
    jQuery('#grid_4column').removeClass('active');
  });
  jQuery('#grid_3column').on('click', function () {
    jQuery('#swap .col-12').removeClass('listing');
    jQuery('#swap .col-12').addClass('col-lg-4');
    jQuery('#swap .col-12').addClass('col-md-6');
    jQuery('#swap .col-12').addClass('griding');
    jQuery(this).addClass('active');
    jQuery('#list_4column').removeClass('active');
  });
}); //Display grid/list 3 Column

jQuery(document).ready(function () {
  jQuery('#list_3column').on('click', function () {
    jQuery('#swap .col-12').removeClass('griding');
    jQuery('#swap .col-12').removeClass('col-lg-4');
    jQuery('#swap .col-12').removeClass('col-md-6');
    jQuery('#swap .col-12').addClass('listing');
    jQuery(this).addClass('active');
    jQuery('#grid_3column').removeClass('active');
  });
  jQuery('#grid_3column').on('click', function () {
    jQuery('#swap .col-12').removeClass('listing');
    jQuery('#swap .col-12').addClass('col-lg-4');
    jQuery('#swap .col-12').addClass('col-md-6');
    jQuery('#swap .col-12').addClass('griding');
    jQuery(this).addClass('active');
    jQuery('#list_3column').removeClass('active');
  });
}); // Quantiy Counter

jQuery(document).ready(function () {
  var quantitiy = 0;
  jQuery('.quantity-right-plus').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity').val()); // If is not undefined

    jQuery('#quantity').val(quantity + 1); // Increment
  });
  jQuery('.quantity-left-minus').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity').val()); // If is not undefined
    // Increment

    if (quantity > 0) {
      jQuery('#quantity').val(quantity - 1);
    }
  });
});
jQuery(document).ready(function () {
  var quantitiy = 0;
  jQuery('.quantity-plus1').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity1').val()); // If is not undefined

    jQuery('#quantity1').val(quantity + 1); // Increment
  });
  jQuery('.quantity-minus1').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity1').val()); // If is not undefined
    // Increment

    if (quantity > 0) {
      jQuery('#quantity1').val(quantity - 1);
    }
  });
});
jQuery(document).ready(function () {
  var quantitiy = 0;
  jQuery('.quantity-right-plus').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity2').val()); // If is not undefined

    jQuery('#quantity2').val(quantity + 1); // Increment
  });
  jQuery('.quantity-left-minus').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity2').val()); // If is not undefined
    // Increment

    if (quantity > 0) {
      jQuery('#quantity2').val(quantity - 1);
    }
  });
});
jQuery(document).ready(function () {
  var quantitiy = 0;
  jQuery('.quantity-plus2').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity2').val()); // If is not undefined

    jQuery('#quantity2').val(quantity + 1); // Increment
  });
  jQuery('.quantity-minus2').click(function (e) {
    // Stop acting like a button
    e.preventDefault(); // Get the field name

    var quantity = parseInt(jQuery('#quantity2').val()); // If is not undefined
    // Increment

    if (quantity > 0) {
      jQuery('#quantity2').val(quantity - 1);
    }
  });
});
jQuery(document).ready(function () {
  jQuery(window).scroll(function () {
    var positiontop = jQuery(document).scrollTop();
  });
}); ///popup-newsletter

jQuery(window).on('load', function () {
  jQuery('#newsletterModal').modal('show');
});
jQuery('#mynewsletterModalModal').modal('handleUpdate');
jQuery('.fadeInUp').css('transform', 'translateY(0px)'); // Product SLICK

jQuery('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  infinite: false,
  draggable: false,
  fade: true,
  asNavFor: '.slider-nav',
  adaptiveHeight: true
});
jQuery('.slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  centerMode: true,
  centerPadding: '60px',
  dots: false,
  arrows: true,
  focusOnSelect: true
}); // Product vertical SLICK

jQuery('.slider-for-vertical').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  infinite: false,
  draggable: false,
  fade: true,
  asNavFor: '.slider-nav-vertical'
});
jQuery('.slider-nav-vertical').slick({
  dots: false,
  arrows: true,
  vertical: true,
  asNavFor: '.slider-for-vertical',
  slidesToShow: 3,
  // centerMode: true,
  slidesToScroll: 1,
  verticalSwiping: true,
  focusOnSelect: true
});
jQuery(function () {
  // ZOOM
  jQuery('.ex1').zoom();
});
jQuery('.slide-toggle').on('click', function (event) {
  jQuery('.switcher').toggleClass('active');
}); // Fancy Box For Product Detail Page

jQuery(document).ready(function () {
  jQuery(".fancybox-button").fancybox({
    openEffect: 'none',
    closeEffect: 'none',
    prevEffect: 'none',
    nextEffect: 'none',
    closeBtn: true,
    margin: [20, 60, 20, 60],
    helpers: {
      title: {
        type: 'inside'
      },
      buttons: {}
    }
  });
});
jQuery(document).ready(function () {
  jQuery(".bodyrtl").attr("data-placement", "right");
});
jQuery(".swticher-rtl").click(function () {
  jQuery("body").toggleClass("bodyrtl");

  if (jQuery("body").hasClass("bodyrtl") === true) {
    jQuery("*").each(function () {
      if (jQuery(this).attr("data-placement") === "left") {
        jQuery(this).tooltip('dispose');
        jQuery(this).tooltip({
          placement: 'right'
        });
      }
    });
  } else {
    jQuery("*").each(function () {
      if (jQuery(this).attr("data-placement") === "left") {
        jQuery(this).tooltip('dispose');
        jQuery(this).tooltip({
          placement: 'left'
        });
      }
    });
  }

  jQuery(".swticher-rtl").toggleClass("active");
});
jQuery(".swticher-boxed").click(function () {
  jQuery("html").toggleClass("boxed");
  jQuery(".swticher-boxed").toggleClass("active");
}); // Color Scheme Change

jQuery(document).on("click", "#switchColor a", function () {
  var cssValue = jQuery(this).attr("id");
  jQuery("#switchColor li").removeClass('active');
  jQuery(this).parent().addClass('active');

  if (cssValue == "default") {
    jQuery('link[rel=stylesheet][href="css/yellow.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/green.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/navy-blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/red.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/pink.css"]').remove();
  } else if (cssValue == "yellow") {
    jQuery('head').append('<link type="text/css" rel="stylesheet" href="css/yellow.css">');
    jQuery('link[rel=stylesheet][href="css/default.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/green.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/navy-blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/red.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/pink.css"]').remove();
  } else if (cssValue == "blue") {
    jQuery('head').append('<link type="text/css" rel="stylesheet" href="css/blue.css">');
    jQuery('link[rel=stylesheet][href="css/default.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/yellow.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/green.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/navy-blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/red.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/pink.css"]').remove();
  } else if (cssValue == "green") {
    jQuery('head').append('<link type="text/css" rel="stylesheet" href="css/green.css">');
    jQuery('link[rel=stylesheet][href="css/default.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/yellow.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/navy-blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/red.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/pink.css"]').remove();
  } else if (cssValue == "navy-blue") {
    jQuery('head').append('<link type="text/css" rel="stylesheet" href="css/navy-blue.css">');
    jQuery('link[rel=stylesheet][href="css/default.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/green.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/yellow.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/red.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/pink.css"]').remove();
  } else if (cssValue == "red") {
    jQuery('head').append('<link type="text/css" rel="stylesheet" href="css/red.css">');
    jQuery('link[rel=stylesheet][href="css/default.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/green.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/navy-blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/yellow.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/pink.css"]').remove();
  } else if (cssValue == "pink") {
    jQuery('head').append('<link type="text/css" rel="stylesheet" href="css/pink.css">');
    jQuery('link[rel=stylesheet][href="css/default.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/green.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/navy-blue.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/red.css"]').remove();
    jQuery('link[rel=stylesheet][href="css/yellow.css"]').remove();
  }
}); // Add To Cart Button Enable

jQuery(document).ready(function () {
  jQuery('.color-selection ul li a').on('click', function () {
    jQuery('.color-selection ul li').removeClass("active");
    jQuery(this).parent().addClass("active");
  });
  jQuery('.size-selection ul li a').on('click', function () {
    jQuery('.size-selection ul li').removeClass("active");
    jQuery(this).parent().addClass("active");
  });
});

function notificationCompare() {
  jQuery('#notificationCompare').show();
  setTimeout(function () {
    jQuery('#notificationCompare').hide('slow');
  }, 2000);
} // checkout


jQuery('.cta').on('click', function () {
  jQuery(this).removeClass("active");
  jQuery(this).removeClass("show"); //jQuery(this).parents('.nav li a').eq(5).addClass( "active");
  //jQuery(this).parents('.nav li a').addClass( "show");
});
jQuery('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
  var hashValue = jQuery(e.target).attr('href');
  jQuery("#pills-shipping-tab").removeClass("active");
  jQuery("#pills-billing-tab").removeClass("active");
  jQuery("#pills-method-tab").removeClass("active");
  jQuery("#pills-order-tab").removeClass("active");
  jQuery(hashValue + "-tab").addClass("active");
}); //paste this code under head tag or in a seperate js file.
// Wait for window load

jQuery(window).on('load', function () {
  // Animate loader off screen
  jQuery('.se-pre-con').fadeOut("slow");
});
jQuery(document).on("click", ".alert .close", function () {
  jQuery(this).animate({
    opacity: 0
  }, 1000).hide('slow'); // jQuery(".alert").slideUp(1000, function() {
  //     jQuery(this).remove();
  // });
}); // instagram

jQuery(document).ready(function () {
  jQuery('.switc').click(function () {
    jQuery('.switchdiv').toggle();
  });
});
jQuery(document).on("click", ".alert .close", function () {
  jQuery(this).animate({
    opacity: 0
  }, 1000).hide('slow'); // jQuery(".alert").slideUp(1000, function() {
  //     jQuery(this).remove();
  // });
}); // tooltip for modal 

jQuery(document).ready(function () {
  jQuery('body').tooltip({
    selector: "[data-tooltip=tooltip]",
    container: "body"
  });
}); // tooltip for click 

jQuery('[data-toggle="tooltip"]').tooltip({
  trigger: 'hover'
});
jQuery('[data-tooltip="tooltip"]').tooltip({
  trigger: 'hover'
});
jQuery(document).ready(function () {
  jQuery('[rel=tooltip]').tooltip({
    trigger: "hover"
  });
});
jQuery('body').on('hidden.bs.popover', function (e) {
  jQuery(e.target).data("bs.popover").inState.click = false;
});

/***/ }),

/***/ 4:
/*!**********************************************!*\
  !*** multi ./resources/assets/js/scripts.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\www\working\laravel\laravel_groceries_git\laravel-ionic-android-shop\resources\assets\js\scripts.js */"./resources/assets/js/scripts.js");


/***/ })

/******/ });