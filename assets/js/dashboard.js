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
        // load_last_24h_electricity();
        load_monthly_electricity();
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
        electricity_delta = calculate_electricity_delta(values);
        draw_electricity_delta(electricity_delta, electricity_channels);
    });
}

function load_monthly_electricity() {
    ajax_get('/api/electricity_monthly', function(values){
        display_monthly_electricity(values);
    });
}

function calculate_electricity_delta(values) {
    var channels_last_values = [];
    var channels_delta = [];
    values.forEach(function(v){
        if(channels_last_values[v.channel]) {
            // calculate delta
            previous = channels_last_values[v.channel];
            channels_delta.push({
                phase1_rae: v.phase1_rae - previous.phase1_rae,
                phase1_fae: v.phase1_fae - previous.phase1_fae,
                phase2_rae: v.phase2_rae - previous.phase2_rae,
                phase2_fae: v.phase2_fae - previous.phase2_fae,
                phase3_rae: v.phase3_rae - previous.phase3_rae,
                phase3_fae: v.phase3_fae - previous.phase3_fae,
                channel: v.channel,
                dt: v.dt
            })
        } 
        channels_last_values[v.channel] = v;
    });
    return channels_delta;
}

function return_empty_monthly_row() {
    return {
        date: '',
        production: 0,
        selfConsumption: 0,
        consumption: 0,
        fedIntoGrid: 0
    };
}

function display_monthly_electricity(values) {
    var currentRow = return_empty_monthly_row();
    var lastRow = return_empty_monthly_row();

    values.forEach(function(item, index) {
        thisRowDate = '' + item.y + '/' + item.m;
        if (thisRowDate != currentRow.date) {
            add_row_to_monthly_table(currentRow, lastRow);
            lastRow = currentRow;
            currentRow = return_empty_monthly_row();
            currentRow.date = thisRowDate;
        }
        if (item.channel == "31938") { //main counter
            currentRow.consumption = Math.round((parseInt(item.p1f) + parseInt(item.p2f) + parseInt(item.p3f))/100000);
            currentRow.fedIntoGrid = Math.round((parseInt(item.p1r) + parseInt(item.p2r) + parseInt(item.p3r))/100000);
        }
        if (item.channel == "32424") { //main counter
            currentRow.production = Math.round((parseInt(item.p1r) + parseInt(item.p2r) + parseInt(item.p3r))/100000);
        }
    })

    add_row_to_monthly_table(currentRow, lastRow);
}

function add_row_to_monthly_table(rowData, lastRowData) {
    var tbody = document.querySelector("#monthly_table table tbody");
    
    if (rowData.date != '') {
        // calculate self consumption
        if ((rowData.production == 0) && (rowData.fedIntoGrid > 0)) {
            rowData.production = rowData.fedIntoGrid;
        }
        rowData.selfConsumption = rowData.production - rowData.fedIntoGrid;
        if ((lastRowData.production == 0) && (lastRowData.fedIntoGrid > 0)) {
            lastRowData.production = lastRowData.fedIntoGrid;
        }
        lastRowData.selfConsumption = lastRowData.production - lastRowData.fedIntoGrid;
        
        var row = tbody.insertRow(-1);
        var cdate = row.insertCell(0);
        var cprod = row.insertCell(1);
        var cconsprod = row.insertCell(2);
        var ccons = row.insertCell(3);
        var cfed = row.insertCell(4);
        var cconstotal = row.insertCell(5);
        var cconscalc = row.insertCell(6);

        cdate.innerHTML = rowData.date;
        cprod.innerHTML = '' + (rowData.production - lastRowData.production) + ' kWh<br />' + 
             rowData.production + ' kWh';
        cconsprod.innerHTML = '' + (rowData.selfConsumption - lastRowData.selfConsumption) + ' kWh<br />' + 
             rowData.selfConsumption + ' kWh';
        ccons.innerHTML = '' + (rowData.consumption - lastRowData.consumption) + ' kWh<br />' + 
             rowData.consumption + ' kWh';
        cfed.innerHTML = '' + (rowData.fedIntoGrid - lastRowData.fedIntoGrid) + ' kWh<br />' + 
             rowData.fedIntoGrid + ' kWh';
        cconstotal.innerHTML = '' + 
            ((rowData.selfConsumption + rowData.consumption) - (lastRowData.selfConsumption + lastRowData.consumption)) + ' kWh<br />' +
            (rowData.selfConsumption + rowData.consumption) + ' kWh';
        cconscalc.innerHTML = '' + 
            Math.round(rowData.consumption - (0.8 * rowData.fedIntoGrid) - (lastRowData.consumption - (0.8 * lastRowData.fedIntoGrid)) ) + ' kWh<br />' + 
            Math.round(rowData.consumption - (0.8 * rowData.fedIntoGrid)) + ' kWh';
    }
}

load_last_temps();
load_electricity_counters();