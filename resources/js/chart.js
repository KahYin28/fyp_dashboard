import {  Line  ,    mixins } from 'vue-chartjs'

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
                scales: {
                    yAxes: [{
                        scaleLabel:{
                          display: true,
                          labelString:'Degree'
                        },
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                    xAxes: [{
                       // type:'time',
                        time:{
                           // parser: timeFormat,
                          tooltipFormat : 'll HH:mm'
                        },
                        scaleLabel:{
                            display: true,
                            labelString:'Date'
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
    }

}
