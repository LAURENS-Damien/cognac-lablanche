<template>
  <div id="home-page">
    <Loader v-bind:loading="viewState">
      <template v-if="homePageDatas !== undefined">
        <div class="row mt-lg-5">
          <div class="video-container col-12 col-lg-6 pt-3">
            <iframe class="video-presentation"
                    width="100%" height="100%" src="https://www.youtube.com/embed/mnn90IqBom4"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
          </div>
          <div class="col-12 col-lg-6">
            <h1 class="text-center" v-html="homePageDatas.title"></h1>
            <Separator/>
            <div class="text-center" v-html="homePageDatas.content"></div>
          </div>
          <div class="col-12">
            <Production/>
          </div>
        </div>
        <div class="row">
          <div class="col-12 px-0">
            <Coordinates class="col-12 py-3 pb-lg-5"/>
          </div>
        </div>
      </template>
    </Loader>
  </div>
</template>

<script lang="ts">
import {Component, Mixins} from 'vue-property-decorator';
import Separator from '@/components/Separator.vue';
import Production from '@/components/Production.vue';
import Coordinates from '@/components/Coordinates.vue';
import Spinner from '@/components/Spinner.vue';
import {ViewState} from '@/ts/Models';
import Loader from '@/components/Loader.vue';
import {HomePageDatas} from '@/ts/WpDatas';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component({
  components: {
    Loader,
    Coordinates,
    Separator,
    Production,
    Spinner,
  },
})
export default class HomePage extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Cognac LABLANCHE, producteur de Cognac, Pineau des Charentes';
  public metaDescription = 'A la recherche de Cognacs, Pineaux des Charentes, Pétillants de raison ou autres vins de Pays Charentais? Nous vous donnons rendez vous sur la commune de Chadenac en Charente-Maritime';
  private viewState: ViewState = ViewState.Loading;

  get homePageDatas(): HomePageDatas {
    if (this.$store.getters.wpDatas.homePageDatas !== undefined) {
      this.viewState = ViewState.Loaded;
    }
    return this.$store.getters.wpDatas.homePageDatas;
  }

  public created() {
    this.$store.dispatch('loadWpDatas');
  }
}
</script>

<style lang="scss" scoped>
.video-container {
  height: px-to-rem(315);

  .video-presentation {
    border: none;
  }
}
</style>