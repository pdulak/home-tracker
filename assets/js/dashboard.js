function fill_last_temps(element, index, array) {
    this_temp = document.getElementById('temp_' + element.id);
    this_temp.innerHTML = '<h5>' + element.label + '</h5>';
    this_temp.innerHTML += '<h2>' + element.value + '</h2>';
    this_temp.innerHTML += '<h6>' + element.date_timestamp + '</h6>';
}

function fill_electricity_meters(element, index, array) {
    this_temp = document.getElementById('electricity');
    new_div = document.createElement('div');
    new_div.id = 'channel_' + element.channel;
    new_div.innerHTML = '<h3>' + element.label + ' (' + (element.isProducer==1?'Produkcja prądu':'Zużycie prądu') + ')</h3>';
    this_temp.append(new_div);
    load_data_for_channel(element.channel)
}

function fill_single_meter(ch, values) {
    this_div = document.getElementById('channel_' + ch);
    new_row = document.createElement('div');
    new_row.classList.add('row');
    this_div.append(new_row);
    total_power = 0;
    values.phases.forEach(function(e, i, a){
        this_phase = document.createElement('div');
        this_phase.classList.add('column');
        this_phase.classList.add('center');
        this_phase.innerHTML = '<h5>Faza ' + e.number + '</h5>'
        this_phase.innerHTML += '<h3>' + e.powerActive.toFixed(2) + ' W</h3>';
        this_phase.innerHTML += '<h5>' + e.voltage + ' V</h5>';
        new_row.append(this_phase);
        total_power += e.powerActive;
    });
    global = document.createElement('div');
    global.classList.add('column');
    global.classList.add('center');
    global.innerHTML = '<h5>Wszystkie fazy</h5><h2>' + total_power.toFixed(2) + ' W</h2>';
    new_row.prepend(global);
}

function load_last_temps() {
    ajax_get('/api/last_temp', function(values){
        values.forEach(fill_last_temps);
    });
}

function load_electricity_counters() {
    ajax_get('/api/electricity_counters', function(values){
        values.forEach(fill_electricity_meters);
    });
}

function load_data_for_channel(ch) {
    ajax_get('/api/electricity_state?channel=' + ch, function(values){
        fill_single_meter(ch, values);
    });
}

load_last_temps();
load_electricity_counters();