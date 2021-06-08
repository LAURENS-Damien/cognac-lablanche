<template>
  <Loader v-bind:loading="viewState">
    <div id="historic" class="my-3 my-lg-5" v-if="historicDatas !== null">
      <h1 class="my-lg-5">{{ historicDatas.title }}</h1>
      <div class="row">
        <div class="col-12 col-lg-5 pt-3" v-html="historicDatas.image"></div>
        <div class="col-12 col-lg-7 pt-3" v-html="historicDatas.content"></div>
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
import {Component, Mixins, Vue} from 'vue-property-decorator';
import {HistoricDatas} from '@/ts/WpDatas';
import {ViewState} from '@/ts/Models';
import Loader from '@/components/Loader.vue';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component({
  components: {Loader},
})
export default class Historic extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'L\'histoire de la maison Cognac LABLANCHE';
  public metaDescription = 'La maison Cognac LABLANCHE, plus d\'un siècle de savoir faire!';
  private viewState: ViewState = ViewState.Loading;

  get historicDatas(): HistoricDatas | null {
    if (this.$store.getters.wpDatas.historicDatas !== undefined) {
      this.viewState = ViewState.Loaded;
      return this.$store.getters.wpDatas.historicDatas;
    } else {
      return null;
    }
  }

  public created() {
    this.$store.dispatch('loadWpDatas');
  }
}
</script>
