<?php
	
	namespace NitricWare;
	
	use NitricWare\INWWRelais;
	
	class NWWRelaisInfluxDB implements INWWRelais {
		
		public function handleData (NWWWundergroundJSONData $data): bool {
			// TODO: Implement handleData() method.
			// This class must transform the windy $_POST to InfluxDB format
			return true;
		}
	}