<?php

$pw = "";
if ($pw && ($_GET["pw"] ?? null) != $pw) {
    http_response_code(404);
    exit;
}

phpinfo();
