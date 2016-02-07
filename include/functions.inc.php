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

    if ($data != null) {
        header('Content-type: application/json; charset=utf8');
        echo json_encode($data);
    }
}

function jsonItemData($classe = 0, $start = 0, $count = 10) {
    $add = "";
    $data = [];

    if ($classe != 0) {
        $add = "AND `Require_Job`='{$classe}'";
    }

    $query = "SELECT COUNT(*) AS `total` FROM `iteminfo`,`itemnames` n WHERE n.`CDITEM` = `String_Item_Name` {$add};";
    $total = queryDB($query);
    $data['total'] = $total;

    $query = "SELECT `ID`,
	n.`NAME` AS `Name`,
	`NationEnable`,
	`Item_Type`,
	`Item_Type_Option`,
	`Item_Category`,
	`Grade`,
	`Grinding_Trait_Able`,
	`Abili_val`,
	`Price_Buy`,
	`Price_Sell`,
	`Stack_Max`,
	`Item_Lv`,
	`Require_Level`,
	`ItemValueLv`,
	`Min_MasteryGrade`,
	`Min_MasteryLevel`,
	`Require_Sex`,
	`Require_Job`,
	`Equip_Type`,
	`Equip_Slot`,
	`Equip_Slot_Overlap`,
	`Weapon_Type`,
	`Armor_Type`,
	`Bag_Size`,
	`Bind_Type`,
	`Durability`,
	`Possession_Max`,
	`RandomSet_ID`,
	`Socket_GroupID`,
	`Effect_ID_1`,
	`Skill_ID_1`,
	`Theme_ID`,
	`Is_Drop`,
	`Is_Deposit`,
	`Is_Destruct`,
	`Is_Sell`,
	`Is_Trade`,
	`Is_Compose`,
	`High_Category`,
	`Medium_Category`,
	`Low_Category`,
	`Ignore_Search`,
	`Including_Button`,
	`Costume_Animation`,
	`FxGroupID`,
	`Default_Color`,
	`Color_Variation`,
	`CollisionType_ID`,
	`Icon`,
	`UpdateCode`
	FROM
	`iteminfo`,
	`itemnames` n
	WHERE n.`CDITEM` = `String_Item_Name` {$add}
	ORDER BY `ID`
	LIMIT {$start}, {$count};";
    $data['data'] = queryDB($query);

    if ($data != null) {
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