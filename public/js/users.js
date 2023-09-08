/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
var routes = new Vue({
  el: '#users',
  data: function data() {
    return {
      isActive: false,
      name: '',
      b64: ''
    };
  },
  mounted: function mounted() {///console.log("to aqui no users");
  },
  methods: {
    remove: function remove(b64) {
      axios["delete"]('users/' + b64).then(function () {
        window.location = 'users';
      });
      ;
    },
    dismiss: function dismiss() {
      $('#confirmation').modal('hide');
    },
    modalRemove: function modalRemove(b64) {
      this.b64 = b64;
      var data = JSON.parse(atob(b64));
      this.name = data.name;
      $('#confirmation').modal('show');
    },
    confirmRemove: function confirmRemove() {
      this.remove(this.b64);
    }
  }
});
/******/ })()
;