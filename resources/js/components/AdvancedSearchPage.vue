<template>

    <main class="main main--advanced-search">

        <advanced-search-form 
            v-if="dataIsReady"
            v-on:updateFilters="filterResults()" 
            v-on:updateLocation="search()"
            :currentQuery="currentQuery"
            :highestAptPrice="currentQuery.highestAptPrice"
            :servicesList="servicesList"
            >

            <!-- Search Form -->

        </advanced-search-form>

        <apartments-list 
            v-if="dataIsReady"
            :apartments="listApartments" 
            :mapIsShown="mapIsShown"
            :foundApt="apartments.length"
            v-on:resetFilters="resetFilters(true)"
             class="apartments-list--full-width">

            <!-- Lista degli appartamenti -->

        </apartments-list>

        <chalet-map 
            v-if="dataIsReady"
            v-on:mapToggled="toggleMap()" 
            :baseLon="baseLon" 
            :baseLat="baseLat"
            :apartments="mapApartmens"
            :radius="currentQuery.maxDistance">

            <!-- Mappa -->

        </chalet-map>

    </main>
    
</template>

<script>
    export default {

        mounted() {
            this.resetFilters(false);   // Imposta filtri per Query di partenza

            this.currentQuery.baseLocation = this.destination;  // Location di partenza
            this.currentQuery.maxDistance  = 20;                // Raggio di ricerca di default

            this.getServicesList();     // Compila lista servizi
            this.search();              // Esegue la prima ricerca
        },
        data() {
            return {
                
                dataIsReady : false,            // flag: mostra i componenti solo quando sarà = true
                mapIsShown : true,              // true se la mappa è visualizzata, false se l'utente l'ha nascosta

                // Liste di Appartamenti
                apartments: [] ,                // Lista Generale con tutti i risultati trovati
                filteredApartments : [] ,       // Appartamenti che soddisfano i filtri definiti dall'utente
                listApartments : [],            // Array ottimizzato per il component apartmentList
                mapApartmens : [],              // Array ottimizzato per il component chaletMap

                // Coordinate Località ricercata
                baseLat  : 0 ,                  // latitudine
                baseLon : 0 ,                   // Longituine

                // Query di ricerca dell'utente
                currentQuery : {
                    baseLocation     : null ,   // Località o indirizzo cercato dall'utente
                    maxDistance      : null ,   // Raggio entro il quale effettuare il filtraggio
                    highestAptPrice  : null ,   // Prezzo più alto fra quelli di tutti gli appartamenti corrisponenti alla località
                    maxPrice         : null ,   // Prezzo massimo definito dall'utente
                    guests           : null ,   // Numero di Ospiti per il quale è stata effettuata la ricerca
                    minRating        : null ,   // Punteggio minimo dell'appartamento definito dall'utente
                    minRooms         : null ,   // Minimo numero di camere richieste dall'utente
                    selectedServices : null ,   // Lista dei servizi richiesti dall'utente
                } ,

                servicesList : [],              // Array di tutti i possibili servizi presenti sul db
            }
        },
        props : ['destination'] ,   // Arriva come parametro URL e deriva da uno dei link in home page oppure dalla località cha abbiamo scelo di default
        methods : {

            //  Metodo che imposta sui valori più permissivi tutti i filtri (tranne quelli gestiti separatamente)
            resetFilters(needToFilter){
                    
                this.currentQuery.maxDistance      = 60;
                this.currentQuery.guests           = 1;
                this.currentQuery.minRating        = 1;
                this.currentQuery.minRooms         = 1;
                this.currentQuery.selectedServices = [];
                this.currentQuery.maxPrice = this.currentQuery.highestAptPrice;

                if(needToFilter) this.filterResults();
            },

            // Metodo che cambia la variabile flag all'apaprire o allo scomparire della mappa
            toggleMap(){
                this.mapIsShown == false ? this.mapIsShown = true : this.mapIsShown = false;
            },

            // Metodo che richiede la lista complessiva dei servizi al database tramite chiamata API
            getServicesList(){
                axios
                .get('http://127.0.0.1:8000/api/services')
                .then((servicesList)=>{                    
                    this.servicesList = servicesList.data.results;
                });
            },
            
            // Metodo che si occupa di cercare sul database gli appartamenti presenti entro 60Km dalla località cercata
            search() {
                console.log("Occhio: Sto per lanciare una nuova richiesa al server!");
                self = this;    // alias
                axios
                    .get('http://127.0.0.1:8000/api/location' , {
                        params: {
                            location    :   this.currentQuery.baseLocation ,
                            radius      :   60  // max radius                
                            }
                        })
                    .then((response)=>{

                        // *********************************************
                        // Trasformo la lista dei servizi da array di oggetti ad array di stringhe
                        // (Benché ciò dovrebbe avvenire lato server...)
                        response.data.results.forEach(apt => {
                            if(apt.services.length>0){                                
                                let tmpArray=[];                                
                                apt.services.forEach(service => {
                                    service.service_id ? tmpArray.push(service.service_id) : null;                                
                                });
                                apt.services = tmpArray;
                            }
                        }); // Fine Conversione
                        // *********************************************

                        self.apartments = response.data.results;    // Salva l'array degli apt ottenuti nella variabile apartments

                        self.baseLat = response.data.base_lat;      // latitudine  località cercata dall'utente
                        self.baseLon = response.data.base_lon;      // Longitudine località cercata dall'utente
                        
                        self.filterResults();                       // Filtra Dati appena ottenuti in base alle richieste dell'utente

                        self.dataIsReady = true;                    // trigger flag: alla prima ricerca effettuata mostretà searchForm, Map e AptList                        
                });
            } ,

            //  Metodo che esamina l'array degli apt restituito dal db e trova il prezzo più alto fra tutti
            getHighestPrice() {
                
                if(!this.currentQuery.highestAptPrice) this.currentQuery.highestAptPrice = 299;
                
                if (this.apartments.length == 0) return // Se la lista di appartamenti è vuota abbandona la fuzione

                let tmpHighestPrice = this.apartments[0].price;
                this.apartments.forEach(apt => {
                    apt.price > tmpHighestPrice ? tmpHighestPrice = apt.price : null;
                });

                this.currentQuery.highestAptPrice = Math.ceil(tmpHighestPrice);

            } ,

            //  Metodo che si occupa di filtrare l'array di apt restituito dal db in base ai filtri applicati dall'utente
            filterResults(){
                
                // Resetta tutte le liste di apt tranne quella 'grezza' che utilizzeremo per il filtraggio
                this.filteredApartments = [];   
                this.listApartments = [];
                this.mapApartmens = [];
                
                this.getHighestPrice();     // Richiede prezzo più alto fra apt presenti in array generale
                
                // Imposta prezzo massimo su quello più elevato fra gli apt in array nel caso in cui l'utente non... 
                // ...lo avesse ancora definito o questo fosse superiore a quello più elevato fra gli apt in array
                if(!this.currentQuery.maxPrice || this.currentQuery.maxPrice > this.currentQuery.highestAptPrice ) 
                    this.currentQuery.maxPrice = this.currentQuery.highestAptPrice;
                
                if(this.apartments.length == 0) return;     // se l'array degli apt è vuoto abbandona la funzione

                
                // Per l'effettivo filtraggio viene utilizzato for 
                // (preferito al foreach per la possibilità di usare 'continue')
                
                mainFor: for(let i = 0; i < this.apartments.length ; i++) {

                    const apt   = this.apartments[i];   // Alias
                    const query = this.currentQuery;    // Alias

                    if (apt.dist > query.maxDistance)   continue;   // Filtro distanza
                    if (apt.price > query.maxPrice)     continue;   // Filtro Prezzo
                    if ( apt.rating < query.minRating ) continue;   // filtro Punteggio
                    if ( apt.beds < query.guests )      continue;   // Filtro Posti letto
                    if ( apt.rooms < query.minRooms )   continue;   // Filtro Camere
                    
                    // Controllo Servizi Aggiuntivi
                        
                    if(query.selectedServices.length > 0){                  // Se sono stati richiesti servizi
                        
                        for(let i=0; i<query.selectedServices.length; i++){ // Ciclo tutti i servizi richiesti dall'utente
                            const reqServ = query.selectedServices[i];      // alias
                            let found = false;                              // flag

                            for(let j=0; j<apt.services.length; j++){       // per ogni servizio richiesto controllo che sia presente fra quelli offerti dall'appartamento
                                const aptServ = apt.services[j];
                                if(aptServ == reqServ) found = true;        // Se il servizio è present porto il flag a true
                            }   // inner for

                            if (found == false) continue mainFor;           // se anche un solo servizio richiesto non era presente l'appartamento è scartato
                        }

                    }

                    this.filteredApartments.push(apt);   // Se l'appartamento soddisfa tutti i filtri lo pusho nell'array degli apt filtrati            
                                    
                }  // main for

                if (this.filteredApartments.length > 1) this.sortApartments();  // Se il filtraggio restituisce più di un apt, lancia metodo di ordinamento
                
                //  array ottimizzato per visualizzazione su mappa 
                this.mapApartmens = this.filteredApartments.map(({lat, lon , id , name , price , is_sponsored , cover_img}) => ({lat, lon , id , name , price , is_sponsored, cover_img}));

                //  array ottimizzato per visualizzazione card apt
                this.listApartments = this.filteredApartments.map(({id , name , price, dist, beds, rating, is_sponsored, cover_img , excerpt}) => ({id , name , price, dist, beds, rating, is_sponsored, cover_img , excerpt}));

            },

            // Metodo che si occupa di ordinare gli apt filtrati in mase all'eventuale sponsorizzazione ed alla distanza dalla località cercata dall'utente
            sortApartments(){
                
                let sortedApt = []; //  Predispongo array
                    
                while(this.filteredApartments.length > 1) {
                    
                    let minDist   = this.filteredApartments[0].dist;
                    let closerApt = 0;

                    for(let i = 0; i < this.filteredApartments.length ; i++) {                        
                        const apt   = this.filteredApartments[i];   // Alias
                        if(apt.dist <= minDist) {
                            minDist  = apt.dist;
                            closerApt = i;                            
                        }
                    }

                    sortedApt.push(this.filteredApartments[closerApt]); // aggiunge l'apt la cui distanza è quella minima all'array degli apt ordinati
                    this.filteredApartments.splice(closerApt , 1);  // Rimuove l'apt appena aggiunto dall'array principale per escluderlo dalle verifiche successive

                }

                sortedApt.push(this.filteredApartments[0]); // pusha l'ultimo apt rimasto nell'array principale (non gestito dal while)

                this.filteredApartments = [];

                // A questo punto filteredApartments è vuoto mentre sortApartments contiene tutti gli apt già ordinati
                
                // Ricreo l'array filteredApartments inserrendo ai primi posti gli apt sponsorizzati
                for(let i = 0; i < sortedApt.length ; i++)
                    if(sortedApt[i].is_sponsored) this.filteredApartments.push(sortedApt[i]);

                // Dopo gli apt sponsorizzati inserisco quelli rimanenti
                for(let i = 0; i < sortedApt.length ; i++)
                    if(!sortedApt[i].is_sponsored) this.filteredApartments.push(sortedApt[i]);

            },
        }
    }
</script>

<style scoped lang="scss">

@import "../../sass/variables";

    .main--advanced-search {
        height: calc(100vh - #{$height-section-medium});
        background-color: $bg-transparent;
        max-width: $width-inner-content;
        margin-left: auto;
        margin-right: auto;
        position: relative;

        .apartments-list {
            width: 100%;
            padding: $spacing-standard $spacing-more;
            padding-right: 50%;
            height: calc(100vh - 2 * #{$height-section-medium});
            overflow-x: auto;
            overflow-y: auto;

            @include responsive(tablet) {
                padding-right: $spacing-standard;
                height: calc( 100% - #{$height-section-big} - #{$height-section-medium});
            }

            @include responsive(phone) {
                padding: $spacing-standard;
            }

            &--map-hidden {
                height: calc(  100% - #{$height-section-medium}); 
            }
        }
    }
</style>
