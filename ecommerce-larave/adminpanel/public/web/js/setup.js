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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/setup.js":
/*!**************************************!*\
  !*** ./resources/assets/js/setup.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  $(document).ready(function () {
    $('.xzoom, .xzoom-gallery').xzoom({
      position: 'left',
      zoomWidth: 400,
      title: true,
      tint: '#333',
      Xoffset: 15
    });
    $('.xzoom2, .xzoom-gallery2').xzoom({
      position: '#xzoom2-id',
      tint: '#ffa200'
    });
    $('.xzoom3, .xzoom-gallery3').xzoom({
      position: 'lens',
      lensShape: 'circle',
      sourceClass: 'xzoom-hidden'
    });
    $('.xzoom4, .xzoom-gallery4').xzoom({
      position: 'left',
      tint: '#006699',
      Xoffset: -15
    });
    $('.xzoom5, .xzoom-gallery5').xzoom({
      position: 'right',
      tint: '#006699',
      Xoffset: 15
    }); //Integration with hammer.js

    var isTouchSupported = 'ontouchstart' in window;

    if (isTouchSupported) {
      //If touch device
      $('.xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5').each(function () {
        var xzoom = $(this).data('xzoom');
        xzoom.eventunbind();
      });
      $('.xzoom, .xzoom2, .xzoom3').each(function () {
        var xzoom = $(this).data('xzoom');
        $(this).hammer().on("tap", function (event) {
          event.pageX = event.gesture.center.pageX;
          event.pageY = event.gesture.center.pageY;
          var s = 1,
              ls;

          xzoom.eventmove = function (element) {
            element.hammer().on('drag', function (event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              xzoom.movezoom(event);
              event.gesture.preventDefault();
            });
          };

          xzoom.eventleave = function (element) {
            element.hammer().on('tap', function (event) {
              xzoom.closezoom();
            });
          };

          xzoom.openzoom(event);
        });
      }); // $('.xzoom4').each(function() {
      //     var xzoom = $(this).data('xzoom');
      //     $(this).hammer().on("tap", function(event) {
      //         event.pageX = event.gesture.center.pageX;
      //         event.pageY = event.gesture.center.pageY;
      //         var s = 1, ls;
      //         xzoom.eventmove = function(element) {
      //             element.hammer().on('drag', function(event) {
      //                 event.pageX = event.gesture.center.pageX;
      //                 event.pageY = event.gesture.center.pageY;
      //                 xzoom.movezoom(event);
      //                 event.gesture.preventDefault();
      //             });
      //         }
      //         var counter = 0;
      //         xzoom.eventclick = function(element) {
      //             element.hammer().on('tap', function() {
      //                 counter++;
      //                 if (counter == 1) setTimeout(openfancy,300);
      //                 event.gesture.preventDefault();
      //             });
      //         }
      //         function openfancy() {
      //             if (counter == 2) {
      //                 xzoom.closezoom();
      //                 $.fancybox.open(xzoom.gallery().cgallery);
      //             } else {
      //                 xzoom.closezoom();
      //             }
      //             counter = 0;
      //         }
      //     xzoom.openzoom(event);
      //     });
      // });

      $('.xzoom4').each(function () {
        var xzoom = $(this).data('xzoom');
        $(this).hammer().on("tap", function (event) {
          event.pageX = event.gesture.center.pageX;
          event.pageY = event.gesture.center.pageY;
          var s = 1,
              ls;

          xzoom.eventmove = function (element) {
            element.hammer().on('drag', function (event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              xzoom.movezoom(event);
              event.gesture.preventDefault();
            });
          };

          var counter = 0;

          xzoom.eventclick = function (element) {
            element.hammer().on('tap', function () {
              counter++;
              if (counter == 1) setTimeout(openmagnific, 300);
              event.gesture.preventDefault();
            });
          };

          function openmagnific() {
            if (counter == 2) {
              xzoom.closezoom();
              var gallery = xzoom.gallery().cgallery;
              var i,
                  images = new Array();

              for (i in gallery) {
                images[i] = {
                  src: gallery[i]
                };
              }

              $.magnificPopup.open({
                items: images,
                type: 'image',
                gallery: {
                  enabled: true
                }
              });
            } else {
              xzoom.closezoom();
            }

            counter = 0;
          }

          xzoom.openzoom(event);
        });
      });
      $('.xzoom5').each(function () {
        var xzoom = $(this).data('xzoom');
        $(this).hammer().on("tap", function (event) {
          event.pageX = event.gesture.center.pageX;
          event.pageY = event.gesture.center.pageY;
          var s = 1,
              ls;

          xzoom.eventmove = function (element) {
            element.hammer().on('drag', function (event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              xzoom.movezoom(event);
              event.gesture.preventDefault();
            });
          };

          var counter = 0;

          xzoom.eventclick = function (element) {
            element.hammer().on('tap', function () {
              counter++;
              if (counter == 1) setTimeout(openmagnific, 300);
              event.gesture.preventDefault();
            });
          };

          function openmagnific() {
            if (counter == 2) {
              xzoom.closezoom();
              var gallery = xzoom.gallery().cgallery;
              var i,
                  images = new Array();

              for (i in gallery) {
                images[i] = {
                  src: gallery[i]
                };
              }

              $.magnificPopup.open({
                items: images,
                type: 'image',
                gallery: {
                  enabled: true
                }
              });
            } else {
              xzoom.closezoom();
            }

            counter = 0;
          }

          xzoom.openzoom(event);
        });
      });
    } else {
      //If not touch device
      //Integration with fancybox plugin
      $('#xzoom-fancy').bind('click', function (event) {
        var xzoom = $(this).data('xzoom');
        xzoom.closezoom();
        $.fancybox.open(xzoom.gallery().cgallery, {
          padding: 0,
          helpers: {
            overlay: {
              locked: false
            }
          }
        });
        event.preventDefault();
      }); //Integration with magnific popup plugin

      $('#xzoom-magnific').bind('click', function (event) {
        var xzoom = $(this).data('xzoom');
        xzoom.closezoom();
        var gallery = xzoom.gallery().cgallery;
        var i,
            images = new Array();

        for (i in gallery) {
          images[i] = {
            src: gallery[i]
          };
        }

        $.magnificPopup.open({
          items: images,
          type: 'image',
          gallery: {
            enabled: true
          }
        });
        event.preventDefault();
      });
    }
  });
})(jQuery);

/***/ }),

/***/ 5:
/*!********************************************!*\
  !*** multi ./resources/assets/js/setup.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\www\working\laravel\laravel_groceries_git\laravel-ionic-android-shop\resources\assets\js\setup.js */"./resources/assets/js/setup.js");


/***/ })

/******/ });