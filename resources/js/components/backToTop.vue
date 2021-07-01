<template>
    <div class="back-to-top"
        :class="hasScrolled ? null : 'transparent'">
        <a class="back-to-top__link" href="#">
            <i class="back-to-top__icon fas fa-arrow-up"></i>
        </a>
    </div>
</template>

<script>
    export default {
        mounted() {
            window.addEventListener('scroll', this.testScroll);
        },
        data() {
            return {
                hasScrolled : false
            }
        } ,
        methods : {

            testScroll(ev){
                if(window.pageYOffset>200)
                    this.hasScrolled = true;
            }
        }
    }
</script>

<style scoped lang="scss">

    @import "../../sass/variables";

    .back-to-top {
        position: fixed;
        z-index: 850;
        bottom: $spacing-standard;
        right: $spacing-standard;
        background-color: $color-primary-light;
        text-align: center;
        border-radius: $border-radius-standard;
        border: 1px solid $color-primary-light;
        transition: background $animation-time-standard , opacity $animation-time-very-slow;


        @include shadow-standard;   

        &__link {
            display: block;
            width: $height-section-small;
            height: $height-section-small;
            line-height: $height-section-small;
            transition: all $animation-time-standard;

            &:link ,
            &:hover ,
            &:active ,
            &:visited {
                color: $white;
                text-decoration: none;
            }
        }

        &:hover {
            background-color: $white;            

            .back-to-top__link {
                color: $color-primary-light;
            }
        }

        &__icon {
            font-size: 1.5em;
            // position: relative;
            // top: 3px;
            width: 100%;
            height: 100%;
            line-height: 5rem;
        }
    }
</style>