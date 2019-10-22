import Vue from 'vue';
import Router from 'vue-router';
import Accueil from './views/Accueil.vue';
import HomeOrigin from './views/HomeOrigin.vue';
import About from './views/About.vue';
import ProductSheet from './views/ProductSheet.vue';
import Error from './views/Error.vue';
import Catalog from '@/views/Catalog.vue';
import Gallery from '@/views/Gallery.vue';

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
      path: '/catalog',
      name: 'catalog',
      component: Catalog,
    },
    {
      path: '/galerie',
      name: 'gallery',
      component: Gallery,
    },
    {
      path: '/productsheet/:productPath/productsCategory/:productsCategory',
      name: 'productsheet',
      component: ProductSheet,
    },
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
