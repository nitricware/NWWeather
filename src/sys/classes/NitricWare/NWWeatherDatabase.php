<?php
	
	namespace NitricWare;
	
	use SQLite3;
	
	class NWWeatherDatabase {
		public $dbPath = ROOT_DIR."/db/data.sqlite";
		public SQLite3|null $db = null;
		
		public function __construct () {
			$this->db = new SQLite3($this->dbPath);
		}
		public function countDatapoints() {
			return $this->db->querySingle("SELECT COUNT(*) FROM tableWeatherdata");
		}
		
		public function getTemperatureDataPoints(NWWeatherTemperatures $unit = NWWeatherTemperatures::Celsius, int $limit = 100, int $start = 0, int $end = 0): array {
			$sql = /** @lang SQL */ "SELECT tempf, dateutc FROM tableWeatherData WHERE realtime > $start ";
			if ($end >0) {
				$sql .= /** @lang SQL */ "AND realtime <= $end ";
			}
			$sql .= /** @lang SQL */ "ORDER BY realtime DESC ";
			if ($limit > 0) {
				$sql .= /** @lang SQL */ "LIMIT $limit ";
			}
			$sql .= ";";
			$result = $this->db->query($sql);
			$return = [];
			
			while ($row = $result->fetchArray()) {
				if ($unit != NWWeatherTemperatures::Fahrenheit) {
					$return[$row[1]] = ($row[0] - 30) / 2;
				} else {
					$return[$row[1]] = $row[0];
				}
			}
			
			return $return;
		}
	}
	
	enum NWWeatherTemperatures {
		case Celsius;
		case Fahrenheit;
	}