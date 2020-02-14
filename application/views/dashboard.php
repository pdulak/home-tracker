<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
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

<div class="container electricity_container">
    <div class="row" id="electricity">
    </div>
</div>

<script src="<?php echo site_url('/') ?>assets/js/Chart.bundle.min.js"></script>
<script src="<?php echo site_url('/') ?>assets/js/tools.js"></script>
<script src="<?php echo site_url('/') ?>assets/js/tools-charts.js"></script>
<script src="<?php echo site_url('/') ?>assets/js/dashboard.js"></script>

</body>
</html>