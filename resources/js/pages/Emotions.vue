<template>
    <div>
    <h1>Facial Expression</h1>
        <div class="chart-container" style="width: 700px">
    <radar-chart v-if="loaded"
                 :chart-data="dataCollection">

    </radar-chart>
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
        created(){


        },
        mounted() {
            this.requestData();
        },
        methods:{
            requestData(){
                this.std = this.$route.query.id;
                console.log(this.std + 'sd');
                axios.get('emotion/'+ this.std).then(response => {
                    this.dataCollection = response.data;
                    console.log(this.dataCollection);
                    var EMO = [];

                 //   for (let i = 0; i < this.dataCollection.length; i++) {
                        // var keys = Object.keys(this.dataCollection[i]);
                        // for(var j=0; j<keys.length; j++) {
                        //     var key = keys[j];
                        //     console.log(key, this.dataCollection[key]);
                        // }
                        let happy = this.dataCollection['happy'] ;
                        let sad = this.dataCollection['sad'] ;
                        let angry = this.dataCollection['angry'] ;
                        let confused = this.dataCollection['confused'] ;
                        let disgusted = this.dataCollection['disgusted'] ;
                        let surprised = this.dataCollection['surprised'] ;
                        let calm = this.dataCollection['calm'] ;
                        let unknown = this.dataCollection['unknown'] ;
                        let fear = this.dataCollection['fear'] ;
                        EMO.push(angry,sad,happy,confused,disgusted,surprised,calm,unknown,fear);
                        // console.log(EMO);
                //    }
                    this.dataCollection = {
                        labels: ['Happy','Sad','Angry','Confused','Disgusted','Surprised','Calm','Unknown','Fear'],
                        datasets: [
                            {
                                label: "Emotions",
                                backgroundColor: "#3c8af8",
                                borderColor: "#3c8af0",
                                borderWidth: 2,
                                fill: false,
                                data: EMO
                            }
                        ]
                    };

                });



        }
    }
    }
</script>

<style scoped>

</style>
