<template>
    <div class="p-3">
        <Breadcrumb v-bind:items="items"/>
        <Product v-bind:fullDescription="true" v-bind:productPath="$route.params.productPath"/>
        <span class="font-weight-bold underline lead">Notre gamme complète : </span>
        <Products v-bind:productsCategory="$route.params.productsCategory"/>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import Breadcrumb from '@/components/Breadcrumb.vue';
  import Product from '@/components/Product.vue';
  import Products from '@/components/Products.vue';

  @Component({
    components: {
      Breadcrumb,
      Product,
      Products,
    },
  })
  export default class ProductSheet extends Vue {
    private items = {};

    public created() {
      this.items = [
        {
          text: 'Catalogue',
          href: '/catalogue',
        },
        {
          text: 'Fiche Produit',
          active: true,
        },
      ];
    }
  }
</script>
