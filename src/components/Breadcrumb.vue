<template>
    <div>
        <b-breadcrumb v-bind:items="items"></b-breadcrumb>
    </div>
</template>

<script lang="ts">
  import {Component, Prop, Vue} from 'vue-property-decorator';

  @Component
  export default class Breadcrumb extends Vue {
    @Prop() private items!: [];
  }
</script>

<style lang="scss" scoped>
    .breadcrumb {
        background-color: transparent;
        padding-left: 0;
    }
</style>
