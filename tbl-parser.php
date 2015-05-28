<html>
<head>
	<title>TBL File Parser</title>
</head>
<body>
<div id="container">
<?php
include "include/CsvToArray.Class.php";

if (isset($_GET['parse'])) {
$filename = $_FILES['userfile']['name'];
list($file, $ext) = explode('.', $filename);
if($ext != "tbl") { echo "<h2>O arquivo {$filename} é inválido, somente arquivos \".tbl\" são permitidos!</h2><br /><a href=\"tbl-parser.php\"><< Voltar</a><br />"; die(); }
$uploaddir = 'upload/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile); 
$query = "";
foreach(CsvToArray::open($uploadfile, "\t") as $row)
{
	$str = mb_substr($row[1], 0, strlen($row[1]),"EUC-KR");
	$query .= "UPDATE `iteminfo` SET `Name` = '{$str}' WHERE `String_Item_Name` = '{$row[0]}';<br />\n";
}
echo "{$query}";
//echo "Query:<br /><textarea cols='150' rows='20'>{$query}</textarea><br /><br />";
echo "Feito!<br /><a href=\"tbl-parser.php\"><< Voltar</a><br />";
} else {
?>
<form enctype="multipart/form-data" id="file" method="POST" action="tbl-parser.php?parse">
<input type="file" id="userfile" name="userfile" />
<input type="submit" value="Enviar" />
</form>
<?php
}
?>
</div>
</body>
<?php
function parse_word($word, $pos)
{
	return (ord($word{$pos+1}) << 8) | ord($word{$pos});
}

function parse_dword($dword, $pos)
{
	return (ord($dword{$pos+3}) << 24) | (ord($dword{$pos+2}) << 16) | (ord($dword{$pos+1}) << 8) | ord($dword{$pos});
}

function parse_string($string, $pos, $len)
{
	$str = mb_substr($string, $pos, $len);
	$find =  array("\\", "\x00");
	$replace = array("\\\\", "");
	$str = str_replace($find, $replace, $str);
	return $str;
}
?>