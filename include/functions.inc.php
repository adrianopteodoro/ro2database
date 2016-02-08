<?php
include "./include/config.inc.php";
include "./include/queries.inc.php";

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

function jsonItemData($opt = null, $start = 0, $count = 5) {
    global $qItemData, $qItemDataCount;
    $add = "";
    $data = [];

    $addcount = 1;
    if ($opt != null) {
        if($opt['classe'] != 0 || $opt['category'] != 0) {
            $add .=" WHERE ";
        }
        foreach ($opt as $o) {
            if (isset($opt['classe']) && ($opt['classe'] == $o) && $o != 0) {
                if($addcount > 1) {
                    $add .= "AND ";
                }
                $add .= "i.`Require_Job` = '{$o}' ";
                $addcount++;
            }
            if (isset($opt['category']) && ($opt['category'] == $o) && $o != 0) {
                if($addcount > 1) {
                    $add .= "AND ";
                }
                $add .= "c.`Index` = '{$o}' ";
                $addcount++;
            }
        }
    }

    $query = "{$qItemDataCount} {$add};";
    $total = queryDB($query);
    $data['total'] = $total;

    $query = "{$qItemData} {$add} ORDER BY i.`ID` LIMIT {$start}, {$count};";
    $data['data'] = queryDB($query);

    if ($data['data'] != null && $data['total'] != null) {
        for ($i = 0; $i < $count; $i++) {
            $data['data'][$i]['Icon'] = getImage($data['data'][$i]['Icon']);
        }
        header('Content-type: application/json; charset=utf8');
        //print_r($data);
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