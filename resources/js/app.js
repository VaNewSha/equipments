require('./bootstrap');


import { createApp } from 'vue';
import router from './router'

import EquipmentIndexPage from './pages/EquipmentIndexPage.vue';
import EquipmentEditPage from './pages/EquipmentEditPage.vue';

createApp({
    components: {
        EquipmentIndexPage, EquipmentEditPage
    }
}).use(router).mount('#app')
