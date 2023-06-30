/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/ivrs.js ***!
  \******************************/
var audios = new Vue({
  el: '#ivrs',
  data: function data() {
    return {};
  },
  mounted: function mounted() {},
  methods: {
    remove: function remove(id) {
      axios["delete"]('/ivr/' + id).then(function () {
        window.location = '/ivr';
      });
    }
  }
});
/******/ })()
;