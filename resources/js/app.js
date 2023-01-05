/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import CoreuiVue from '@coreui/vue'
import './bootstrap';
import { createApp } from 'vue';
import { configure, defineRule } from "vee-validate";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
configure({
    validateOnBlur: true,
    validateOnChange: true,
    validateOnInput: true,
    validateOnModelUpdate: true,
});

const app = createApp({});
app.use(CoreuiVue);
app.use(VueSweetalert2);
defineRule('password_rule', value => {
    return /^[A-Za-z0-9]*$/i.test(value);
});


import Loader from './components/common/loader.vue';
import CustomInput from './components/common/customInput.vue';
import PopupAlert from './components/common/popupAlert.vue';

import ExampleComponent from './components/ExampleComponent.vue';
import CreateCompany from "./components/company/create.vue";


app.component('loader', Loader);
app.component('custom-input', CustomInput);
app.component('popup-alert', PopupAlert);

app.component('example-component', ExampleComponent);
app.component('create-company', CreateCompany);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
