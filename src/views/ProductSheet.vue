<template>
    <div class="p-3">
        <Product v-bind:fullDescription="true" v-bind:productPath="$route.params.productPath"/>
        <span class="font-weight-bold underline lead">Notre gamme complète : </span>
        <Products productsCategory="cognacs"/>
    </div>
</template>

<script lang="ts">
  import {Component, Prop, Vue} from 'vue-property-decorator';
  import Product from '@/components/Product.vue';
  import Products from '@/components/Products.vue';

  @Component({
    components: {
      Product,
      Products,
    },
  })
  export default class ProductSheet extends Vue {
    @Prop() private productPath!: string;
    // @Prop() private productsCategory!: string;
  }
</script>
