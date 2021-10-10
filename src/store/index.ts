import Vue from 'vue';
import * as Vuex from 'vuex';
import axios from 'axios';
import {AppState} from '@/ts/Models';
import * as Constants from '@/ts/constants';
import {StoreOptions} from 'vuex';
import {
  CampingCarParkingDatas, ContactDatas, GalleryDatas,
  HistoricDatas,
  HomePageDatas, OrderDatas,
  ProductionDatas, ShopPresentationDatas,
  VineyardManagementDatas,
  WpDatas,
} from '@/ts/WpDatas';

Vue.use(Vuex);

type Context = Vuex.ActionContext<AppState, AppState>;

const store: StoreOptions<AppState> = {
  state: {
    wpDatas: new WpDatas(),
  },
  getters: {
    wpDatas: (state: AppState) => {
      return state.wpDatas;
    },
  },
  actions: {
    loadWpDatas(context: Context) {
      axios.get(Constants.URL_WP_DATAS)
        .then((response: any) => {
          const homePageDatas = response.data.homePage as HomePageDatas;
          const productionDatas = response.data.catalog as ProductionDatas;
          const vineyardManagementDatas = response.data.vineyardManagement as VineyardManagementDatas;
          const historicDatas = response.data.historic as HistoricDatas;
          const campingCarParkingDatas = response.data.parking as CampingCarParkingDatas;
          const galleryDatas = response.data.gallery as GalleryDatas;
          const contactDatas = response.data.contact as ContactDatas;
          const orderDatas = response.data.order as OrderDatas;
          const shopPresentationDatas = response.data.shopPresentation as ShopPresentationDatas;
          const wpDatas = new WpDatas(
            homePageDatas,
            productionDatas,
            vineyardManagementDatas,
            historicDatas,
            campingCarParkingDatas,
            galleryDatas,
            contactDatas,
            orderDatas,
            shopPresentationDatas,
          );
          context.commit('setWpDatas', wpDatas);
        })
        .catch(() => {
          const wpDatas = new WpDatas();
          context.commit('setWpDatas', wpDatas);
          window.location.href = '/erreur';
        });
    },
  },
  mutations: {
    setWpDatas(state, wpDatas: WpDatas) {
      state.wpDatas = wpDatas;
    },
  },
};

export default new Vuex.Store<AppState>(store);
