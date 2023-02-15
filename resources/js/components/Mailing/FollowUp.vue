<template>
    <div>
        <h1>vue FollowUp</h1>
    </div>
</template>
<script>
    export default {  
        data() {
            return {}
        },
        mounted() {
            // axios.get('http://webdec-dev03.webdec.com.br/trunks/fields')
            // .then(res => {
            //     this.fields = res.data.response;
            //     Object.keys(this.fields).forEach((key) => {
            //         if (this.fields[key].type.includes("|")) {
            //             let types = this.fields[key].type.split("|");
            //             this.fields[key].type = types;
            //         }
            //     });
        
            // }).catch(err => {
            //     console.log(err)
            // });
            // axios.post('http://webdec-dev03.webdec.com.br/trunks/list', {accountcode: this.$root.$data.accountCode})
            // .then(res => {
            //     this.trunks = res.data.response;
            // }).catch(err => {
            //     console.log(err)
            // })
        }, 
        methods: {
            // addShow: function() {
            //     console.log("Adicionar novo tronco");
            //     this.list = false;
            //     this.edit = false;
            //     this.add = true;
            // },
            // editTrunk: function (trunkName) {
            //     this.resetTrunk();
            //     this.list = false;
            //     this.edit = true;
            //     this.setTrunk(this.trunks[trunkName+"_"+this.$root.$data.accountCode]);
            // },
            // resetTrunk: function() {
            //     Object.keys(this.trunk).forEach((key) => {
            //         this.trunk[key] = '';
            //     });
            // },
            // setTrunk: function(t) {
            //     Object.keys(this.trunk).forEach((key) => {
            //         this.trunk[key] = t[key];
            //     });
            // },
            // save() {
            //     //console.log(this.trunk);
            //     axios.post('http://webdec-dev03.webdec.com.br/trunks/save', {trunk: this.trunk, accountcode: this.$root.$data.accountCode})
            //     .then(function (response) {
            //         window.location='/trunks';
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });
            // }
            
        }
    }
</script>
