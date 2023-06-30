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
                <div v-if="data.length !== 0" id="users" class="card-body table-full-width table-responsive">
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
                                <th>Agressividade</th>
                                <th>Tamanho</th>
                                <th>Sucesso</th>
                                <th>Falhas</th>
                                <th>Erros</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" :key="item.id">
                                <td>
                                    <a :href="'/mailing/'+item._id">
                                        {{item.campaign_name}}
                                    </a>
                                </td>
                                <td>
                                    {{item.status}}
                                    <a v-if="item.status == 'pausado'" v-on:click="start(item._id)">
                                        <i class="fa fa-play"></i>
                                    </a>
                                    <a v-if="item.status == 'iniciada'" v-on:click="pause(item._id)">
                                        <i class="fa fa-pause"></i>
                                    </a>
                                </td>
                                <td>{{item.strength}}</td>
                                <td>{{item.size}}</td>
                                <td>{{item.success}}</td>
                                <td>{{item.fail}}</td>
                                <td>
                                    <a v-if="item.errors !== 0" :href="url + '?file_path_error=' + endpoint(item.file_path_error)">
                                        {{item.errors}}
                                    </a>
                                    <span v-else>
                                        0
                                    </span>
                                </td>
                                <td>
                                    <vs-button circle icon color="danger" size="mini" floating @click="drop(item._id)">
                                        <i class='fa fa-trash'></i>
                                    </vs-button>
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
            data: [],
            url: `${window.Laravel.baseUrl}mailing-export-error`,
            showNoRegister: false,
            next_page_url: 1,
            prev_page_url: null,
            nextClass: this.next_page_url == null ? 'page-item disabled' : 'page-item',
            prevClass: this.prev_page_url == null ? 'page-item disabled' : 'page-item'
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
    methods: {
        pause(id) {
            this.$vs.loading();
            axios.post('/mailing/pause/' + id)
                .then(res => {
                    this.$vs.loading.close()
                    this.updateStatus(id, 'pausado');
                    this.$vs.notify({
                        color: 'success',
                        position: 'top-right',
                        title: '',
                        text: 'Campanha pausa'
                    });
                }).catch(err => {
                    this.$vs.loading.close()
                    this.$vs.notify({
                        color: 'danger',
                        position: 'top-right',
                        title: 'Ops',
                        text: err
                    });
                });
        },
        start(id) {
            this.$vs.loading();
            axios.post('/mailing/start/' + id)
                .then(res => {
                    this.$vs.loading.close()
                    this.updateStatus(id, 'iniciada');
                    this.$vs.notify({
                        color: 'success',
                        position: 'top-right',
                        title: 'Oba',
                        text: 'Campanha iniciada'
                    });
                }).catch(err => {
                    this.$vs.loading.close()
                    this.$vs.notify({
                        color: 'danger',
                        position: 'top-right',
                        title: 'Ops',
                        text: err
                    });
                });
        },
        next() {
            //let t = this
            axios.get(this.next_page_url)
                .then(res => {
                    this.showNoRegister = (res.data.data.length === 0)
                    this.next_page_url = res.data.next_page_url !== undefined ? res.data.next_page_url : null
                    this.prev_page_url = res.data.prev_page_url !== undefined ? res.data.prev_page_url : null
                    this.nextClass = res.data.next_page_url == null ? 'page-item disabled' : 'page-item'
                    this.prevClass = res.data.prev_page_url == null ? 'page-item disabled' : 'page-item'
                    this.data = res.data.data
                }).catch(err => {
                    console.log(err)
                });
        },
        prev() {
            ///let t = this
            axios.get(this.prev_page_url)
                .then(res => {
                    this.showNoRegister = (res.data.data.length === 0)
                    this.next_page_url = res.data.next_page_url !== undefined ? res.data.next_page_url : null
                    this.prev_page_url = res.data.prev_page_url !== undefined ? res.data.prev_page_url : null
                    this.nextClass = res.data.next_page_url == null ? 'page-item disabled' : 'page-item'
                    this.prevClass = res.data.prev_page_url == null ? 'page-item disabled' : 'page-item'
                    this.data = res.data.data
                }).catch(err => {
                    console.log(err)
                });
        },
        endpoint(path) {
            return btoa(path)
        },
        drop(id) {
            this.$vs.loading();
            axios.delete('/mailing/' + id).then((res) => {
                //// removes the mailing from data
                this.data = this.data.filter((mailing) => {
                    if (mailing._id != id) {
                        return mailing;
                    }
                });

                /// notify user;
                this.$vs.loading.close()
                this.$vs.notify({
                    color: 'danger',
                    position: 'top-right',
                    title: 'Ahn :( que pena!',
                    text: 'Campanha removida'
                });
            });
        },
        updateStatus(id, status) {
            this.data = this.data.map((item) => {
                if (item._id != id) {
                    return item;
                }  

                if (item._id == id) {
                    item.status = status;
                    return item;
                }
            })
        }

    }
}
</script>
