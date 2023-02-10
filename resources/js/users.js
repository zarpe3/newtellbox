const routes = new Vue({
    el: '#users',
    data: function () {
        return {
            isActive: false,
            name: '',
            b64: '',

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
        dismiss: function() {
            $('#confirmation').modal('hide');
        },
        modalRemove: function(b64) {
            this.b64 = b64;
            let data = JSON.parse(atob(b64));
            this.name = data.name;
            $('#confirmation').modal('show');
        },
        confirmRemove: function() {
            this.remove(this.b64);
        }

    }
});