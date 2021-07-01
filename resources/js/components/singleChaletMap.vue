<template>
            <div class="apt-on-map" id="apt-on-map"></div>
</template>

<script>
    export default {

        mounted() {

            // Inizializza Mappa
            this.mymap = L.map('apt-on-map').setView([this.latitude, this.longitude], 10);

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
                iconUrl: '../img/greenMarker.png',
                shadowUrl: '../img/markerShadow.png',
                iconSize:     [30, 44], // size of the icon
                shadowSize:   [60, 25], // size of the shadow
                iconAnchor:   [15, 22], // point of the icon which will correspond to marker's location
                shadowAnchor: [0, 0],  // the same for the shadow
                popupAnchor:  [0, -22] // point from which the popup should open relative to the iconAnchor
            });

            let newMarker = L.marker([this.latitude, this.longitude] , {icon : this.markerIcon});
            newMarker.addTo(this.mymap);

        },
        data() {            
            return {                
                mymap        : null ,
                markerIcon   : null ,
            }
        },
        props : ['latitude' , 'longitude'] ,
    }

</script>

<style scoped lang="scss">

    @import "../../sass/variables";

    .apt-on-map {
        height: $height-section-big;
    }
</style>