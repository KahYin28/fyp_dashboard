<template>
    <div>
        <h1>The Hello Component </h1>
        <h1>{{me}}</h1>

        <div class="chart-container" style="width: 700px">
            <doughnut-chart v-if="abc"
                            :chart-data="studentCollection">
            </doughnut-chart>
        </div>

    </div>

</template>

<script>
    import testChart from "../testChart";
    import axios from 'axios'
    export default {
        name: "Hello",
        components: {

          "doughnutChart":testChart
        },


        data() {
            return {

                me: '',
                abc: true,
                studentCollection: null,
            }
        },
        mounted() {
            this.requestNumOfStd();
        },
        methods: {
            requestNumOfStd() {
                axios.get('student').then(response => {
                    this.studentCollection = response.data.data;
                    console.log(this.studentCollection.length);
                    var numOfStd = this.studentCollection.length;

                    this.studentCollection = {
                        datasets: [{
                            backgroundColor: "#c120f8",
                            data: numOfStd
                        }],
                        labels: [
                            'Students',
                        ],
                    }
                })
            },
        },
        created() {
            console.log("sd"),
                axios.get( 'student')
                    .then(response => (

                        this.info = response,
                            console.log(this.info['data']['data']),
                            this.me= this.info['data']['data'][0].name,
                            console.log(this.info['data'])
                    ))





        }
    }
</script>

<style scoped>

</style>
