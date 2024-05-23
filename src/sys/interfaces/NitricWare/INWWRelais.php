<?php
	namespace NitricWare;
	interface INWWRelais {
		public function handleData (NWWWundergroundJSONData $data): bool;
	}
