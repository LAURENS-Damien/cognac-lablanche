<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="text-center" v-html="homePage.title"></div>
                <Separator/>
                <div class="text-center" v-html="homePage.content"></div>
                <Coordinates class="text-center pt-3"/>
            </div>
        </div>
        <div class="row pt-5">
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
    import axios from 'axios';
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
        axios.get(Constants.URL_HOME_PAGE)
          .then((response) => {
            this.homePage = response.data;
          })
          .catch(() => {
            window.location.href = '/erreur';
          });
      }
    }
</script>
