/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/audios.js ***!
  \********************************/
var audios = new Vue({
  el: '#audios',
  data: function data() {
    return {
      isActive: false
    };
  },
  mounted: function mounted() {},
  methods: {
    remove: function remove(fileName) {
      console.log(fileName);
      axios["delete"]('/' + app.accountCode + '/audios/' + fileName).then(function () {
        window.location = '/' + app.accountCode + '/audios/';
      });
    }
  }
});
/******/ })()
;