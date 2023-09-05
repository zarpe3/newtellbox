const audios = new Vue({
    el: '#ivrs',
    data: function () {
        return {}
    },
    mounted() {
    },
    methods: {
        remove: function (id) {
            axios.delete('ivr/' + id)
            .then(function () {
                window.location = 'ivr'
            });
        }
    }
});