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
<script src="<?php echo site_url('/') ?>assets/js/tools.js"></script>
<script src="<?php echo site_url('/') ?>assets/js/dashboard.js"></script>

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
        }
    }
});
</script>

</body>
</html>