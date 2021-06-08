<template>
  <div id="catalog" class="row">
    <Production class="col-12"/>
  </div>
</template>

<script lang="ts">
import {Component, Mixins, Vue} from 'vue-property-decorator';
import Production from '@/components/Production.vue';
import MetaTitleMixins from '@/ts/mixins/MetaTitleMixins';
import MetaDescriptionMixins from '@/ts/mixins/MetaDescriptionMixins';

@Component({
  components: {
    Production,
  },
})
export default class Catalog extends Mixins(MetaTitleMixins, MetaDescriptionMixins) {
  public metaTitle = 'Catalogue de Cognacs, Pineaux des Charentes et vins de pays - CL';
  public metaDescription = 'A la recherche de Cognacs, Pineaux des Charentes, Pétillants de raisin ou autres Vins de Pays Mainart, venez découvrir le catalogue de Cognac LABLANCHE';
}
</script>
