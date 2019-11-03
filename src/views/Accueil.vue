<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="text-center" v-html="accueilPage.post_title"></div>
                <Separator/>
                <div class="text-center" v-html="accueilPage.post_content"></div>
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
    export default class Accueil extends Vue {
      private accueilPage = {};

      public created() {
        axios.get(Constants.URL_PAGE_ACCUEIL)
          .then((response) => {
            this.accueilPage = response.data;
          })
          .catch((error) => {
            window.location.href = '/error';
          });
      }
    }
</script>
