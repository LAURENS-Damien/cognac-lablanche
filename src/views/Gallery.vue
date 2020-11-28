<template>
  <div class="gallery container-fluid limit-max-width pt-3">
    <h1 class="my-lg-5">{{ gallery.title }}</h1>
    <h2 class="pb-3">Photos</h2>
    <div class="row" v-html="gallery.content"></div>
    <h2>Vidéos</h2>
    <div class="row py-3">
      <div class="col-12 col-lg-6 py-3" style="height: 315px;">
        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/mnn90IqBom4" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
      </div>
      <div class="col-12 col-lg-6 py-3" style="height: 315px;">
        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/tVdm6HB07H4" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
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
