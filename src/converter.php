<pre>
<?php
	ini_set('max_execution_time', '0');
    ob_implicit_flush();
	use NitricWare\NWWRelaisSQLite;
	use NitricWare\NWWWundergroundJSONData;
	
    require "sys/autoloader.php";
    
    function getFiles($dir): array {
	    $d = scandir($dir);
        $files = [];
	    foreach ($d as $f) {
		    if ($f != "." && $f != ".." && $f != ".gitignore" && !strpos($f,"indycall_")) {
			    $files[] = $dir.$f;
		    }
	    }
        
        return $files;
    }
    
    function getAPIURL($file): string {
	    $f = file_get_contents($file);
	    $m = null;
	    $o = preg_match_all("/\[([A-Za-z]+)] => ([A-Za-z0-9._-]+)/", $f, $m);
	    
	    $r = array_combine($m[1],$m[2]);
	    
	    $u = "http://cayoparaiso.local/~kurt/weather/endpoints/post/wunderground/v1/endpoint.php?";
	    
	    $p = [];
	    
	    foreach ($r as $k => $v) {
            if ($k == "dateutc") {
                // MARK: filemtime and filectime return different results based on the OS
                $v = urlencode(gmdate("d M Y H:i:s", filemtime($file)));
            }
            
            if ($k == "realtime") {
	            // MARK: filemtime and filectime return different results based on the OS
                $v = filemtime($file);
            }
		    $p[] = "$k=$v";
	    }
	    
	    $u .= implode("&",$p);
	    
	    return $u;
    }
    
    function callEndpoint($url): string {
	    $ch = curl_init($url);
	    
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $r = curl_exec($ch);
	    curl_close($ch);
        
        echo "Error: ".curl_error($ch);
        
        return $r == "" ? "--- | ".curl_error($ch) : $r." | ".curl_error($ch);
    }
	
    function unserializeFile($file) {
        $f = file_get_contents($file);
        print_r($f);
        $o = unserialize($f);
        return $o;
    }
	
	function getWeatherObject($file): NWWWundergroundJSONData {
		$f = file_get_contents($file);
        $t = pathinfo($file)["filename"];
		$m = null;
		$o = preg_match_all("/\[([A-Za-z]+)] => ([A-Za-z0-9._-]+)/", $f, $m);
		
		$r = array_combine($m[1],$m[2]);
        $r["dateutc"] = gmdate("d M Y H:i:s", filemtime($file));
        $r["realtime"] = filemtime($file);
        
        $w = new NWWWundergroundJSONData();
        $w->parseFromArray($r, true);
        return $w;
	}
    
    /*
     * CONVERTER
     * (c) Kurt Frey
     */
	
	$files = [];
	//$logs = scandir("./logs");
	//$sysLogs = scandir("./sys/logs");
	
	$logs = getFiles(ROOT_DIR."/../logs/");
	$sysLogs = getFiles(ROOT_DIR."/../sys/logs/");
	
	$files = array_merge($logs,$sysLogs);
	
	// print_r($files);
    $count = count($files);
    $i = 1;
    echo "starting to parse $count files...\n";
    
    foreach ($files as $f) {
        echo "[$i/$count] parsing $f\n";
        $w = getWeatherObject($f);
        //print_r($w);
	    $sqlite = new NWWRelaisSQLite();
	    $sqlite->handleData($w);
        $i++;
    }