<?php

$pw = "";
if ($pw && ($_GET["pw"] ?? null) != $pw) {
    http_response_code(404);
    exit;
}

$user = [
    "exec"              => trim( exec("whoami")         ),
    "shell_exec"        => trim( shell_exec("whoami")   ),
    "get_current_user"  => trim( get_current_user()     ),
];

echo "<pre>";
print_r($user);

