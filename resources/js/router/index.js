import { createRouter, createWebHistory } from 'vue-router'

import EquipmentIndexPage from '../pages/EquipmentIndexPage.vue'
import EquipmentCreatePage from '../pages/EquipmentCreatePage.vue'
import EquipmentPage from "../pages/EquipmentPage";

const routes = [
    {
        path: '/',
        component: EquipmentPage,
        children: [
            {
                path: '',
                component: EquipmentIndexPage,
            },
            {
                path: 'create',
                component: EquipmentCreatePage,
            },
        ]
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
