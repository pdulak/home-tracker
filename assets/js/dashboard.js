var last_temps;
var electricity_channels;

function fill_last_temps(element, index, array) {
    var this_temp = document.getElementById('temp_' + element.id);
    this_temp.innerHTML = '<h5>' + element.label + '</h5>'
                        + '<h2>' + element.value + '</h2>'
                        + '<h6>' + element.date_timestamp + '</h6>';
    this_temp.dataset.address = element.address;
    this_temp.dataset.id = element.id;
}

function fill_electricity_meters(element, index, array) {
    var this_temp = document.getElementById('electricity');
    var new_div = document.createElement('div');
    new_div.id = 'channel_' + element.channel;
    new_div.classList.add('column');
    new_div.innerHTML = '<h2>' + element.label + ' (' + (element.isProducer==1?'Produkcja prądu':'Zużycie prądu') + ')</h2>';
    this_temp.append(new_div);
    load_data_for_channel(element.channel)
}

function fill_single_meter(ch, values) {
    var this_div = document.getElementById('channel_' + ch);
    var new_row = document.createElement('div');
    new_row.classList.add('row');
    this_div.append(new_row);

    var total_power = 0;
    values.phases.forEach(function(e, i, a){
        var this_phase = document.createElement('div');
        this_phase.classList.add('column');
        this_phase.classList.add('center');
        this_phase.innerHTML = '<h5>Faza ' + e.number + '</h5>'
                            + '<h5>' + e.powerActive.toFixed(2) + ' W</h5>'
                            + '<h6>' + e.voltage + ' V</h6>';
        new_row.append(this_phase);
        total_power += e.powerActive;
    });
    var global = document.createElement('div');
    global.classList.add('column');
    global.classList.add('center');
    global.innerHTML = '<h5>Wszystkie fazy</h5><h2>' + total_power.toFixed(0) + ' W</h2>';
    new_row.prepend(global);
}

function load_last_temps() {
    ajax_get('/api/last_temp', function(values){
        values.forEach(fill_last_temps);
        last_temps = values;
        load_last_24h_temp();
    });
}

function load_electricity_counters() {
    ajax_get('/api/electricity_counters', function(values){
        values.forEach(fill_electricity_meters);
        electricity_channels = values;
        load_last_24h_electricity();
    });
}

function load_data_for_channel(ch) {
    ajax_get('/api/electricity_state?channel=' + ch, function(values){
        fill_single_meter(ch, values);
    });
}

function load_last_24h_temp() {
    ajax_get('/api/temp_24h', function(values){
        last_temps.forEach(function(e,i,a){
            // extract chart data
            this_temp_data = values.filter(function(value){ return value.id == e.id });
            // find div to place chart in
            this_div = document.querySelectorAll('div[data-id="' + e.id + '"]')[0];
            // add canvas
            new_canvas_id = 'temp_chart_' + e.id; 
            this_div.innerHTML += '<canvas id="' + new_canvas_id + '"></canvas>';
            
            draw_24h_temp(new_canvas_id, this_temp_data);
        })
    });
}

function load_last_24h_electricity() {
    ajax_get('/api/electricity_24h', function(values){
        console.log(values);
    });
}

load_last_temps();
load_electricity_counters();