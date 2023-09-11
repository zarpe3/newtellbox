<template>
    <div>
    
        <div class="modal fade modal-large modal-primary" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="modal-profile">
                            <i class="fa fa-trash"></i>
                        </div>
                    </div>
                    <div class="modal-body text-center">
                        <p>Você tem certeza de que deseja remover o ramal {{ deleteMe }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" v-on:click="dismiss()" class="btn btn-link btn-simple">Não</button>
                        <button type="button" v-on:click="confirmRemove()" class="btn btn-link btn-simple" data-dismiss="modal">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    
    
    
        <div v-show="list" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables">
    
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Ramais</h3>
                                    <p class="text-sm mb-0">
                                        Pagina para configuração e criação de ramais
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <a v-on:click="addShow" class="btn btn-sm btn-default">Adicionar</a>
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
                                    <tr>
                                        <th>Ramal</th>
                                        <th>IP</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody v-for="exten in extens">
                                    <tr>
                                        <td>{{ exten.name.substr(exten.accountcode.length, 4) }}</td>
                                        <td>{{ exten.ipaddr }}</td>
                                        <td class="d-flex">
                                            <a v-on:click="editExten(exten.name)"><i class="fa fa-edit"></i></a>
                                            <a style="color: red;" v-on:click="remove(exten.name)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!--<div v-show="edit" class="container-fluid">
                        <div class="row">
                            
                            <div class="card data-tables">
                                <div class="card-body table-full-width table-responsive">
                                    <div class="container">
                                        <button v-on:click="back()" class="btn btn-warning">Voltar</button> - 
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
                                                    <input v-if="field.type == 'string'" type="text"  v-model="exten[field.name]"  class="form-control" placeholder="" value="" required="">
                                                    <input v-if="field.type == 'password'" type="password"  v-model="exten[field.name]"  class="form-control" placeholder="" value="" required="">
                                                    <input v-if="field.type == 'number'" type="number" :max="field.max" :min="field.min" :step="field.step" v-model="exten[field.name]"  class="form-control" placeholder="" value="" required="">
                                                    <select v-if="Array.isArray(field.type)" v-model="exten[field.name]" id="field.name" class="form-control">
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
                    </div>-->
        <div v-show="edit" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="width: 90%">
                        <div class="card-header">
                            <h4 class="card-title">Editar ramal</h4>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <button v-on:click="back()" class="btn btn-warning">Voltar</button> -
                                <button v-on:click="save()" :disabled="isDisabled" class="btn btn-success">Salvar</button>
                            </div>
                            <div class="row">
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>Ramal</label>
                                        <input type="number" min="1000" required="required" max="9999" v-model="exten.name" class="form-control" placeholder="Ramal">
                                    </div>
                                </div>
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>Rota de Saida</label>
                                        <select class="form-control" v-model="exten.context_to">
                                            <option v-for="route in routes" :selected="route.name == exten.context_to"
                                                v-bind:value="route.name">
                                                {{ route.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 px-1">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" v-model="exten.secret" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Transporte</label>
                                        <select class="form-control" v-model="exten.transport">
                                            <option value='udp'>UDP</option>
                                            <option value='tcp'>TCP</option>
                                            <option value='udp,tcp'>UDP,TCP</option>
                                            <option value='tcp,udp'>TCP,UDP</option>
                                            <option value='tls'>TLS</option>
                                            <option value='tls,udp,tcp'>TLS,UDP,TCP</option>
                                            <option value='ws,wss,udp'>ws,wss,udp</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group">
                                        <label for="record">Grava</label>
                                        <select class="form-control" v-model="exten.record">
                                            <option value='0'>Não</option>
                                            <option value='1'>Sim</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label>WebRtc</label>
                                        <select class="form-control" v-model="exten.webrtc">
                                            <option value='yes'>Sim</option>
                                            <option value='no'>Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>DTLSPRIVATEKEY</label>
                                                    <input type="text" class="form-control" placeholder="/path/to/file" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>DTLSCERTFILE</label>
                                                    <input type="text" class="form-control" placeholder="/path/to/file" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>DTLSENABLE</label>
                                                    <select class="form-control" v-model="exten.dtlsenable">
                                                        <option value='yes'>Sim</option>
                                                        <option value='no'>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>DTLSVERIFY</label>
                                                    <input type="text" class="form-control" v-model="exten.dtlsverify"
                                                        placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label>DTLSSETUP</label>
                                                    <input type="text" v-model="exten.dtlssetup" class="form-control"
                                                        placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>RTCP_MUX</label>
                                                    <input type="text" v-model="exten.rtcp_mux" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>ICESUPPORT</label>
                                                    <select class="form-control" v-model="exten.icesupport">
                                                        <option value='yes'>Sim</option>
                                                        <option value='no'>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label>AVPF</label>
                                                    <input type="text" v-model="exten.avpf" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>-->
                            <button v-on:click="save()" :disabled="isDisabled" class="btn btn-success pull-right">Salvar</button>
                            <div clas="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="add" class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card" style="width: 90%">
                        <div class="card-header">
                            <h4 class="card-title">Adicionar ramal</h4>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <button v-on:click="back()" class="btn btn-warning">Voltar</button> -
                                <button v-on:click="save()" :disabled="isDisabled" class="btn btn-success">Salvar</button>
                            </div>
                            <div class="row">
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>Ramal</label>
                                        <input type="text" v-model="exten.name" class="form-control" placeholder="Ramal">
                                    </div>
                                </div>
                                <div class="col-md-5 pr-1">
                                    <div class="form-group">
                                        <label>Rota de Saida</label>
                                        <select class="form-control" v-model="exten.context_to">
                                            <option v-for="route in routes" v-bind:value="route.name">
                                                {{ route.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 px-1">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" v-model="exten.secret" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-4 pl-1">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Transporte</label>
                                        <select class="form-control" v-model="exten.transport">
                                            <option value='udp'>UDP</option>
                                            <option value='tcp'>TCP</option>
                                            <option value='udp,tcp'>UDP,TCP</option>
                                            <option value='tcp,udp'>TCP,UDP</option>
                                            <option value='tls'>TLS</option>
                                            <option value='tls,udp,tcp'>TLS,UDP,TCP</option>
                                            <option value='ws,wss,udp'>ws,wss,udp</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <div class="form-group">
                                        <label>WebRtc</label>
                                        <select class="form-control" v-model="exten.webrtc">
                                            <option value='yes'>Sim</option>
                                            <option value='no'>Não</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>DTLSPRIVATEKEY</label>
                                                    <input type="text" class="form-control" placeholder="/path/to/file" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>DTLSCERTFILE</label>
                                                    <input type="text" class="form-control" placeholder="/path/to/file" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>DTLSENABLE</label>
                                                    <select class="form-control" v-model="exten.dtlsenable">
                                                        <option value='yes'>Sim</option>
                                                        <option value='no'>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>DTLSVERIFY</label>
                                                    <input type="text" class="form-control" v-model="exten.dtlsverify"
                                                        placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label>DTLSSETUP</label>
                                                    <input type="text" v-model="exten.dtlssetup" class="form-control"
                                                        placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 pr-1">
                                                <div class="form-group">
                                                    <label>RTCP_MUX</label>
                                                    <input type="text" v-model="exten.rtcp_mux" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <div class="form-group">
                                                    <label>ICESUPPORT</label>
                                                    <select class="form-control" v-model="exten.icesupport">
                                                        <option value='yes'>Sim</option>
                                                        <option value='no'>Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label>AVPF</label>
                                                    <input type="text" v-model="exten.avpf" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>-->
                            <button v-on:click="save()" :disabled="isDisabled" class="btn btn-success pull-right">Salvar</button>
                            <div clas="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    Tutorial
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['extradata', 'extraroutes'],
    data() {
        return {
            list: true,
            edit: false,
            add: false,
            deleteMe: null,
            extens: [],
            routes: [],
            exten: {
                name: '',
                ipaddr: '',
                port: '',
                regseconds: '',
                defaultuser: '',
                fullcontact: '',
                regserver: '',
                useragent: '',
                lastms: '',
                host: '',
                type: '',
                context: 'outgoing',
                permit: '',
                deny: '',
                secret: '',
                md5secret: '',
                transport: '',
                dtmfmode: '',
                directmedia: '',
                nat: '',
                callgroup: '',
                pickupgroup: '',
                language: '',
                allow: '',
                disallow: '',
                insecure: '',
                trustrpid: '',
                progressinband: '',
                accountcode: '',
                setvar: '',
                callerid: '',
                callcounter: '',
                busylevel: '',
                allowoverlap: '',
                allowsubscribe: '',
                videosupport: '',
                regexten: '',
                fromdomain: '',
                fromuser: '',
                qualify: '',
                defaultip: '',
                auth: '',
                parkinglot: '',
                'call-limit': '',
                dtlsenable: '',
                dtlsverify: '',
                dtlsprivatekey: '',
                dtlscertfile: '',
                dtlssetup: '',
                rtcp_mux: '',
                icesupport: '',
                avpf: '',
                context_to: '',
                record: '',
                webrtc: '',
            },
            fields: [
                { 'name': 'name', 'type': 'number', 'description': '', min: 1000, max: 9999, step: 1, 'add': true, readonly: true },
                { 'name': 'ipaddr', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'port', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'regseconds', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'defaultuser', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'fullcontact', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'regserver', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'useragent', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'lastms', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'host', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'type', 'type': ['friend'], 'description': '', 'add': false },
                { 'name': 'context_to', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'permit', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'deny', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'secret', 'type': 'password', 'description': '', 'add': true },
                { 'name': 'md5secret', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'transport', 'type': ['udp', 'tcp', 'udp,tcp', 'tcp,udp', 'tls', 'tls,udp,tcp', 'ws,wss,udp'], 'description': '', 'add': true },
                { 'name': 'dtmfmode', 'type': ['inband', 'info', 'rfc2833'], 'description': '', 'add': false },
                { 'name': 'directmedia', 'type': ['yes', 'no'], 'description': '', 'add': false },
                { 'name': 'nat', 'type': ['force_rport,comedia', 'yes', 'no'], 'description': '', 'add': false },
                { 'name': 'callgroup', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'pickupgroup', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'language', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'allow', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'disallow', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'insecure', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'trustrpid', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'progressinband', 'type': ['yes', 'no'], 'description': '', 'add': false },
                { 'name': 'accountcode', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'setvar', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'callerid', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'callcounter', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'busylevel', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'allowoverlap', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'allowsubscribe', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'videosupport', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'regexten', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'fromdomain', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'fromuser', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'qualify', 'type': ['yes', 'no'], 'description': '', 'add': false },
                { 'name': 'defaultip', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'auth', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'parkinglot', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'call-limit', 'type': 'string', 'description': '', 'add': false },
                { 'name': 'dtlsenable', 'type': ['yes', 'no'], 'description': '', 'add': true },
                { 'name': 'dtlsverify', 'type': 'string', 'description': '', 'add': true },
                { 'name': 'dtlsprivatekey', 'type': 'string', 'description': '', 'add': true },
                { 'name': 'dtlscertfile', 'type': 'string', 'description': '', 'add': true },
                { 'name': 'dtlssetup', 'type': 'string', 'description': '', 'add': true },
                { 'name': 'rtcp_mux', 'type': 'string', 'description': '', 'add': true },
                { 'name': 'icesupport', 'type': ['yes', 'no'], 'description': '', 'add': true },
                { 'name': 'avpf', 'type': 'string', 'description': '', 'add': true }
            ],
        }
    },
    mounted() {
        this.routes = this.extraroutes;
        /*this.extraroutes.forEach((route) => {
            this.routes.push(route);
        });*/
        this.extens = this.extradata;
    },
    created() {

    },
    computed: {
        isDisabled() {

            if (isNaN(parseInt(this.exten.name))) {
                return true;
            }

            if (parseInt(this.exten.name) < 1000) {
                return true;
            }

            if (parseInt(this.exten.name) > 9999) {
                return true;
            }

            return false;
        },
    },
    methods: {
        confirmRemove: function() {
            axios.delete('extens/' + this.deleteMe)
                .then(function() {
                    window.location = 'extens'
                });;

        },
        dismiss: function() {
            this.deleteMe = null;
            $('#confirmation').modal('hide');
        },
        remove: function(name) {
            this.deleteMe = name
            $('#confirmation').modal('show');
        },
        addShow: function() {
            this.resetExten();
            this.list = false;
            this.edit = false;
            this.add = true;
        },
        listShow: function() {
            this.list = true;
            this.edit = false;
            this.add = false;
        },
        editShow: function() {
            this.list = false;
            this.add = false;
            this.edit = true;
        },
        editExten: function(name) {
            this.resetExten();
            this.list = false;
            this.edit = true;
            this.setExten(name);
        },
        resetExten: function() {
            Object.keys(this.exten).forEach((key) => {
                this.exten[key] = '';
            });
        },
        setExten: function(e) {
            this.resetExten();
            this.extens.forEach((ext, index) => {
                if (ext.name == e) {
                    this.exten = ext;

                    this.exten.defaultuser = this.exten.name.substr(this.exten.accountcode.length, 4);
                    this.exten.callerid = this.exten.name.substr(this.exten.accountcode.length, 4);
                    this.exten.name = this.exten.name.substr(this.exten.accountcode.length, 4);
                    if (this.exten.icesupport === 'yes') {
                        this.exten.webrtc = 'yes';
                    } else {
                        this.exten.webrtc = 'no';
                    }

                }
            });
            if (this.exten.name != '') {
                this.editShow();
            }
        },
        save() {

            if (isNaN(parseInt(this.exten.name))) {
                return true;
            }

            if (parseInt(this.exten.name) < 1000) {
                return true;
            }

            if (parseInt(this.exten.name) > 9999) {
                return true;
            }

            let me = this;
            axios.post('extens', this.exten)
                .then(function(response) {
                    window.location = 'extens';
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        back: function() {
            location.reload();
        }

    }
}
</script>
