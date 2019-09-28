<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="text-center" v-html="accueilPage.title.rendered"></div>
                <Separator/>
                <div class="text-center" v-html="accueilPage.content.rendered"></div>
                <Contact class="pt-5"/>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-12 px-0">
                <Products/>
            </div>
        </div>
        <div class="row">
            <div class="col-12 px-0">
                <Footer/>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Separator from '@/components/Separator.vue';
    import Contact from '@/components/Contact.vue';
    import Products from '@/components/Catalog.vue';
    import Footer from '@/components/Footer.vue';
    import axios from 'axios';
    import * as Constants from '@/ts/constants';

    @Component({
      components: {
        Separator,
          Contact,
         Products,
           Footer,
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
