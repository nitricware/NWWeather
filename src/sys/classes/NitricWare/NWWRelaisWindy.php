<?php
	
	namespace NitricWare;
	
	class NWWRelaisWindy implements INWWRelais {
		private string $apiURL = "https://stations.windy.com/pws/update/%s?winddir=%d&windspeedmph=%d&windgustmph=%d&tempf=%d&rainin=%d&baromin=%F&dewptf=%F&humidity=%d";
		public function handleData (NWWWundergroundJSONData $data): bool {
			//https://stations.windy.com/pws/update/
			//XXX-API-KEY-XXX
			//?
			//winddir=230&windspeedmph=12&windgustmph=12&tempf=70&rainin=0&baromin=29.1&dewptf=68.2&humidity=90
			// eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjaSI6OTUxODAxOSwiaWF0IjoxNjkxNTA5MTQ5fQ.JJBVr-7V2L0LtDPrlbPfkYOlj_DDfc0MHqt7p_XgZkY
			$apiCall = sprintf(
				$this->apiURL,
				NWWeatherSettings::$windyAPIKey,
				$data->winddir,
				$data->windspeedmph,
				$data->windgustmph,
				$data->tempf,
				$data->rainin,
				$data->baromin,
				$data->dewptf,
				$data->humidity
			);
			
			// TODO: that's a code smell. the actual API call is in file_get_contents...
			$db = new NWWRelaisSQLite();
			$db->log("NWWRelaisWindy", file_get_contents($apiCall));
			
			return true;
		}
	}