<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">
                    <div id="app" class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Campanhas</h3>
                                <p class="text-sm mb-0">
                                    Gerenciamento de Campanhas
                                </p>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                    </div>
                    <div class="toolbar">
                        <!--Here you can write extra buttons/actions for the toolbar-->
                    </div>
                    <div v-if="data.length !== 0"
                    id="users" class="card-body table-full-width table-responsive"> 
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li :class="prevClass">
                                    <a class="page-link" @click="prev">Anterior</a>
                                </li>
                                <li :class="nextClass">
                                    <a class="page-link" @click="next">Próximo</a>
                                </li>
                            </ul>
                        </nav>                 
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Campanha</th>
                                    <th>Status</th>
                                    <th>Tamanho</th>
                                    <th>Sucesso</th>
                                    <th>Falhas</th>
                                    <th>Erros</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in data" :key="item.id">
                                    <td>{{item.campaign_name}}</td>
                                    <td>{{item.status}}</td>
                                    <td>{{item.size}}</td>
                                    <td>{{item.success}}</td>
                                    <td>{{item.fail}}</td>
                                    <td>
                                        <a v-if="item.errors !== 0" :href="url + '?file_path_error=' + endpoint(item.file_path_error)">
                                            {{item.errors}}
                                        </a>
                                    </td>
                                </tr>                               
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li :class="prevClass">
                                    <a class="page-link" @click="prev">Anterior</a>
                                </li>
                                <li :class="nextClass">
                                    <a class="page-link" @click="next">Próximo</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div v-else style="padding: 10px;">
                        <div v-if="showNoRegister" class="alert alert-primary" role="alert">
                            Nenhum registro localizado
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
                data : [],
                url: `${window.Laravel.baseUrl}mailing-export-error`,
                showNoRegister: false,
                next_page_url: 1,
                prev_page_url: null,
                nextClass : this.next_page_url == null ? 'page-item disabled' : 'page-item',
                prevClass : this.prev_page_url == null ? 'page-item disabled' : 'page-item'
            }
        },
        mounted() {
            let t = this
            axios.get(`${window.Laravel.baseUrl}mailing-follow-up`)
            .then(res => {
                t.showNoRegister = (res.data.data.length === 0)
                t.next_page_url = res.data.next_page_url !== undefined ? res.data.next_page_url : null
                t.prev_page_url = res.data.prev_page_url !== undefined ? res.data.prev_page_url : null
                t.nextClass = res.data.next_page_url == null ? 'page-item disabled' : 'page-item'
                t.prevClass = res.data.prev_page_url == null ? 'page-item disabled' : 'page-item'
                t.data = res.data.data
            }).catch(err => {
                t.showNoRegister = true
                console.log(err)
            });
        },
        methods:{
            next(){
                let t = this
                axios.get(this.next_page_url)
                .then(res => {
                    t.showNoRegister = (res.data.data.length === 0)
                    t.next_page_url = res.data.next_page_url !== undefined ? res.data.next_page_url : null
                    t.prev_page_url = res.data.prev_page_url !== undefined ? res.data.prev_page_url : null
                    t.nextClass = res.data.next_page_url == null ? 'page-item disabled' : 'page-item'
                    t.prevClass = res.data.prev_page_url == null ? 'page-item disabled' : 'page-item'
                    t.data = res.data.data
                }).catch(err => {
                    console.log(err)
                });
            },
            prev(){
                let t = this
                axios.get(this.prev_page_url)
                .then(res => {
                    t.showNoRegister = (res.data.data.length === 0)
                    t.next_page_url = res.data.next_page_url !== undefined ? res.data.next_page_url : null
                    t.prev_page_url = res.data.prev_page_url !== undefined ? res.data.prev_page_url : null
                    t.nextClass = res.data.next_page_url == null ? 'page-item disabled' : 'page-item'
                    t.prevClass = res.data.prev_page_url == null ? 'page-item disabled' : 'page-item'
                    t.data = res.data.data
                }).catch(err => {
                    console.log(err)
                });
            },
            endpoint(path){
                return btoa(path)
            }
        } 
    }
</script>
