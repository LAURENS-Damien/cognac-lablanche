<template>
    <div class="home-page container-fluid limit-max-width">
        <Loader v-bind:loading="viewState">
            <div v-if="homePageDatas != null" class="row mt-lg-5">
                <div class="col-12 col-lg-6 pt-3" style="height: 315px;">
                  <iframe width="100%" height="100%" src="https://www.youtube.com/embed/mnn90IqBom4" frameborder="0"
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
                    <Coordinates class="col-12 py-3 pb-lg-5 text-center"/>
                </div>
            </div>
        </Loader>
    </div>
</template>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator';
  import Separator from '@/components/Separator.vue';
  import Production from '@/components/Production.vue';
  import Coordinates from '@/components/Coordinates.vue';
  import Spinner from '@/components/Spinner.vue';
  import {HomePageDatas, ViewState} from '@/ts/Models';
  import Loader from '@/components/Loader.vue';

  @Component({
    components: {
      Loader,
      Coordinates,
      Separator,
      Production,
      Spinner,
    },
  })
  export default class HomePage extends Vue {
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
