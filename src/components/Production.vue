<template>
    <div class="container-fluid">
        <h2 class="text-lg-center">Notre production</h2>
        <ul id="productsList" class="text-lg-center">
            <li v-for="(products, index) in production" v-on:click="changeProductsCategory" v-bind:productsCategoryToDisplay="products.post_name" :class="index === 0 ? 'underline' : ''" class="d-lg-inline-block px-lg-3">
                {{ products.post_title }}
            </li>
        </ul>
        <div class="px-1">
            <Products v-if="this.productsCategoryToDisplay !== ''" v-bind:productsCategory="this.productsCategoryToDisplay"/>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import Products from '@/components/Products.vue';

@Component({
    components: {
        Products,
    },
})
export default class Production extends Vue {
    private production = [];
    private productsCategoryToDisplay = '';

    public created() {
      this.axios.get(Constants.URL_CATALOG)
            .then((response) => {
                this.production = response.data;
                this.productsCategoryToDisplay = response.data[0].post_name;
            })
            .catch(() => {
              window.location.href = '/erreur';
            });
    }

    public changeProductsCategory(event: any): void {
      this.productsCategoryToDisplay = event.target.getAttribute('productsCategoryToDisplay');
      const productsList = document.getElementById('productsList');
      if (productsList !== null) {
        for (const child of productsList.children) {
          child.classList.remove('underline');
        }
      }
      event.target.classList.add('underline');
    }
}
</script>

<style lang="scss" scoped>
    li {
        &:hover {
            cursor: pointer;
        }
    }
</style>
