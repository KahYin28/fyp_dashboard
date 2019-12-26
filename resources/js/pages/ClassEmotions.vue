<template>
    <div>
        <div class="chart-container" style="width: 700px">
            <bar-chart v-if="loaded"
                       :chart-data="emotionsCollection">
            </bar-chart>
        </div>
    </div>
</template>

<script>
    import barChart from "../barChart.js";

    export default {
        name: "Emotions",
        components: {
            barChart,
        },
        data() {
            return {
                loaded: true,
                emotionsCollection: null,
                std:'',
                aaa:'',
                bbb: ''
            };
        },

        mounted() {
            this.requestEmotionData();
            // this.getStudent();
            this.getRealtimeData();

        },
        methods: {
            // getStudent() {
            //     if (this.$session.exists('data')) {
            //         this.sessionData = this.$session.get('data');
            //         console.log(this.sessionData)
            //
            //         this.formdata = {'lesson_id': this.sessionData['id']};
            //         axios.post('update', this.formdata)
            //             .then(res => {
            //                 console.log(res.data);
            //
            //             });
            //     }
            // },
            requestEmotionData() {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['id']);
                    axios.get('getStudentEmotion?lesson_id=' + this.sessionData['id']).then(response => {
                        this.emotionsCollection = response.data;
                        this.setChart(this.emotionsCollection);
                    });
                }

            },
            setChart(data){
                 this.emotionsCollection = data;
                var HAPPY = this.emotionsCollection.happy_avg;
                var SAD = this.emotionsCollection.sad_avg;
                var ANGRY = this.emotionsCollection.angry_avg;
                var CONFUSED = this.emotionsCollection.confused_avg;
                var DISGUSTED = this.emotionsCollection.disgusted_avg;
                var SURPRISED = this.emotionsCollection.surprised_avg;
                var CALM = this.emotionsCollection.calm_avg;
                var FEAR = this.emotionsCollection.fear_avg;

                this.emotionsCollection = {
                    labels: ['Happy', 'Sad', 'Angry', 'Confused', 'Disgusted', 'Surprised', 'Calm', 'Fear'],
                    datasets: [{
                        label: "Emotions",
                        backgroundColor: ["#ffff1a", "#00008b", "#ff1a1a", "#787878", "#32cd32", "#ff69b4","#52CAFF","#9370db"],
                        // backgroundColor: "#f83269",
                        // borderColor: "#ed574d",
                        borderWidth: 2,
                        fill: false,
                        data: [HAPPY, SAD, ANGRY, CONFUSED, DISGUSTED, SURPRISED, CALM, FEAR]

                    }]
                };
            },
            getRealtimeData() {
                window.Echo.channel('EmotionChannel')
                    .listen('EmotionUpdateEvent', (e) => {
                        this.data = e.key;
                        console.log(this.data);
                        this.setChart(this.data);
                    })
            }
        }
    }
</script>

<style scoped>

</style>
