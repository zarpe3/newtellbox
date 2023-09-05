<template>
<vuetable 
    ref="vuetable" 
    api-url="home/json" 
    :fields="fields" 
    :css="{tableClass: '', tableHeaderClass: 'table-striped'}"
>

    <div slot="status-slot" slot-scope="props">
    <a v-if="props.rowData.status === 1" :href="'/'+props.rowData.accountcode+'/home'">
        <span class="ui teal label"><i class="fa fa-check-circle" style="color: green;"></i></span>
    </a>
    <span v-else class="ui pink label"><i class="fa fa-check-circle" style="color: red;"></i></span>
  </div>
</vuetable>
</template>

<script>
import Vuetable from 'vuetable-2'

export default {
    props: {

    },
    data: function () {
        return {
            fields: [
                {
                    name: "status-slot",
                    title: 'Status',
                    titleClass: "center aligned",
                    dataClass: "center aligned",
                    width: "15%",
                }, {
                    name: "name",
                    title: 'Nome da Conta',
                    titleClass: "center aligned",
                    dataClass: "center aligned",
                }, {
                    name: "accountcode",
                    title: 'Código',
                    titleClass: "center aligned",
                    dataClass: "center aligned",
                },  {
                    name: "created_at",
                    title: 'Criado em',
                    titleClass: "center aligned",
                    dataClass: "center aligned",
                },
            ],
        }
    },
    components: {
        Vuetable
    },
    
    mounted() {
        console.log(this.rowData);
    },
}
</script>
<style>
</style>