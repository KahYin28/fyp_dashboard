import {  Bar   ,    mixins } from 'vue-chartjs'

export default {
    extends: Bar ,
    mixins: [mixins.reactiveProp],

    props: ['chartData'],
    data() {
        return {
            options: { //Chart.js options
                title:{
                    display:true,
                    text:'Facial Emotions of Students in Class'
                },
                scales: {

                    xAxes: [{
                        scaleLabel:{
                            display: true,
                            labelString:'Emotions'

                        },
                        ticks: {
                            max: 100,
                            min: 0,
                            stepSize: 5,
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
                        labelString:'Percentage'

                    },
                    ticks: {
                        max: 100,
                        min: 0,
                        stepSize: 5,
                        beginAtZero: true
                    },

                }],

                legend: {
                    display: true
                },
                tooltips:{
                    enabled: true,
                    // callbacks: {
                    //     label: function(tooltipItems, data) {
                    //         return data.datasets[tooltipItems.datasetIndex].labels+': ' + tooltipItems.xLabel + ' %';
                    //     }
                    // },

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
