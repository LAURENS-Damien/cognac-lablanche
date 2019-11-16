import Vue from 'vue';
import Router from 'vue-router';
import ProductSheet from './views/ProductSheet.vue';
import Error from './views/Error.vue';
import Catalog from '@/views/Catalog.vue';
import Gallery from '@/views/Gallery.vue';
import Newsletter from '@/views/Newsletter.vue';
import Order from '@/views/Order.vue';
import Contact from '@/views/Contact.vue';
import HomePage from '@/views/HomePage.vue';
import Historic from '@/views/Historic.vue';
import VineyardManagement from '@/views/VineyardManagement.vue';
import CampingCarParking from '@/views/CampingCarParking.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'accueil',
      component: HomePage,
    },
    {
      path: '/historique',
      name: 'historique',
      component: Historic,
    },
    {
      path: '/conduite-vignoble',
      name: 'conduiteVignoble',
      component: VineyardManagement,
    },
    {
      path: '/parking-camping-car',
      name: 'parkingCampingCar',
      component: CampingCarParking,
    },
    {
      path: '/catalogue',
      name: 'catalog',
      component: Catalog,
    },
    {
      path: '/contact',
      name: 'contact',
      component: Contact,
    },
    {
      path: '/galerie',
      name: 'gallery',
      component: Gallery,
    },
    {
      path: '/newsletter',
      name: 'newsletter',
      component: Newsletter,
    },
    {
      path: '/commander',
      name: 'commander',
      component: Order,
    },
    {
      path: '/productsheet/:productPath/productsCategory/:productsCategory',
      name: 'productsheet',
      component: ProductSheet,
    },
    {
      path: '*',
      name: 'error',
      component: Error,
    },
  ],
});
