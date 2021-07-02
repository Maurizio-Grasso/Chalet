<template>
        <section class="map-section">
            
            <div class="chalet-map" id="chalet-map">
            </div>  
        
            <div class="chalet-map__button-container">

                <!-- Close Button  -->
                <div class="chalet-map__button chalet-map__button--close"
                    @click="toggleMap()"
                    :class="mapIsShown ? null : 'hidden'">
                    <i class="fas fa-times"></i>
                </div>
                
                <!-- Open Button -->
                <div class="chalet-map__button chalet-map__button--open"
                    @click="toggleMap()"
                    :class="mapIsShown ? 'hidden' : null">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
            </div>
        
        </section>
</template>

<script>
    export default {

        mounted() {

            // Inizializza Mappa
            this.mymap = L.map('chalet-map').setView([this.baseLat, this.baseLon], this.zoomLevel);

            // Aggiunge Layer grafico
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/light-v10',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoibWF1cml6aW8tZ3Jhc3NvIiwiYSI6ImNrbjBhcHYyOTBhd3AydmxyeHE2dm9pMWQifQ.W2n4tefi_FBnxWHAbz_yxA'
            }).addTo(this.mymap);

            //  Crea Marker di Base
            this.markerIcon = L.icon({
                iconUrl: 'img/greenMarker.png',
                shadowUrl: 'img/markerShadow.png',
                iconSize:     [20, 30], // size of the icon
                shadowSize:   [40, 15], // size of the shadow
                iconAnchor:   [20, 30], // point of the icon which will correspond to marker's location
                shadowAnchor: [10, 10],  // the same for the shadow
                popupAnchor:  [0, -22] // point from which the popup should open relative to the iconAnchor
            });

            this.setZoom();             // regola lo zoom
            this.updateCoordinates();   // centra su località cercata
            this.updateMarkers();       // aggiunge markers

        },
        data() {            
            return {                
                mymap        : null ,
                mapIsShown   : true ,
                radiusCircle : null ,
                markers      : null ,
                markerIcon   : null ,
                zoomLevel    : null ,
            }
        },
        props : ['baseLat' , 'baseLon' , 'apartments' , 'radius'] ,
        watch: { 
            baseLat: {                
                handler: function() {
                    this.updateCoordinates();
                }
            } ,
            apartments: {                
                handler: function() {
                    this.updateMarkers();
                }
             } ,
            radius: {                
                handler: function() {
                    this.setZoom();
                    this.updateCoordinates();
                }
            } 
        },
        methods : {            

            //  Metodo che si occupa di mostrare o nascondere l'intera mappa
            toggleMap() {
                this.$emit('mapToggled');
                
                let mapClasses = document.getElementById("chalet-map").classList;                
                this.mapIsShown ? mapClasses.add('hidden') : mapClasses.remove('hidden');                
                this.mymap.invalidateSize();    // Previene deformazione della mappa alla sua ricomparsa
                this.mapIsShown ? this.mapIsShown = false : this.mapIsShown = true;

            } ,

            // Questo metodo esegue le operazioni necessarie al variare
            // della destinazione ricercata dall'utente
            updateCoordinates(){

                // Centra la mappa sulla destinazione cercata
                this.mymap.panTo([ this.baseLat , this.baseLon , {animate: true,} ]);

                // Cancella il cerchio corrisponente al raggio precedente (se esistente)
                if(this.radiusCircle) this.radiusCircle.remove();

                // Crea un nuovo cerchio corrisponente al raggio di ricerca                
                this.radiusCircle = L.circle([this.baseLat, this.baseLon], {
                    color: 'green',
                    fillColor: 'green',
                    fillOpacity: 0.05,
                    radius: this.radius * 1000
                }).addTo(this.mymap);                

            },

            //  Metodo che regola lo zoom in base al raggio di ricerca impostato dall'utente
            setZoom(){

                if(this.radius <= 20) this.zoomLevel = 10;
                    else if (this.radius >= 60) this.zoomLevel = 8;
                    else this.zoomLevel = 9;
                    this.mymap.setZoom(this.zoomLevel);

            },

            // Questo metodo si occupa di aggiornare i marker visibili sulla mappa
            updateMarkers(){                

                // Se sono presenti dei marker precedenti li rimuove dalla mappa                
                if(this.markers){
                    this.markers.forEach(marker => {
                        marker.remove();
                    });
                }

                this.markers=[];    // Reset array

                // Per ogni appartamento che ha superato la selezione 
                // crea un marker nell'array e lo aggiunge alla mappa
                
                this.apartments.forEach(apt => {                    
                    let newMarker = L.marker([apt.lat, apt.lon] , {icon : this.markerIcon});
                    newMarker.bindPopup('<div class="chalet-popup'+ (apt.is_sponsored ? ' chalet-popup--sponsored' : '') +'"><img class="chalet-popup__image" src="storage/' + apt.cover_img + '" alt=""><h4 class="chalet-popup__name">' + apt.name + '</h4><span class="chalet-popup__price">'+ apt.price +'&euro;</span><a class="chalet-popup__link" href="/single/'+apt.id+'">Dettagli <i class="fas fa-long-arrow-alt-right"></i></a></div>');
                    this.markers.push(newMarker);
                    newMarker.addTo(this.mymap);
                });
            }
        }
    }

