import Vue from 'vue';
import App from './App.vue';
import router from './router';
import BootstrapVue from 'bootstrap-vue';
import PortalVue from 'portal-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import axios, {AxiosStatic} from 'axios';
import store from './store';

Vue.use(BootstrapVue);
Vue.use(PortalVue);
Vue.config.productionTip = false;

Vue.use({
  install() {
    Vue.prototype.axios = axios.create({
      baseURL: process.env.VUE_APP_API_URL,
    });
  },
});

declare module 'vue/types/vue' {
  interface Vue {
    axios: AxiosStatic;
  }
}

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount('#app');
