<template>
    <div class="container">

        <div class="modal fade modal-large modal-primary" id="dialog" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="modal-profile">
                            <i class="fa fa-trash"></i>
                        </div>
                    </div>
                    <div class="modal-body text-center">
                        <p>{{ actionText }}</p>
                        <select v-model="actionExten" name="extens" class="form-control">
                            <option v-for="exten in extens" :value="exten.name">{{ toExten(exten.name) }}</option>
                        </select> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" v-on:click="cancel()" class="btn btn-link btn-simple">Cancelar</button>
                        <button type="button" v-on:click="confirm()" class="btn btn-link btn-simple" data-dismiss="modal">Transferir</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div style="width: 100%; display: flex; justify-content: end">
                <ul style="display: flex; justify-content: flex-start; padding: 0; max-height: 31px; margin: 0">
                    <li class="Idle summary">
                        Disponivel
                    </li>
                    <li class="InUse summary">
                        Falando
                    </li>
                    <li class="Unavailable summary">
                        Indisponivel
                    </li>
                </ul>
            </div>
        </div>
        <hr />
        <div class="row">
            <div v-for="exten in extens" class="col-2 p-1">
                <div class="card-console">
                    <div class="card-body p-3" :class="getClass(exten.name)">
                        {{ exten.name.replace(exten.accountcode, "") }}
                        <div class="mt-1 p-0" v-if="exten.state == 'InUse'"
                            style="border-radius: 10px; background: white;color: black;">
                            {{ exten.connected }} : {{ exten.timerCount }}
                        </div>
                        <div v-if="exten.state == 'InUse'" class="col-12 buttons" style=""
                            :class="getClass(exten.name)">
                            <div class="btn-group" role="group"
                                style="margin: 0px; width: 100%; text-align: center; display: flex; justify-content: center;">
                                <button v-on:click="hangup(exten.channel)" type="button" style="background: white;"
                                    class="p-1 btn btn-secondary btn-sm"><img alt="hangup" height="15" width="18"
                                        src="img/call.png" /></button>
                                <button v-on:click="transfer(exten.channel)" type="button" style="background: white;"
                                    class="p-1 btn btn-secondary btn-sm"><img alt="transfer" height="15" width="18"
                                        src="img/outgoing-call.png" /></button>
                                <button v-on:click="spy(exten.channel, exten.name)" type="button" style="background: white;"
                                    class="p-1 btn btn-secondary btn-sm"><img alt="spy" height="15" width="18"
                                        src="img/headset.png" /></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Echo from 'laravel-echo';
export default {
    props: ['extradata'],
    data() {
        return {
            extens: {},
            actionExten: null,
            action: null,
            actionText: null,
            actionChannel: null,
            accountcode: null,
            Echo: null,
        }
    },
    mounted() {
        const me = this;
        this.extens = this.extradata.map((el) => {
            return {
                accountcode: el.accountcode,
                name: el.name,
                state: 'Unavailable',
                number: null,
                timerCount: null,
                start_date: null,
                timerSeconds: 0
            };
        });

        this.accountcode = "a" + this.$root.$data.accountCode;
        me.Echo.channel(this.accountcode).listen('.Hints', (response) => {
            me.extens.forEach((value, key) => {
                if (value.name === response.extens.name) {

                    if (response.extens.state == 'InUse') {
                        value.channel = response.extens.channel;
                        value.connected = response.extens.connected;
                        value.start_date = Date.now();
                        value.timer = window.setInterval(() => {

                            if (value.start_date == null) {
                                clearInterval(value.timer);
                            }

                            if (value.start_date != null) {
                                value.timerSeconds++;
                                value.timerCount = me.toHHMMSS(value.timerSeconds);
                            }

                        }, 1000);
                    }

                    if (response.extens.state != 'InUse') {
                        value.channel = null
                        value.connected = null;
                        value.start_date = null;
                        value.timerSeconds = 0;
                        clearInterval(value.timer);
                    }

                    me.changeState(key, response.extens.state);
                    return;
                }
            });

        });

        axios.post('http://webdec-dev03.webdec.com.br/hints', { accountcode: this.$root.$data.accountCode })
            .then(function (hintsResponse) {
                hintsResponse.data.forEach((value) => {
                    me.extens.forEach((exten, key) => {
                        if (exten.name === value.exten) {
                            exten.state = value.state;
                        }
                    });
                });
            })
            .catch(function (hintsFailure) {
                console.log(hintsFailure);
            });
    },
    created() {
        this.Echo = new Echo({
            broadcaster: 'pusher',
            key: process.env.MIX_PUSHER_APP_KEY,
            cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            forceTLS: false,
            wsHost: 'webdec-dev03.webdec.com.br',
            wsPort: 6001,
        });
    },
    methods: {
        transfer: function(channel) {
            this.actionChannel = channel;
            this.action = 'transfer';
            this.actionText = 'Para qual ramal você irá transferir?';
            $('#dialog').modal('show');
        },
        spy: function(channel, name) {
            this.actionChannel = name;
            this.action = 'spy';
            this.actionText = 'Qual ramal irá espionar essa ligação?';
            $('#dialog').modal('show');
        },
        confirm: function() {

            if (this.action == 'transfer') {
                axios.post('/reception/transfer/' + this.actionExten , { 'channel': this.actionChannel })
                .then(function (response) {
                    $('#dialog').modal('hide');
                });
            }

            if (this.action == 'spy') {
                axios.post('/reception/spy/' + this.actionExten, { 'channel': this.actionChannel })
                .then(function (response) {
                    $('#dialog').modal('hide');
                });
            }
        },
        cancel: function() {
            $('#dialog').modal('hide');
            this.action = null;
            this.actionChannel = null;
            this.actionText = null;
        },
        hangup: function (channel) {
            console.log("Trying to hangup channel " + channel);
            axios.post('/reception/hangup', { 'channel': channel })
                .then(function (response) {
                    console.log(response);
                });

        },
        changeState: function (key, state) {
            this.extens[key].state = state;
        },
        getClass: function (name) {
            let state = '';
            this.extens.forEach((exten, key) => {
                if (exten.name === name) {
                    state = exten.state;
                    return;
                }
            });
            return {
                'Idle': (state === 'Idle') ? true : false,
                'Unavailable': (state === 'Unavailable') ? true : false,
                'InUse': (state === 'InUse') ? true : false,
            }
        },
        toHHMMSS: function (sec) {
            var sec_num = parseInt(sec, 10); // don't forget the second param
            var hours = Math.floor(sec_num / 3600);
            var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
            var seconds = sec_num - (hours * 3600) - (minutes * 60);

            if (hours < 10) { hours = "0" + hours; }
            if (minutes < 10) { minutes = "0" + minutes; }
            if (seconds < 10) { seconds = "0" + seconds; }
            return hours + ':' + minutes + ':' + seconds;
        },
        toExten: function(exten) {
            return exten.substr(exten.length -4,4);
        }
    },
    watch: {
        'extens.start_date': function (oldVal, newVal) {
            console.log(oldVal);
            console.log(newVal);
        }
    }
}
</script>
<style>
.card-console {
    height: 80px;
    max-height: 80px;
}

.Idle {
    background: #004085 !important;
    color: white;
}

.Unavailable {
    background: gray !important;
    color: black;
}

.InUse {
    background: #ffbc67 !important;
    color: white;
}

.buttons button {
    background: white;
    color: black;
    font-weight: 700;
}

li.summary {
    width: 100px;
    text-align: center;
    padding: 0px;
    font-size: 14px;
    display: block;
}

.card-console .card-body {
    max-height: 80px;
}
</style>


