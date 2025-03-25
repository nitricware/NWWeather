<?php
	
	namespace NitricWare;
	
	use SQLite3;
	
	class NWWLogDatabase {
		public $dbPath = ROOT_DIR . "/db/data.sqlite";
		public SQLite3|null $db = null;
		
		public function __construct () {
			$this->db = new SQLite3($this->dbPath);
		}
		
		public function getLogEntries(int $limit = 10) {
			$sql = /** @lang SQL */
				"SELECT * FROM tableLog ORDER BY id DESC LIMIT $limit;";
			$result = $this->db->query($sql);
			$return = [];
			
			while ($row = $result->fetchArray()) {
				$data = new NWWLogEntry();
				$data->parseFromArray($row);
				$return[] = $data;
			}
			
			return $return;
		}
	}