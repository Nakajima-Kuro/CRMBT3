function viewEmployee(canvas, chart) {
    canvas.onclick = function(evt) {
        var activePoints = chart.getElementsAtEvent(evt);
        if (activePoints[0]) {
            var chartData = activePoints[0]['_chart'].config.data;
            var idx = activePoints[0]['_index'];

            var label = chartData.labels[idx];
            var value = chartData.datasets[0].data[idx];
            window.location.href = "userlist.php?searchEmp=" + label;
        }
    }
}