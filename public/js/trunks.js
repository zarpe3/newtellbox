/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/trunks.js ***!
  \********************************/
var trunks = new Vue({
  el: '#trunks',
  data: function data() {
    return {
      isActive: false
    };
  },
  mounted: function mounted() {///console.log("to aqui no routes");
  },
  methods: {
    remove: function remove(b64) {
      axios["delete"]('/trunks/' + b64).then(function () {
        window.location = '/trunks';
      });
      ;
    }
  }
});
/******/ })()
;