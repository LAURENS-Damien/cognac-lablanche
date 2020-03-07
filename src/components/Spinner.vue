<template>
<!--    <div class="grapesBrunch">-->
<!--        <div class="jauge-remplissage1"></div>-->
<!--        <div class="range">-->
<!--            <div class="tail"></div>-->
<!--        </div>-->
<!--        <div class="range">-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--        </div>-->
<!--        <div class="range">-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--        </div>-->
<!--        <div class="range">-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--        </div>-->
<!--        <div class="range">-->
<!--            <div class="grap"></div>-->
<!--            <div class="grap"></div>-->
<!--        </div>-->
<!--        <div class="range">-->
<!--            <div class="grap"></div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="spinner d-flex justify-content-center align-items-center">
        <b-spinner label="Chargement..."></b-spinner>
    </div>
</template>

<script lang="ts">
  import {Component, Vue} from 'vue-property-decorator';

  @Component
  export default class Spinner extends Vue {
  }
</script>

<style lang="scss" scoped>
    .spinner {
        display: flex;
        min-height: 25rem;
    }
    .grapesBrunch {
        position: relative;
        text-align: center;
    }
    .jauge-remplissage1 {
        z-index: -1;
        animation-name: example;
        animation-duration: 4s;
        animation-iteration-count: infinite;
        width: 100%;
        height: 0;
        position: absolute;
        left: 0;
        bottom: 0;
    }
    /* Standard syntax */
    @keyframes example {
        0%   {background-color:purple; left:0px; height:0px;}
        25%  {background-color:purple; left:0px; height:20px;}
        50%  {background-color:purple; left:0px; height:40px;}
        75%  {background-color:purple; left:0px; height:60px;}
        100% {background-color:purple; left:0px; height:80px;}
    }
    .tail {
        display: inline-block;
        height: 20px;
        width: 5px;
        border: 1px solid black;
        border-top-right-radius: 5px;
        /*text-align: center;*/
    }
    .range {
        /*text-align: center;*/
        line-height: 0;
    }
    .grap{
        display: inline-block;
        width: 10px;
        height: 10px;
        border: 1px solid black;
        border-radius: 50%;
    }
    /*#grap1{*/
    /*    display: inline-block;*/
    /*    width: 10px;*/
    /*    height: 10px;*/
    /*    border: 1px solid black;*/
    /*    border-radius: 50%;*/
    /*}*/
    /*#grap2{*/
    /*    display: inline-block;*/
    /*    width: 10px;*/
    /*    height: 10px;*/
    /*    border: 1px solid black;*/
    /*    border-radius: 50%;*/
    /*}*/
    /*#grap3{*/
    /*    display: inline-block;*/
    /*    width: 10px;*/
    /*    height: 10px;*/
    /*    border: 1px solid black;*/
    /*    border-radius: 50%;*/
    /*}*/
    /*#grap4{*/
    /*    display: inline-block;*/
    /*    width: 10px;*/
    /*    height: 10px;*/
    /*    border: 1px solid black;*/
    /*    border-radius: 50%;*/
    /*}*/
    /*#grap5{*/
    /*    display: inline-block;*/
    /*    width: 10px;*/
    /*    height: 10px;*/
    /*    border: 1px solid black;*/
    /*    border-radius: 50%;*/
    /*}*/
</style>