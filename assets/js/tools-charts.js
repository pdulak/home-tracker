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

function draw_electricity_delta(electricity_delta, electricity_channels) {
    electricity_channels.forEach(function(v) {
        new_canvas_id = 'channel_chart_' + v.channel; 
        
        this_chart_data = electricity_delta.filter(row => row.channel == v.channel);
        draw_single_channel(this_chart_data, new_canvas_id);
    });
}

function draw_single_channel(el_data, canvas_id) {
    // prepare dataset
    labels = el_data.map(function(e){ return e.dt.split(' ')[1].substring(0,5); });

    var ctx = document.getElementById(canvas_id);
    var elChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: 'El1',
                    data: el_data.map(function(e){ return e.phase1_rae; }),
                    borderColor: 'rgba(255,50,50,1)' ,
                    pointRadius: 0,   
                },{
                    label: 'El2',
                    data: el_data.map(function(e){ return e.phase2_rae; }),
                    borderColor: 'rgba(50,255,50,1)' ,
                    pointRadius: 0,   
                },{
                    label: 'El3',
                    data: el_data.map(function(e){ return e.phase3_rae; }),
                    borderColor: 'rgba(50,50,255,1)' ,
                    pointRadius: 0,   
                },{
                    label: 'El1F',
                    data: el_data.map(function(e){ return e.phase1_fae; }),
                    borderColor: 'rgba(155,50,50,0.8)' ,
                    pointRadius: 0,   
                },{
                    label: 'El2F',
                    data: el_data.map(function(e){ return e.phase2_fae; }),
                    borderColor: 'rgba(50,155,50,0.8)' ,
                    pointRadius: 0,   
                },{
                    label: 'El3F',
                    data: el_data.map(function(e){ return e.phase3_fae; }),
                    borderColor: 'rgba(50,50,155,0.8)' ,
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
                        suggestedMax: 20000,
                    },
                    // type: 'logarithmic',
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