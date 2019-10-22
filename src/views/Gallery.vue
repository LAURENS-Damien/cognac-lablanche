<template>
        <div class="gallery container-fluid pt-3">
            <div class="row" v-html="gallery.content">
            </div>
        </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import * as Constants from '@/ts/constants';
  import axios from 'axios';

  @Component
  export default class Gallery extends Vue {
    private gallery: any[] = [];
    // private galleryJSON = {};

    public created() {
      axios.get(Constants.URL_GALLERY)
        .then((response) => {
          this.gallery = response.data;
        })
        .catch((error) => {
          window.location.href = '/error';
        });
    }

  }
</script>

<style lang="scss">
    .gallery {
        & img {
            width: 100%;
        }
    }
</style>