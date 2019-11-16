<template>
    <div class="contact container-fluid limit-max-width my-3 my-lg-5">
        <h1 class="my-lg-5">{{ contact.title }}</h1>
        <Coordinates/>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import axios from 'axios';
  import * as Constants from '@/ts/constants';
  import Coordinates from '@/components/Coordinates.vue';

  @Component({
    components: {
      Coordinates,
    },
  })
  export default class Contact extends Vue {
    private contact = {};

    public created() {
      axios.get(Constants.URL_CONTACT)
        .then((response) => {
          this.contact = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
    }
  }
</script>

<style lang="scss" scoped>

</style>
