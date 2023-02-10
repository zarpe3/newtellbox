/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/voicemail.js ***!
  \***********************************/
var routes = new Vue({
  el: '#voicemail',
  data: function data() {
    return {
      params: true,
      voicemails: false
    };
  },
  mounted: function mounted() {///console.log("to aqui no voicemail");
  },
  methods: {
    showParams: function showParams() {
      this.params = true;
      this.voicemails = false;
    },
    showVoicemails: function showVoicemails() {
      this.params = false;
      this.voicemails = true;
    }
  }
});
/******/ })()
;