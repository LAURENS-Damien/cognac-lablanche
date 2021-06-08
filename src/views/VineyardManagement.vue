<template>
  <div class="vineyard-management container-fluid limit-max-width my-3 my-lg-5">
    <Loader v-bind:loading="viewState">
      <template v-if="vineyardManagementDatas != null">
        <h1 class="my-lg-5" v-html="vineyardManagementDatas.title"></h1>
        <template v-for="(parimage, index) in vineyardManagementDatas.zigzag">
          <ZigZag :image="parimage[1]"
                  :title="parimage[0]"
                  :content="parimage[2]"
                  :image-position="index"/>
        </template>
      </template>
    </Loader>
  </div>
</template>

<script lang="ts">
import {Component, Mixins, Vue} from 'vue-property-decorator';
import ZigZag from '@/components/ZigZag.vue';
import {ViewState} from '@/ts/Models';
import Loader from '@/components/Loader.vue';
import {VineyardManagementDatas} from '@/ts/WpDatas';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component({
  components: {
    Loader,
    ZigZag,
  },
})
export default class VineyardManagement extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Une culture raisonnée et des engagements - Cognac LABLANCHE';
  public metaDescription = 'A la recherche de Cognacs, Pineaux des Charentes, Pétillants de raisin ou autres vins de Pays Charentais? Nous vous donnons rendez vous sur la commune de Chadenac en Charente-Maritime';
  private viewState: ViewState = ViewState.Loading;

  get vineyardManagementDatas(): VineyardManagementDatas {
    if (this.$store.getters.wpDatas.vineyardManagementDatas !== undefined) {
      this.viewState = ViewState.Loaded;
    }
    return this.$store.getters.wpDatas.vineyardManagementDatas;
  }

  public created() {
    this.$store.dispatch('loadWpDatas');
  }
}
</script>
