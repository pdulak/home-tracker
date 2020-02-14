<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Tracker Dashboard</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/milligram.css">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/loader.css">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/Chart.min.css">

    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/style.css">
</head>
<body>
<div class="loading" id="ajax-loader-overlay">Loading&#8230;</div>

<div class="container">
    <h1>Tracker Dashboard</h1>
</div>

<div class="container">
    <div class="row">
        <div class="column">
            <div class="center last_temp" id="temp_1">
                Czerpnia
            </div>
        </div>
        <div class="column">
            <div class="center last_temp" id="temp_3">
                Wyrzutnia
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="center last_temp" id="temp_4">
                Do domu
            </div>
        </div>
        <div class="column">
            <div class="center last_temp" id="temp_2">
                Z domu
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="column"></div>
        <div class="column">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<div class="container" id="electricity">
</div>

<script src="<?php echo site_url('/') ?>assets/js/Chart.bundle.min.js"></script>
<script>
    var ajax_count = 0;

    function ajax_start() {
        ajax_count++;
        if (ajax_count == 1) {
            document.getElementById("ajax-loader-overlay").style.display = 'block';
        }
    }

    function ajax_finish() {
        if (ajax_count > 0) {
            ajax_count--;
            if (ajax_count == 0) {
                document.getElementById("ajax-loader-overlay").style.display = 'none';
            }
        }
    }

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
        ajax_start();
        var r = new XMLHttpRequest();
        r.open('GET', '/api/last_temp');
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                ajax_finish();
                if (r.status != 200) {
                    // load error
                } else {
                    values = JSON.parse(r.responseText);
                    values.forEach(fill_last_temps);
                }
            }
        };
        r.send();
    }

    function load_electricity_counters() {
        ajax_start();
        var r = new XMLHttpRequest();
        r.open('GET', '/api/electricity_counters');
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                ajax_finish();
                if (r.status != 200) {
                    // load error
                } else {
                    values = JSON.parse(r.responseText);
                    values.forEach(fill_electricity_meters);
                }
            }
        };
        r.send();
    }

    function load_data_for_channel(ch) {
        ajax_start();
        var r = new XMLHttpRequest();
        r.open('GET', '/api/electricity_state?channel=' + ch);
        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                ajax_finish();
                if (r.status != 200) {
                    // load error
                } else {
                    values = JSON.parse(r.responseText);
                    fill_single_meter(ch, values);
                }
            }
        };
        r.send();
    }

    load_last_temps();
    load_electricity_counters();
</script>

<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [ 1, 2, 3, 4, 5, 6],
        datasets: [{
            label: 'test',
            data: [12, 19, 3, 5, 2, 3],
            borderColor: 'rgba(200,100,100,1)' ,
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        bezierCurve: false, //remove curves from your plot
        scaleShowLabels: false, //remove labels
        tooltipEvents: [], //remove trigger from tooltips so they will'nt be show
        pointDot: false, //remove the points markers
        scaleShowGridLines: true //set to false to remove the grids background
    }
});
</script>

</body>
</html>