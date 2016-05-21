<?php

require_once("base.inc.php");
require_once("clientinfo.class.php");

$info = new ClientInfo();

$hostTitle = "IP Address";
$hostContent =$info->getIP();
if ($info->getHostname() != $info->getIP()) {
	$hostTitle .= " / Hostname";
	$hostContent .= " / " . $info->getHostname();
}
ob_start();
?>
<h3><?=$hostTitle?></h3>
<p>
	<?=$hostContent?>
</p>
<h3>Browser</h3>
<p>
	<?=$info->getBrowser()?>
</p>
<h3>Operating System</h3>
<p>
	<?=$info->getOS()?> (Language: <?=$info->getLanguage()?>)
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
		"Lang" => "en",
		"Charset" => "UTF-8",
		"Title" => "IP Info",
		"Author" => "Malte Bublitz",
		"HumansTXT" => false,
		"Stylesheet" => "assets/css/style.css"
	),
	"Content" => Array(
		"Header" => Array(
			"LinkURL" => "./",
			"Title" => "IP Info"
		),
		"Content" => $contentData,
		"Footer" => $footerData
	)
);

require_once("template.inc.php");
?>
