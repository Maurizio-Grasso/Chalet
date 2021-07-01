<template>

    <div v-if="dataIsReady" class="slider-wrapper">
        
        <div @click="showPreviousItem" class="prev">
            <i class="fas fa-angle-left"></i>
        </div>

        <div class="cards">
            
            <a 
            v-for=" (item , index) in shownItems"
            :key="index"
            :href="'/single/'+apartments[shownItems[index]]['id']"
            class="card">

                <div class="card__img">
                    <img :src="'../storage/'+apartments[shownItems[index]]['cover_img']" class="img_slider" alt="">
                </div>

                <div class="card__data">

                    <h4 class="card__title">{{apartments[shownItems[index]]['name']}}</h4> 
                    
                    <i v-for="(star,index) in Math.ceil(apartments[shownItems[index]]['rating'])" 
                      :key="'fullStar'+index" class="fas fa-star"></i><i v-for="(star,index) in (5 - Math.ceil(apartments[shownItems[index]]['rating']))" 
                      :key="'emptyStar'+index" class="far fa-star"></i>

                </div>

            </a><!-- Card End -->

        </div><!-- Cards END -->


        <div @click="showNextItem" class="next">
            <i class="fas fa-angle-right"></i>
        </div>  

    </div>

</template>


<script>
        export default {
        mounted() {
            
            if(screen.width <= 600)
                this.itemsShown = 1;
            else if (screen.width <= 1024) 
                this.itemsShown = 2;
            else
                this.itemsShown = 3;
            
            
            this.shownItems = [];

            for (let i = 0; i < this.itemsShown; i++) {
                this.shownItems.push(i);
            }

            self = this;    // alias
                axios
                    .get('http://127.0.0.1:8000/api/getSponsoredApt' , {
                        params: {
                            nOfItems    :   6
                            }
                        })
                    .then((response)=>{
                        self.apartments = response.data.results;    // Salva l'array degli apt ottenuti nella variabile apartments
                        self.dataIsReady = true;                       
                });

        } 
        ,
        data() {
            return {
                apartments:  null ,
                itemsShown:  null ,
                shownItems:  null ,                
                dataIsReady: null ,
            }
        },
        methods : {
            showPreviousItem(){
                // mostra elemento precedente
                for(let i = 0; i < this.shownItems.length; i++) {
                let current = this.shownItems[i];
                current == 0 ? current = (this.apartments.length -1) : --current;
                this.shownItems.splice(i , 1 , current );
                console.log("Sto cambiando shownitems");
                }                
            },
            showNextItem(){
                // mostra elemento successivo

                for(let i = 0; i < this.shownItems.length; i++) {
                    let current = this.shownItems[i];
                    current == (this.apartments.length -1) ? current = 0 : ++current;
                    this.shownItems.splice(i , 1 , current );
                    console.log("Sto cambiando shownitems");
                }
            },
        }
    }
    
</script>

<!-- Style della pagina. Scoped=>Valido solo per la pagina -->

<style scoped lang="scss">

@import "../../sass/variables";


    .slider-wrapper {
        position: relative;
        margin: auto;
        width: 100%;
    }

    .cards {
        // width: 100%;
        width: calc(100% - (2 * 5rem));
        margin: auto;
        display: flex;
    }

    .card{        
        padding:$spacing-standard;
        border-radius: $border-radius-standard;
        display: block;
        flex: 0 0 calc((100% - 2 * #{$spacing-standard}) / 3);

        @include responsive(tablet) {            
            flex: 0 0 calc((100% - #{$spacing-standard}) / 2);            
        }

        @include responsive(phone) {            
            flex: 0 0 100%;
        }

        // @include responsive(phone) {
        //     width: 100%;
        //     height: $height-section-big;
        //     margin-bottom:$spacing-more;
        // }
        
        &:link ,
        &:visited,
        &:active,
        &:hover {
            color: $color-primary;
            text-decoration: none;
        }

        &:not(:last-child) {
            margin-right: $spacing-standard;
        }

        @include shadow-standard;


        &__data {
            line-height: $height-section-medium / 2;
            padding-top: $spacing-standard;
            // line-height: $height-section-medium / 2;
            // width: calc(100% - 2 * #{$spacing-standard});
            background-color: rgba($white , .5);
        }

        &__title {
            font-size: 2.5rem;
            margin-bottom: 0;
        }

        &__img{
            height: 100%;
            width: 100%;
            height: $height-section-big;

            img{
                border-radius: $border-radius-standard;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }                    
        }        
    }

    .prev,
    .next {
        position: absolute;
        color: $color-primary;
        top: 50%;
        transform: translateY(-50%) scaleY(1.5);
        font-size: 6rem;
        cursor: pointer;
        width: 5rem;
        i {
            padding: 0;
        }
        @include responsive(tablet) {
            font-size: 5rem;
        }
    }

    .next {
        left: auto;
        right: 0;
        text-align: right;
    }
    .prev {
        left: 0;
        right: auto;
        text-align: left;

    }

</style>
