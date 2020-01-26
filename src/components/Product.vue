<template>
    <div class="product container-fluid">
        <div class="row">
            <div class="col-12 px-0" v-bind:class="fullDescription ? 'col-lg-4' : ''">
                <div class="bottle" v-bind:class="fullDescription ? 'product-king-size' : 'product-size'" v-html="product.image" v-on:click="goToProductSheet"></div>
                <span v-html="product.title" class="d-block col-12 px-0 font-weight-bold"/>
                <span v-html="acf.appellation" class="d-block col-12 px-0"/>
                <span v-if="!fullDescription" v-html="acf.prix" class="d-block col-12 px-0"/>
                <br>
            </div>
            <div class="col-12 col-lg-8 px-0 px-lg-4">
                <div class="row">
                    <div v-if="fullDescription" class="col-12 pt-2">
                        <span class="underline font-weight-bold">Description :</span>
                        <p v-html="acf.description">Description</p>
                        <span class="underline font-weight-bold">Cépage :</span>
                        <p v-html="acf.cepage">Cépage</p>
                        <span class="underline font-weight-bold">Température :</span>
                        <p v-html="acf.temperature_ideale_de_service">Température</p>
                        <span class="underline font-weight-bold">Nez :</span>
                        <p v-html="acf.nez">Nez</p>
                        <span class="underline font-weight-bold">Bouche :</span>
                        <p v-html="acf.bouche">Bouche</p>
                        <span class="underline font-weight-bold">Suggestions :</span>
                        <p v-html="acf.suggestions">Suggestions</p>
                        <span class="underline font-weight-bold">Divers :</span>
                        <p v-html="acf.divers">Divers</p>
                        <span class="underline font-weight-bold">Prix :</span>
                        <p v-html="acf.prix" class="text-price">Prix</p>
                    </div>
                </div>
            </div>
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
        border: 1px $hf-color solid;
        text-align: center;
    }

    .product-size {
        height: 380px;
    }

    .product-king-size {
        height: 500px;
    }

    @include media-breakpoint-up(md)  {
        .product-king-size {
            height: 700px;
        }
    }
</style>