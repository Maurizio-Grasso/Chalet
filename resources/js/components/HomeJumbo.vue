<template>

<div v-if="dataIsReady" class="jumbotron">

            <video v-if="!isMobile" class="jumbotron__bg-video" autoplay muted loop>

                <!-- NOTA: prima di mandare in produzione 
                bisogna assicurarsi che il video non venga
                caricato sui dispositivi mobili! -->

                <source :src="videoSrc" type="video/mp4">
                Browser non supportato!
            </video>

            <img v-else :src="imgSrc" alt="ChaletBnb" class="jumbotron__bg-img">

            <div class="jumbotron__search-box">
                <h1 class="jumbotron__title">Dove vuoi andare?</h1>
                <p class="jumbotron__text">Prenota subito la tua prossima vacanza</p>

                <form :action="searchRoute" method="get" class="form jumbotron__form">
                    <input name="location" type="text" class="form__input jumbotron__input" placeholder="Prova con 'Cortina d'Ampezzo'" minlength=3 required>
                    <button type="submit" class="jumbotron__search-button btn btn--primary-light-inverse">Cerca</button>
                </form>

            </div>
        </div>
</template>

<script>
    export default {
        created(){

            if (screen.width <= 1024) this.isMobile = true
            else return this.isMobile = false;

        },
        mounted() {            
            this.dataIsReady=true;
        },
        props : ['search-route'] ,
        data() {
            return {
                'videoSrc'    : 'img/jumbo-vid.mp4',
                'imgSrc'      : 'img/jumbo-img.jpg' ,
                'dataIsReady' : false,
                'isMobile'    : null,
            }
        },
    }
</script>

<style scoped lang="scss">

@import "../../sass/variables";

.jumbotron {

    margin-top: - $height-section-medium;   // reset main margin
    
    height: 100vh;
    width: 100%;
    background-color: rgba($color-primary , .25);
    
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    position: relative;
    padding: $spacing-standard;

    @include responsive(tablet) {
        margin-top: 0;    
        height: calc(100vh - #{$height-section-medium});
    }

    &__bg-video ,
    &__bg-img   {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -5;
    }

    &__search-box {
        position: relative;
        top: $height-section-medium;

        @include responsive(tablet) {
            top: 0;
        }
        
    }
    
    &__title {
        font-size: 5rem;
        letter-spacing: 5px;
        // margin-bottom: 2rem;
        margin-bottom: $spacing-more;

        @include responsive(phone) {
            font-size: 7rem;
            line-height: 9rem;
            letter-spacing: 7px;
        }

    }
 
    &__text {
        font-size: 2rem;
        text-align: center;
        letter-spacing: 3.5px;
        margin-bottom: 2rem;

        @include responsive(phone) {
            margin-bottom: $spacing-more;
            font-size: 3rem;
        }
    }
    
    &__input {
        height: 4rem;
        width: 70%;
        padding-left: $spacing-small;
        border-radius: $border-radius-standard;
        margin-right: $spacing-small;        
        border: 1px solid $color-primary-light;

        
        &:hover ,
        &:active ,
        &:focus,
        &:focus-visible {
            outline: none;
            // border: none;
        }
        &:focus {
            box-shadow: 0 0 2rem rgba($white , .5);
            border-color: $white;
        }

        @include responsive(phone) {
            display: block;
            margin: auto;
            width: 100%;
            margin-bottom: $spacing-standard;
        }
    }

    &__form {
        padding: $spacing-more;
        background-color: rgba($white,.2);
        border-radius: $border-radius-more;
        
        @include responsive(phone) {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            height: 100%;
            // padding: $spacing-more;
            padding: 5rem;
        }
    }

    &__search-button {
        width: 25%;
        @include responsive(phone) {
            background-color: $color-primary-light;
            color: $white;
            border: 1px solid $white;
            &::hover {
                background-color: $color-primary-light;
                color: $white;
                border: 1px solid $white;

            }
        }
        @include responsive(phone) {
            display: block;
            margin: auto;
            width: 100%;
        }
    }
}
</style>
