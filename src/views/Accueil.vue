<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                Page d'accueil
                <Separator/>
                Page d'accueil<br>
                Page d'accueil<br>
                <div v-for="page in accueilPage">
                    {{page.content.rendered}}
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Separator from '@/components/Separator.vue';
    import axios from 'axios';
    import * as Constants from '@/ts/constants';

    @Component({
      components: {
        Separator,
      },
    })
    export default class Accueil extends Vue {
      private accueilPage = [];

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
