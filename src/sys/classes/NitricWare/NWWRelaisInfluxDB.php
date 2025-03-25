<?php
	
	namespace NitricWare;
	
	use NitricWare\INWWRelais;
	
	class NWWRelaisInfluxDB implements INWWRelais {
		
		public function handleData (NWWWundergroundJSONData $data): bool {
			$influxDbRequest = [];
			$influxDbRequest['url'] = NWWeatherSettings::$influxDBURL . "bucket=" . NWWeatherSettings::$influxDBBucket . "&precision=s";
			$influxDbRequest['headers'] = [
				'Content-Type' => 'text/plain; charset=utf-8'
			];
			$influxDbRequest['body'] = "weather,location=$data->stationID ";
			$fields = [];
			
			// Extract fields from the NWWundergroundJSONData object
			foreach ($data as $field => $value) {
				// Ignore any fields that are not scalar values (e.g. arrays, objects)
				if (
					$field != "id" &&
					$field != "stationID" &&
					$field != "PASSWORD" &&
					$field != "dateutc" &&
					$field != "action" &&
					$field != "softwaretype" &&
					$field != "realtime" &&
					$field != "rtfreq"
					
				) {
					$fields[] = "$field=$value";
				}
			}
			
			$influxDbRequest['body'] .= implode(",", $fields);
			
			$influxDbRequest['body'] .= " ";
			$influxDbRequest['body'] .= $data->realtime;
			$influxDbRequest['body'] .= "";
			
			$influxDbRequest['body'] .= "\n";
			
			$ch = curl_init($influxDbRequest['url']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $influxDbRequest['body']);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $influxDbRequest['headers']);
			
			$response = curl_exec($ch);
			print_r($influxDbRequest['body']);
			echo $response;
			curl_close($ch);
			
			if ($response === false) {
				echo "Error sending data to InfluxDB: " . curl_error($ch);
			} else {
				echo "Data sent to InfluxDB successfully!";
			}
			return true;
		}
	}