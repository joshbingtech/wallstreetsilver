var visitors_data = [
    { name: 568, y: 568, device: "Desktop", color: "#33BF8C"},
    { name: 1306, y: 1306, device: "Mobile Phone", color: "#F2B604"},
    { name: 123, y: 123, device: "Tablet", color: "#F95360"},
];

var users_data = [
    { name: "Admin", y: 2, color: "#33BF8C"},
    { name: "Journalist", y: 15, color: "#F2B604"},
    { name: "User", y: 45, color: "#F95360"},
];

$("#visitors-chart").highcharts({
    chart: {
        backgroundColor:'rgba(255, 255, 255, 0.0)',
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: '',
        style: {
            display: 'none'
        }
    },
    tooltip: {
        formatter: function () {
            return this.point.name + ' visits on <b>' + this.point.device + '</b>';
        }
    },
    series: [{
        type: 'pie',
        innerSize: '60%',
        startAngle: 270,
        dataLabels: {
            enabled: true,
            distance: -20,
            style: {
                fontFamily: 'glober_regularregular',
                fontWeight: 'bold',
                fontSize: '15px',
                color: '#FFFFFF',
                textOutline: false
            }
        },
        data: visitors_data
    }]
});

$("#users-chart").highcharts({
    chart: {
        backgroundColor:'rgba(255, 255, 255, 0.0)',
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: '',
        style: {
            display: 'none'
        }
    },
    tooltip: {
        formatter: function () {
            return this.point.name + ': <b>' + this.point.y + '</b>';
        }
    },
    series: [{
        type: 'pie',
        innerSize: '60%',
        startAngle: 270,
        dataLabels: {
            enabled: true,
            distance: -20,
            style: {
                fontFamily: 'glober_regularregular',
                fontWeight: 'bold',
                fontSize: '15px',
                color: '#FFFFFF',
                textOutline: false
            }
        },
        data: users_data
    }]
});
