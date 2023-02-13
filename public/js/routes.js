/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/routes.js ***!
  \********************************/
var routes = new Vue({
  el: '#routes',
  data: function data() {
    return {
      isActive: false
    };
  },
  mounted: function mounted() {
    ///console.log("to aqui no routes");
  },
  methods: {
    remove: function remove(b64) {
      axios["delete"]('/routes/' + b64).then(function () {
        window.location = '/routes';
      });
      ;
    }
  }
});
/******/ })()
;