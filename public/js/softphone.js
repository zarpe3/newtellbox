/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/softphone.js ***!
  \***********************************/
var app = new Vue({
  el: '#softphone',
  data: function data() {
    return {
      isActive: false
    };
  },
  mounted: function mounted() {},
  methods: {
    showSoftphone: function showSoftphone() {
      this.isActive = !this.isActive;
    },
    dtmf: function dtmf(key) {
      console.log(key);
    }
  }
});
/******/ })()
;