<script>
import { Pie } from 'vue-chartjs';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import Chart from 'chart.js';

export default {
    extends: Pie,
    props: ['parentData'],
    data: () => ({
        chartData: {
            labels: ['管理費', '修繕積立金', 'ローン返済額'],
            datasets: [
                {
                    label: 'My First dataset',
                    data: [10, 10, 80],
                    backgroundColor: ['#EB5757', '#F2994A', '#F2C94C']
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true
            },
            plugins: {
                datalabels: {
                    color: 'black',
                    labels: {
                        "管理費": "test"
                    }
                },
            }
        }
    }),

    watch: {
        parentData: function(newValue, oldValue) {
            this.chartData.datasets[0].data = this.parentData;
            // Chart.plugins.register(ChartDataLabels);
            this.renderChart(this.chartData, this.options)
        }
    },

    mounted() {
        Chart.plugins.register(ChartDataLabels);
        this.renderChart(this.chartData, this.options);
    }
};
</script>
