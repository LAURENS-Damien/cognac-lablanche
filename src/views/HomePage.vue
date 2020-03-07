<template>
    <div class="home-page container-fluid limit-max-width">
        <div v-if="isLoading">
            <Spinner/>
        </div>
        <div v-else>
            <div class="row mt-lg-5">
                <div class="col-12 col-lg-6 pt-3" v-html="homePage.image"></div>
                <div class="col-12 col-lg-6">
                    <h1 class="text-center" v-html="homePage.title"></h1>
                    <Separator/>
                    <div class="text-center" v-html="homePage.content"></div>
                </div>
                <Production/>
            </div>
            <div class="row">
                <div class="col-12 px-0">
                    <Coordinates class="col-12 py-3 pb-lg-5 text-center "/>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
  import {Component, Vue, Watch} from 'vue-property-decorator';
  import Separator from '@/components/Separator.vue';
  import Production from '@/components/Production.vue';
  import Coordinates from '@/components/Coordinates.vue';
  import Spinner from '@/components/Spinner.vue';
  import {HomePageDatas, ViewState, WpDatas} from '@/ts/Models';

  @Component({
    components: {
      Coordinates,
      Separator,
      Production,
      Spinner,
    },
  })
  export default class HomePage extends Vue {
    private viewState: ViewState = ViewState.Loading;
    private homePage?: HomePageDatas;

    public created() {
      if (this.wpDatas?.homePageDatas) {
        this.viewState = ViewState.Loaded;
        this.homePage = this.wpDatas.homePageDatas;
      } else {
        this.viewState = ViewState.Loading;
        this.$store.dispatch('loadWpDatas');
      }
    }

    @Watch('wpDatas')
    public onWpDatasChange(wpDatas: WpDatas) {
      if (this.wpDatas?.homePageDatas) {
        this.viewState = ViewState.Loaded;
        this.homePage = wpDatas.homePageDatas;
      } else {
        this.viewState = ViewState.Error;
      }
    }

    get wpDatas(): WpDatas {
      return this.$store.getters.wpDatas;
    }

    get isLoading(): boolean {
      return this.viewState === ViewState.Loading;
    }

    get isError(): boolean {
      return this.viewState === ViewState.Error;
    }
  }
</script>
