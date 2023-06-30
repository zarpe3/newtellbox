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
                    <input v-model="calendar[0][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Dom Fim
                    </label>
                    <input v-model="calendar[0][1]" type="time" class="form-control" placeholder="00:00">
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
                    <input v-model="calendar[1][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Seg Fim
                    </label>
                    <input v-model="calendar[1][1]" type="time" class="form-control" placeholder="00:00">
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
                    <input v-model="calendar[2][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Ter Fim
                    </label>
                    <input v-model="calendar[2][1]" type="time" class="form-control" placeholder="00:00">
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
                    <input v-model="calendar[3][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Qua Fim
                    </label>
                    <input v-model="calendar[3][1]" type="time" class="form-control" placeholder="00:00">
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
                    <input v-model="calendar[4][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Qui Fim
                    </label>
                    <input v-model="calendar[4][1]" type="time" class="form-control" placeholder="00:00">
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
                    <input v-model="calendar[5][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Sex Fim
                    </label>
                    <input v-model="calendar[5][1]" type="time" class="form-control" placeholder="00:00">
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
                    <input v-model="calendar[6][0]" type="time" class="form-control" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-control-label" for="max_attempts">
                        Sab Fim
                    </label>
                    <input v-model="calendar[6][1]" type="time" class="form-control" placeholder="00:00">
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
        }
    },
    mounted() {
    },
    methods: {
    }
};
</script>

