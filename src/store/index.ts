import Vue from 'vue';
import * as Vuex from 'vuex';
import axios from 'axios';
import {AppState, HomePageDatas, WpDatas} from '@/ts/Models';
import * as Constants from '@/ts/constants';

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
          const wpDatas = new WpDatas(homePageDatas);
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
