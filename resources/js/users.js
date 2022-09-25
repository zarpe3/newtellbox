const routes = new Vue({
    el: '#users',
    data: function () {
        return {
            isActive: false
        }
    },
    mounted() {
        ///console.log("to aqui no users");
    },
    methods: {
        remove: function (b64) {
            axios.delete('/users/' + b64)
            .then(function () {
                window.location = '/users'
            });
            ;
        },
    }
});