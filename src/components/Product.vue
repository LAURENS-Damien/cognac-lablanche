<template>
    <div>
        <div class="bottle">
<!--                    <img alt="" src="@/../test/mocks/pages/products/cognacs/xo/cognac_xo.jpg">-->
            <img alt="" v-bind:src="photo" v-on:click="goToProductSheet" class="product-size">
        </div>
        <span v-html="productName" class="font-weight-bold"></span>
        <br>
        <span v-html="acf.appellation"></span>
        <br>
        <div v-if="fullDescription" class="pt-2">
            <span class="underline">Description :</span>
            <p v-html="acf.description">Description</p>
            <span class="underline">Cépage :</span>
            <p v-html="acf.cepage">Cépage</p>
            <span class="underline">Température :</span>
            <p v-html="acf.temperature_ideale_de_service">Température</p>
            <span class="underline">Nez :</span>
            <p v-html="acf.nez">Nez</p>
            <span class="underline">Bouche :</span>
            <p v-html="acf.bouche">Bouche</p>
            <span class="underline">Suggestions :</span>
            <p v-html="acf.suggestions">Suggestions</p>
            <span class="underline">Divers :</span>
            <p v-html="acf.divers">Divers</p>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch } from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import axios from 'axios';
import router from '@/router';

@Component
export default class Product extends Vue {

    @Prop() private productPath!: string;
    @Prop() private fullDescription!: boolean;
    private productId: number = 0;
    private productName: string = '';
    private featuredMediaUrl: string = '';
    private photo: string = '';
    private acf: string = '';

    public created() {
      this.getProduct();
    }

    @Watch('productPath')
    public getProduct() {
    axios.get(Constants.URL_PRODUCT + '/' + this.productPath)
          .then((response) => {
            this.productId = response.data.ID;
            this.productName = response.data.post_title;
            this.getCustomFields();
            axios.get(Constants.URL_PAGES + '/' + this.productId)
              .then((response2) => {
                const tmp = response2.data._links;
                for (const d in tmp) {
                  if (d === 'wp:featuredmedia') {
                    this.featuredMediaUrl = tmp[d][0].href;
                    axios.get(this.featuredMediaUrl)
                      .then((response3) => {
                        this.photo = response3.data.source_url;
                      })
                      .catch((error) => {
                        window.location.href = '/error';
                      });
                  }
                }
              })
              .catch((error) => {
                window.location.href = '/error';
              });
          })
          .catch((error) => {
            window.location.href = '/error';
          });
    }

    public getCustomFields() {
      axios.get(Constants.URL_ACF_PAGES + '/' + this.productId)
        .then((response) => {
          this.acf = response.data.acf;
        })
        .catch((error) => {
          window.location.href = '/error';
        });
    }

    public goToProductSheet() {
      router.push({ name: 'productsheet', params: { productPath: this.productPath }});
    }
}
</script>

<style lang="scss" scoped>
    .bottle {
        border: 1px grey solid;
        text-align: center;
    }

    .product-size {
        height: 380px;
    }
</style>