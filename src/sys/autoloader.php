<?php
    function NWAutoLoad(string $className): void {
        // Resolve namespaces into directories
        $className = str_replace("\\", "/", $className);
        if (file_exists(__DIR__."/classes/$className.php")) include __DIR__."/classes/$className.php";
	    if (file_exists(__DIR__."/interfaces/$className.php")) include __DIR__."/interfaces/$className.php";
    }
	const ROOT_DIR = __DIR__;
	error_reporting(E_ALL);
	

    spl_autoload_register("NWAutoLoad");
	/*
    include __DIR__."/var/settings.php";
	use NitricWare\NWWeatherSettings as NWWeatherSettings;
    $settings = new NWWeatherSettings();
	*/
	