<template>
    <div>
        <p class="text-center">Téléphone</p>
        <p class="text-center">+33 (0)5 62 69 74 58</p>
        <p class="pt-2 text-center">Ouvert toute l'année</p>
        <p class="text-center">
            9h-12h30 et 14h-18h (Lun-Ven)<br>
            9h-12h30 et 14h-17h30 (samedi)
        </p>
        <p class="text-center">Ouvert le samedi du 1er juin au 30 septembre</p>
        <p class="text-center">Fermé le dimanche et les jours fériés.</p>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Contact extends Vue {
    }
</script>

<style lang="scss" scoped>

</style>