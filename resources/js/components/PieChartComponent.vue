<script>
import { Pie } from 'vue-chartjs';
// import ChartDataLabels from 'chartjs-plugin-datalabels';
// import Chart from 'chart.js';

export default {
    components: {
        ChartDataLabels: () => import('chartjs-plugin-datalabels'),
        Chart: () => import('chart.js'),
    },
    extends: Pie,
    props: ['parentData'],
    data: () => ({
        chartData: {
            labels: ['管理費', '修繕積立金', 'ローン返済額'],
            datasets: [
                {
                    label: 'My First dataset',
                    data: [10, 10, 80],
                    backgroundColor: ['#F39A7B', '#E5C47F', '#98B6B8']
                }
            ],
            
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    display: false
                },
            },
        }
    }),

    watch: {
        parentData: function(newValue, oldValue) {
            this.chartData.datasets[0].data = this.parentData;
            // Chart.plugins.register(ChartDataLabels);
            this.renderChart(this.chartData, this.options);
        }
    },

    updated() {
        Chart.plugins.register(ChartDataLabels);
        this.renderChart(this.chartData, this.options);
    }
};
</script>
