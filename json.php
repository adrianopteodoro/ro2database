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
	$noimage = "images/noicon.png";
	if ($filename != null)
	{
		$filename = substr($filename, 2, strlen($filename));
		$file = strtok($filename, '.');
		$outfile = "images/{$file}.png";
		$outfile = str_replace("\\", "/", $outfile);
		$outfile = str_replace("icon", "Icon", $outfile);
		return file_exists($outfile) ? $outfile : $noimage;
	}
	else
	{
		return $noimage;
	}
}
?>