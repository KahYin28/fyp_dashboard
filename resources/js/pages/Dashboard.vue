<template>
    <div>
        <div class="card mb-3" style="max-width: 420px;">
            <div class="row no-gutters">
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="float-left" style="width: 200px">
                                <doughnut-chart v-if="loaded"
                                                :chart-data="studentCollection" :option="options">
                                </doughnut-chart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h1 style="margin-top:5rem;">{{ num }}</h1>
                </div>
            </div>

        </div>


        <div class="mt-3">
            <div class="card" style="width: 700px ;">
                <app-class-emotions></app-class-emotions>
            </div>
        </div>


        <div class="mt-3">
            <div class="card" style="width: 700px;">
                <line-chart v-if="loaded"
                            :chart-data="dataCollection"
                >
                </line-chart>

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
                sensor_id_collection: '',
                sensor_id: '',
                venue_id: '',
                chartDate: '',
                chartDegree: '',
                chartHumid: '',
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
            this.getSensorID()
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

                            var numOfStd = this.studentCollection.total;

                            this.studentCollection = {
                                datasets: [{
                                    backgroundColor: "#1e90ff",
                                    data: [numOfStd],
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

            getSensorID() {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');

                    this.formdata = {'venue_id': this.sessionData['venue_id']};
                    axios.post('getSensorData', this.formdata)
                        .then(res => {
                            console.log(res.data.sensor_id);
                            this.sensor_id = res.data.sensor_id;
                            this.$session.set('sensor', this.sensor_id);
                        });
                }
            },

            requestTemperatureData() {
                // if(this.$session.exists('graph_data')){
                //     this.temperatureArray =   this.$session.get('graph_data');
                //     for (let i = 0; i < this.temperatureArray.length; i++) {
                //         let degree = this.temperatureArray[i]['value'];
                //         let date_time = this.temperatureArray[i]['created_at'];
                //         DEG.push(degree);
                //
                //         DATE.push(date_time);
                //
                //     }
                //     this.chartDate = DATE;
                //     this.setChartData(this.temperatureArray,null, this.chartDate);
                // }
                if (this.$session.exists('sensor')) {
                    this.sensorData = this.$session.get('sensor');
                    console.log(this.sensorData)

                    axios.get('sensorData?sensor_id=' + this.sensorData + '&&field=Temperature(C)')
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
                            // this.chartDate = DATE;
                            // this.chartDegree = DEG;

                            // console.log(this.chartDegree);
                            // console.log(this.chartDate);

                            axios.get('sensorData?sensor_id=' + this.sensorData + '&&field=Humidity(%)')
                                .then(response => {
                                    this.dataCollection = response.data.data;
                                    console.log(this.dataCollection);
                                    var HUMID = [];
                                    for (let i = 0; i < this.dataCollection.length; i++) {
                                        let humid = this.dataCollection[i]['value'];
                                        HUMID.push(humid);
                                    }
                                    // this.chartHumid = HUMID;
                                    // console.log(this.chartHumid);
                                    this.setChartData(DEG, HUMID, DATE);
                                });
                        });
                }
            },
            setChartData(DEG, HUMID, DATE) {
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
                        // console.log(e.key);
                        // this.$session.set('graph_data', e.key);
                        this.temperatureArray = e.key;
                        var celsius = [];
                        var time = [];
                        for (let i = 0; i < this.temperatureArray.length; i++) {
                            let value = this.temperatureArray[i]['value'];
                            let datetime = this.temperatureArray[i]['created_at'];
                            celsius.push(value);
                            time.push(datetime);
                        }
                        console.log(this.temperatureArray);
                        window.Echo.channel('HumidityChannel')
                            .listen('HumidityUpdateEvent', (e) => {
                                this.humidityArray = e.key;
                                var humid = [];

                                for (let i = 0; i < this.humidityArray.length; i++) {
                                    let hum = this.humidityArray[i]['value'];
                                    humid.push(hum);
                                }
                                this.setChartData(celsius, humid, time);
                            });

                    });
            }
        }
    }


</script>

<style scoped>

</style>
