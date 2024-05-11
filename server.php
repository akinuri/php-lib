<?php

$pw = "";
if ($pw && ($_GET["pw"] ?? null) != $pw) {
    http_response_code(404);
    exit;
}

$server = $_SERVER;
$server["SERVER_SIGNATURE"] = preg_replace("/<\/?address>/", "", $server["SERVER_SIGNATURE"]);
ksort($server);
$groups = [];
$misc = [];
foreach ($server as $key => $value) {
    if (str_contains($key, "_")) {
        $groupName = explode("_", $key)[0];
        $groups[$groupName][$key] = trim($value);
    } else {
        $misc[$key] = trim($value);
    }
}
$groups["MISC"] = $misc;
$server = $groups;
unset($groups, $misc);

if (array_key_exists("json", $_GET)) {
    echo json_encode($server, JSON_PRETTY_PRINT);
} else {
    echo "<pre>";
    print_r($server);
}
