<template>
  <div id="app">
    <Navigation/>
    <div class="container-fluid limit-max-width">
      <router-view/>
    </div>
    <Footer/>
  </div>
</template>

<style lang="scss">
  @import url('https://fonts.googleapis.com/css?family=Farro&display=swap');

  body {
    font-family: 'Farro', cursive;
  }
</style>
<script>
    import { Component, Vue } from 'vue-property-decorator';
    import Navigation from './components/Navigation';
    import Footer from './components/Footer';

    @Component({
        components: {
          Footer,
          Navigation,
        },
    })
    export default class App extends Vue {
    }
</script>