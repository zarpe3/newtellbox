<template>
    <div class="form-group">
        <fieldset class="form-group border p-3">
            <legend class="">Opções</legend>
            <div v-for="option in options" class="row">
                <div class="col-md-4">
                    <label :for="'option_'+option">Opção {{ option }}:</label>
                    <select v-model="option_fields['option_'+option]" v-on:change="changeOption($event, option)" :name="'option_' + option" class="form-control">
                        <option value="0">-</option>
                        <option value="1">Fila</option>
                        <option value="2">Ramais</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label :for="'value_'+option">Opção {{ option }}:</label>
                    <select v-model="option_value['option_'+option]" v-on:change="changeOption($event)" :name="'value_' + option" class="form-control">
                        <option v-for="(element, index) in elements['element_'+option]" :key="index" :value="element">{{element}}</option>
                    </select>
                </div>
            </div>
        </fieldset>
    </div>
</template>
<script>
export default {
    props: ['extendata', 'queuedata'],
    data: function () {
        return {
            destiny_type: '',
            destiny_value: '',
            options: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            option_fields: {
                 option_0: null, 
                 option_1: null, 
                 option_2: null, 
                 option_3: null, 
                 option_4: null, 
                 option_5: null, 
                 option_5: null, 
                 option_6: null, 
                 option_7: null, 
                 option_8: null, 
                 option_9: null
            },
            option_value: {
                 value_0: null, 
                 value_1: null, 
                 value_2: null, 
                 value_3: null, 
                 value_4: null, 
                 value_5: null, 
                 value_5: null, 
                 value_6: null, 
                 value_7: null, 
                 value_8: null, 
                 value_9: null
            },
            elements: {
                element_0: [],
                element_1: [],
                element_2: [],
                element_3: [],
                element_4: [],
                element_5: [],
                element_6: [],
                element_7: [],
                element_8: [],
                element_9: [],
            },
            extens: [],
            queues: [],
        }
    },
    mounted() {
        this.extens = JSON.parse(this.extendata);
        this.queues = JSON.parse(this.queuedata);
    },
    methods: {
        changeOption: function(event, option) {
            //// fila
            if (this.option_fields['option_'+option] == 1) { 
                this.elements['element_'+option] = this.queues.map( queue => queue.name);
            }
            //// ramais
            if (this.option_fields['option_'+option] == 2) { 
                this.elements['element_'+option] = this.extens.map( exten => exten.name.slice(-4));
            }
        }
    }
};
</script>
<style>
    legend {
        font-size: 0.75rem;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    select {
        height: calc(2.2rem + 0px);
    }
</style>

