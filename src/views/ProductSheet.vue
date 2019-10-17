<template>
    <div class="p-3">
        <Product v-bind:fullDescription="true" v-bind:productPath="$route.params.productPath"/>
        <span class="font-weight-bold underline lead">Notre gamme complète : </span>
        <Products v-bind:productsCategory="$route.params.productsCategory"/>
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
  }
</script>
