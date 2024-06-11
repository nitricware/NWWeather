<?php
	
	namespace NitricWare;
	
	/*
 * Array
(
    [ID] => TestID
    [PASSWORD] => TestKey
    [tempf] => 63.0
    [humidity] => 68
    [dewptf] => 52.2
    [windchillf] => 63.0
    [winddir] => 288
    [windspeedmph] => 2.91
    [windgustmph] => 4.47
    [rainin] => 0.000
    [dailyrainin] => 0.059
    [weeklyrainin] => 0.449
    [monthlyrainin] => 2.567
    [yearlyrainin] => -9999
    [totalrainin] => 16.949
    [solarradiation] => 137.15
    [UV] => 1
    [indoortempf] => 71.2
    [indoorhumidity] => 62
    [absbaromin] => 29.149
    [baromin] => 30.304
    [lowbatt] => 0
    [dateutc] => now
    [softwaretype] => EasyWeatherPro_V5.1.1
    [action] => updateraw
    [realtime] => 1
    [rtfreq] => 5
)
 */
	class NWWWundergroundJSONData {
		public readonly int $id;
		public readonly string $stationID;
		public readonly string $PASSWORD;
		public readonly float $tempf;
		public readonly int $humidity;
		public readonly float $dewptf;
		public readonly float $windchillf;
		public readonly int $winddir;
		public readonly float $windspeedmph;
		public readonly float $windgustmph;
		public readonly float $rainin;
		public readonly float $dailyrainin;
		public readonly float $weeklyrainin;
		public readonly float $monthlyrainin;
		public readonly float $yearlyrainin;
		public readonly float $totalrainin;
		public readonly float $solarradiation;
		public readonly int $UV;
		public readonly float $indoortempf;
		public readonly float $indoorhumidity;
		public readonly float $absbaromin;
		public readonly float $baromin;
		public readonly int $lowbatt;
		public readonly mixed $dateutc;
		public readonly string $softwaretype;
		public readonly string $action;
		public readonly int $realtime;
		public readonly int $rtfreq;
		
		public function parseFromArray(array $input, bool $useInputTime = false, $fromDatabase = false) {
			$defaultValues = [
				"ID" => "DefaultID",
				"PASSWORD" => "DefaultPassword",
				"tempf" => 0.0,
				"humidity" => 0.0,
				"dewptf" => 0.0,
				"windchillf" => 0.0,
				"winddir" => 0.0,
				"windspeedmph" => 0.0,
				"windgustmph" => 0.0,
				"rainin" => 0.0,
				"dailyrainin" => 0.0,
				"weeklyrainin" => 0.0,
				"monthlyrainin" => 0.0,
				"yearlyrainin" => 0.0,
				"totalrainin" => 0.0,
				"solarradiation" => 0.0,
				"UV" => 0.0,
				"indoortempf" => 0.0,
				"indoorhumidity" => 0.0,
				"absbaromin" => 0.0,
				"baromin" => 0.0,
				"lowbatt" => 0,
				"dateutc" => gmdate("d M Y H:i:s", time()),
				"softwaretype" => "DefaultSoftware",
				"action" => "DefaultAction",
				"realtime" => time(),
				"rtfreq" => 0,
				"stationID" => "DefaultStationID"
			];
			
			$input = array_merge($defaultValues,$input);
			
			if ($fromDatabase) {
				$this->stationID = $input["stationID"];
				$this->id = $input["id"];
			} else {
				$this->stationID = $input["ID"];
				$this->id = 0;
			}
			
			$this->PASSWORD = $input["PASSWORD"];
			$this->tempf = $input["tempf"];
			$this->humidity = $input["humidity"];
			$this->dewptf = $input["dewptf"];
			$this->windchillf = $input["windchillf"];
			$this->winddir = $input["winddir"];
			$this->windspeedmph = $input["windspeedmph"];
			$this->windgustmph = $input["windgustmph"];
			$this->rainin = $input["rainin"];
			$this->dailyrainin = $input["dailyrainin"];
			$this->weeklyrainin = $input["weeklyrainin"];
			$this->monthlyrainin = $input["monthlyrainin"];
			$this->yearlyrainin = $input["yearlyrainin"];
			$this->totalrainin = $input["totalrainin"];
			$this->solarradiation = $input["solarradiation"];
			$this->UV = $input["UV"];
			$this->indoortempf = $input["indoortempf"];
			$this->indoorhumidity = $input["indoorhumidity"];
			$this->absbaromin = $input["absbaromin"];
			$this->baromin = $input["baromin"];
			$this->lowbatt = $input["lowbatt"];
			
			if ($useInputTime) {
				$this->dateutc = $input["dateutc"];
			} else {
				$this->dateutc = gmdate("d M Y H:i:s", time());
			}
			
			$this->softwaretype = $input["softwaretype"];
			$this->action = $input["action"];
			
			if ($useInputTime) {
				$this->realtime = $input["realtime"];
			} else {
				$this->realtime = time();
			}
			
			$this->rtfreq = $input["rtfreq"];
		}
	}