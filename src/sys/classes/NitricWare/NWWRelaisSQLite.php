<?php
	
	namespace NitricWare;
	
	use NitricWare\INWWRelais;
	use \SQLite3;
	
	class NWWRelaisSQLite implements INWWRelais {
		public $dbPath = ROOT_DIR."/db/data.sqlite";
		public $db = null;
		
		public function __construct() {
			if (!file_exists($this->dbPath)) {
				$this->createDatabase();
			} else {
				$this->db = new SQLite3($this->dbPath);
			}
		}
		
		public function handleData (NWWWundergroundJSONData $data): bool {
			$keyArray = [];
			$keyString = "";
			$valueArray = [];
			$valueString = "";
			
			foreach ($data as $key => $value) {
				if ($key != "id" && $key != "PASSWORD") {
					$keyArray[] = $key;
					$valueArray[] = "'$value'";
				}
			}
			
			$keyString = implode(",", $keyArray);
			$valueString = implode(",", $valueArray);
			
			$query = "INSERT INTO tableWeatherData ($keyString) VALUES ($valueString)";
			$this->db->exec($query);
			return true;
		}
		
		public function log(string $caller, string $message) {
			$dateutc = gmdate("d M Y H:i:s", time());
			$query = "INSERT INTO tableLog ('dateutc', 'caller', 'message') VALUES ('$dateutc', '$caller', '$message')";
			$this->db->exec($query);
		}
		
		private function createDatabase() {
			$this->db = new SQLite3($this->dbPath);
			$this->db->exec("CREATE TABLE IF NOT EXISTS tableWeatherData(
							    id INTEGER PRIMARY KEY AUTOINCREMENT,
							    stationID TEXT NOT NULL DEFAULT 'defaultStation',
   								tempf FLOAT NOT NULL DEFAULT '0',
								humidity INT NOT NULL DEFAULT '0',
								dewptf FLOAT NOT NULL DEFAULT '0',
								windchillf FLOAT NOT NULL DEFAULT '0',
								winddir INT NOT NULL DEFAULT '0',
								windspeedmph FLOAT NOT NULL DEFAULT '0',
								windgustmph FLOAT NOT NULL DEFAULT '0',
								rainin TEXT FLOAT NULL DEFAULT '0',
								dailyrainin FLOAT NOT NULL DEFAULT '0',
								weeklyrainin FLOAT NOT NULL DEFAULT '0',
								monthlyrainin FLOAT NOT NULL DEFAULT '0',
								yearlyrainin FLOAT NOT NULL DEFAULT '0',
								totalrainin FLOAT NOT NULL DEFAULT '0',
								solarradiation FLOAT NOT NULL DEFAULT '0',
								UV INT NOT NULL DEFAULT '0',
								indoortempf FLOAT NOT NULL DEFAULT '0',
								indoorhumidity INT NOT NULL DEFAULT '0',
								absbaromin FLOAT NOT NULL DEFAULT '0',
								baromin FLOAT NOT NULL DEFAULT '0',
								lowbatt INT NOT NULL DEFAULT '0',
								dateutc TEXT NOT NULL DEFAULT '0',
								softwaretype TEXT NOT NULL DEFAULT '0',
								action TEXT NOT NULL DEFAULT '0',
								realtime INT NOT NULL DEFAULT '0',
								rtfreq INT NOT NULL DEFAULT '0'
							)");
			$this->db->exec("CREATE TABLE IF NOT EXISTS tableLog(
							    id INTEGER PRIMARY KEY AUTOINCREMENT,
   								dateutc TEXT NOT NULL DEFAULT '0',
   								caller TEXT NOT NULL DEFAULT '0',
   								message TEXT NOT NULL DEFAULT '0'
							)");
		}
	}