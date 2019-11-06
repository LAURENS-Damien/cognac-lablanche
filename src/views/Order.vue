<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>{{ order.title }}</h1>
                <p class="pt-3" v-html="order.content"></p>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import * as Constants from '@/ts/constants';
  import axios from 'axios';

  @Component
  export default class Order extends Vue {
    private order = {};

    public created() {
      axios.get(Constants.URL_ORDER)
        .then((response) => {
          this.order = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
    }
  }
</script>

<style lang="scss" scoped>

</style>