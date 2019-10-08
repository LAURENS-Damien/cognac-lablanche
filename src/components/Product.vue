<template>
    <div>
        <div class="bottle">
                    <img alt="" src="@/../test/mocks/pages/products/cognacs/xo/cognac_xo.jpg">
<!--            <img alt="" v-bind:src="photo" class="product-size">-->
        </div>
        <span v-html="productName" class="font-weight-bold"></span>
        <br>
        <span v-html="appellation"></span><br>
        <span>{{productPath}}</span>
        <!--<p v-if="fullDescription" v-html="product.post_content">Description</p>-->
    </div>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch, Ref } from 'vue-property-decorator';
import * as Constants from '@/ts/constants';
import axios from 'axios';

@Component
export default class Product extends Vue {

    @Prop() private productPath!: string;
    @Prop() private fullDescription!: boolean;
    private productId: number = 0;
    private productName: string = '';
    private featuredMediaUrl: string = '';
    private photo: string = '';
    private appellation: string = '';

    public created() {
      this.getPhoto();
    }

    // @Ref('productPath')
    public getPhoto() {
    // console.log('MAJ productPath');
    // console.log(Constants.URL_PRODUCT + '/' + this.productPath);
    axios.get(Constants.URL_PRODUCT + '/' + this.productPath)
          .then((response) => {
            this.productId = response.data.ID;
            this.productName = response.data.post_title;
            this.getCustomFields();
            // console.log(Constants.URL_PAGES + '/' + this.productId);
            axios.get(Constants.URL_PAGES + '/' + this.productId)
              .then((response2) => {
                const tmp = response2.data._links;
                for (const d in tmp) {
                  if (d === 'wp:featuredmedia') {
                    this.featuredMediaUrl = tmp[d][0].href;
                    // console.log(this.featuredMediaUrl);
                    axios.get(this.featuredMediaUrl)
                      .then((response3) => {
                        this.photo = response3.data.source_url;
                        // console.log(this.photo);
                      })
                      .catch((error) => {
                        window.location.href = '/error';
                      });
                  }
                }
              })
              .catch((error) => {
                window.location.href = '/error';
              });
          })
          .catch((error) => {
            window.location.href = '/error';
          });
    }

    public getCustomFields() {
      axios.get(Constants.URL_ACF_PAGES + '/' + this.productId)
        .then((response) => {
          this.appellation = response.data.acf.appellation;
        })
        .catch((error) => {
          window.location.href = '/error';
        });
    }
}
</script>

<style lang="scss" scoped>
    .bottle {
        border: 1px grey solid;
        text-align: center;
    }

    .product-size {
        height: 380px;
    }
</style>