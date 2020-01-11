<template>
    <div class="order container-fluid limit-max-width my-3 my-lg-5">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <div class="full-width" v-html="shopPresentation.image"></div>
                    </div>
                    <div class="col-8">
                        <h1 v-html="shopPresentation.title"></h1>
                        <Separator/>
                        <p v-html="shopPresentation.content"></p>
                    </div>
                </div>
                <div class="row pt-5">
                    <div class="col-8">
                        <h2>Nos autres adresses</h2>
                        <p class="pt-3">Retrouvez nous également à Jonzac aux <a href="https://delices-de-saintonge.com/">Déclices de Saintonge</a> et à Pons à la boutique <a href="https://www.facebook.com/lepanierduproducteurpons/">Le panier du producteur</a></p>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-12">
                        <h2 class="mb-4">{{ order.title }}</h2>
                        <p v-html="order.content"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import * as Constants from '@/ts/constants';
  import Separator from '@/components/Separator.vue';
  @Component({
    components: {Separator},
  })
  export default class Order extends Vue {
    private order = {};
    private shopPresentation = {};

    public created() {
      this.axios.get(Constants.URL_ORDER)
        .then((response) => {
          this.order = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
      this.axios.get(Constants.URL_SHOP_PRESENTATION)
        .then((response) => {
          this.shopPresentation = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
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