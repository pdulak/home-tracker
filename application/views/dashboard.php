<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$assetsVersion = '2020021501';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
	<title>Tracker Dashboard</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/normalize.css?v=<?php echo $assetsVersion ?>">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/milligram.css?v=<?php echo $assetsVersion ?>">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/loader.css?v=<?php echo $assetsVersion ?>">
    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/Chart.min.css?v=<?php echo $assetsVersion ?>">

    <link rel="stylesheet" href="<?php echo site_url('/') ?>assets/css/style.css">
</head>
<body>
<div class="loading" id="ajax-loader-overlay">Loading&#8230;</div>

<header></header>

<div class="container electricity_container">
    <div class="row" id="electricity">
    </div>
    <!-- <div class="row">
        <div class="column">
            <div class="center">
                <canvas id="channel_chart_31938"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="center">
                <canvas id="channel_chart_32424"></canvas>
            </div>
        </div>
    </div> -->
    <div class="row" id="monthly_table">
        <table>
            <thead>
                <tr>
                    <th>miesiąc</th>
                    <th>produkcja</th>
                    <th>zużycie z produkcji</th>
                    <th>zużycie z elektrowni</th>
                    <th>oddane</th>
                    <th>zużycie całkowite</th>
                    <th>zużycie minus magazyn (oddane*0.8)</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
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

<script src="<?php echo site_url('/') ?>assets/js/Chart.bundle.min.js"></script>
<script src="<?php echo site_url('/') ?>assets/js/tools.js?v=<?php echo $assetsVersion ?>"></script>
<script src="<?php echo site_url('/') ?>assets/js/tools-charts.js?v=<?php echo $assetsVersion ?>"></script>
<script src="<?php echo site_url('/') ?>assets/js/dashboard.js?v=<?php echo $assetsVersion ?>"></script>

</body>
</html>