</script>

<style lang="scss">

    @import "../../sass/variables";

    .chalet-map {
        position: absolute;
        z-index: 2;
        right: $spacing-standard;
        top: $height-section-medium + $spacing-standard;
        width: calc(50% - 2 * #{$spacing-standard});
        height: calc(100vh - 2 * #{$height-section-medium} - 2 * #{$spacing-standard});

        @include responsive(tablet) {
            top: auto;
            right: auto;
            height: $height-section-big;
            width: 100%;
        }

        &__button-container{
            display: none;
            @include responsive(tablet) {
                display: block;
            }
        }
        &__button {
            position: fixed;
            bottom: $height-section-big;            
            right: $spacing-more;                        
            height: $height-section-medium;
            line-height: $height-section-medium;
            width: $height-section-medium;
            transform: translateY(50%);
            z-index: 500;            
            background-color: $white;
            text-align: center;
            border-radius: 50%;
            font-size: 3rem;
            border: 1px solid $color-primary-light;
            transition: background $animation-time-standard , opacity $animation-time-very-slow;
            color: $color-primary-light;
            @include shadow-standard;
            cursor: pointer;
        }

    }

    .chalet-popup {
        width: auto;
        max-height: $height-section-medium;
        width: $height-section-small * 4 + $spacing-small;


        @include clearfix;        
        
        &__image {
            float: left;
            width: $height-section-small;
            height: $height-section-small;
            margin-right: $spacing-small;
            object-fit: cover;
            object-position: center;
            border-radius: $border-radius-standard;
        }

        &__name{
            float: left;
            width: $height-section-small * 3;
            height: $height-section-small / 3 * 2;
            line-height: $height-section-small / 3;
            color: $color-primary;
            clear: right;
            font-size: 120%;
            font-weight: bold;
            }

        &__price {
            float: left;
            height: $height-section-small / 3 * 1;                
        }

        &__link{
            float: right;
            height: $height-section-small / 3 * 1;
            &:link,
            &:active,
            &:visited,
            &:focus {
                color: $color-secondary;
                text-decoration: none;
            }

            &:hover {
                color: $color-secondary-dark;
                text-decoration: underline;
            }
        }

        &--sponsored {
            position: relative;
            &::before {
                content: '\f164';
                position: absolute;
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                color: $color-secondary;
                top: $spacing-tiny;
                left: 0;
                border: 1px solid $color-secondary;
                transform: translate(-50% , -50%);
                height: 2.5rem;
                width: 2.5rem;
                background-color: $white;
                border-radius: 50%;
                text-align: center;
                line-height: 2.5rem;
            }
        }
    }
    .leaflet-bottom.leaflet-right {z-index: 700;}
</style>