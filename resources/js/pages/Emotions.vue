<template>
    <div>
        <h1>Facial Expression</h1>

<!--        <select v-model="selectedStudent" class="custom-select" size="10" >-->
<!--            <option v-for="attend in attends.data"-->
<!--                    :value="attend.student_id" :key="attend.id">-->
<!--           {{attend.student_id}}-->
<!--            </option>-->

<!--        </select>-->
<!--        <div class="mt-3">Selected: <strong>{{ selectedStudent }}</strong></div>-->









        <div class="chart-container" style="width: 700px">
            <radar-chart v-if="loaded"
                         :chart-data="dataCollection">
            </radar-chart>
        </div>
        <div>
            <b-card class="mt-3" title="Happy" width="30px">
            </b-card>
            <b-card class="mt-3" title="Sad"width="30px">
            </b-card>
            <b-card class="mt-3" title="Angry"width="30px">
            </b-card>
            <b-card class="mt-3" title="Confused"width="30px">
            </b-card>
            <b-card class="mt-3" title="Disgusted"width="30px">
            </b-card>
            <b-card class="mt-3" title="Surprised"width="30px">
            </b-card>
            <b-card class="mt-3" title="Calm"width="30px">
            </b-card>
            <b-card class="mt-3" title="Fear"width="30px">
            </b-card>
        </div>
    </div>

</template>

<script>
    import RadarChart from "../radarChart";
    import pagination from 'laravel-vue-pagination'

    export default {
        name: "Emotions",
        components: {
            RadarChart,
            'pagination': pagination
        },
        data() {
            return {
                loaded: true,
                dataCollection: null,


                attends: {},
                perPage: 5,
                currentPage: 1,
                now: new Date(),
                error: '',



            };
        },

        mounted() {
            this.requestData();

            this.getStudentList();
        },
        methods: {

            requestData() {
                this.std = this.$route.query.id;
                console.log(this.std);

                axios.get('emotion/' + this.std).then(response => {
                    this.dataCollection = response.data;
                    console.log(this.dataCollection);
                    var EMO = [];

                    let happy = this.dataCollection['happy'];
                    let sad = this.dataCollection['sad'];
                    let angry = this.dataCollection['angry'];
                    let confused = this.dataCollection['confused'];
                    let disgusted = this.dataCollection['disgusted'];
                    let surprised = this.dataCollection['surprised'];
                    let calm = this.dataCollection['calm'];
                    let fear = this.dataCollection['fear'];
                    EMO.push(happy, sad, angry, confused, disgusted, surprised, calm, fear);
                    console.log(EMO);

                    this.dataCollection = {
                        labels: ['Happy', 'Sad', 'Angry', 'Confused', 'Disgusted', 'Surprised', 'Calm', 'Fear'],
                        datasets: [{
                            label: "Emotions",
                            backgroundColor: "#3c8af8",
                            borderColor: "#3c8af0",
                            borderWidth: 2,
                            fill: false,
                            data: EMO
                        }]
                    };
                });
            },


            getStudentList() {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['id']);

                    axios.get('attend?lesson_id=' + this.sessionData['id'])
                        .then(data => {
                            this.attends = data.data;
                            console.log(this.attends)
                        })
                }
            },
            /**pagination for student list result**/
            getResults(page = 1) {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['id']);

                    // this.lesson_id = this.$route.query.lesson_id;
                    axios.get('attend?lesson_id=' + this.sessionData['id'] + '&page=' + page)
                        .then(response => {
                            this.attends = response.data;
                            console.log(this.attends)
                        })
                        .catch(err => {
                            this.loading = false;
                            this.error = err;
                        });
                }

            },
        }
    }
</script>

<style scoped>

</style>
