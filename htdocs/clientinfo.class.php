<?php
/**
 * clientinfo.class.php
 *     ClientInfo class, responsible for detecting
 *     all the information
 *
 * Copyright (c) 2016 Malte Bublitz, https://malte70.github.io/
 * All rights reserved.
 */

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
				$this->browser = "Mozilla Firefox";
				$pos_version_start = stripos(
					$ua,
					"Firefox/"
				) + strlen("Firefox/");
				
				$version = substr($ua, $pos_version_start);
				
				$this->browser .= " " . $version;
				
			} elseif (stripos($ua, "MSIE") !== false) {
				$this->browser = "Microsoft Internet Explorer";
				$pos_version_start = stripos(
					$ua,
					"MSIE"
				) + strlen("MSIE ");
				$pos_version_end = stripos(
					$ua,
					";",
					$pos_version_start
				);
				
				$version = substr(
					$ua,
					$pos_version_start,
					$pos_version_end - $pos_version_start
				);
				
				$this->browser .= " " . $version;
				
			} elseif (stripos($ua, "OPR") !== false) {
				$this->browser = "Opera";
				$pos_version_start = stripos(
					$ua,
					"OPR/"
				) + strlen("OPR/");
				$version = explode(
					".",
					substr(
						$ua,
						$pos_version_start
					)
				);
				
				$this->browser .= " " . $version[0] . "." . $version[1];
				
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
				
			} else if (stripos($ua, "Safari") !== false) {
				$this->browser = "Apple Safari";
				$pos_version_start = stripos(
					$ua,
					"Version/"
				) + strlen("Version/");
				$pos_version_end = stripos(
					$ua,
					" ",
					$pos_version_start
				);
				
				$version = substr(
					$ua,
					$pos_version_start,
					$pos_version_end - $pos_version_start
				);
				
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
				
				if (stripos($ua, "Windows NT 10.0") !== false || stripos($ua, "Windows 10") !== false) {
					$this->OS .= " 10";
				} else if (stripos($ua, "Windows NT 6.3") !== false || stripos($ua, "Windows 8.1") !== false) {
					$this->OS .= " 8.1";
				} else if (stripos($ua, "Windows NT 6.2") !== false || stripos($ua, "Windows 8") !== false) {
					$this->OS .= " 8";
				} else if (stripos($ua, "Windows NT 6.1") !== false || stripos($ua, "Windows 7") !== false) {
					$this->OS .= " 7";
				} else if (stripos($ua, "Windows NT 6.0") !== false || stripos($ua, "Windows Vista") !== false) {
					$this->OS .= " Vista";
				} else if (stripos($ua, "Windows NT 5.1") !== false || stripos($ua, "Windows XP") !== false) {
					$this->OS .= " XP";
				}
				
			} elseif (stripos($ua, "Linux") !== false) {
				$this->OS = "GNU/Linux";
				
			} elseif (stripos($ua, "Macintosh") !== false) {
				$this->OS = "Apple OS X";
				
				$pos_version_start = stripos(
					$ua,
					"OS X"
				) + strlen("OS X ");
				$pos_version_bracket = stripos(
					$ua,
					")",
					$pos_version_start
				);
				$pos_version_semicolon = stripos(
					$ua,
					";",
					$pos_version_start
				);
				if ($pos_version_bracket > 1 && $pos_version_semicolon > 1) {
					$pos_version_end = min(
						$pos_version_bracket,
						$pos_version_semicolon
					);
				} elseif ($pos_version_bracket > 1) {
					$pos_version_end = $pos_version_bracket;
				} else {
					$pos_version_end = $pos_version_semicolon;
				}
				$version = explode(
					"_",
					substr(
						$ua,
						$pos_version_start,
						$pos_version_end - $pos_version_start
					)
				);
				
				$this->OS .= " " . implode($version, ".");
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
