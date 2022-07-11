import { createRouter, createWebHistory } from 'vue-router'

import EquipmentIndexPage from '../pages/EquipmentIndexPage.vue'
import EquipmentEditPage from '../pages/EquipmentEditPage.vue'

const routes = [
    {
        path: '/',
        component: EquipmentIndexPage
    },
    {
        path: '/asd',
        component: EquipmentEditPage
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
