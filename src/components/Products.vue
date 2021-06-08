<template>
  <Loader :loading="viewState">
    <ul class="row" @click="scrollTop">
      <li v-for="product in products" class="col-12 col-xl-4">
        <Product v-bind:fullDescription="false" v-bind:productPath="product.productPath"
                 v-bind:productsCategory="productsCategory"/>
      </li>
    </ul>
  </Loader>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import Product from './Product.vue';
import Loader from '@/components/Loader.vue';
import {ViewState} from '@/ts/Models';

@Component({
  components: {
    Product,
    Loader,
  },
})
export default class Products extends Vue {
  @Prop() private readonly productsCategory!: string;
  private products: any[] = [];
  private viewState: ViewState = ViewState.Loading;

  public created() {
    this.getProducts();
  }

  @Watch('productsCategory')
  public getProducts() {
    this.viewState = ViewState.Loading;
    this.axios.get(Constants.URL_CATALOG + '/' + this.productsCategory)
        .then((response) => {
          this.products = [];
          for (const product in response.data) {
            if (product !== '') {
              const productJSON = {
                productPath: this.productsCategory + '/' + response.data[product].post_name,
              };
              this.products.push(productJSON);
            }
          }
          this.viewState = ViewState.Loaded;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
  }

  public scrollTop() {
    const top = document.querySelector('.navbar');
    if (top !== null) {
      top.scrollIntoView(false);
    }
  }
}
</script>

<style lang="scss" scoped>
ul {
  list-style: none;
  padding-inline-start: 0;
}

li {
  &:hover {
    cursor: pointer;
  }

}
</style>