<template>
    <div>
        <div><h5>Facial expression of student: {{std}}</h5></div>
        <div class="chart-container" style="width: 700px">
            <radar-chart v-if="loaded"
                         :chart-data="dataCollection">
            </radar-chart>
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
                timer:'',
                std:'',

            };
        },

        mounted() {
            this.requestData();
            this.timer = setInterval(this.requestData, 2000)
        },
        beforeDestroy () {
            clearInterval(this.timer)
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

            // getRealtimeData() {
            //     window.Echo.channel('EmotionChannel')
            //         .listen('EmotionUpdateEvent', (e) => {
            //             this.data = e.key;
            //             console.log(this.data);
            //
            //             // if(this.data)
            //
            //         })
            // }






        }
    }
</script>

<style scoped>

</style>
