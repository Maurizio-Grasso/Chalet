<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="tab-title">Le tue statistiche</h1>
            </div>

            <!-- SELECT PER SCEGLIERE APPARTAMENTO -->
            <div class="col-sm-6">
                <h4>Seleziona un appartamento per le statistiche specifiche</h4>
                <select class="custom-select custom-select-lg mb-3" v-model="selectedApartment"
                @change="onChangeFilter()">
                    <option selected value="-1">Tutti gli appartamenti</option>
                    <option v-for="apartment in apartments" :key="apartment.id" :value="apartment.id">{{ apartment.title }}</option>
                </select>
            </div>
        </div>
    
    <div class="row card-row">
        <div class="col-lg-4 col-md-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">           
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8s11 8 11 8s-4 8-11 8s-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></g></svg>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="numbers">
                                <p class="card-category">Visualizzazioni</p>
                                <h3 class="card-title">{{this.viewsPerApt.length}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i>Visualizzazioni Totali</i>
                    </div>
                </div>
            </div>
        </div>
    
     
        <div class="col-lg-4 col-md-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">           
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></g></svg>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="numbers">
                                <p class="card-category">Messaggi</p>
                                <h3 class="card-title">{{this.messagesPerApt.length}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i>Totali ricevuti</i>
                    </div>
                </div>
            </div>
    
        </div>
        
    
        <div class="col-lg-4 col-md-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">           
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="3em" height="3em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></g></svg>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="numbers">
                                <p class="card-category">Spese</p>
                                <h3 class="card-title">{{this.sumSponsorship}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i>Totale Speso</i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

      
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Visualizzazioni </h5>
                    <h3 class="card-title">
                        <i>{{this.viewsPerApt.length}} questo mese</i>
                    </h3>
                </div>

               
                <div class="card-body">
                    <div class="chart-area">
                        <div id="app">
                            <admin-statistics-chart :parentData="viewsPerApt"></admin-statistics-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
        
</template>

<script>
import AdminStatisticsChart from './AdminStatisticsChart.vue';
    export default {
        props:['apartments','views','messages','sponsorships', 'id_apt'],
        name: 'App',
        components: { AdminStatisticsChart },
        data(){
            return{
                sumSponsorship:0,
                viewsPerApt : this.views,
                messagesPerApt : this.messages,
                sponsorshipsPerApt : this.sponsorships,
                selectedApartment: String,
                selectedApartment: this.id_apt
            };
        },
        mounted(){
            this.getTotalMoney();
            if(this.selectedApartment=='-1'){
                    this.viewsPerApt = this.views;
                    this.messagesPerApt = this.messages;
                    this.sponsorshipsPerApt = this.sponsorships;
                    this.getTotalMoney();
                }else{
                    this.getMessagesPerApt(this.selectedApartment);
                    this.getViewsPerApt(this.selectedApartment);
                    this.getSponsorshipsPerApt(this.selectedApartment);
                }
        },
        methods:{
            getTotalMoney(){
                this.sumSponsorship=0
                for (let i = 0; i < this.sponsorshipsPerApt.length; i++) {
                    this.sumSponsorship += this.sponsorshipsPerApt[i].amount;
                    
                }
            },
            onChangeFilter(){
                if(this.selectedApartment=='-1'){
                    this.viewsPerApt = this.views;
                    this.messagesPerApt = this.messages;
                    this.sponsorshipsPerApt = this.sponsorships;
                    this.getTotalMoney();
                }else{
                    this.getMessagesPerApt(this.selectedApartment);
                    this.getViewsPerApt(this.selectedApartment);
                    this.getSponsorshipsPerApt(this.selectedApartment);
                };
            },
            getMessagesPerApt(apt_id){
                this.messagesPerApt=[];
                for (let i = 0; i < this.messages.length; i++) {
                    if(this.messages[i].apartment_id == apt_id){
                        this.messagesPerApt.push(this.messages[i])
                    };
                }
            },
            getViewsPerApt(apt_id){
                this.viewsPerApt=[];
                for (let i = 0; i < this.views.length; i++) {
                    if(this.views[i].apartment_id == apt_id){
                        this.viewsPerApt.push(this.views[i])
                    };
                }
            },
            getSponsorshipsPerApt(apt_id){
                this.sponsorshipsPerApt=[];
                for (let i = 0; i < this.sponsorships.length; i++) {
                    if(this.sponsorships[i].apartment_id == apt_id){
                        this.sponsorshipsPerApt.push(this.sponsorships[i])
                    };
                };
                
                this.getTotalMoney();
            },
            data(){
                return myData = {
                sumSponsorship:0,
                viewsPerApt : this.views,
                messagesPerApt : this.messages,
                sponsorshipsPerApt : this.sponsorships,
                selectedApartment:'all'
                }
            }
        }
    }
    

</script>

