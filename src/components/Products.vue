<template>
    <div>
        <ul>
            <li v-for="product in products" class="mb-5">
<!--                {{productsCategory + '/' + product.post_name}}-->
                <Product v-bind:fullDescription="false" v-bind:productPath="productsCategory + '/' + product.post_name"/>
            </li>
        </ul>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import axios from 'axios';
import Product from '@/components/Product.vue';

@Component({
  components: {
    Product,
  },
})
export default class Products extends Vue {
  @Prop() private productsCategory!: string;
  private products = {};

  public created() {
    // console.log('Created');
    this.getProducts();
  }

  public getProducts() {
    axios.get(Constants.URL_CATALOG + '/' + this.productsCategory)
      .then((response) => {
        this.products = response.data;
      })
      .catch((error) => {
        window.location.href = '/error';
      });
  }

  @Watch('productsCategory')
  public majProducts() {
    // console.log('MAJ productsCategory');
    axios.get(Constants.URL_CATALOG + '/' + this.productsCategory)
      .then((response) => {
        this.products = response.data;
        // console.log(this.products);
      })
      .catch((error) => {
        window.location.href = '/error';
      });
  }
}
</script>

<style lang="scss" scoped>
    ul {
        list-style: none;
        padding-inline-start: 0;
    }
</style>