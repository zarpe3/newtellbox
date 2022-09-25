const trunks = new Vue({
    el: '#trunks',
    data: function () {
        return {
            isActive: false
        }
    },
    mounted() {
        ///console.log("to aqui no routes");
    },
    methods: {
        remove: function (b64) {
            axios.delete('/trunks/' + b64)
            .then(function () {
                window.location = '/trunks'
            });
            ;
        },
    }
});