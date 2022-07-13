require('./bootstrap');

import { createApp } from 'vue';
import router from './router'
import Notifications from '@kyvg/vue3-notification'

import App from './App.vue';
import ModalComponent from './components/ModalComponent.vue';
import PaginationComponent from './components/PaginationComponent.vue';

createApp({
    components: {
        App, PaginationComponent, ModalComponent
    }
}).use(Notifications).use(router).mount('#app')
