<template>
    <div class="footer p-3">
        <span>Copyright Cognac Lablanche © 2020 Tous droits réservés.</span>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    @Component
    export default class Footer extends Vue {

    }
</script>

<style lang="scss" scoped>
    .footer {
        background-color: $hf-color;
        color: white;
    }
</style>
