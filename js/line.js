
var ctx_line = document.getElementById("myLineChart").getContext('2d');
var data_line = [0, 0, 0, 0];
// var data_line2 = [0, 0, 0, 0];
   
var myLineChart = new Chart(ctx_line, {
    type: 'line',
    data: {
        labels: ["1", "2", "3","4"],
        datasets: [{
            label: 'Temperatura',
            type: 'line',
            data: data_line,
            backgroundColor: [
                'rgba(103, 195, 255, 0.6)'
            ],
            borderColor: [
                'rgba(103,195,255,1)'
            ],
            data:[],
            borderWidth: 3,
            fill: false,
            pointRadius: 1,
            pointHoverRadius: 3,
            yAxisID: 'y_temp',
            showLine: true, // no line shown
            steppedLine: false, //before, after, middle, true, false
            //borderDash: [5,5], //para hacer punteada 
            //interpolacion -> //lineTension: 0 //cubicInterpolationMode: 'monotone'
        },
        {
            label: 'Humedad',
            type: 'line',
            data: data_line,
            backgroundColor: [
                'rgba(153, 100, 100, 0.6)'
            ],
            borderColor: [
                'rgba(153,100,100,1)'
            ],
            data:[],
            borderWidth: 3,
            fill: false,
            pointRadius: 1,
            pointHoverRadius: 3,
            yAxisID: 'y_hum',
            showLine: true, // no line shown
            //steppedLine: false, //before, after, middle, true, false
            //cubicInterpolationMode: 'monotone'
            //borderDash: [5,5], //para hacer punteada 
            //interpolacion -> //lineTension: 0 //cubicInterpolationMode: 'monotone'
        }]
    },
    options: {
        maintainAspectRatio: true,
        responsive: true,
        responsiveAnimationDuration: 400,
        cutoutPercentage: 50,
        hoverMode: 'index',
        stacked: false,
        scales: {
            yAxes: [{
                display: true,
                type: 'linear',
                position: 'left',
                scaleLabel: {
                    labelString: 'Grados',
                    display: true
                },
                ticks:{
                    min:0,
                    max:60,
                    stepSizes: 5
                },
                id: 'y_temp'
            },{
                display: true,
                type: 'linear',
                position: 'right',
                scaleLabel: {
                    labelString: '% humedad',
                    display: true
                },
                ticks:{
                    min:0,
                    suggestedMax:100,
                    stepSizes: 5
                },
                id: 'y_hum'
        }],
            xAxes: [{
                type: 'time',
                display: true,
            }]
        },
        layout: {padding: 1},
        legend: {
            display: true,
            position: 'bottom',
            fullWidth: true,
            labels: {fontColor: 'rgb(100, 100, 100)',
                    boxWidth: 10,
                    fontSize: 12
            }
        },
        title: {
            display: false,
            text: 'TITULO'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        },

    }
});


function updateDataChar() {
    var xhttp, res;
    xhttp = new XMLHttpRequest();
    var json_string = '{"table":"measurements", "limit":"100","device_id":1}';
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            res = JSON.parse(this.responseText);
            res.forEach(function (data, index) {
                var date = new Date(data.created_at);
                // console.log(date);
                myLineChart.data.labels[index] = date.toISOString(); //toISOString
                myLineChart.data.datasets[0].data[index] = data.temperature;
                myLineChart.data.datasets[1].data[index] = data.humidity;
                //console.log(myLineChart.data.datasets[0].data[index]);
                //console.log(myLineChart.data.datasets[1].data[index]);
                //console.log(date.toISOString());
                //console.log(date.toTimeString());
                // myLineChart.data.datasets[1].data[index] = data.nok;
                // console.log(data.ok + "|" + data.nok);
            });
            myLineChart.update();
        }
    };
    xhttp.open("GET", "http://localhost/backend/api/querys.php?x="+json_string, true);//grower-lab.com
    xhttp.send();
    console.log(moment().add(1,'d').toDate());
}

function loadData() {
    updateDataChar();
}

