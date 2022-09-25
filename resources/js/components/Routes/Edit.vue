<template>
    <div>
        <div class="row">
            <div class="col-sm-4">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h6 class="mb-0">Adicionar Todos os tipos e DDDs</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-7">
                            <label class="form-control-label" for="trunk">Selecione Tronco</label>
                            <select v-model="trunkAll" name="trunk" id="input-type" class="form-control">
                                <option v-for="d in list.trunks" :value="d">{{d}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="text-middle"><br /></label>
                            <a class="text-middle" href="#" v-on:click="addAll">Adicionar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card data-tables">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h6 class="mb-0">Adicionar Manual DDD e Tipo</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-3">
                            <label class="form-control-label" for="DDD">Selecione DDD</label>
                            <select v-model="ddd" name="ddd" id="input-ddd" class="form-control">
                                <option v-for="d in list.ddds" :value="d.DDD">{{d.DDD}}</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-control-label" for="type">Selecione Tipo</label>
                            <select v-model="type" name="type" id="input-type" class="form-control">
                                <option value="fixo">Fixo</option>
                                <option value="celular">Celular</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-control-label" for="trunk">Selecione Tronco</label>
                            <select v-model="trunk" name="trunk" id="input-type" class="form-control">
                                <option v-for="d in list.trunks" :value="d">{{d}}</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="text-middle"><br /></label>
                            <a class="text-middle" href="#" v-on:click="add">Adicionar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card strpied-tabled-with-hover col-sm-12">
                <div class="card-header">
                    Lista de DDDs e Tipos disponíveis
                </div>
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>DDD</th>
                                <th>Tipo</th>
                                <th>Tronco</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="avail in list.available">
                                <td>{{avail.DDD}}</td>
                                <td>{{avail.type}}</td>
                                <td>{{avail.trunk}}</td>
                                <td><a v-on:click="remove(avail.DDD,avail.type,avail.trunk)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['extradata', 'routes'],
        data() {
            return {
                list: {
                    available: [],
                    trunks: [],
                    ddds: [
                        {'DDD': 11, 'Region': 'São Paulo – SP'},
                        {'DDD': 12, 'Region': 'São José dos Campos – SP'},
                        {'DDD': 13, 'Region': 'Santos – SP'},
                        {'DDD': 14, 'Region': 'Bauru – SP'},
                        {'DDD': 15, 'Region': 'Sorocaba – SP'},
                        {'DDD': 16, 'Region': 'Ribeirão Preto – SP'},
                        {'DDD': 17, 'Region': 'São José do Rio Preto – SP'},
                        {'DDD': 18, 'Region': 'Presidente Prudente – SP'},
                        {'DDD': 19, 'Region': 'Campinas – SP'},
                        {'DDD': 21, 'Region': 'Rio de Janeiro – RJ'},
                        {'DDD': 22, 'Region': 'Campos dos Goytacazes – RJ'},
                        {'DDD': 24, 'Region': 'Volta Redonda – RJ'},
                        {'DDD': 27, 'Region': 'Vila Velha/Vitória – ES'},
                        {'DDD': 28, 'Region': 'Cachoeiro de Itapemirim – ES'},
                        {'DDD': 31, 'Region': 'Belo Horizonte – MG'},
                        {'DDD': 32, 'Region': 'Juiz de Fora – MG'},
                        {'DDD': 33, 'Region': 'Governador Valadares – MG'},
                        {'DDD': 34, 'Region': 'Uberlândia – MG'},
                        {'DDD': 35, 'Region': 'Poços de Caldas – MG'},
                        {'DDD': 37, 'Region': 'Divinópolis – MG'},
                        {'DDD': 38, 'Region': 'Montes Claros – MG'},
                        {'DDD': 41, 'Region': 'Curitiba – PR'},
                        {'DDD': 42, 'Region': 'Ponta Grossa – PR'},
                        {'DDD': 43, 'Region': 'Londrina – PR'},
                        {'DDD': 44, 'Region': 'Maringá – PR'},
                        {'DDD': 45, 'Region': 'Foz do Iguaçú – PR'},
                        {'DDD': 46, 'Region': 'Francisco Beltrão/Pato Branco – PR'},
                        {'DDD': 47, 'Region': 'Joinville – SC'},
                        {'DDD': 48, 'Region': 'Florianópolis – SC'},
                        {'DDD': 49, 'Region': 'Chapecó – SC'},
                        {'DDD': 51, 'Region': 'Porto Alegre – RS'},
                        {'DDD': 53, 'Region': 'Pelotas – RS'},
                        {'DDD': 54, 'Region': 'Caxias do Sul – RS'},
                        {'DDD': 55, 'Region': 'Santa Maria – RS'},
                        {'DDD': 61, 'Region': 'Brasília – DF'},
                        {'DDD': 62, 'Region': 'Goiânia – GO'},
                        {'DDD': 63, 'Region': 'Palmas – TO'},
                        {'DDD': 64, 'Region': 'Rio Verde – GO'},
                        {'DDD': 65, 'Region': 'Cuiabá – MT'},
                        {'DDD': 66, 'Region': 'Rondonópolis – MT'},
                        {'DDD': 67, 'Region': 'Campo Grande – MS'},
                        {'DDD': 68, 'Region': 'Rio Branco – AC'},
                        {'DDD': 69, 'Region': 'Porto Velho – RO'},
                        {'DDD': 71, 'Region': 'Salvador – BA'},
                        {'DDD': 73, 'Region': 'Ilhéus – BA'},
                        {'DDD': 74, 'Region': 'Juazeiro – BA'},
                        {'DDD': 75, 'Region': 'Feira de Santana – BA'},
                        {'DDD': 77, 'Region': 'Barreiras – BA'},
                        {'DDD': 79, 'Region': 'Aracaju – SE'},
                        {'DDD': 81, 'Region': 'Recife – PE'},
                        {'DDD': 82, 'Region': 'Maceió – AL'},
                        {'DDD': 83, 'Region': 'João Pessoa – PB'},
                        {'DDD': 84, 'Region': 'Natal – RN'},
                        {'DDD': 85, 'Region': 'Fortaleza – CE'},
                        {'DDD': 86, 'Region': 'Teresina – PI'},
                        {'DDD': 87, 'Region': 'Petrolina – PE'},
                        {'DDD': 88, 'Region': 'Juazeiro do Norte – CE'},
                        {'DDD': 89, 'Region': 'Picos – PI'},
                        {'DDD': 91, 'Region': 'Belém – PA'},
                        {'DDD': 92, 'Region': 'Manaus – AM'},
                        {'DDD': 93, 'Region': 'Santarém – PA'},
                        {'DDD': 94, 'Region': 'Marabá – PA'},
                        {'DDD': 95, 'Region': 'Boa Vista – RR'},
                        {'DDD': 96, 'Region': 'Macapá – AP'},
                        {'DDD': 97, 'Region': 'Coari – AM'},
                        {'DDD': 98, 'Region': 'São Luís – MA'},
                        {'DDD': 99, 'Region': 'Imperatriz – MA'}
                    ]
                },
                ddd: null,
                type: null,
                trunk: null,
                trunkAll: null,
            }
        },
        mounted() {
            let response = JSON.parse(this.extradata);
            let trunks = Object.keys(response.response);
            let me = this;
            trunks.forEach(function (name) {
                me.list.trunks.push(response.response[name].trunkName);
            });
            
            let routes = JSON.parse(this.routes);
            routes.forEach(function (route) {
                me.list.available.push({ DDD: route.ddd, type: route.type, trunk: route.trunk});
            });
            this.setValue();
            ///
        },
        created() {

        },
        methods: {
            add: function () {
                let element = this.list.available.find( el => {
                    return (el.DDD == this.ddd && el.type == this.type && el.trunk == this.trunk);
                });
                if (element == undefined) {
                    this.list.available.push({ DDD: this.ddd, type: this.type, trunk: this.trunk});
                }
                this.setValue();
            },
            addAll: function () {
                
                if (this.trunkAll != null) {
                    this.list.available = [];
                    this.list.ddds.forEach((el) => {
                        this.list.available.push({ DDD: el.DDD, type: 'fixo', trunk: this.trunkAll});
                        this.list.available.push({ DDD: el.DDD, type: 'celular', trunk: this.trunkAll});
                    });
                }
                this.setValue();
            },
            remove: function(ddd,type,trunk) {
                this.list.available = this.list.available.filter( el => {
                    return (el.DDD != ddd || el.type != type || el.trunk != trunk);
                });
                this.setValue();
            },
            setValue: function() {
                document.getElementById('infos').value = btoa(JSON.stringify(this.list.available));
            }
            
            
        }
    }
</script>