<?php
	namespace NitricWare;
	
	// 1. rename file to settings.php
	// 2, rename class to NWWeatherSettings
	class NWWeatherSettingsExample {
		public static string $relaisURL = "https://relais.url";
		public static string $windyAPIKey = "";
		public static array $relaisList = [ "NitricWare\NWWRelaisSQLite", "NitricWare\NWWRelaisInfluxDB" ];
		public static string $influxDBURL = "http://localhost:8086/api/v2/write?";
		public static string $influxDBBucket = "weatherdb";
	}