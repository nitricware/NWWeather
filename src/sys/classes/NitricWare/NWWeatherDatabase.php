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
			return $this->db->querySingle("SELECT COUNT(*) FROM tableWeatherData");
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
				/** if the weather station, for some reason, can't measure the temperature,
				 * it will return -9999.0. Therefore, we omit rows with a temperature of -9999.0.
				 */
				if ($row[0] == -9999.0) {
					continue;
				}
				
				if ($unit != NWWeatherTemperatures::Fahrenheit) {
					$return[$row[1]] = ($row[0] - 30) / 2;
				} else {
					$return[$row[1]] = $row[0];
				}
			}
			
			return $return;
		}
		
		public function getLatestRecords (int $limit = 5): array {
			$sql = /** @lang SQL */ "SELECT * FROM tableWeatherData ORDER BY realtime DESC LIMIT $limit;";
			$result = $this->db->query($sql);
			$return = [];
			
			while ($row = $result->fetchArray()) {
				$data = new NWWWundergroundJSONData();
				$data->parseFromArray($row, useInputTime: true, fromDatabase: true);
				$return[] = $data;
			}
			
			return $return;
		}
	}
	
	enum NWWeatherTemperatures {
		case Celsius;
		case Fahrenheit;
	}