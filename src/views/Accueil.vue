<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                Page d'accueil
                <Separator/>
                Page d'accueil<br>
                Page d'accueil<br>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Separator from '@/components/Separator.vue';

    @Component({
      components: {
        Separator,
      },
    })
    export default class Accueil extends Vue {}
</script>
