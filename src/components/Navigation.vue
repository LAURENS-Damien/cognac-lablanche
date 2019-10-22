<template>
    <b-navbar toggleable="lg" type="dark" variant="dark">
        <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>

        <b-navbar-brand><img alt="Vue logo" src="../assets/logo.png"></b-navbar-brand>

        <b-collapse id="nav-text-collapse" is-nav>
            <b-navbar-nav>
                <li class="nav-item">
                    <router-link class="nav-link" to="/">Accueil</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/galerie">Galerie</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/catalog">Catalogue</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/error">Contact</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/error">Newsletter</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/error">Commander</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/home">Home</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/homeorigin">HomeOrigin</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/about">About</router-link>
                </li>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  @Component
  export default class Navigation extends Vue {

  }
</script>

<style lang="scss" scoped>
</style>