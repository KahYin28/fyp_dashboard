<template>
    <div>
        <h1>Facial Expression</h1>
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

    export default {
        name: "Emotions",
        components: {
            RadarChart,
        },
        data() {
            return {
                loaded: true,
                dataCollection: null,
            };
        },

        mounted() {
            this.requestData();
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
                    //    }
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
            }
        }
    }
</script>

<style scoped>

</style>
