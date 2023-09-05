/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/queue.js ***!
  \*******************************/
var routes = new Vue({
  el: '#queue',
  data: function data() {
    return {
      isActive: false,
      name: '',
      id: ''
    };
  },
  mounted: function mounted() {///console.log("to aqui no users");
  },
  methods: {
    remove: function remove(id) {
      axios["delete"]('queue/' + id).then(function () {
        window.location = 'queue';
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
      this.id = data.id;
      $('#confirmation').modal('show');
    },
    confirmRemove: function confirmRemove() {
      this.remove(this.id);
    }
  }
});
/******/ })()
;