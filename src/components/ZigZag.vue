<template>
  <div class="row mb-5">
    <div class="col-12 col-lg-6 pt-3" :class="imagePosition % 2 === 0 ? 'order-1' : 'order-2'" v-html="image"></div>
    <div class="col-12 col-lg-6 pt-3" :class="imagePosition % 2 === 0 ? 'order-2' : 'order-1'">
      <div class="col-12 mb-3" v-html="title"></div>
      <p class="col-12" v-html="content"></p>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';

@Component
export default class ZigZag extends Vue {
  @Prop() private title!: string;
  @Prop() private content!: string;
  @Prop() private image!: string;
  @Prop() private imagePosition!: number;
}
</script>
