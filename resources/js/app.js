import VideosList from "./components/VideosList";
import Alpine from 'alpinejs';
import casteaching_palanka from 'casteaching'
import Vue from 'vue'

require('./bootstrap');

window.Alpine = Alpine;
window.casteaching = casteaching_palanka;
window.Vue = Vue

window.Vue.component('videos-list', VideosList)
Alpine.start();

const app= new window.Vue({
    el:'#app',
});
