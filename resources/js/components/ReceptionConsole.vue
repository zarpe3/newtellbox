<template>
    <div class="container">
        <div class="row">
            <div style="width: 100%; display: flex; justify-content: end">
                <ul style="display: flex; justify-content: flex-start; padding: 0; max-height: 31px; margin: 0">
                    <li class="Idle summary" >
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
            <div v-for="exten in extens" class="col-md-2">
                <div class="card-console">
                    <div class="card-body" :class="getClass(exten.name)">
                        {{ exten.name.replace(exten.accountcode, "") }}

                        <div v-if="exten.state == 'InUse'" class="col-12 buttons" style="padding: 0px;"
                            :class="getClass(exten.name)">
                            <div class="btn-group" role="group"
                                style="margin: 0px; width: 100%; text-align: center; display: flex; justify-content: center;">
                                <button type="button" style="background: white;" class="btn btn-secondary btn-sm"><img
                                        alt="hangup" height="15" width="18" src="img/call.png" /></button>
                                <button type="button" style="background: white;" class="btn btn-secondary btn-sm"><img
                                        alt="hangup" height="15" width="18" src="img/outgoing-call.png" /></button>
                                <button type="button" style="background: white;" class="btn btn-secondary btn-sm"><img
                                        alt="hangup" height="15" width="18" src="img/headset.png" /></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Echo from 'laravel-echo';
export default {
    props: ['extradata'],
    data() {
        return {
            extens: null,
            accountcode: null,
            Echo: null,
        }
    },
    mounted() {
        const me = this;
        this.extens = this.extradata.map((el) => {
            return { accountcode: el.accountcode, name: el.name, state: 'Unavailable', number: null, time: null };
        });

        this.accountcode = "a" + this.$root.$data.accountCode;
        me.Echo.channel(this.accountcode).listen('.Hints', (response) => {
            me.extens.forEach((value, key) => {
                if (value.name === response.extens.name) {

                    if (response.extens.state == 'InUse') {
                        value.channel = response.extens.channel;
                    }

                    if (response.extens.state != 'InUse') {
                        value.channel = null
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
        }

    },
}
</script>
<style>
.card-console {
    height: 88px;
    max-height: 88px;
}

.Idle {
    background: green !important;
    color: white;
}

.Unavailable {
    background: gray !important;
    color: black;
}

.InUse {
    background: blue !important;
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
</style>


