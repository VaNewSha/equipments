require('./bootstrap');

import { createApp } from 'vue';
import router from './router'

import App from './App.vue';
import ModalComponent from './components/ModalComponent.vue';
import PaginationComponent from './components/PaginationComponent.vue';

createApp({
    components: {
        App, PaginationComponent, ModalComponent
    }
}).use(router).mount('#app')
