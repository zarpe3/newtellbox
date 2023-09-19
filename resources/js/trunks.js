const trunks = new Vue({
    el: '#trunks',
    data: function () {
        return {
            isActive: false,
            trunkName: '',
            b64: '',
        }
    },
    mounted() {
        ///console.log("to aqui no routes");
    },
    methods: {
        remove: function (b64) {
            axios.delete('/'+app.accountCode+'/trunks/' + b64)
            .then(function () {
                window.location = '/'+app.accountCode+'/trunks'
            });
            ;
        },
        modalDelete: function(b64) {
            this.trunkName = atob(b64);
            this.b64 = b64;
            $('#confirmation').modal('show');
        },
        confirmRemove: function() {
            this.remove(this.b64);
        },
        dismiss: function() {
            $('#confirmation').modal('hide'); 
        }
    }
});