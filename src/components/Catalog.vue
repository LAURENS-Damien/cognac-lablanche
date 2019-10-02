<template>
    <div>
        <h2>Notre production</h2>
        <ul>
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

    public changeProductsCategory(event: any): void {
      this.productsCategoryToDisplay = event.target.getAttribute('productsCategoryToDisplay');
    }
}
</script>

<style lang="scss" scoped>

</style>