<template>
    <div class="row">
        <div class="col-12">
            <Product v-bind:fullDescription="true" v-bind:productPath="$route.params.productPath"/>
        </div>
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
