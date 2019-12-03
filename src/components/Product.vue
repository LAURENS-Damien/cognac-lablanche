<template>
    <div class="product">
        <div class="bottle product-size" v-html="product.image" v-on:click="goToProductSheet"></div>
        <span v-html="product.title" class="font-weight-bold"></span>
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
import router from '@/router';

@Component
export default class Product extends Vue {

    @Prop() private productPath!: string;
    @Prop() private productsCategory!: string;
    @Prop() private fullDescription!: boolean;
    private productId: number = 0;
    private productName: string = '';
    private acf: string = '';
    private product = {};

    public created() {
      this.getProduct();
    }

    @Watch('productPath')
    public getProduct() {
      this.axios.get(Constants.URL_PRODUCT + '/' + this.productPath)
          .then((response) => {
            this.productId = response.data.id;
            this.productName = response.data.post_title;
            this.getCustomFields();
            this.product = response.data;
          })
          .catch(() => {
            window.location.href = '/erreur';
          });
    }

    public getCustomFields() {
      this.axios.get(Constants.URL_ACF_PAGES + '/' + this.productId)
        .then((response) => {
          this.acf = response.data.acf;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
    }

    public goToProductSheet() {
      router.push({ name: 'productsheet',
                    params: { productPath: this.productPath, productsCategory: this.productsCategory }});
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