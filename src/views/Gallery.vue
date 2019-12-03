<template>
    <div class="gallery container-fluid limit-max-width pt-3">
        <h1 class="my-lg-5">{{ gallery.title }}</h1>
        <div class="row" v-html="gallery.content">
        </div>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import * as Constants from '@/ts/constants';

  @Component
  export default class Gallery extends Vue {
    private gallery = {};

    public created() {
      this.axios.get(Constants.URL_GALLERY)
        .then((response) => {
          this.gallery = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
    }

  }
</script>
