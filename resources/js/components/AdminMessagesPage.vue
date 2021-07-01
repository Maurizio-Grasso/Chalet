<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="tab-title">I tuoi Messaggi</h1>
            </div>
            
            <!-- SELECT PER SCEGLIERE APPARTAMENTO -->
            <div class="col-sm-6">
                <h4>Seleziona un appartamento per i messaggi specifici</h4>
                <select class="custom-select custom-select-lg mb-3" v-model="selectedApartment"
                @change="onChangeFilter()">
                    <option selected value="-1">Tutti gli appartamenti</option>
                    <option v-for="apartment in apartments" :key="apartment.id" :value="apartment.id">{{ apartment.title }}</option>
                </select>
            </div>

            <table class="table table-striped table-responsive-sm">

                <!-- titoli colonne -->
                <thead class="table-light">
                    <tr role="row">
                        <th class="align-middle" tabindex="0" rowspan="1" colspan="1">Apt Id</th>
                        <th class="align-middle" tabindex="0" rowspan="1" colspan="1">Contatto</th>
                        <th class="align-middle" tabindex="0" rowspan="1" colspan="1">Testo del messaggio</th>
                        <th class="align-middle" tabindex="0" rowspan="1" colspan="1">Data</th>
                    </tr>
                </thead>

                <tbody>
                    
                    
                    <!-- riga appartamento -->
                    <tr role="row" v-for="message in this.messagesPerApt" :key="message.id">
                        <td class="text-left">{{message.apartment_id}}</td>
                        <td class="text-left">{{message.email_sender}}</td>
                        <td class="text-left">{{message.message_text}}</td>
                        <td class="text-left">{{message.date}}</td>
                    </tr>

                    <!-- @endforeach -->

                </tbody>
            </table>
        </div>

    </div>
        
</template>

<script>
    export default {
        props:['apartments','messages', 'id_apt'],
        data(){
            return{
                messagesPerApt : this.messages,
                selectedApartment: String,
                selectedApartment: this.id_apt
            };
        },
        mounted(){
           if(this.selectedApartment=='-1'){
                    this.messagesPerApt = this.messages;
                }else{
                    this.getMessagesPerApt(this.selectedApartment);
                }
        },
        methods:{
            onChangeFilter(){
                if(this.selectedApartment=='-1'){
                    this.messagesPerApt = this.messages;
                }else{
                    this.getMessagesPerApt(this.selectedApartment);
                }
            },
            getMessagesPerApt(apt_id){
                this.messagesPerApt=[];
                for (let i = 0; i < this.messages.length; i++) {
                    if(this.messages[i].apartment_id == apt_id){
                        this.messagesPerApt.push(this.messages[i])
                    };
                }
            },
        }
    }
    

</script>

