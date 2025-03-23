<?php
	
	use NitricWare\NWWRelaisInfluxDB;
	use NitricWare\NWWRelaisLocalCopy;
	use NitricWare\NWWRelaisSQLite;
	use NitricWare\NWWRelaisWindy;
	use NitricWare\NWWWundergroundJSONData;
	
	include "../../../../sys/autoloader.php";
	include "../../../../sys/var/settings.php";

	// TODO: Loop through NWWRelais classes
	// $x = new $className()
	// $x->handleData($_GET)
	// cayoparaiso.local/~kurt/weather/endpoints/post/wunderground/v1/endpoint.php?ID=TestID&PASSWORD=TestKey&tempf=63&humidity=68&dewptf=52.2&windchillf=63&winddir=288&windspeedmph=2.91&windgustmph=4.47&rainin=0&dailyrainin=0.059&weeklyrainin=0.449&yearlyrainin=-9999&totalrainin=16.949&solarradiation=137.15&UV=1&indoortempf=71.2&indoorhumidity=62&absbaromin=29.149&baromin=30.304&lowbatt=0&dateutc=now&softwaretype=EasyWeatherPro_V5.1.1&action=updateraw&realtime=1&rtfreq=5&monthlyrainin=2.567
	// localhost/endpoints/post/wunderground/v1/endpoint.php?ID=TestID&PASSWORD=TestKey&tempf=63&humidity=68&dewptf=52.2&windchillf=63&winddir=288&windspeedmph=2.91&windgustmph=4.47&rainin=0&dailyrainin=0.059&weeklyrainin=0.449&yearlyrainin=-9999&totalrainin=16.949&solarradiation=137.15&UV=1&indoortempf=71.2&indoorhumidity=62&absbaromin=29.149&baromin=30.304&lowbatt=0&dateutc=now&softwaretype=EasyWeatherPro_V5.1.1&action=updateraw&realtime=1&rtfreq=5&monthlyrainin=2.567
	$data = new NWWWundergroundJSONData();
	$data->parseFromArray($_GET);
	
	//print_r($data);
	
    $localCopy = new NWWRelaisLocalCopy();
	$localCopy->handleData($data);
	
	//echo "writing to DB";
	
	$sqlite = new NWWRelaisSQLite();
	$sqlite->handleData($data);
	
	$windy = new NWWRelaisWindy();
	$windy->handleData($data);
	
	$influxDB = new NWWRelaisInfluxDB();
	$influxDB->handleData($data);