<template>
    <div class="p-3">
        <Product v-bind:fullDescription="true" v-bind:productPath="$route.params.productPath"/>
    </div>
</template>

<script lang="ts">
  import {Component, Prop, Vue} from 'vue-property-decorator';
  import Product from '@/components/Product.vue';

  @Component({
    components: {
      Product,
    },
  })
  export default class ProductSheet extends Vue {
    @Prop() private productPath!: string;
  }
</script>
