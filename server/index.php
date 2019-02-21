<?php

$files = array_diff(scandir("vars"), [".", ".."]);
sort($files);

$vars  = [];
$props = [];

foreach ($files as $file) {
    $contents = file_get_contents("vars/" . $file);
    $contents = json_decode($contents, true);
    ksort($contents);
    $vars[$file] = $contents;
    $props = array_merge($props, array_keys($contents));
}

$props = array_unique($props);

?>

<title>$_SERVER</title>

<style>
    table {
        border-collapse: collapse;
        table-layout: fixed;
        font-family: sans-serif;
        font-size: 14px;
        max-width: 100%;
        word-break: break-word;
    }
    table thead th {
        background-color: rgba(0,0,0,0.1);
        padding: 4px 5px;
        border: 1px solid hsl(0, 0%, 80%);
    }
    table td {
        padding: 4px 5px;
        border: 1px solid hsl(0, 0%, 80%);
        max-width: 450px;
    }
    table tbody tr:hover {
        background-color: rgba(0,0,0,0.1);
    }
    .exists {
        background-color: hsla(75, 100%, 50%, .2);
    }
    .common td {
        background-color: hsla(120, 100%, 50%, .2);
    }
</style>


<table>
    <thead>
        <tr>
            <th>$_SERVER</th>
<?php

foreach ($files as $file) {
    echo "<th>{$file}</th>";
}

?>
        </tr>
    </thead>
<?php

include "element.php";

foreach ($props as $prop) {
    $row = elem("tr");
    $row->append( elem("td", null, $prop) );
    $common = [];
    foreach ($files as $file) {
        $cell = elem("td");
        if (isset($vars[$file][$prop])) {
            $cell->append($vars[$file][$prop]);
            $cell->attr("class", "exists");
            $common[] = true;
        }
        $row->append($cell);
    }
    if (count($common) == 4) {
        $row->attr("class", "common");
    }
    $row->output();
}

?>
</table>
