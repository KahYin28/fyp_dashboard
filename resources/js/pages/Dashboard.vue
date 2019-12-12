<template>
    <div>
        <div class="mb-3">
            <div class="card" style="width: 400px ;">
                <div class="card-body">
                    <div class="chart-container">
                        <div class="float-left" style="width: 200px">
                            <doughnut-chart v-if="loaded"
                                            :chart-data="studentCollection" :option="options">
                            </doughnut-chart>
                        </div>
                    </div>
                    <h1>{{ num }}</h1>
                </div>
            </div>
        </div>

        <div class="mt-3">
        <div class="card" style="width: 700px;">
<!--            <div class="chart-container" style="width: 700px">-->
                <line-chart v-if="loaded"
                            :chart-data="dataCollection">
                </line-chart>
<!--            </div>-->
        </div>
        </div>

            <div class="mt-3">
                <div class="card" style="width: 700px ;">
                <app-class-emotions></app-class-emotions>
            </div>
            </div>
        </div>

</template>

<script>
    import doughnutChart from "../doughnutChart.js";
    import lineChart from "../chart.js";
    import ClassEmotions from "./ClassEmotions";

    export default {
        components: {
            "app-class-emotions": ClassEmotions,
            "line-chart": lineChart,
            "doughnut-chart": doughnutChart,
        },
        data() {
            return {
                loaded: true,
                abc: true,
                dataCollection: null,
                studentCollection: null,
                num: null,
                venue_id: '',
                chartDate: '',
                chartDegree:'',
                chartHumid:'',
                options: {
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
            if (this.$session.exists('data')) {
                this.sessionData = this.$session.get('data');
                console.log(this.sessionData['venue_id']);
            }
            this.requestNumOfStd();
            this.requestTemperatureData();
            this.getRealtimeData();
        },
        methods: {
            requestNumOfStd() {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['id'])

                    axios.get('register?lesson_id=' + this.sessionData['id'])
                        .then(response => {
                            console.log(response);
                            this.studentCollection = response.data;

                            var numOfStd = [this.studentCollection.total];

                            this.studentCollection = {
                                datasets: [{
                                    backgroundColor: "#8C2EEB",
                                    data: numOfStd,
                                }],
                                labels: [
                                    'Students',
                                ],
                            };
                            console.log(numOfStd);
                            this.num = numOfStd;
                        });
                }
            },
            requestTemperatureData() {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['venue_id'])

                    axios.get('sensorData?sensor_id=1&&field=Temperature(C)')
                        .then(response => {
                            this.dataCollection = response.data.data;
                            console.log(this.dataCollection);
                            var DEG = [];
                            var DATE = [];

                            for (let i = 0; i < this.dataCollection.length; i++) {
                                let degree = this.dataCollection[i]['value'];
                                let date_time = this.dataCollection[i]['created_at'];
                                DEG.push(degree);
                                DATE.push(date_time);
                            }
                            // console.log(DEG);
                            // console.log(DATE);
                            this.chartDate = DATE;
                            this.chartDegree = DEG;
                            console.log(this.chartDegree);
                            console.log(this.chartDate);

                            axios.get('sensorData?sensor_id=1&&field=Humidity(%)')
                                .then(response => {
                                    this.dataCollection = response.data.data;
                                    console.log(this.dataCollection);
                                    var HUMID = [];
                                    for (let i = 0; i < this.dataCollection.length; i++) {
                                        let humid = this.dataCollection[i]['value'];
                                        HUMID.push(humid);
                                    }
                                    this.chartHumid = HUMID;
                                    console.log(this.chartHumid);
                                    this.setChartData(this.chartDegree, this.chartHumid, this.chartDate);
                                });

                        });
                }
            },
            setChartData(DEG, HUMID, DATE ) {
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
                        },
                        {
                            label: "Humidity",
                            backgroundColor: "#EB6D22",
                            borderColor: "#EB6D22",
                            borderWidth: 2,
                            fill: false,
                            data: HUMID
                        },

                    ],


                };
            },
            getRealtimeData() {
                window.Echo.channel('TemperatureChannel')
                    .listen('TemperatureUpdateEvent', (e) => {
                        console.log(e.key);
                        this.chartArray = e.key;
                      var celsius =[];
                      var time=[];
                        for (let i = 0; i < this.chartArray.length; i++) {
                            let bb = this.chartArray[i]['value'];
                            let cc = this.chartArray[i]['created_at'];

                            celsius.push(bb);
                            time.push(cc);
                        }
                        window.Echo.channel('HumidityChannel')
                            .listen('HumidityUpdateEvent', (e) => {
                                this.arr = e.key;
                                var hu =[];

                                for (let i = 0; i < this.arr.length; i++) {
                                    let dd = this.arr[i]['value'];
                                    hu.push(dd);
                                }
                                // console.log(this.chartDate);
                                this.setChartData(celsius, hu , time);
                            });
                        // console.log(this.chartDate);
                        // this.setChartData(celsius, this.chartHumid, time);
                    });

            }
        }

    }


</script>

<style scoped>

</style>
