<template>
    <div class="container-fluid">
        <div class="row" v-html="contact.content"></div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import * as Constants from '@/ts/constants';

    @Component
    export default class Coordinates extends Vue {
      private contact = {};

      public created() {
        this.axios.get(Constants.URL_CONTACT)
          .then((response) => {
            this.contact = response.data;
          })
          .catch(() => {
            window.location.href = '/erreur';
          });
      }
    }
</script>
