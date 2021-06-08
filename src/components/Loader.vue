<template>
    <div class="header">
        <template v-if="isLoading">
            <Spinner/>
        </template>
        <template v-else>
            <slot></slot>
        </template>
    </div>
</template>

<script lang="ts">
  import {Component, Prop, Vue} from 'vue-property-decorator';
  import {ViewState} from '@/ts/Models';
  import Spinner from '@/components/Spinner.vue';
  @Component({
    components: {
      Spinner,
    },
  })
    export default class Loader extends Vue {
        @Prop() private loading!: ViewState;

        get isLoading(): boolean {
            return this.loading === ViewState.Loading;
        }
    }
</script>
