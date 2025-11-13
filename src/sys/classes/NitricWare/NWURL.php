<?php
    namespace NitricWare;

    class NWURL {
        private string $url;
        
        function __construct(string $url)
        {
            if (substr($url, -1, 1) == "/") {
                $this->url = $url;
            } else {
                $this->url = $url."/";
            }
        }

        function getURL(): string {
            return $this->url;
        }
    }