<template>
    <div class="home-page container-fluid limit-max-width">
        <div class="row mt-lg-5">
            <div class="col-12 col-lg-6 pt-3" v-html="homePage.image"></div>
            <div class="col-12 col-lg-6">
                <h1 class="text-center" v-html="homePage.title"></h1>
                <Separator/>
                <div class="text-center" v-html="homePage.content"></div>
            </div>
            <Coordinates class="col-12 pt-3 pt-lg-5 text-center "/>
        </div>
        <div class="row pt-4">
            <div class="col-12 px-0">
                <Production/>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Separator from '@/components/Separator.vue';
    import Production from '@/components/Production.vue';
    import * as Constants from '@/ts/constants';
    import Coordinates from '@/components/Coordinates.vue';

    @Component({
      components: {
        Coordinates,
        Separator,
       Production,
      },
    })
    export default class HomePage extends Vue {
      private homePage = {};

      public created() {
        this.axios.get(Constants.URL_HOME_PAGE)
          .then((response) => {
            this.homePage = response.data;
          })
          .catch(() => {
            window.location.href = '/erreur';
          });
      }
    }
</script>
