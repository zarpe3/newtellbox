/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/trunks.js ***!
  \********************************/
var trunks = new Vue({
  el: '#trunks',
  data: function data() {
    return {
      isActive: false,
      trunkName: '',
      b64: ''
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
    },
    modalDelete: function modalDelete(b64) {
      this.trunkName = atob(b64);
      this.b64 = b64;
      $('#confirmation').modal('show');
    },
    confirmRemove: function confirmRemove() {
      this.remove(this.b64);
    },
    dismiss: function dismiss() {
      $('#confirmation').modal('hide');
    }
  }
});
/******/ })()
;