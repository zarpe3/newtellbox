const routes = new Vue({
    el: '#voicemail',
    data: function() {
        return {
            params: true,
            voicemails: false,

        }
    },
    mounted() {
        ///console.log("to aqui no voicemail");
    },
    methods: {
        showParams: function() {
            this.params = true;
            this.voicemails = false;
        },
        showVoicemails: function() {
            this.params = false;
            this.voicemails = true;
        }
    }
});