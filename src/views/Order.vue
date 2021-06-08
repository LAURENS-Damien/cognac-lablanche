<template>
  <Loader v-bind:loading="viewState">
    <div id="order" class="my-3 my-lg-5" v-if="shopPresentationDatas !== null">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-12 col-lg-5">
              <div class="full-width" v-html="shopPresentationDatas.image"></div>
            </div>
            <div class="col-12 col-lg-7">
              <h1 v-html="shopPresentationDatas.title"></h1>
              <Separator/>
              <p v-html="shopPresentationDatas.content"></p>
            </div>
          </div>
          <div class="row pt-3">
            <div class="col-12">
              <h2>Nos autres adresses</h2>
              <p class="pt-3">Retrouvez nous également à Jonzac aux <a href="https://delices-de-saintonge.com/">Déclices
                de Saintonge</a> et à Pons à la boutique <a href="https://www.facebook.com/Le-panier-du-producteur-Pons-105479374884971/">Le
                panier du producteur</a></p>
            </div>
          </div>
          <div class="row pt-3">
            <div class="col-12">
              <h2 class="mb-4">{{ orderDatas.title }}</h2>
              <p v-html="orderDatas.content"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
import {Component, Mixins, Vue} from 'vue-property-decorator';
import Separator from '@/components/Separator.vue';
import Loader from '@/components/Loader.vue';
import {ViewState} from '@/ts/Models';
import {ContactDatas, OrderDatas} from '@/ts/WpDatas';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component({
  components: {Loader, Separator},
})
export default class Order extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Vente à la propriété - Cognac LABLANCHE';
  public metaDescription = 'Venez découvrir nos produits dans nos différents points de vente';
  private viewState: ViewState = ViewState.Loading;

  get shopPresentationDatas(): ContactDatas | null {
    if (this.$store.getters.wpDatas.shopPresentationDatas !== undefined) {
      this.viewState = ViewState.Loaded;
      return this.$store.getters.wpDatas.shopPresentationDatas;
    } else {
      return null;
    }
  }

  get orderDatas(): OrderDatas | null {
    if (this.$store.getters.wpDatas.orderDatas !== undefined) {
      this.viewState = ViewState.Loaded;
      return this.$store.getters.wpDatas.orderDatas;
    } else {
      return null;
    }
  }

  public created() {
    this.$store.dispatch('loadWpDatas');
  }
}
</script>

<style lang="scss">
.shop-presentation .wp-block-group__inner-container {
  display: flex;

  & .wp-block-media-text__media img {
    width: 100%;
  }

  & .wp-block-media-text__content {
    margin-left: 15px;
  }
}
</style>