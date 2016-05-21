<?php

class ClientInfo {
    private $IP= "";
    private $hostname = "";
    private $userAgent = "";
    private $browser = "";
    private $OS = "";
    private $language = "";
    
    public function getIP() {
        if (empty($this->IP)) {
            $this->IP = $_SERVER["REMOTE_ADDR"];
        }
        
        return $this->IP;
    }
    public function getHostname() {
        if (empty($this->hostname)) {
            $this->hostname = gethostbyaddr(
                $this->getIP()
            );
        }
        
        return $this->hostname;
    }
    public function getUserAgent() {
        if (empty($this->userAgent)) {
            $this->userAgent = $_SERVER["HTTP_USER_AGENT"];
        }
        
        return $this->userAgent;
    }
    public function getBrowser() {
        if (empty($this->browser)) {
            $ua = $this->getUserAgent();
            
            if (stripos($ua, "Firefox") !== false) {
                $this->browser = "Firefox";
		$pos_version_start = stripos(
                    $ua,
                    "Firefox/"
                ) + strlen("Firefox/");
                
                $version = substr($ua, $pos_version_start);
				
                $this->browser .= " " . $version;

            } elseif (stripos($ua, "MSIE") !== false) {
                $this->browser = "Internet Explorer";
            } elseif (stripos($ua, "Chrome") !== false) {
                $this->browser = "Google Chrome";
                $pos_version_start = stripos(
                    $ua,
                    "Chrome/"
                ) + strlen("Chrome/");
                $pos_version_end = stripos(
                    $ua,
                    " ",
                    $pos_version_start
                );
                $version = explode(
                    ".",
                    substr(
                        $ua,
                        $pos_version_start,
                        $pos_version_end - $pos_version_start
                    )
                );
                $version = $version[0] . "." . $version[1];
                $this->browser .= " " . $version;
            } else {
                $this->browser = "Unknown";
            }
        }
        
        return $this->browser;
    }
    public function getOS() {
        if (empty($this->OS)) {
            $this->OS = "AbsolutelyEpicOS";
            
            $ua = $this->getUserAgent();
            if (stripos($ua, "Android") !== false) {
                // Check for Android before checking for GNU/Linux,
                // since (at least) Android's Chrome identifies itself
                // as “Linux”, since it simply is.
                $this->OS = "Android ";
                $pos_version_start = stripos(
                        $ua,
                        "Android"
                ) + strlen("Android");
               $pos_version_end = stripos(
                        $ua,
                        ";",
                        $pos_version_start
                );
                $this->OS .= substr(
                    $ua,
                    $pos_version_start,
                    $pos_version_end - $pos_version_start
                );
            } elseif (stripos($ua, "FreeBSD") !== false) {
                $this->OS = "FreeBSD";
            } elseif (stripos($ua, "OpenBSD") !== false) {
                $this->OS = "OpenBSD";
            } elseif (stripos($ua, "Windows") !== false) {
                $this->OS = "MS Windows";
            } elseif (stripos($ua, "Linux") !== false) {
                $this->OS = "GNU/Linux";
            } else {
                $this->OS = "Unknown";
            }
        }
        
        return $this->OS;
    }
    public function getLanguage() {
        if (empty($this->language)) {
            $accept_languages = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
            $this->language = explode(
                ";",
                explode(
                    ",",
                    $accept_languages
                )[0]
            )[0];
            // Fix to look right (de_DE, not de-DE)
            $this->language = str_replace(
                "-",
                "_",
                $this->language
            );
        }
        
        return $this->language;
    }
    public function __construct() {
    }
}

?>
