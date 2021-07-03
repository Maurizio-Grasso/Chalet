<template>
    <a :href="'single/'+id" class="single-apartment"
        :class="is_sponsored ? 'single-apartment--sponsored' : null">

        <div class="sponsored-box">
            
            <span class="sponsored-box__text">
                In Evidenza
            </span>

            <i class="sponsored-box__icon far fa-thumbs-up"></i>

        </div>

        <div class="single-apartment__image-container">
            <img :src="imgSrc" :alt="name"
                class="single-apartment__image">
        </div>

        <div class="single-apartment__data">
            <h3 class="single-apartment__name">{{name}}</h3>
            
            <p class="single-apartment__description" v-html="excerpt">
                <!-- {{}} -->
            </p>

            <div class="single-apartment__services">
                
                <span class="single-apartment__rating"><i class="fas fa-star"></i>{{rating}}</span>
                <span class="single-apartment__beds hide-on-mobile"><i class="fas fa-user"></i>{{beds}}</span>
                <!-- <span class="single-apartment__rating"><i class="fas fa-restroom"></i>2</span> -->
                <span class="single-apartment__price"><i class="fas fa-euro-sign"></i>{{price}}</span>
                <span v-if="dist" fclass="single-apartment__distance"><i class="fas fa-map-marker-alt"></i>{{Math.round(dist * 100) / 100}} Km</span>
                
                <!-- <a :href="'single/'+id" class="btn btn--secondary btn--small">Prenota</a> -->

            </div>
        </div>

    </a>
</template>

<script>
    export default {
        mounted() {
            this.dist = Math.round(this.dist * 100) / 100;
        },
        props : ['name' , 'imgSrc' , 'rating' , 'id' , 'price' , 'beds' , 'is_sponsored' , 'dist' , 'excerpt'] ,
    }
</script>

<style lang="scss">
@import "../../sass/variables";

    .single-apartment {
        height: $height-section-big;
        width: 100%;
        border-radius: $border-radius-standard;
        overflow:hidden;
        display: flex;
        flex-direction: row;
        background-color: $white;
        text-align: center;
        transition: box-shadow $animation-time-slow;
        // transition: color $animation-time-standard;

        @include shadow-standard;

        &:link ,
        &:hover,
        &:visited,
        &:active,
        &:focus {
            text-decoration: none;
            color: inherit;
        }

        &:hover {

            @include shadow-enhanced;

            .single-apartment__image {
                transform: scale(1.1);
            }

            .single-apartment__name {
                color: $color-primary-light;
            }

            .single-apartment__services i ,
            .single-apartment__services strong{
                color: $color-primary-light;
            }
        }

        &:not(:last-child){
            margin-bottom: $spacing-more;
        }

        &__image-container {
            height: 100%;
            flex: 0 0 50%;
            overflow: hidden;
        }

        &__image {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform $animation-time-very-slow;
        }

        &__name {
            margin-bottom: 0;
            transition: color $animation-time-slow;

        }

        &__data {
            flex: 0 0 50%;
            padding: $spacing-small;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        &__description {
            // font-size: 80%;
        }

        &__services {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            width: 100%;

            i {
                margin-right: .5rem;            
                font-size: 90%;
                transition: color $animation-time-slow;
            }

        }

        .sponsored-box {
            display: none;
        }

        &--sponsored {
            position: relative;

            .sponsored-box {
                display: block;
            }

        }
    }

    .sponsored-box {
        position: absolute;
        left: $spacing-small;
        top: $spacing-small;
        background-color: $white;
        z-index: 100;
        padding-left: $spacing-small;
        padding-right: $spacing-small;
        color: $color-secondary;
        height: 3.5rem;
        line-height: 3.5rem;
        border-radius: $border-radius-standard;
    }
    
</style>