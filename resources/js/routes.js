const routes = new Vue({
    el: '#routes',
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
            axios.delete('/routes/' + b64)
            .then(function () {
                window.location = '/routes'
            });
            ;
        },
    }
});