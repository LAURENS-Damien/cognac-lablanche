<template>
    <div class="row">
        <div class="col-12 text-center">
            Une erreur s'est produite, merci de réessayer ultérieurement.
            <b-button variant="success" class="d-block">Retour à la page d'accueil</b-button>
        </div>
    </div>
</template>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator';
  @Component
  export default class Error extends Vue {}
</script>
