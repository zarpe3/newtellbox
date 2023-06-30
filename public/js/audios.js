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
  mounted: function mounted() {///console.log("to aqui no routes");
  },
  methods: {
    remove: function remove(fileName) {
      axios["delete"]('/audios/' + fileName).then(function () {
        window.location = '/audios';
      });
    }
  }
});
/******/ })()
;