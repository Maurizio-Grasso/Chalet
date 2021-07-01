<template>
  <div>
    <canvas id="planet-chart" width="400" height="180"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  props: ['views'],
  name: "PlanetChart",
  watch: {
        views: function (newVal, oldVal) {
          this.adminStatisticsChartData.data.viewsData = this.views;
          this.adminStatisticsChartData.data.AptCounter = 0;
          this.viewCounter();
          this.adminStatisticsChartData.data.labels = [];
          this.createdAt();
          this.adminStatisticsChartData.data.datasets[0].data = [];
          this.insertView();
        } 
    },
  mounted() {
    const ctx = document.getElementById("planet-chart");
    new Chart(ctx, this.adminStatisticsChartData);
    this.viewCounter();
    this.createdAt();
    this.insertView();
    console.log(this.views);
    
  },
  data() {
    return {
      adminStatisticsChartData: {
        type: "bar",
        data: {
          AptCounter: 0,
          viewsData: this.views, //prova di trasferimento dati da props a data -- sembra non aggiornarsi all'aggiornare del props
          searchResult: [],
          labels: [
            // "Lunedì",
            // "Martedì",
            // "Mercoledì",
            // "Giovedì",
            // "Venerdì",
            // "Sabato",
            // "Domenica",
          ],
          datasets: [
            {
              label: "Numero di Visualizzazioni",
              // data: [0, 0, 1, 2, 3, 4, 5, 6],
              data: [],
              backgroundColor: "rgba(54,73,93,.5)",
              borderColor: "#36495d",
              borderWidth: 3,
            },
          ],
        },
        options: {
          responsive: true,
          lineTension: 1,
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  padding: 25,
                },
              },
            ],
          },
        },
      },
    };
  },
  methods: {
    //metodo che aggiunge +1 al contatore per ogni appartamento all'interno di views
    viewCounter: function () {
      this.views.forEach((element) => {
        this.adminStatisticsChartData.data.AptCounter=this.adminStatisticsChartData.data.AptCounter+1;
        return console.log(this.adminStatisticsChartData.data.AptCounter);
      });
    },
    createdAt: function () {
      this.views.forEach((element) => {
        var date = new Date (element.created_at);
        var day = date.getDate();
        if(!this.adminStatisticsChartData.data.labels.includes(day)){
          this.adminStatisticsChartData.data.labels.push(day);
        }
      });
    },

    insertView: function () {
       for(let i=0; i<this.adminStatisticsChartData.data.labels.length; i++){
         this.adminStatisticsChartData.data.datasets[0].data[i] = 0;
       }
      this.views.forEach((element) => {
        var date =  new Date (element.created_at);
        var day = date.getDate();

        for(let i=0; i<this.adminStatisticsChartData.data.labels.length; i++){
          
            if(day==this.adminStatisticsChartData.data.labels[i]){
              // console.log(this.adminStatisticsChartData.data.datasets[0].data)
              this.adminStatisticsChartData.data.datasets[0].data[i]++;
            }
        }
      })
    }
  },
};
</script>
