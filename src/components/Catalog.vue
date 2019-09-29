<template>
    <div>
        <h2>Notre production</h2>
        <ul>
            <li v-for="products in catalog">
                {{ products.post_title }}
            </li>
        </ul>
        <div class="px-3">
            <Products v-if="this.firstProductsCategory != ''" v-bind:productsCategory="this.firstProductsCategory"/>
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
        private firstProductsCategory = '';

        public created() {
            axios.get(Constants.URL_CATALOG)
                .then((response) => {
                    this.catalog = response.data;
                    this.firstProductsCategory = response.data[0].post_name;
                })
                .catch((error) => {
                  window.location.href = '/error';
                });
        }
    }
</script>

<style lang="scss" scoped>

</style>