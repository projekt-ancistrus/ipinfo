<?php

require_once("base.inc.php");
require_once("clientinfo.class.php");

$info = new ClientInfo();

$hostContent =$info->getIP();
if ($info->getHostname() != $info->getIP()) {
	$hostContent .= " / " . $info->getHostname();
}
$lang = substr(
	$info->getLanguage(),
	0,
	2
);
function getMsg($lang, $id) {
	$Translations = Array(
		"de" => Array(
			"Title"   => "Deine IP",
			"IP"      => "IP-Adresse",
			"Browser" => "Browser",
			"OS"      => "Betriebssystem",
			"Lang"    => "Sprache",
			"UA"      => "User-Agent"
		),
		"en" => Array(
			"Title"   => "Your IP",
			"IP"      => "IP Address",
			"Browser" => "Browser",
			"OS"      => "Operating System",
			"Lang"    => "Language",
			"UA"      => "User Agent"
		)
	);
	
	return $Translations[$lang][$id];
}
ob_start();
?>
<h3><?=getMsg($lang, "IP")?></h3>
<p>
	<?=$hostContent?>
</p>
<h3><?=getMsg($lang, "Browser")?></h3>
<p>
	<?=$info->getBrowser()?>
</p>
<h3><?=getMsg($lang, "OS")?></h3>
<p>
	<?=$info->getOS()?> (<?=getMsg($lang, "Lang")?>: <?=$info->getLanguage()?>)
</p>
<h3><?=getMsg($lang, "UA")?></h3>
<p>
	<?=$info->getUserAgent()?>
</p>
<?php

$contentData = Array(
	"Main" => ob_get_clean()
);
$footerData = Array(
	"© " . $AppInfo["Copyright"]["Year"] . ' <a href="' . $AppInfo["Copyright"]["AuthorLink"] . '" rel="me nofollow">' . $AppInfo["Copyright"]["AuthorName"] . '</a>',
	'Powered by <a href="' . $AppInfo["URL"] . '">' . $AppInfo["Name"] . '</a>'
);

$Data = Array(
	"Meta" => Array(
		"Lang"       => $lang,
		"Charset"    => "UTF-8",
		"Title"      => getMsg($lang, "Title"),
		"Author"     => "Malte Bublitz",
		"HumansTXT"  => false,
		"Stylesheet" => "assets/css/style.css"
	),
	"Content" => Array(
		"Header" => Array(
			"LinkURL" => "./",
			"Title"   => getMsg($lang, "Title")
		),
		"Content" => $contentData,
		"Footer" => $footerData
	)
);

require_once("template.inc.php");
?>
