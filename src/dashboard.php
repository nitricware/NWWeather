<?php
	
	use NitricWare\NWWeatherDatabase;
	use NitricWare\NWWeatherTemperatures;
	use NitricWare\Tonic;
	
	require "sys/autoloader.php";
	require "vendor/autoload.php";
	
	$head = new Tonic("sys/views/head.html");
	$footer = new Tonic("sys/views/footer.html");
	$dashboard = new Tonic("sys/views/dashboard.html");
	
	$db = new NWWeatherDatabase();
	
	$dashboard->assign("dataPointsCount", $db->countDatapoints());
	
	$temperatureDataPoints = $db->getTemperatureDataPoints();
	$dashboard->assign("temperatureDataPoints", $temperatureDataPoints);
	
	$head->render(true);
	$dashboard->render(true);
	$footer->render(true);
