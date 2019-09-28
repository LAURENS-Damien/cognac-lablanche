<template>
    <div>
        <h2>Notre production</h2>
        <ul>
            <li v-for="products in catalog">
                {{ products.post_title }}
            </li>
        </ul>
        <div class="px-3">
            <Products v-bind:productsCategory="catalog[0].post_name"/>
            <!--<Product v-bind:fullDescription="false" v-bind:productCategory="products[1].post_title"/>-->
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
        private catalog = {};

        public created() {
            axios.get(Constants.URL_CATALOG)
                .then((response) => {
                    this.catalog = response.data;
                })
                .catch((error) => {
                  window.location.href = '/error';
                });
        }
    }
</script>

<style lang="scss" scoped>

</style>