<template>
    <div class="vineyard-management container-fluid limit-max-width my-3 my-lg-5">
        <h1 class="my-lg-5">{{ vineyardMnagement.title }}</h1>
        <div class="row">
            <div class="col-12 col-lg-5 pt-3" v-html="vineyardMnagement.image"></div>
            <div class="col-12 col-lg-7 pt-3" v-html="vineyardMnagement.content"></div>
        </div>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import axios from 'axios';
  import * as Constants from '@/ts/constants';

  @Component
  export default class VineyardManagement extends Vue {
    private vineyardMnagement = {};

    public created() {
      axios.get(Constants.URL_VINEYARD_MANAGEMENT)
        .then((response) => {
          this.vineyardMnagement = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
    }
  }
</script>

<style lang="scss" scoped>

</style>