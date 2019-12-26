import {  Line  ,    mixins } from 'vue-chartjs'
import 'chartjs-plugin-streaming';

export default {
    extends: Line,
    mixins: [mixins.reactiveProp],
    props: ['chartData'],

    data() {
        return {
            options: { //Chart.js options
                title:{
                    display:true,
                    text:'Classroom Temperature'
                },
                animation: {
                    duration: 2000 // general animation time
                },
                hover: {
                    animationDuration: 1000 // duration of animations when hovering an item
                },
                responsiveAnimationDuration: 2000, // animation duration after a resize

                scales: {
                    yAxes: [{
                        scaleLabel:{
                          display: true,
                          labelString:'Temperature(C) and Humidity(%)'
                        },

                        ticks: {
                             beginAtZero: true,

                        },
                        gridLines: {
                            display: true
                        }
                    }],
                    xAxes: [{
                       //  type: 'realtime',
                       //  realtime: {
                       //      onRefresh: function(chart) {
                       //          chart.data.datasets.forEach(function(dataset) {
                       //              dataset.data.push({
                       //                  x: Date.now(),
                       //                  y: Math.random()
                       //s
                       //              });
                       //
                       //          });
                       //
                       //      },
                       //      delay: 2000
                       //  },
                       //  ticks:{
                       //      maxTicksLimit: 15,
                       //      beginAtZero: true,
                       //  },
                       //  display: true,
                        scaleLabel:{
                            display: true,
                            labelString:'Date and Time'
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                },
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },

    mounted(){
        this.renderChart(this.chartdata)
    },

}
