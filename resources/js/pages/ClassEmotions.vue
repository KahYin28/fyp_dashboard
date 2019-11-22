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
            };
        },

        mounted() {
            this.requestEmotionData();
        },
        methods:{
            requestEmotionData(){
                axios.get('emotion').then(response => {
                    this.emotionsCollection = response.data.data;
                    console.log(this.emotionsCollection);

                    var HAPPY=[];
                    var SAD=[];
                    var ANGRY=[];
                    var CONFUSED=[];
                    var DISGUSTED=[];
                    var SURPRISED=[];
                    var CALM=[];
                    var UNKNOWN=[];
                    var FEAR=[];

                    for (let i = 0; i < this.emotionsCollection.length; i++) {
                        let happy = this.emotionsCollection[i]['happy'];
                        let sad = this.emotionsCollection[i]['sad'] ;
                        let angry = this.emotionsCollection[i]['angry'] ;
                        let confused = this.emotionsCollection[i]['confused'] ;
                        let disgusted = this.emotionsCollection[i]['disgusted'] ;
                        let surprised = this.emotionsCollection[i]['surprised'] ;
                        let calm = this.emotionsCollection[i]['calm'] ;
                        let unknown = this.emotionsCollection[i]['unknown'] ;
                        let fear = this.emotionsCollection[i]['fear'] ;

                        HAPPY.push(happy);
                        SAD.push(sad);
                        ANGRY.push(angry);
                        CONFUSED.push(confused);
                        DISGUSTED.push(disgusted);
                        SURPRISED.push(surprised);
                        CALM.push(calm);
                        UNKNOWN.push(unknown);
                        FEAR.push(fear);

                        function calcSum(arr){
                            var sum = 0;
                             sum = arr.reduce(function (a, b) {
                                return a + b;
                            })
                            return sum;
                        };

                        var total_happy = calcSum(HAPPY);
                        var percent_happy =((total_happy/(HAPPY.length * 100)*100).toFixed(2));
                        var total_sad = calcSum(SAD);
                        var percent_sad =((total_sad/(SAD.length * 100)*100).toFixed(2));
                        var total_angry = calcSum(ANGRY);
                        var percent_angry =((total_angry/(ANGRY.length * 100)*100).toFixed(2));
                        var total_confused = calcSum(CONFUSED);
                        var percent_confused =((total_confused/(CONFUSED.length * 100)*100).toFixed(2));
                        var total_disgusted = calcSum(DISGUSTED);
                        var percent_disgusted =((total_disgusted/(DISGUSTED.length * 100)*100).toFixed(2));
                        var total_suprised = calcSum(SURPRISED);
                        var percent_suprised =((total_suprised/(SURPRISED.length * 100)*100).toFixed(2));
                        var total_calm = calcSum(CALM);
                        var percent_calm =((total_calm/(CALM.length * 100)*100).toFixed(2));
                        var total_unknown = calcSum(UNKNOWN);
                        var percent_unknown =((total_unknown/(UNKNOWN.length * 100)*100).toFixed(2));
                        var total_fear = calcSum(FEAR);
                        var percent_fear =((total_fear/(FEAR.length * 100)*100).toFixed(2));

                    }

                    this.emotionsCollection = {
                        labels: ['Happy','Sad','Angry','Confused','Disgusted','Surprised','Calm','Unknown','Fear'],

                        datasets: [
                            {
                                label: "Emotions",
                                backgroundColor: "#3c8af8",
                                borderColor: "#3c8af0",
                                borderWidth: 2,
                                fill: false,
                                data:[percent_happy,percent_sad,percent_angry,percent_confused,
                                    percent_disgusted,percent_suprised,percent_calm,percent_unknown,percent_fear]

                            }
                        ]
                    };

                });



            },


        }
    }
</script>

<style scoped>

</style>
