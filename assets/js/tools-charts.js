function draw_24h_temp(canvas_id, temp_data) {
    // prepare dataset
    labels = temp_data.map(function(e){ return e.dt.split(' ')[1].substring(0,5); });
    data = temp_data.map(function(e){ return e.v; });

    var ctx = document.getElementById(canvas_id);
    var tempChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperatura',
                data: data,
                borderColor: 'rgba(255,50,50,1)' ,
                pointRadius: 0,
                
            }]
        },
        options: {
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 25,
                    }
                }],
                xAxes: [{
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                }]
            }
        }
    });
}