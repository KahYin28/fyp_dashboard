<template>
    <div>
        <div class="float-right">
        <div class="card" style="width: 400px ;">
            <div class="card-body">
                <div class="chart-container">
                    <div class="float-left"  style="width: 200px" >
                        <doughnut-chart v-if="loaded"
                                        :chart-data="studentCollection"  :option="options">
                        </doughnut-chart>
                    </div>
                </div>
                <h1 >{{ num }}</h1>
            </div>

        </div>
        </div>
        <div class="chart-container" style="width: 700px">
            <line-chart v-if="loaded"
                   :chart-data="dataCollection">
            </line-chart>
        </div>

        <div class="mt-3">
            <app-class-emotions></app-class-emotions>
        </div>

    </div>
</template>

<script>

    import doughnutChart from "../doughnutChart.js";
    import lineChart from "../chart.js";
    import ClassEmotions from "./ClassEmotions";

    // import io from "socket.io-client";
    // var socket = io.connect("http://localhost:4000");

    export default {

        components: {
            "app-class-emotions":ClassEmotions,
            "line-chart": lineChart,
            "doughnut-chart" : doughnutChart,
        },
        // created() {
        //     this.getRealtimeData()
        // },

        data() {
            return {
                loaded: true,
                abc:true,
                dataCollection: null,
                studentCollection: null,
                num:null,

                options:{
                    plugins: {
                        datalabels: {
                            render: 'percentage',
                            precision: 2
                        }
                    }
                 }

            };
        },
        mounted() {
            this.requestNumOfStd();
            this.requestData();
        },
        methods: {
            requestNumOfStd(){
                axios.get('student').then(response => {
                    this.studentCollection = response.data.data;
              //      console.log(this.studentCollection.length);
                     var numOfStd = [this.studentCollection.length] ;

                    this.studentCollection = {
                        datasets: [{
                                backgroundColor: "#439bf8",
                                data: numOfStd,
                            }],
                        labels:[
                            'Students',
                        ],
                    };
                    console.log(numOfStd);
                    this.num = numOfStd;

                });

            },
            requestData() {
                axios.get('venue').then(response => {
                    this.dataCollection = response.data.data;
                 //   console.log(this.dataCollection);
                    var DEG = [];
                    var DATE =[];

                    for (let i = 0; i < this.dataCollection.length; i++) {
                        let degree = this.dataCollection[i]['temperature'];
                        let date_time = this.dataCollection[i]['created_at'];
                        DEG.push(degree);
                        DATE.push(date_time);
                    }
                    // console.log(DEG);
                    // console.log(DATE);

                    this.dataCollection = {
                        labels: DATE,

                        datasets: [
                            {
                                label: "Degree",
                                backgroundColor: "#3c8af8",
                                borderColor: "#3c8af0",
                                borderWidth: 2,
                                fill: false,
                                data: DEG
                            }
                        ]
                    };

                });
            },
            // getRealtimeData() {
            //     console.log('getRealtimeData');
            //     socket.on("temperature.update", fetchedData => {
            //         // this.fillData(fetchedData)
            //         console.log(fetchedData)
            //     })
            // },
        }
    }
</script>

<style scoped>

</style>
