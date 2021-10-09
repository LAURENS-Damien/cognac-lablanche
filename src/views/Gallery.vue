<template>
  <Loader v-bind:loading="viewState">
    <div id="gallery" class="pt-3" v-if="galleryDatas !== null">
      <h1 class="my-lg-5">{{ galleryDatas.title }}</h1>
      <h2 class="pb-3">Photos</h2>
      <div class="row" v-html="galleryDatas.content"></div>
      <h2>Vidéos</h2>
      <div class="row py-3">
        <div class="col-12 col-lg-6 py-3" style="height: 315px;">
          <iframe width="100%" height="100%" src="https://www.youtube.com/embed/mnn90IqBom4" frameborder="0"
                  title="Vidéo de présentation de l'exploitation"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        </div>
        <div class="col-12 col-lg-6 py-3" style="height: 315px;">
          <iframe width="100%" height="100%" src="https://www.youtube.com/embed/-GCaizOmjlE" frameborder="0"
                  title="Vidéo de dégustation de brulots"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        </div>
        <div class="col-12 col-lg-6 py-3" style="height: 315px;">
          <iframe width="100%" height="100%" src="https://www.youtube.com/embed/MNhGwR2S4rI" frameborder="0"
                  title="Vidéo de présentation de la conduite du vignoble"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        </div>
        <div class="col-12 col-lg-6 py-3" style="height: 315px;">
          <iframe width="100%" height="100%" src="https://www.youtube.com/embed/tVdm6HB07H4" frameborder="0"
                  title="Vidéo de présentation de l'aire de camping car"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
import {Component, Mixins, Vue} from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import Loader from '@/components/Loader.vue';
import {ViewState} from '@/ts/Models';
import {CampingCarParkingDatas, GalleryDatas} from '@/ts/WpDatas';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';
@Component({
  components: {Loader},
})
export default class Gallery extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Galerie de photos et de vidéos - Cognac LABLANCHE';
  public metaDescription = 'Notre savoir faire en photos et vidéos';
  private viewState: ViewState = ViewState.Loading;

  get galleryDatas(): GalleryDatas | null {
    if (this.$store.getters.wpDatas.galleryDatas !== undefined) {
      this.viewState = ViewState.Loaded;
      return this.$store.getters.wpDatas.galleryDatas;
    } else {
      return null;
    }
  }

  public created() {
    this.$store.dispatch('loadWpDatas');
  }

}
</script>
