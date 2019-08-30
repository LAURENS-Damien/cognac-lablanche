<template>
    <div>
        <div class="bottle">
            <!--        <img alt="" src="@/../test/mocks/pages/products/xo/cognac_xo.jpg">-->
            <img alt="" v-bind:src="product.img.rendered">
        </div>
        <span v-html="product.title.rendered" class="font-weight-bold"></span>
        <br>
        <span v-html="product.appellation.rendered"></span>
        <p v-if="fullDescription" v-html="product.description.rendered">Description</p>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import * as Constants from '@/ts/constants';
    import axios from 'axios';

    @Component
    export default class Product extends Vue {
        @Prop() private fullDescription!: boolean;
        private product = {};

        public created() {
            axios.get(Constants.URL_COGNAC_XO)
                .then((response) => {
                    this.product = response.data;
                })
                .catch((error) => {
                    window.location.href = '/error';
                });
        }
    }
</script>

<style lang="scss" scoped>
    .bottle {
        border: 1px grey solid;
        text-align: center;
    }
</style>