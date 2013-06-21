<?php
header("Content-Type: text/html; charset=utf-8");
$hostname = $_SERVER["HTTP_HOST"];
$parking_url = "http://www.sedoparking.com/search/registrar.php?registrar=blacknightregpark&domain=" . rawurlencode($hostname);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html lang="en">
        <head>
                <title><?php ee($hostname) ?> is currently registered.</title>
        </head>
        <frameset rows="45, *">
                <frame src="http://www.blacknight.ie/holding_page.php" scrolling="no" noresize="noresize" frameborder="0">
                <frame src="<?php ee($parking_url) ?>" frameborder="0">
                <noframes>
                        <body>
                                <p>This site uses frames. If your browser does not support frames then click below to visit our website:<br>
                                <a href="<?php ee($parking_url) ?>"><?php ee($hostname) ?></a></p>
                        </body>
                </noframes>
        </frameset>
</html>
<?php
function ee() {
        $args = func_get_args();
        echo htmlspecialchars(implode('', $args), ENT_QUOTES, 'UTF-8');
}

function trim_domain($domain) {
        if (substr($domain, 0, 4) === 'www.') {
                return substr($domain, 4);
        }
        return $domain;
}

