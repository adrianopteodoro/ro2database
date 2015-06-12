<?php

include "./include/config.inc.php";

if (isset($_GET['get'])) {
    switch ($_GET['get']) {
        case 'item':
            $classe = 0;
            $start = 0;
            $count = 10;
            if (isset($_GET['classe'])) {
                $classe = $_GET['classe'];
            }
            if (isset($_GET['start'])) {
                $start = $_GET['start'];
            }
            if (isset($_GET['count'])) {
                $count = $_GET['count'];
            }
            jsonItemData($classe, $start, $count);
            break;
        case 'itemcount':
            $classe = 0;
            if (isset($_GET['classe'])) {
                $classe = $_GET['classe'];
            }
            jsonItemCount($classe);
            break;
    }
} else {
    die();
}

function jsonItemCount($classe = 0) {
    $add = "";
    if ($classe != 0) {
        $add = "WHERE `Require_Job`='{$classe}'";
    }
    $query = "SELECT COUNT(*) AS `total` FROM `iteminfo` {$add};";
    $data = queryDB($query);
    if ($data != null) {
        header('Content-type: application/json; charset=utf8');
        echo json_encode($data);
    }
}

function jsonItemData($classe = 0, $start = 0, $count = 10) {
    $add = "";
    if ($classe != 0) {
        $add = "WHERE `Require_Job`='{$classe}'";
    }
    $query = "SELECT * FROM `iteminfo` {$add} ORDER BY `ID` LIMIT {$start}, {$count};";
    $data = queryDB($query);
    if ($data != null) {
        for ($i = 0; $i < $count; $i++) {
            $data[$i]['Icon'] = getImage($data[$i]['Icon']);
        }
        header('Content-type: application/json; charset=utf8');
        echo json_encode($data);
    }
}

function getImage($filename) {
    $noimage = "images/noicon.png";
    if ($filename != null) {
        $filename = substr($filename, 2, strlen($filename));
        $file = strtok($filename, '.');
        $outfile = "images/{$file}.png";
        $outfile = str_replace("\\", "/", $outfile);
        $outfile = str_replace("icon", "Icon", $outfile);
        return file_exists($outfile) ? $outfile : $noimage;
    } else {
        return $noimage;
    }
}

?>