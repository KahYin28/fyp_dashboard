import {  HorizontalBar   ,    mixins } from 'vue-chartjs'

export default {
    extends: HorizontalBar ,
    mixins: [mixins.reactiveProp],

    props: ['chartData'],
    data() {
        return {
            options: { //Chart.js options
                title:{
                    display:true,
                    text:'Emotion of Students in Class'
                },
                scales: {

                    xAxes: [{
                        scaleLabel:{

                            display: true,
                            labelString:'Percentage'
                        },
                        ticks: {
                            max: 100,
                            min: 0,
                            stepSize: 10,
                            beginAtZero: true
                        },
                        gridLines: {
                            display: true
                        }
                    }]
                },
                yAxes: [{
                    scaleLabel:{
                        display: true,
                        labelString:'Emotions'
                    },

                }],

                legend: {
                    display: true
                },
                tooltips:{
                    enabled: true,
                    callbacks: {
                        label: function(tooltipItems, data) {
                            return data.datasets[tooltipItems.datasetIndex].label +': ' + tooltipItems.xLabel + ' %';
                        }
                    },

                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted(){
        this.renderChart(this.chartdata)
    }

}
