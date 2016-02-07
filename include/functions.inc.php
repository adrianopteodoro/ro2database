<?php
include "./include/config.inc.php";

function queryDB($query) {
    global $config;
    $dbh = new PDO("mysql:host={$config['dbhost']};port={$config['dbport']};dbname={$config['database']}", $config['dbusername'], $config['dbpassword'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $stm = $dbh->prepare($query);
    $result = $stm->execute();
    if ($result != null) {
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($stm);
    unset($dbh);
    return $rows;
}

function javaLibs() {
	global $libs;
	foreach ($libs as $lib) {
		echo "\t<script type=\"text/javascript\" src=\"js/libs/$lib\"></script>\n";
	}
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
        $tmp = strtolower("images/{$file}.png");
        $outfile = str_replace("\\", "/", $tmp);
        return file_exists($outfile) ? $outfile : $noimage;
    } else {
        return $noimage;
    }
}
?>