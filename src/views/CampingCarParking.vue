<template>
  <Loader v-bind:loading="viewState">
    <div id="camping-car-parking" class="my-3 my-lg-5" v-if="campingCarParkingDatas !== null">
      <h1 class="my-lg-5" v-html="campingCarParkingDatas.title"></h1>
      <div class="row">
        <div class="col-12 col-lg-5 pt-3" v-html="campingCarParkingDatas.image"></div>
        <div class="col-12 col-lg-7 pt-3" v-html="campingCarParkingDatas.content"></div>
      </div>
    </div>
  </Loader>
</template>

<script lang="ts">
import {Component, Mixins, Vue} from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import {ViewState} from '@/ts/Models';
import {CampingCarParkingDatas, HistoricDatas} from '@/ts/WpDatas';
import Loader from '@/components/Loader.vue';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component({
  components: {Loader},
})
export default class CampingCarParking extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Parking camping car - Cognac LABLANCHE';
  public metaDescription = 'Venez découvrir notre exploitation à pieds, voiture ou même en camping car!';
  private viewState: ViewState = ViewState.Loading;

  get campingCarParkingDatas(): CampingCarParkingDatas | null {
    if (this.$store.getters.wpDatas.campingCarParkingDatas !== undefined) {
      this.viewState = ViewState.Loaded;
      return this.$store.getters.wpDatas.campingCarParkingDatas;
    } else {
      return null;
    }
  }

  public created() {
    this.$store.dispatch('loadWpDatas');
  }
}
</script>
