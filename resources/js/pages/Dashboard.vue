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
        <div class="card" style="width: 600px;">
<!--            <div class="chart-container" style="width: 700px">-->
                <line-chart v-if="loaded"
                            :chart-data="dataCollection">
                </line-chart>
<!--            </div>-->
        </div>
        </div>

            <div class="mt-3">
                <div class="card" style="width: 600px ;">
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
        created() {

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
            this.requestData();
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
                                    backgroundColor: "#439bf8",
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
            requestData() {
                this.venue_id = this.$route.query.venue_id;

                axios.get('temperature?venue_id' + this.venue_id)
                    .then(response => {
                        this.dataCollection = response.data.data;
                        //   console.log(this.dataCollection);
                        var DEG = [];
                        var DATE = [];

                        for (let i = 0; i < this.dataCollection.length; i++) {
                            let degree = this.dataCollection[i]['value'];
                            let date_time = this.dataCollection[i]['created_at'];
                            DEG.push(degree);
                            DATE.push(date_time);
                        }
                        console.log(DEG);
                        // console.log(DATE);
                        this.chartDate = DATE;
                        console.log(this.chartDate);
                        this.setChartData(DEG, DATE);


                    });
            },
            setChartData(DEG, DATE) {
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
            },
            getRealtimeData() {
                window.Echo.channel('TemperatureChannel.')
                    .listen('TemperatureUpdateEvent', (e) => {
                        console.log(e.key);
                        console.log(e.key['value']);
                        //  this.chartArray=[e.key['value'], 21, 16, 32, 27, 32, 30, 19, 22, 25];
                        this.chartArray = [e.key['value']];
                        //  lineChart.render();
                        console.log(this.chartDate);
                        this.setChartData(this.chartArray, this.chartDate);
                        console.log(e.abc);
                    });

            }
        },

    }


</script>

<style scoped>

</style>
