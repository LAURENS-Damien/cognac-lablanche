<template>
    <div>
        <h2>Notre production</h2>
        <ul id="catalogProductsList">
            <li v-for="products in catalog" v-on:click="changeProductsCategory" v-bind:productsCategoryToDisplay="products.post_name">
                {{ products.post_title }}
            </li>
        </ul>
        <div class="px-3">
            <Products v-if="this.productsCategoryToDisplay != ''" v-bind:productsCategory="this.productsCategoryToDisplay"/>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import axios from 'axios';
import * as Constants from '@/ts/constants';
import Products from '@/components/Products.vue';

@Component({
    components: {
        Products,
    },
})
export default class Catalog extends Vue {
    private catalog = [];
    private productsCategoryToDisplay = '';

    public created() {
        axios.get(Constants.URL_CATALOG)
            .then((response) => {
                this.catalog = response.data;
                this.productsCategoryToDisplay = response.data[0].post_name;
            })
            .catch((error) => {
              window.location.href = '/error';
            });
    }

    public mounted() {
      const defaultProductCategories = document.getElementById('catalogProductsList');
      // console.log('TOTO1');
      // console.log(defaultProductCategories);
      if (defaultProductCategories !== null) {
        // console.log('TOTO2');
        // console.log(defaultProductCategories.childElementCount);
        if (defaultProductCategories.firstElementChild !== null) {
          // console.log(defaultProductCategories.firstElementChild.classList);
          // console.log('TOTO3');
          defaultProductCategories.firstElementChild.classList.add('underline');
        }
      }
    }

    public changeProductsCategory(event: any): void {
      this.productsCategoryToDisplay = event.target.getAttribute('productsCategoryToDisplay');
      const catalogProductsList = document.getElementById('catalogProductsList');
      if (catalogProductsList !== null) {
        for (const child of catalogProductsList.children) {
          child.classList.remove('underline');
        }
      }
      event.target.classList.add('underline');
    }
}
</script>

<style lang="scss" scoped>

</style>