<template>

<!-- Template:Codice HTML -->

    <div class="img_slider">

        <div id="root" class="container">

                <div class="slider-wrapper">

                    <div @click="prevImage" class="prev">
                        <i class="fas fa-angle-left"></i>
                    </div>

                    <div class="images">
                        
                        <img :src="'/storage/' + photos[counter]['img_path']" class="img_slider" alt="">

                        <div class="nav">                            
                            <div 
                                 v-for="(photo , index) in photos" :key="index"
                                :class="(index==counter) ? active : null" 
                                 class="img_preview" 
                                 @click="circleClick(index)">

                                <img :src="'/storage/' + photo['img_path']" alt="">

                            </div>
                        </div>

                    </div>

                    <div @click="nextImage" class="next">
                        <i class="fas fa-angle-right"></i>
                    </div>
                    
                </div>
        </div>
    </div>

</template>

<!-- Utilizzo Vue -->

<script>
        export default {
        mounted() {
            
        } 
        ,
        data() {
            return {
                active: "active",
                counter: 0
            }
        },
        props : ['photos'],
        methods : {
            prevImage: function() {
            this.counter--;
            if (this.counter < 0) {
                this.counter = (this.photos.length - 1);
                console.log(this.counter);
            }
        },
        nextImage: function() {
            this.counter++;
            if (this.counter > this.photos.length - 1) {
                this.counter = 0;
                console.log(this.counter);
            }
        },
        circleClick: function(index) {
            this.counter = index;
        },
        }
    }
</script>

<!-- Style della pagina. Scoped=>Valido solo per la pagina -->

<style scoped lang="scss">

@import "../../sass/variables";


.container {
    max-width:$width-inner-content;
    margin: 0 auto;
    .slider-wrapper {
        position: relative;
        margin: auto;
        width: 100%;

            .images {
                // height: 100%;
                text-align: center;
                img.active {
                display: inline-block;
                }

                .img_slider {
                    width: 100%;
                    height: $height-section-huge;
                    border-radius: $border-radius-standard;
                    object-fit: cover;
                }
            }
    }
    .prev,
    .next {
        position: absolute;
        color: $white;
        top:calc( #{$height-section-huge} / 2);
        transform: translateY(-50%) scaleY(1.5);
        font-size: 8rem;
        opacity: .75;
        cursor: pointer;
        
        @include responsive(phone) {
            display: none;
        }
    }

    .prev {
        left: $spacing-standard;
        right: auto;
    }

    .next {
        left: auto;
        right: $spacing-standard;
    }


    .nav {
            // @include responsive(phone) {
            //     display: none;
            // }
        padding: $spacing-tiny;
        border-radius: $border-radius-standard;
        background: rgba(0, 0, 0, .7);
    }

    .img_preview {
        padding:$spacing-tiny;
        display: inline-block;
        width: 10rem;
        height: 10rem;
        cursor: pointer;


        img{
            width: 100%;
            border-radius: $border-radius-standard;
            object-fit: cover;
            height:100%;
            border: 2px solid transparent;
            transition: border-color $animation-time-standard;
        }
    }
    .img_preview.active{
        img{
            border-color: $white;
        }
    }
    .slider-wrapper.none {
    display: none;
    }
}


</style>
