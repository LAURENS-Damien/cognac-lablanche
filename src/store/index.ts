import Vue from 'vue';
import * as Vuex from 'vuex';
import axios from 'axios';
import {AppState, HomePageDatas, ProductionDatas, WpDatas} from '@/ts/Models';
import * as Constants from '@/ts/constants';
import Production from '@/components/Production.vue';

Vue.use(Vuex);

type Context = Vuex.ActionContext<AppState, AppState>;

export default new Vuex.Store({
  state: {
    wpDatas: new WpDatas(),
  },
  getters: {
    wpDatas: (state: AppState) => {
      return state.wpDatas;
    },
  },
  mutations: {
    setWpDatas(state, wpDatas: WpDatas) {
      state.wpDatas = wpDatas;
    },
  },
  actions: {
    loadWpDatas(context: Context) {
      axios.get(Constants.URL_WP_DATAS)
        .then((response) => {
          const homePageDatas = response.data.homePage as HomePageDatas;
          const productionDatas = response.data.catalog as ProductionDatas;
          const wpDatas = new WpDatas(homePageDatas, productionDatas);
          context.commit('setWpDatas', wpDatas);
        })
        .catch(() => {
          const wpDatas = new WpDatas();
          context.commit('setWpDatas', wpDatas);
          window.location.href = '/erreur';
        });
    },
  },
});
