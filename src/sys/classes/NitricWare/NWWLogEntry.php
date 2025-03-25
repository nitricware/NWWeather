<?php
	
	namespace NitricWare;

	class NWWLogEntry {
		public int $id;
		public string $dateutc;
		public string $caller;
		public string $message;
		
		public function parseFromArray(array $data): void {
			$this->id = $data["id"];
			$this->dateutc = $data["dateutc"];
			$this->caller = $data["caller"];
			$this->message = $data["message"];
		}
	}