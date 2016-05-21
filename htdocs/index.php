<?php

require_once("base.inc.php");
require_once("clientinfo.class.php");

$info = new ClientInfo();

$c = "<section class=\"text-center\">\n";
$c .= " \t<h2>" . $info->getIP() . "</h2>\n";
$c .= "\t<p>\n\t\t";
$c .= '<a href="info.php">Details</a>';
$c .= " \n\t</p>\n</section>\n";

$contentData = Array(
    "Main" => $c
);
$footerData = Array(
    "© " . $AppInfo["Copyright"]["Year"] . ' <a href="' . $AppInfo["Copyright"]["AuthorLink"] . '" rel="me nofollow">' . $AppInfo["Copyright"]["AuthorName"] . '</a>',
    'Powered by <a href="' . $AppInfo["URL"] . '">' . $AppInfo["Name"] . '</a>'
);

if (substr($info->getLanguage(), 0, 2) == "de") {
    $msg_your_ip = "Deine IP–Adresse";
} else {
    $msg_your_ip = "Your IP";
}
$Data = Array(
    "Meta" => Array(
        "Lang" => "en",
        "Charset" => "UTF-8",
        "Title" => $msg_your_ip . " :: " . $AppInfo["Name"],
        "Author" => "Malte Bublitz",
        "HumansTXT" => false,
        "Stylesheet" => "assets/css/style.css"
    ),
    "Content" => Array(
        "Header" => Array(
            "LinkURL" => "./",
            "Title" => $msg_your_ip
        ),
        "Content" => $contentData,
        "Footer" => $footerData
    )
);

require_once("template.inc.php");
?>
