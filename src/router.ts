import Vue from 'vue';
import Router from 'vue-router';
import HomeOrigin from './views/HomeOrigin.vue';
import About from './views/About.vue';
import Home from './views/Home.vue';
import Error from './views/Error.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
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
      path: '/error',
      name: 'error',
      component: Error,
    },
  ],
});
