<template>
    <div>
        <div class="form-group">
            <label class="form-control-label">
                <i class="nc-icon nc-map-big"></i>Tipo Destino
            </label>
            <select name="destiny_type" id="destiny_type" v-model="destiny_type" @change="changeType()" class="form-control">
                <option value="ura">Ura</option>
                <option value="ramal">Ramal</option>
                <option value="fila">Fila</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-control-label">
                <i class="nc-icon nc-map-big"></i>Destino
            </label>
            <select name="destiny_value" id="destiny_value" v-model="destiny_value" class="form-control">
                <option v-for="element in elements" :value="element.value">{{ element.name }}</option>
            </select>
        </div>
    </div>
</template>
<script>
export default {
    props: ['extendata', 'inbounddata','queuedata','ivrdata'],
    data: function () {
        return {
            destiny_type: '',
            destiny_value: '',
            elements: [],
            extens: [],
            inbound: [],
            queues: [],
            ivrs: [],
        }
    },
    mounted() {
        this.ivrs = JSON.parse(this.ivrdata);
        this.extens = JSON.parse(this.extendata);
        this.queues = JSON.parse(this.queuedata);
        this.inbound = JSON.parse(this.inbounddata);
        this.destiny_type = this.inbound.destiny_type;
        //$('#destiny_type').val(this.inbound.destiny_type);
        this.changeType();
        //$('#destiny_value').val(this.inbound.destiny_value);
        this.destiny_value = this.inbound.destiny_value; 

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

            if (this.destiny_type == 'ura') {
                this.elements = this.ivrs.map(ivr => ({name: ivr.name, value: ivr.id}) );
            }
            //console.log(this.elements);
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
