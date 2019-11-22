import { Pie , mixins } from 'vue-chartjs'

export default {
    extends: Pie,
    mixins: [mixins.reactiveProp],

    props: ['chartData'],
    data() {
        return {
            options: { // Doughnut Chart.js options
                title: {
                    display: true,
                    text: 'Total Number of Students'
                },
                legend: {
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



