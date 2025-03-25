<?php
	
	use NitricWare\NWWeatherDatabase;
	use NitricWare\NWWeatherTemperatures;
	use NitricWare\NWWLogDatabase;
	use NitricWare\Tonic;
	
	require "sys/autoloader.php";
	require "vendor/autoload.php";
	
	$head = new Tonic("sys/views/head.html");
	$footer = new Tonic("sys/views/footer.html");
	$dashboard = new Tonic("sys/views/dashboard.html");
	
	$db = new NWWeatherDatabase();
	$ldb = new NWWLogDatabase();
	
	$dashboard->assign("dataPointsCount", $db->countDatapoints());
	
	$temperatureDataPoints = $db->getTemperatureDataPoints();
	$dashboard->assign("temperatureDataPoints", $temperatureDataPoints);
	
	$latestRecords = $db->getLatestRecords();
	$dashboard->assign("latestRecords", $latestRecords);
	
	$latestLogEntries = $ldb->getLogEntries();
	$dashboard->assign("latestLogEntries", $latestLogEntries);
	
	$head->render(true);
	$dashboard->render(true);
	$footer->render(true);
