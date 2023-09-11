const audios = new Vue({
    el: '#audios',
    data: function () {
        return {
            isActive: false
        }
    },
    mounted() {
    },
    methods: {
        remove: function (fileName) {
            console.log(fileName);
            axios.delete('/'+app.accountCode+'/audios/' + fileName)
            .then(function () {
                window.location = '/'+app.accountCode+'/audios/'
            });
        }
    }
});