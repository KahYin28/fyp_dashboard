import {    Radar,    mixins } from 'vue-chartjs'

export default {
    extends: Radar,
    mixins: [mixins.reactiveProp],

    props: ['chartData'],
    data() {
        return {
            options: { //Radar Chart.js options
                title:{
                    display:true,
                    text:'Facial Expression'
                },
                scale: {
                    angleLines: {
                        display: false
                    },
                    ticks: {
                        suggestedMin: 50,
                        suggestedMax: 100
                    }
                },

                legend: {
                    position:'top',
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted() {
        this.renderChart(this.chartdata)
    }

}
