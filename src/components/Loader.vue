<template>
    <div class="header">
        <div v-if="isLoading">
            <Spinner/>
        </div>
        <div v-else>
            <slot></slot>
        </div>
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
