require('./bootstrap');

window.swal = require('sweetalert2');

import Vue from "vue";
import App from "./components/App";
import HeaderComponent from "./components/HeaderComponent";

const app = new Vue({
    el: "#app",
    data: {
        name: "SHahed"
    },
    components: {
        App,
        HeaderComponent
    }
});

