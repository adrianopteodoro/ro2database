<?php
include "./include/config.inc.php";

if(isset($_GET['get']))
{
	switch($_GET['get'])
	{
		case 'item':
			jsonItemData($_GET['classe'], $_GET['start'], $_GET['count']);
		break;
	}
}
else
{
	die();
}

function jsonItemData($classe = null, $start = 0, $count = 10)
{
	if($classe != null) $add = "WHERE `Require_Job`='{$classe}'";
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
				
function getImage($filename)
{
	if ($filename != null)
	{
		$filename = substr($filename, 2, strlen($filename));
		$file = strtok($filename, '.');
		return file_exists(strtolower("images/{$file}.png")) ? strtolower("images/{$file}.png") : "images/ui/icon/noicon.png";
	}
	else
	{
		return "images/ui/icon/noicon.png";
	}
}
?>