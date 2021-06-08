<template>
  <Loader v-bind:loading="viewState">
        <div class="row" v-if="contactDatas !== null" v-html="contactDatas.content"></div>
  </Loader>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import Loader from '@/components/Loader.vue';
import {ViewState} from '@/ts/Models';
import {ContactDatas} from '@/ts/WpDatas';

@Component({
      components: {Loader},
    })
    export default class Coordinates extends Vue {
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
