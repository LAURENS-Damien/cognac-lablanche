import Vue from 'vue';
import Router from 'vue-router';
import Accueil from './views/Accueil.vue';
import HomeOrigin from './views/HomeOrigin.vue';
import About from './views/About.vue';
import ProductSheet from './views/ProductSheet.vue';
import Error from './views/Error.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'accueil',
      component: Accueil,
    },
    {
      path: '/productsheet:productPath',
      name: 'productsheet',
      component: ProductSheet,
    },
    // {
    //   path: '/home',
    //   name: 'home',
    //   component: Home,
    // },
    {
      path: '/homeorigin',
      name: 'homeorigin',
      component: HomeOrigin,
    },
    {
      path: '/about',
      name: 'about',
      component: About,
    },
    {
      path: '*',
      name: 'error',
      component: Error,
    },
  ],
});
