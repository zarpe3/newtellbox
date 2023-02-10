const inbounds = new Vue({
    el: '#inbounds',
    data: function () {
        return {
            extens: extensData,
            destiny_type: '',
            destiny_value: '',
            elements: [],
        }
    },
    mounted() {
        console.log(this.extens);
    },
    methods: {
        changeType: function() {
            this.destiny_type = document.getElementById("destiny_type").value;
            this.elements = [];
            if (this.destiny_type == 'ramal') {
                this.elements.push(this.extens.filter(function(exten) {
                    return [{name: exten.name, value: exten.name}];
                }));
            }
            console.log(this.elements);
        },
        remove: function (b64) {
            console.log(b64);
            return;
            axios.delete('/inbounds/' + b64)
            .then(function () {
                window.location = '/inbounds'
            });
            ;
        },
    }
});