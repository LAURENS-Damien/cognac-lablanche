<template>
    <div class="container-fluid">
        <ul class="row">
            <li v-for="product in products" class="col-12 col-lg-3 mb-5">
                <Product v-bind:fullDescription="false" v-bind:productPath="product.productPath" v-bind:productsCategory="productsCategory"/>
            </li>
        </ul>
    </div>
</template>

<script lang="ts">
import {Component, Prop, Vue, Watch} from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import Product from './Product.vue';

@Component({
  components: {
    Product,
  },
})
export default class Products extends Vue {
  @Prop() private productsCategory!: string;
  private products: any[] = [];

  public created() {
    this.getProducts();
  }

  @Watch('productsCategory')
  public getProducts() {
    this.axios.get(Constants.URL_CATALOG + '/' + this.productsCategory)
      .then((response) => {
        this.products = [];
        for (const product in response.data) {
          if (product !== '') {
            const productJSON = {
              productPath : this.productsCategory + '/' + response.data[product].post_name,
            };
            this.products.push(productJSON);
          }
        }
      })
      .catch(() => {
        window.location.href = '/erreur';
      });
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