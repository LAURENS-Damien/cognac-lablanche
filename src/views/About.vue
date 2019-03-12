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

@Component
export default class About extends Vue {
  private message: string = 'Test';
  private urlPages: string = 'http://localhost/wp-json/wp/v2/pages';
  private pages = [];

  public affiche() {
    alert('TEST2');
  }

  public created() {
    axios.get(this.urlPages)
      .then((response) => {
        this.pages = response.data;
      });
  }

}
</script>

<style lang="scss">

  .maClass{
    color: $color;
  }
</style>
