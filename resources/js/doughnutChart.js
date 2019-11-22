import { Doughnut , mixins } from 'vue-chartjs'
import Vue from "vue";
// import ChartDataLabels from "chartjs-plugin-datalabels";
// Vue.use(ChartDataLabels);
export default {
    extends: Doughnut,
    mixins: [mixins.reactiveProp],

    props: ['chartData','option'],
    data() {
        return {
            options: { // Doughnut Chart.js options
                title: {
                    display: true,
                    text: 'Total Number of Students'
                },
                // legend: {
                //     display: true
                // },
                cutoutPercentage: 70,
                // rotation: 180,
                animation: {
                    animateScale: true,

                },
                responsive: true,
                maintainAspectRatio: true,
                // plugins:{
                //     pieceLabel: {
                //         mode: 'percentage',
                //         precision: 1
                //     },
                // }
            }
        }
    },

    mounted() {
        this.renderChart(this.chartdata, this.option)
    }

}



