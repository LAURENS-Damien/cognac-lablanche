<template>
  <Loader v-bind:loading="viewState">
    <div id="contact" class="my-3 my-lg-5" v-if="contactDatas !== null">
      <h1 class="my-lg-5">{{ contactDatas.title }}</h1>
      <Coordinates/>
    </div>
  </Loader>
</template>

<script lang="ts">
import {Component, Mixins, Vue} from 'vue-property-decorator';
import Coordinates from '@/components/Coordinates.vue';
import Loader from '@/components/Loader.vue';
import {ViewState} from '@/ts/Models';
import {ContactDatas} from '@/ts/WpDatas';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component({
  components: {
    Loader,
    Coordinates,
  },
})
export default class Contact extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Contacts - Cognac LABLANCHE';
  public metaDescription = 'Découvrez nos coordonnées téléphoniques, notre adresse ainsi que nos horaires d\'ouvreture';
  private viewState: ViewState = ViewState.Loading;

  get contactDatas(): ContactDatas | null {
    if (this.$store.getters.wpDatas.contactDatas !== undefined) {
      this.viewState = ViewState.Loaded;
      return this.$store.getters.wpDatas.contactDatas;
    } else {
      return null;
    }
  }

  public created() {
    this.$store.dispatch('loadWpDatas');
  }
}
</script>

<style lang="scss" scoped>

</style>
