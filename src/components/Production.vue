<template>
  <Loader :loading="viewState">
    <div class="pt-3 pt-lg-5">
      <h2 class="text-lg-center">Notre production</h2>
      <ul class="text-lg-center">
        <li v-for="category in productionDatas"
            :class="['category d-lg-inline-block px-lg-3', isUnderlined(category) ? 'underline' : null]"
            v-html="category.categoryTitle"
            @click="changeCategory(category)">
        </li>
      </ul>
      <Products class="px-1" :productsCategory="currentCategoryName"/>
    </div>
  </Loader>
</template>


<script lang="ts">
import {Component, Vue, Watch} from 'vue-property-decorator';
import Products from '@/components/Products.vue';
import {ViewState} from '@/ts/Models';
import {Category, ProductionDatas} from '@/ts/WpDatas';
import Loader from '@/components/Loader.vue';

@Component({
  components: {
    Loader,
    Products,
  },
})
export default class Production extends Vue {
  private viewState: ViewState = ViewState.Loading;
  private currentCategory: Category | null = null;

  public created() {
    this.$store.dispatch('loadWpDatas');
  }

  @Watch('productionDatas')
  public onProductionDatasChange() {
    if (this.productionDatas !== null && this.currentCategory === null) {
      this.currentCategory = this.productionDatas[0];
      this.viewState = ViewState.Loaded;
    }
  }

  get productionDatas(): ProductionDatas | null {
    return this.$store.getters.wpDatas.productionDatas;
  }

  get currentCategoryName(): string | null {
    if (this.currentCategory !== null) {
      return this.currentCategory.categoryName;
    } else {
      return null;
    }
  }

  public isUnderlined(category: Category): boolean {
    if (category.categoryName === this.currentCategory?.categoryName) {
      return true;
    } else {
      return false;
    }
  }

  public changeCategory(newCategory: Category) {
    if (this.currentCategory !== null) {
      this.currentCategory.selected = false;
    }
    this.currentCategory = newCategory;
    this.currentCategory.selected = true;
  }
}
</script>

<style lang="scss" scoped>
.category {
  &:hover {
    cursor: pointer;
  }
}
</style>
