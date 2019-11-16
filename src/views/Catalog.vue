<template>
    <div class="catalog container-fluid limit-max-width">
        <div class="row mt-lg-5">
            <div class="col-12">
                <Production/>
            </div>
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
