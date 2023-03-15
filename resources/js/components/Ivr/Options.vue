<template>
    <div class="form-group">
        <fieldset class="form-group border p-4">
            <legend class="p-2">Opções</legend>
            <div v-for="option in options" class="row">
                <div class="col-md-1 label"> Opção {{ option }}:</div>
                <div class="col-md-2">
                    <select v-model="option_fields['option_'+option]" v-on:change="changeOption(option)" :name="'option_' + option" class="form-control">
                        <option value="0">-</option>
                        <option value="1">Fila</option>
                        <option value="2">Ramais</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select  v-model="option_value['value_'+option]" :id="'value_'+option" :name="'value_' + option" class="form-control">
                        <option v-for="element in elements['element_'+option]" :key="element" :value="element">{{element}}</option>
                    </select>
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-1 label"> Desvio</div>
            <div class="col-md-2">
                <select v-model="divert_option" v-on:change="changeDivert()" name="divert_option" class="form-control">
                    <option value="0">-</option>
                    <option value="1">Fila</option>
                    <option value="2">Ramais</option>
                </select>
             </div>
             <div class="col-md-2">
                <select  v-model="divert_value" id="diver_value" name="divert_value" class="form-control">
                    <option v-for="element in divert_elements" :key="element" :value="element">{{element}}</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['extendata', 'queuedata', 'ivrdata'],
    data: function () {
        return {
            divert_option: null,
            divert_value: null,
            divert_elements: [],
            options : [0,1,2,3,4,5,6,7,8,9],
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
        console.log(this.ivrdata);
        let me = this;
        if (this.ivrdata != undefined && this.ivrdata != "") {
            let ivr = JSON.parse(this.ivrdata);
            this.divert_option = ivr.divert_option;
            this.changeDivert();
            this.divert_value = ivr.divert_value;
            Object.keys(ivr).forEach(key => {
                if (me.option_fields.hasOwnProperty(key)) {
                    let number= key.match(/\d+(\.\d+)?/)[0];
                    me.option_fields[key] = ivr[key];
                    me.changeOption(number);
                }
                if (me.option_value.hasOwnProperty(key)) {
                    me.option_value[key] = ivr[key];
                }
            });
        }

    },
    computed: {
        
    },
    methods: {
        async changeOption (option) {
            if (this.option_fields['option_'+option] == 1) { 
                this.elements['element_'+option] = this.queues.map( queue => queue.name);
            }
            //// ramais
            if (this.option_fields['option_'+option] == 2) { 
                this.elements['element_'+option] = this.extens.map( exten => exten.name.slice(-4));
            }
        },
        changeDivert: function() {
            if (this.divert_option == 1) { 
                this.divert_elements = this.queues.map( queue => queue.name);
            }
            //// ramais
            if (this.divert_option == 2) { 
                this.divert_elements = this.extens.map( exten => exten.name.slice(-4));
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
    .label {
        font-size: 0.75rem;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
</style>

