document.addEventListener("DOMContentLoaded", () => {

    // Gráfica de producción
    new ApexCharts(document.querySelector("#chart-produccion"), {
        chart: {
            type: 'bar',
            height: 200,
            toolbar: {
                show: false
            },
            fontFamily: 'Figtree, sans-serif'
        },
        series: [
            {
                name: 'Lechones nacidos',
                data: [110, 125, 98, 140, 134]
            },
            {
                name: 'Mortalidad',
                data: [8, 6, 10, 5, 6]
            }
        ],
        xaxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May']
        },
        colors: ['#1D9E75', '#F0997B'],
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '50%'
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            fontSize: '12px'
        },
        grid: {
            borderColor: '#f3f4f6'
        }
    }).render();

    // Donut estado del hato
    new ApexCharts(document.querySelector("#chart-hato"), {
        chart: {
            type: 'donut',
            height: 160,
            fontFamily: 'Figtree, sans-serif'
        },
        series: [21, 12, 6, 9],
        labels: ['Gestante', 'Lactante', 'En celo', 'Vacía'],
        colors: ['#1D9E75', '#60A5FA', '#FBBF24', '#D1D5DB'],
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%'
                }
            }
        }
    }).render();

});