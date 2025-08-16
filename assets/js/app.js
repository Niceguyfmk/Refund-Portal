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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/app.js":
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
/*! no static exports found */
/***/ (function(module, exports) {

//Pre Loader Start Here
$(window).on('load', function () {
  $('.loader-main').fadeOut();
}); //Pre Loader End Here  
//Loader Js

window.addEventListener("load", function () {
  var Loader = document.querySelector(".loader-main");
  Loader.classList.add("hidden");
}); //Loader Js 
// AOS Animations JS Start Here

AOS.init({
  once: true
});
AOS.refresh(); // AOS Animations JS End here

$(document).ready(function () {
  $(".overlay-close").click(function () {
    $(".offcanvas").removeClass("show");
    $(".offcanvas-backdrop").removeClass("show");
    $(".offcanvas-backdrop").addClass("canvas-display");
    $("body").addClass("body-visible");
  });
});
$(window).scroll(function () {
  if ($(this).scrollTop() > 50) {
    $('.nav-otr').addClass('top-header-fixed');
  } else {
    $('.nav-otr').removeClass('top-header-fixed');
  }
});
$(window).scroll(function () {
  if ($(this).scrollTop() > 0) {
    $('.home-active').addClass('home');
  } else {
    $('.home-active').removeClass('home');
  }
});
$(document).ready(function () {
  var sectionIds = $('a.a-items');
  $(document).scroll(function () {
    sectionIds.each(function () {
      var container = $(this).attr('href');
      var containerOffset = $(container).offset().top;
      var containerHeight = $(container).outerHeight();
      var containerBottom = containerOffset + containerHeight;
      var scrollPosition = $(document).scrollTop();

      if (scrollPosition < containerBottom - 20 && scrollPosition >= containerOffset - 20) {
        $(this).addClass('active');
      } else {
        $(this).removeClass('active');
      }
    });
  });
}); //Counter up Start Here

$('.counter').counterUp({
  delay: 10,
  time: 1000
}); //Counter up End Here 

var swiper = new Swiper('#team-slider', {
  spaceBetween: 24,
  loop: false,
  slidesPerView: 3,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  breakpoints: {
    0: {
      slidesPerView: 3
    },
    575: {
      slidesPerView: 3
    },
    768: {
      slidesPerView: 3
    },
    992: {
      slidesPerView: 4
    }
  }
});
var swiper = new Swiper('#about_slider', {
  spaceBetween: 12,
  loop: true,
  slidesPerView: 3,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  breakpoints: {
    0: {
      slidesPerView: 3
    },
    575: {
      slidesPerView: 3
    },
    768: {
      slidesPerView: 3
    },
    992: {
      slidesPerView: 4
    }
  }
});

/***/ }),

/***/ "./src/scss/app.scss":
/*!***************************!*\
  !*** ./src/scss/app.scss ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************!*\
  !*** multi ./src/js/app.js ./src/scss/app.scss ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! F:\Abhi\AZA- ventures\src\js\app.js */"./src/js/app.js");
module.exports = __webpack_require__(/*! F:\Abhi\AZA- ventures\src\scss\app.scss */"./src/scss/app.scss");


/***/ })

/******/ });
//# sourceMappingURL=app.js.map