<template>
    <section class="apartments-list"
    :class="mapIsShown ? null : 'apartments-list--map-hidden'">


        <!-- Box mostrato se non ci sono chalet da mostrare  -->

        <div v-if="(apartments.length==0) && foundApt!==undefined" class="results-warning">
            
            <i class="results-warning__icon fas fa-exclamation-circle"></i>
            <h3 class="results-warning__title">
                Nessuno Chalet Trovato
            </h3>

            <!-- Se tuttavia esistono degli chalet esclusi dai filtri -->

            <p v-if="foundApt!=0">Nessun risultato disponibile, ma <strong>{{foundApt}}</strong> chalet della zona <span v-if="foundApt>1">sono stati nascosti</span><span v-else>è stato nascosto</span> in base ai filtri selezionati. 
                    <span class="results-warning__reset"
                        @click="$emit('resetFilters')">
                        Clicca qui</span> per azzerare i filtri e visualizzarl<span v-if="foundApt>1">i</span><span v-else>o</span>!
            </p>

            <!-- Se nemmeno con i filtri azzerati esistono chalet disponibili per la località  -->

            <p v-else>Nessun risultato disponibile per questa ricerca; prova a scegliere un'altra località!</p>                
            <p>Oppure, lasciati ispirare dai nostri chalet in evidenza presenti in ogni zona d'Italia!</p>

        </div>

        <!-- Box mostrato nel caso in cui, pur mostrando alcuni chalet, altri rimancono nascosti in base ai filtri applicati -->

        <div v-else-if="(apartments.length < foundApt)" class="results-warning">
            <i class="results-warning__icon fas fa-exclamation-circle"></i>

            <p>Stai visualizzando <strong>{{apartments.length}}</strong> chalet dei <strong>{{foundApt}}</strong> disponibili in quest'area. Per resettare i filtri e visualizzare tutte le opzioni, fai <span class="results-warning__reset"
                        @click="$emit('resetFilters')">
                        click qui</span>,
            </p>

        </div>

        <apartment-card 
            v-for="(apartment , index) in outputApt"
            :key="index" 
            :name="apartment.name" 
            :imgSrc="'storage/' + apartment.cover_img"
            :rating="apartment.rating"
            :id="apartment.id"
            :price="apartment.price"
            :beds="apartment.beds"
            :is_sponsored="apartment.is_sponsored"
            :dist="apartment.dist"
            :excerpt="apartment.excerpt"
            >

            <!-- Apartment Card Component -->

        </apartment-card>

    </section>
</template>

<script>
    export default {
        mounted() {

            this.loadSponsored();
        },
        props : [
            'apartments' ,  // Array di appartamenti da mostrare
            'mapIsShown' ,  // Booleano che indica se la mappa è visibile
            'foundApt' ,      // Numero di appartamenti esistenti per la località, compresi quelli esclusi dal filtraggio
            ],
        watch: {    
            apartments: {                
                handler: function() {
                    this.setOutputArray();
                }
            }
        },
        data() {
            return {
                outputApt    : null,    // Array di appartamenti che sarà effettivamente renderizzato
                sponsoredApt : [],      // Array di apt Sponsorizzati
                showSponsored: false,   // Mostrare apt Sponsorizzati (in assenza di quelli relativi alla ricerca?)
            }
        },
        methods : {
            
            //  Metodo che stabilisce se visualizzare apt Sponsorizzati in caso di assenza risultati
            setOutputArray(){
                if(this.apartments.length > 0) this.outputApt = this.apartments;
                else this.outputApt = this.sponsoredApt;
            },

            // Metodo che effettua una chiamata per ottenere lista di apt sponsorizzati
            loadSponsored(){
                console.log("Sto richiedendo la lista di apt sponsorizzati");
                const self = this;
                axios
                    .get('http://127.0.0.1:8000/api/getSponsoredApt' , {
                        params: {
                            nOfItems    :   6
                            }
                        })
                    .then((response)=>{
                        self.sponsoredApt = response.data.results;
                        self.setOutputArray();
                });
            }
        }
    }
</script>

<style lang="scss">

@import "../../sass/variables";

    .apartments-list {

        display: flex;
        flex-direction: row;
        justify-content: space-between;
        flex-wrap: wrap;
        align-content: flex-start;

        &--full-width {
            .single-apartment {
                flex: 0 0 100%;
            }
        }

        &--responsive {
            .single-apartment {
                flex: 0 0 calc((100% - #{$spacing-standard}) / 2);
                
                @include responsive(tablet) {
                    flex: 0 0 100% ;            
                }
            }
        }
    }

    .results-warning {
    width: 100%;
    background-color: $white;
    margin-bottom: $spacing-more;

    @include responsive(phone) {
        margin-bottom: $spacing-standard;
    }
    
    border-radius: $border-radius-standard;
    padding: $spacing-standard;
    border: 1px dashed $orange;
    position: relative;

    &>:nth-child(2) {
        padding-right: $spacing-standard + 5rem;
    }

    &__title {
        color: $orange;
        margin-bottom: $spacing-standard;
    }

    &__icon {
        position: absolute;
        top: $spacing-small;
        right: $spacing-standard;
        font-size: 5rem;
        color: $orange;
    }

    &__reset {
        color: $color-primary;
        text-decoration: underline;
        cursor: pointer;
    }

    p:not(:last-child) {
        margin-bottom: $spacing-standard;
    }
}

</style>