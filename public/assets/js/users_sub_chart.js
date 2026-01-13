
var options = {
    series: window.chartData.series,
    colors: ["#FF9F29", "#487FFF", "#1E3A8A"],
    labels: window.chartData.labels,
    legend: { show: true },
    chart: {
        type: "donut",
        height: 270,
        sparkline: { enabled: true },
        margin: { top: 0, right: 0, bottom: 0, left: 0 },
        padding: { top: 0, right: 0, bottom: 0, left: 0 },
    },
    stroke: { width: 0 },
    dataLabels: { enabled: false },
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: "bottom" },
            },
        },
    ],
};

var chart = new ApexCharts(
    document.querySelector("#userOverviewDonutChart"),
    options
);
chart.render();
