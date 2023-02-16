<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Adicionar Campanha</h3>
                                <p class="text-sm mb-0">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                    </div>
                    <div class="toolbar">
                        <!--Here you can write extra buttons/actions for the toolbar-->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post" autocomplete="off">
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">
                                        Campanha
                                    </label>
                                    <input type="text" name="name" id="input-name" class="form-control" placeholder="Nome da Campanha" value="" required autofocus>
                                </div>
                                <UploadFile :config="config" ></UploadFile>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import UploadFile from '../../components/Shared/UploadFile';
export default {
    components: { UploadFile},
    data() {
        return {
            config: {
                accept:'text/csv',
                extensions: 'csv',
                minSize: 100,
                size: 64000, //3mb
                postAction: `${window.Laravel.baseUrl}mailing/import`,
            }
        }
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
        inputFile: function (newFile, oldFile) {
            if (newFile && oldFile && !newFile.active && oldFile.active) {
                // Get response data
                console.log('response', newFile.response)
                if (newFile.xhr) {
                //  Get the response status code
                console.log('status', newFile.xhr.status)
                }
            }
        },
        inputFilter: function (newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                // Filter non-image file
                if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
                return prevent()
                }
            }

            // Create a blob field
            newFile.blob = ''
            let URL = window.URL || window.webkitURL
            if (URL && URL.createObjectURL) {
                newFile.blob = URL.createObjectURL(newFile.file)
            }
        }
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
