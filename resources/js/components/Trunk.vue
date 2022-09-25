<template>
    <div>
        <div v-show="list" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables">

                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Troncos</h3>
                                    <p class="text-sm mb-0">
                                        Pagina para configuração e criação de troncos
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <a v-on:click="addShow" class="btn btn-sm btn-default">Add Tronco</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                        </div>

                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr><th>Name</th>
                                        <th>Type</th>
                                        <th>Host</th>
                                        <th>Actions</th>
                                    </tr></thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Host</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody v-for="trunk in trunks">
                                    <tr>
                                        <td>{{ trunk.trunkName }}</td>
                                        <td>{{ trunk.type }}</td>
                                        <td>{{ trunk.host }}</td>
                                        <td class="d-flex justify-content-end">
                                            <a v-on:click="editTrunk(trunk.trunkName)"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-show="edit" class="container-fluid">
            <div class="row">
                
                <div class="card data-tables">
                    <div class="card-body table-full-width table-responsive">
                        <div class="container">
                            <button v-on:click="save()" class="btn btn-success">Salvar</button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr><th>Label</th>
                                    <th>Field</th>
                                    <th>Desc</th>
                                </tr></thead>
                            <tbody>
                                <tr v-for="field in fields">
                                    <td>{{ field.name }}</td>
                                    <td>
                                        <input v-if="field.type == 'string'" type="text" name="field.name" v-model="trunk[field.name]" id="field.name" class="form-control" placeholder="" value="" required="">
                                        <select v-if="Array.isArray(field.type)" name="field.name" v-model="trunk[field.name]" id="field.name" class="form-control">
                                            <option v-for="t in field.type">{{ t }}</option>
                                        </select>    
                                    </td>
                                    <td style="font-size: 8px; color: #666;">
                                        {{ field.description }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="container">
                            <button v-on:click="save()" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="add" class="container-fluid">
            <div class="row">
                
                <div class="card" style="width: 70%;">
                    <div class="card-body">
                        <div class="container">
                            <button v-on:click="save()" class="btn btn-success">Salvar</button>
                        </div>
                         <div class="form-group has-label">
                             <label> Trunk Name </label>
                             <input type="text" name="trunkName" v-model="trunk.trunkName" id="trunkName" class="form-control" placeholder="" value="" required="">  
                             
                         </div>
                        <div v-for="field in fields" class="form-group has-label">
                            <label> {{ field.name }} </label>
                            <input v-if="field.type == 'string'" type="text" name="field.name" v-model="trunk[field.name]" id="field.name" class="form-control" placeholder="" value="" required="">
                            <select v-if="Array.isArray(field.type)" name="field.name" v-model="trunk[field.name]" id="field.name" class="form-control">
                                <option v-for="t in field.type">{{ t }}</option>
                            </select> 
                        </div>
                        <!--<table class="table table-striped">
                            <thead>
                                <tr><th>Label</th>
                                    <th>Field</th>
                                    <!--<th>Desc</th>-->
                                <!--</tr></thead>
                            <tbody>
                                <tr>
                                    <td style="background: #48d4b4">Trunk Name</td>
                                    <td colspan="2" style="background: #1e64d2;">
                                        <input type="text" name="trunkName" v-model="trunk.trunkName" id="trunkName" class="form-control" placeholder="" value="" required="">  
                                    </td>
                                </tr>
                                <tr v-for="field in fields">
                                    <td>{{ field.name }}</td>
                                    <td>
                                        <input v-if="field.type == 'string'" type="text" name="field.name" v-model="trunk[field.name]" id="field.name" class="form-control" placeholder="" value="" required="">
                                        <select v-if="Array.isArray(field.type)" name="field.name" v-model="trunk[field.name]" id="field.name" class="form-control">
                                            <option v-for="t in field.type">{{ t }}</option>
                                        </select>    
                                    </td>
                                    <!--<td style="font-size: 8px; color: #666;">
                                        {{ field.description }}
                                    </td>-->
                                <!--</tr>
                            </tbody>
                        </table>-->
                        <div class="container">
                            <button v-on:click="save()" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {  
        data() {
            return {
                list: true,
                edit: false,
                add: false,
                trunks: [],
                trunk: {
                    accountcode: '',
                    allow: '',
                    disallow: '',
                    allowguest: '',
                    auth: '',
                    callerid: '',
                    canreinvite: '',
                    context: '',
                    defaultip: '',
                    defaultuser: '',
                    directrtpsetup: '',
                    dtmfmode: '',
                    fromuser: '',
                    fromdomain: '',
                    host: '',
                    insecure: '',
                    nat: '',
                    permit: '',
                    port: '',
                    progressinband: '',
                    qualify: '',
                    secret: '',
                    sendrpid: '',
                    setvar: '',
                    code: '',
                    trustrpid: '',
                    type: '',
                    username: '',
                    trunkName: '',
                },
                fields: [],
            }
        },
        mounted() {
            axios.get('http://webdec-dev03.webdec.com.br/trunks/fields')
            .then(res => {
                this.fields = res.data.response;
                Object.keys(this.fields).forEach((key) => {
                    if (this.fields[key].type.includes("|")) {
                        let types = this.fields[key].type.split("|");
                        this.fields[key].type = types;
                    }
                });
        
            }).catch(err => {
                console.log(err)
            });
            axios.post('http://webdec-dev03.webdec.com.br/trunks/list', {accountcode: this.$root.$data.accountCode})
            .then(res => {
                this.trunks = res.data.response;
            }).catch(err => {
                console.log(err)
            })
        },
        methods: {
            addShow: function() {
                console.log("Adicionar novo tronco");
                this.list = false;
                this.edit = false;
                this.add = true;
            },
            editTrunk: function (trunkName) {
                this.resetTrunk();
                this.list = false;
                this.edit = true;
                this.setTrunk(this.trunks[trunkName+"_"+this.$root.$data.accountCode]);
            },
            resetTrunk: function() {
                Object.keys(this.trunk).forEach((key) => {
                    this.trunk[key] = '';
                });
            },
            setTrunk: function(t) {
                Object.keys(this.trunk).forEach((key) => {
                    this.trunk[key] = t[key];
                });
            },
            save() {
                //console.log(this.trunk);
                axios.post('http://webdec-dev03.webdec.com.br/trunks/save', {trunk: this.trunk, accountcode: this.$root.$data.accountCode})
                .then(function (response) {
                    window.location='/trunks';
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
            
        }
    }
</script>
