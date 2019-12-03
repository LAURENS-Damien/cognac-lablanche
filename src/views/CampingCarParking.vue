<template>
    <div class="camping-car-parking container-fluid limit-max-width my-3 my-lg-5">
        <h1 class="my-lg-5">{{ campingCarParking.title }}</h1>
        <div class="row">
            <div class="col-12 col-lg-5 pt-3" v-html="campingCarParking.image"></div>
            <div class="col-12 col-lg-7 pt-3" v-html="campingCarParking.content"></div>
        </div>
    </div>
</template>

<script lang="ts">
  import { Component, Vue } from 'vue-property-decorator';
  import * as Constants from '@/ts/constants';

  @Component
  export default class CampingCarParking extends Vue {
    private campingCarParking = {};

    public created() {
      this.axios.get(Constants.URL_CAMPING_CAR_PARKING)
        .then((response) => {
          this.campingCarParking = response.data;
        })
        .catch(() => {
          window.location.href = '/erreur';
        });
    }
  }
</script>
