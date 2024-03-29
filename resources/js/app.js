/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue';
import vMultiselectListbox from 'vue-multiselect-listbox'
import 'vue-multiselect-listbox/dist/vue-multi-select-listbox.css';
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css'
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('trunk', require('./components/Trunk.vue').default);
Vue.component('exten', require('./components/Exten.vue').default);
Vue.component('mailing-follow-up', require('./components/Mailing/FollowUp.vue').default);
Vue.component('mailing-import', require('./components/Mailing/Import.vue').default);
Vue.component('reception-console', require('./components/ReceptionConsole.vue').default);
Vue.component('add-route', require('./components/Routes/Add.vue').default);
Vue.component('edit-route', require('./components/Routes/Edit.vue').default);
Vue.component('calendar', require('./components/calendar/Calendar.vue').default);
Vue.component('v-multiselect-listbox', vMultiselectListbox)
Vue.use(Vuesax);


Vue.component('add-inbound', require('./components/Inbounds/Add.vue').default);
Vue.component('customer-table', require('./components/customers/Table.vue').default);
Vue.component('edit-inbound', require('./components/Inbounds/Edit.vue').default);

Vue.component('ivr-options', require('./components/Ivr/Options.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */