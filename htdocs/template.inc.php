<?php
// Check that this file is not accessed directly
if (!@isset($Data)) {
    die('<h3 style="color:red;text-align:center;margin-top:6em;">This file should <u>never</u> be accessed direct.</h3>');
}

?><!DOCTYPE html>
<html lang="<?=$Data["Meta"]["Lang"]?>">
    <head>
        <meta charset="<?=$Data["Meta"]["Charset"]?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?=$Data["Meta"]["Title"]?></title>
        
        <meta name="author" content="<?=$Data["Meta"]["Author"]?>">
        
        <link rel="stylesheet" type="text/css" href="<?=$Data["Meta"]["Stylesheet"]?>">
<?php if ($Data["Meta"]["HumansTXT"]): ?>
        <link rel="author" type="text/plain" href="/humans.txt">
<?php endif; ?>
    </head>
    <body id="top">
        <header>
            <h1>
                <a href="<?=$Data["Content"]["Header"]["LinkURL"]?>"><?=$Data["Content"]["Header"]["Title"]?></a>
            </h1>
        </header>
        
        <main>
<?=$Data["Content"]["Content"]["Main"]?>
        </main>
        
        <footer>
<?php
foreach ($Data["Content"]["Footer"] as $p) {
    print "\t\t\t<p>\n\t\t\t\t" . $p . "\n\t\t\t</p>\n";
}
?>
        </footer>
    </body>
</html>
