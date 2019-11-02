<template>
  <div id="app">
    <Navigation/>
    <router-view/>
    <Footer/>
  </div>
</template>

<style lang="scss">
body {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
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