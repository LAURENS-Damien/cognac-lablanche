<template>
  <div class="about">
    <h1 class="maClass">This is an about page with my text : {{message}}</h1>
      <button v-on:click="affiche">TEST méthode</button>
      <div v-for="page in pages">
          {{page.content.rendered}}
      </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import axios from 'axios';
import * as Constants from '@/ts/constants';
// import Services from '@/ts/Services';

@Component
export default class About extends Vue {
  private message: string = 'Test';
  private pages = [];

  public affiche() {
    alert(process.env.VUE_APP_API_PATH);
  }

  public created() {
    axios.get(Constants.URL_PAGES)
      .then((response) => {
        this.pages = response.data;
      })
      .catch((error) => {
        // handle error
        window.location.href = '/error';
      });
    // const test = Services.getWPDData();
    // alert(test);
    // Services.getWPDData().then((value) => this.pages = value.data);
  }

}
</script>

<style lang="scss">

  .maClass{
    color: $color;
  }
</style>
