require('./bootstrap');

window.swal = require('sweetalert2');
window.ToastAlert = require('vue-toastification');
Vue.use(ToastAlert);

import Vue from "vue";
import App from "./components/App";
import HeaderComponent from "./components/HeaderComponent";

const app = new Vue({
    el: "#app",
    components: {
        App,
        HeaderComponent
    },
    methods: {},
    created() {
        //
    }
});

