
var ctx_line = document.getElementById("myLineChart").getContext('2d');
var data_line = [0, 0, 0, 0];
// var data_line2 = [0, 0, 0, 0];
   
var myLineChart = new Chart(ctx_line, {
    type: 'line',
    data: {
        labels: ["1", "2", "3","4"],
        datasets: [{
            label: 'Temperatura',
            data: data_line,
            backgroundColor: [
                'rgba(103, 195, 255, 0.6)',
                'rgba(10, 255,10, 0.6)'
            ],
            borderColor: [
                'rgba(103,195,255,1)',
                'rgba(10, 255, 10, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: true,
        responsive: true,
        responsiveAnimationDuration: 400,
        cutoutPercentage: 50,
        //circumference: 2,
        scales: {
            yAxes: [{
                display: true
            }],
            xAxes: [{
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
        title: {display: false,
            text: 'TITULO'},
        animation: {animateScale: true,
                    animateRotate: true},
        // elements: {pointRadius: 1

    }
});


function updateDataChar() {
    var xhttp, res;
    xhttp = new XMLHttpRequest();
    var json_string = '{"table":"measurements", "limit":"1000","device_id":1}';
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            res = JSON.parse(this.responseText);
            res.forEach(function (data, index) {
                var date = new Date(data.created_at);
                // console.log(date);
                myLineChart.data.labels[index] = date.getHours() + ":" + date.getMinutes();
                
                myLineChart.data.datasets[0].data[index] = data.temperature;
                console.log(myLineChart.data.datasets[0].data[index]);
                // myLineChart.data.datasets[1].data[index] = data.nok;
                // console.log(data.ok + "|" + data.nok);
            });
            myLineChart.update();
            // console.log(xmlDoc);
        }
    };
    xhttp.open("GET", "http://grower-lab.com/api/querys.php?x="+json_string, true);
    xhttp.send();  
}

function loadData() {
    // updateData();
    updateDataChar();
}


