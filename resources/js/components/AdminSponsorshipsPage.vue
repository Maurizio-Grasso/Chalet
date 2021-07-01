<template>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="tab-title">Metti in evidenza un appartamento</h1>
                <a href="/admin/payment" class="btn btn-our-btn">Metti in evidenza</a>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2>Le tue sponsorizzazioni</h2>
                <p>Qui puoi visualizzare tutte le tue sponsorizzazioni </p>

                <table class="table table-borderless">
                    <thead>
                        <tr role="row">
                            <!-- per cell -->
                            <th scope="col" class="text-left d-block d-sm-none">Apt</th>

                            <th scope="col" class="text-left d-none d-sm-table-cell">Appartamento</th>
                            <th scope="col" class="text-left d-none d-sm-table-cell">Inizio</th>
                            <th scope="col" class="text-left">Termine</th>
                            <!-- <th scope="col">Attivo</th> -->
                            <th scope="col" class="text-left">Spesa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sponsored_apartment in sponsored_apartments" :key="sponsored_apartment.id">
                            <td class="text-left">{{sponsored_apartment.id}}</td>
                            <td class="text-left d-none d-sm-table-cell">{{sponsored_apartment.start_date}}</td>
                            <td class="text-left">{{sponsored_apartment.end_date}}</td>
                            <!-- <td class="text-left">SI/NO</td> -->
                            <td class="text-left">{{sponsored_apartment.amount}} €</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <h2>Le tue transazioni</h2>
                <p>Qui puoi visualizzare tutte le tue transazioni</p>

                <table class="table table-borderless">
                    <thead>
                        <tr role="row">
                            <!-- per cell -->
                            <th scope="col" class="text-left d-block d-sm-none">Apt</th>

                            <th scope="col" class="text-left d-none d-sm-table-cell">Appartamento</th>
                            <th scope="col" class="text-left d-none d-sm-table-cell">Data</th>
                            <th scope="col" class="text-left">Status</th>
                            <th scope="col" class="text-left">Importo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sponsored_apartment in sponsored_apartments" :key="sponsored_apartment.id">
                            <td class="text-left">{{sponsored_apartment.id}}</td>
                            <td class="text-left d-none d-sm-table-cell">{{sponsored_apartment.start_date}}</td>
                            <td class="text-left" v-if="(sponsored_apartment.status==1)">Success</td>
                            <td class="text-left" v-else>Failed</td>
                            <td class="text-left">{{sponsored_apartment.amount}} €</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>

    </div>

</template>

<script>
    export default {
        props: ['apartments','sponsored_apartments','sponsorships'],
        mounted(){
            this.filterApartments();
        },

        data:function(){
            return {
                filteredApartments:[],
                selectedApartment:'-1',
                selectedSponsorship:'',
            };
        },
        methods: {
            filterApartments(){
                axios
                .get('http://127.0.0.1:8000/api/getUserSponsoredAptList')
                .then((filteredApartments)=>{
                    console.log(filteredApartments.data.results);
                })
            }
        }
    }

</script>
<style scoped>
    /* table{
        background-color: #d8af7f;
        border-radius: .25rem;
        width: 100%;
        overflow-x: auto;
    }
    thead{
        background-color: rgba(0,0,0,.03);
        font-size: 1.7rem;
    }
    th,td{
        padding:10px 20px;
    }
    @media (max-width: 768px){
        table{
            display: block;
        }
    } */
</style>

