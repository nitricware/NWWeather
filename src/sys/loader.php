<?php
    $classes = scandir(__DIR__ . "/classes/");
    
    foreach ($classes as $class) { 
        if ($class != ".." && $class != ".") {
            include __DIR__."/classes/".$class;
        }
    }

    include __DIR__."/var/settings.php";
    use NitricWare\NWWeatherSettings as NWWeatherSettings;
    $settings = new NWWeatherSettings();

