<?php

$server = $_SERVER;
ksort($server);
echo json_encode($server, JSON_PRETTY_PRINT);

