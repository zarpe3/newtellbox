/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
var routes = new Vue({
  el: '#users',
  data: function data() {
    return {
      isActive: false
    };
  },
  mounted: function mounted() {///console.log("to aqui no users");
  },
  methods: {
    remove: function remove(b64) {
      axios["delete"]('/users/' + b64).then(function () {
        window.location = '/users';
      });
      ;
    }
  }
});
/******/ })()
;