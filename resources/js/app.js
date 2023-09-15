

require('./bootstrap');

window.Vue = require('vue').default;

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
    faUserSecret,
    faTrash,
    faPenToSquare
} from '@fortawesome/free-solid-svg-icons'

import App from '@/components/home.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import { routes } from './routes';
import vueKanban from 'vue-kanban'
import store from '@/store'
import Notifications from 'vue-notification'

library.add(faUserSecret)
library.add(faTrash)
library.add(faPenToSquare)

/* add font awesome icon component */
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false;
Vue.use(vueKanban)
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Notifications)

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

new Vue({
    store:store,
    router: router,
    render: (h) => h(App)
}).$mount("#app");
