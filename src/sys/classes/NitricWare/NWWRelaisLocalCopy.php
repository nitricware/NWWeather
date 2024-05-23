<?php
	namespace NitricWare;
	
	use NitricWare\INWWRelais;
	
	class NWWRelaisLocalCopy implements INWWRelais {
		
		public function handleData (NWWWundergroundJSONData $data): bool {
			// TODO: add setting to specify path
			file_put_contents(ROOT_DIR."/logs/".time().".txt", print_r($data, true));
			
			return true;
		}
	}