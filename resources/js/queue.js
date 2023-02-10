const routes = new Vue({
    el: '#queue',
    data: function () {
        return {
            isActive: false,
            name: '',
            id: '',

        }
    },
    mounted() {
        ///console.log("to aqui no users");
    },
    methods: {
        remove: function (id) {
            axios.delete('/queue/' + id)
            .then(function () {
                window.location = '/queue'
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
            this.id = data.id;
            $('#confirmation').modal('show');
        },
        confirmRemove: function() {
            this.remove(this.id);
        }

    }
});