const audios = new Vue({
    el: '#ivrs',
    data: function () {
        return {}
    },
    mounted() {
    },
    methods: {
        remove: function (id) {
            axios.delete('/'+app.accountCode+'/ivr/' + id)
            .then(function () {
                window.location = '/'+app.accountCode+'/ivr';
            });
        }
    }
});