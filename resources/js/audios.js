const audios = new Vue({
    el: '#audios',
    data: function () {
        return {
            isActive: false
        }
    },
    mounted() {
        ///console.log("to aqui no routes");
    },
    methods: {
        remove: function (fileName) {
            axios.delete('/audios/' + fileName)
            .then(function () {
                window.location = '/audios'
            });
        }
    }
});