
var data = {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
    series: [
      [5, 2, 4, 2, 0]
    ]
  };
var options = {
    // width: 100,
    // height: 500
};
var chart = new Chartist.Line('.ct-chart', data, options);

function updateDataChar1() {
    var xhttp, res;
    xhttp = new XMLHttpRequest();
    var json_string = '{"table":"measurements", "limit":"10","device_id":1}';
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            res = JSON.parse(this.responseText);
            res.forEach(function (data, index) {
                //var date = new Date(data.created_at);
                chart.data.labels[index] = data.created_at;
                chart.data.series[0][index] = data.temperature;
                // chart.data.series.data[index] = data.humidity;
            });
            chart.update(data);
        }
    };
    xhttp.open("GET", "http://192.168.1.4/backend/api/querys.php?x="+json_string, true);//grower-lab.com
    xhttp.send();
    
}

function loadData1() {
    updateDataChar1();
}

