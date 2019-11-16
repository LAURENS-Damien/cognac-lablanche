<template>
    <div class="historic container-fluid limit-max-width my-3 my-lg-5">
        <h1 class="my-lg-5">{{ historic.title }}</h1>
        <div class="row">
            <div class="col-12 col-lg-5 pt-3" v-html="historic.image"></div>
            <div class="col-12 col-lg-7 pt-3" v-html="historic.content"></div>
        </div>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import axios from 'axios';
  import * as Constants from '@/ts/constants';

  @Component
  export default class Historic extends Vue {
    private historic = {};

    public created() {
      axios.get(Constants.URL_HISTORIC)
        .then((response) => {
          this.historic = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
    }
  }
</script>
