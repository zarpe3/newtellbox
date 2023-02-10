<template>
    <div>
        <div class="form-group">
            <label class="form-control-label">
                <i class="nc-icon nc-map-big"></i>Tipo Destino
            </label>
            <select name="destiny_type" v-model="destiny_type" @change="changeType()" class="form-control">
                <option value="ramal">Ramal</option>
                <option value="fila">Fila</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-control-label">
                <i class="nc-icon nc-map-big"></i>Destino
            </label>
            <select name="destiny_value" v-model="destiny_value" class="form-control">
                <option v-for="element in elements" :value="element.value">{{ element.name }}</option>
            </select>
        </div>
    </div>
</template>
<script>
export default {
    props: ['extendata', 'queuedata'],
    data: function () {
        return {
            destiny_type: '',
            destiny_value: '',
            elements: [],
            extens: [],
            queues: [],
        }
    },
    mounted() {
        this.extens = JSON.parse(this.extendata);
        this.queues = JSON.parse(this.queuedata);
    },
    methods: {
        changeType: function () {
            this.elements = [];
            let me = this;
            if (this.destiny_type == 'ramal') {
                this.elements = this.extens.map(exten => ({name: me.toExten(exten.name), value: exten.name}) );
            }

            if (this.destiny_type == 'fila') {
                this.elements = this.queues.map(queue => ({name: queue.name, value: queue.name}) );
            }
            console.log(this.elements);
        },
        toExten: function(exten) {
            return exten.substr(exten.length -4,4);
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
};
</script>
