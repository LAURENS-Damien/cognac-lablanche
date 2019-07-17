<template>
  <div id="app">
    <Navigation/>
    <router-view/>
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
    @Component({
        components: {
            Navigation,
        },
    })
    export default class App extends Vue {
    }
</script>