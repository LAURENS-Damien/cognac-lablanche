<template>
    <b-navbar toggleable="lg" class="flex-lg-column hf-color">
        <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>

        <b-navbar-brand><img alt="Vue logo" v-bind:src="iconUrl"></b-navbar-brand>

        <b-collapse id="nav-text-collapse" is-nav>
            <b-navbar-nav>
                <li class="nav-item">
                    <router-link class="nav-link" to="/" style="color: white;">Accueil</router-link>
                </li>
                <b-nav-item-dropdown text="L'exploitation" right>
                    <b-dropdown-item href="/historique">Historique</b-dropdown-item>
                    <b-dropdown-item href="/conduite-vignoble">Conduite du vignoble</b-dropdown-item>
                    <b-dropdown-item href="/parking-camping-car">Parking camping car</b-dropdown-item>
                </b-nav-item-dropdown>
                <li class="nav-item">
                    <router-link class="nav-link" to="/galerie">Galerie</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/catalogue">Catalogue</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/contact">Contact</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/newsletter">Newsletter</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/commander">Vente de nos produits</router-link>
                </li>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  @Component
  export default class Navigation extends Vue {
    public iconUrl = process.env.VUE_APP_ICON;
  }
</script>
