<template>
    <div class="row">
        <div class="col-12">
            <Production/>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Production from '@/components/Production.vue';

    @Component({
      components: {
        Production,
      },
    })
    export default class Catalog extends Vue {}
</script>

<style scoped>

</style>