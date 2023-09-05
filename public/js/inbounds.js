/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/inbounds.js ***!
  \**********************************/
var inbounds = new Vue({
  el: '#inbounds',
  data: function data() {
    return {
      destiny_type: '',
      destiny_value: '',
      elements: []
    };
  },
  mounted: function mounted() {//console.log(this.extens);
  },
  methods: {
    changeType: function changeType() {
      this.destiny_type = document.getElementById("destiny_type").value;
      this.elements = [];

      if (this.destiny_type == 'ramal') {
        this.elements.push(this.extens.filter(function (exten) {
          return [{
            name: exten.name,
            value: exten.name
          }];
        }));
      }

      console.log(this.elements);
    },
    remove: function remove(b64) {
      console.log(b64);
      axios["delete"]('inbound/' + b64).then(function () {
        location.reload();
      });
      ;
    }
  }
});
/******/ })()
;