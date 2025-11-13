<?php
    const DRYRUN = true;

    include "../../../../vendor/autoload.php";
    include "../../../../sys/autoloader.php";

    $data = $_GET;
    $params = "?";

    foreach ($data as $key => $value) {
        $params .= "$key=$value&";
    }

    if (substr($params, -1,1) == "&") {
        $params = substr($params,0,-1);
    }

    if (DRYRUN) {
        echo $settings->relaisURL->getURL().$params;
    } else {
        // call url
    }
