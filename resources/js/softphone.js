const app = new Vue({
    el: '#softphone',
    data: function() {
        return {
            isActive: false
        }
    },
    mounted() {
        
    },
    methods: {
        showSoftphone: function() {
            this.isActive = !this.isActive;
        },   
        dtmf: function(key) {
            console.log(key);
        }
    }
});
