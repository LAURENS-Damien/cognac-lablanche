<template>
    <div>
        <h2>Notre production</h2>
        <ul>
            <li v-for="product in products">
                {{ product.title.rendered }}
            </li>
        </ul>
        <div class="px-2">
            <Product v-bind:fullDescription="false"/>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Product from '@/components/Product.vue';
    import axios from 'axios';
    import * as Constants from '@/ts/constants';

    @Component({
        components: {
            Product,
        },
    })
    export default class Products extends Vue {
        private products = {};

        public created() {
            axios.get(Constants.URL_PRODUCTS)
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    window.location.href = '/error';
                });
        }
    }
</script>

<style lang="scss" scoped>

</style>