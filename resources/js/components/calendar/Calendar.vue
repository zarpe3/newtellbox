<template>
<div>
    <fieldset style="border: 1px solid #E3E3E3;">
        <legend>Calendario</legend>
        <div class="row">
            &nbsp;
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Dom Inicio
                    </label>
                    <input name="sun_start" v-model="week[0][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Dom Fim
                    </label>
                    <input name="sun_end" v-model="week[0][1]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
        </div>
        <div class="row">
            &nbsp;
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Seg Inicio
                    </label>
                    <input name="mon_start" v-model="week[1][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Seg Fim
                    </label>
                    <input name="mon_end" v-model="week[1][1]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
        </div>
        <div class="row">
            &nbsp;
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Ter Inicio
                    </label>
                    <input name="tue_start" v-model="week[2][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Ter Fim
                    </label>
                    <input name="tue_end" v-model="week[2][1]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
        </div>
        <div class="row">
            &nbsp;
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Qua Inicio
                    </label>
                    <input name="wed_start" v-model="week[3][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Qua Fim
                    </label>
                    <input name="wed_end" v-model="week[3][1]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
        </div>
        <div class="row">
            &nbsp;
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Qui Inicio
                    </label>
                    <input name="thu_start" v-model="week[4][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Qui Fim
                    </label>
                    <input name="thu_end" v-model="week[4][1]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
        </div>
        <div class="row">
            &nbsp;
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Sex Inicio
                    </label>
                    <input name="fri_start" v-model="week[5][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Sex Fim
                    </label>
                    <input name="fri_end" v-model="week[5][1]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
        </div>
        <div class="row">
            &nbsp;
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Sab Inicio
                    </label>
                    <input name="sat_start" v-model="week[6][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Sab Fim
                    </label>
                    <input name="sat_end" v-model="week[6][1]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
        </div>
    </fieldset>
</div>
</template>
<script>
export default {
    /// [ [],[],[],[],[],[],[],[]]
    props: ['calendar'],
    data: function () {
        return {
            week: [
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
            ]
        }
    },
    mounted() {
        if (typeof this.calendar != "object" && this.calendar !== "") {
            this.week = JSON.parse(this.calendar);  
        }
    },
    methods: {
    },
    watch: { 
        calendar: function(newVal, oldVal) {
            if (typeof this.calendar === 'object') {
                this.week = this.calendar;
                return;
            }

            if (this.calendar != "") {
                this.week = JSON.parse(this.calendar); 
            }
        },
        week: function(newVal, oldVal) {
            console.log(newVal);
            console.log(oldVal);
            this.$emit('input', newVal);
        }
    }
};
</script>

