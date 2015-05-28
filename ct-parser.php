<?php
	header('Content-type: text/html; charset=euc-kr');
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<html>
<head>
	<title>CT File Parser</title>
	<meta http-equiv="Content-type" value="text/html; charset=euc-kr" />
</head>
<body>
<div id="container">
<?php
if (isset($_GET['parse'])) {
$start = 64;

$filename = $_FILES['userfile']['name'];
list($file, $ext) = explode('.', $filename);
if($ext != "ct") { echo "<h2>O arquivo {$filename} é inválido, somente arquivos \".ct\" são permitidos!</h2><br /><a href=\"ct-parser.php\"><< Voltar</a><br />"; die(); }
$uploaddir = 'upload/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile); 
$fio = fopen($uploadfile, "rb");
$skillsdata = array();

echo "<h2>Arquivo: {$filename}</h2><br /><br />";

if ($fio)
{
	$data = fread($fio, filesize ($uploadfile));
	$cols = parse_int32($data, $start);
	$skillsdata['total_colunas'] = $cols;
	$lastlen = $start + 4;
	for($i = 0;$i < $cols;$i++)
	{
		$slen = (parse_int32($data, $lastlen) * 2);
		$lastlen += 4;
		$string = parse_string($data, $lastlen, $slen);
		$lastlen += $slen;
		$skillsdata['colunas'][$i]['nome'] = $string;
	}
	$lastlen += 4;
	for($i = 0;$i < $cols;$i++)
	{
		$tipo = parse_int32($data, $lastlen);
		$lastlen += 4;
		$skillsdata['colunas'][$i]['tipo'] = $tipo;
	}
	$linhas = parse_int32($data, $lastlen);
	$lastlen += 4;
	$skillsdata['total_linhas'] = $linhas;
	for($l = 0;$l < $linhas;$l++)
	{
		for($i = 0;$i < $cols;$i++)
		{
			switch($skillsdata['colunas'][$i]['tipo'])
			{
				case 1:
					$skillsdata['linhas'][$l][$i] = parse_int($data, $lastlen);
					$lastlen++;
				break;
				case 2:
					$skillsdata['linhas'][$l][$i] = parse_int($data, $lastlen);
					$lastlen++;
				break;
				case 3:
					$skillsdata['linhas'][$l][$i] = parse_int16($data, $lastlen);
					$lastlen += 2;
				break;
				case 4:
					$skillsdata['linhas'][$l][$i] = parse_int16($data, $lastlen);
					$lastlen += 2;
				break;
				case 5:
					$skillsdata['linhas'][$l][$i] = parse_int32($data, $lastlen);
					$lastlen += 4;
				break;
				case 6:
					$skillsdata['linhas'][$l][$i] = parse_int32($data, $lastlen);
					$lastlen += 4;
				break;
				case 7:
					$skillsdata['linhas'][$l][$i] = parse_hexcolor($data, $lastlen);
					$lastlen += 4;
				break;
				case 8:
					$slen = (parse_int32($data, $lastlen) * 2);
					$lastlen += 4;
					$skillsdata['linhas'][$l][$i] = parse_string($data, $lastlen, $slen);
					$lastlen += $slen;
				break;
				case 9:
					$skillsdata['linhas'][$l][$i] = parse_int32($data, $lastlen);
					$lastlen += 4;
				break;
				case 11:
					$skillsdata['linhas'][$l][$i] = parse_int64($data, $lastlen);
					$lastlen += 8;
				break;
				case 12:
					$skillsdata['linhas'][$l][$i] = parse_int($data, $lastlen);
					$lastlen += 1;
				break;
			}
		}
	}
	fclose($fio);
	unlink($uploadfile);
}

$table =  strtok($filename, ".");
$query = "DROP TABLE IF EXISTS `{$table}`;\n";
$query .= "CREATE TABLE `{$table}` (\n";
for($i = 0; $i < $skillsdata['total_colunas']; $i++)
{
	switch($skillsdata['colunas'][$i]['tipo'])
	{
		case 1:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` INT NOT NULL DEFAULT '0'";
		break;
		case 2:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` INT NOT NULL DEFAULT '0'";
		break;
		case 3:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` INT NOT NULL DEFAULT '0'";
		break;
		case 4:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` INT NOT NULL DEFAULT '0'";
		break;
		case 5:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` BIGINT NOT NULL DEFAULT '0'";
		break;
		case 6:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` BIGINT NOT NULL DEFAULT '0'";
		break;
		case 7:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` VARCHAR(6) NOT NULL DEFAULT ''";
		break;
		case 8:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` VARCHAR(255) NOT NULL DEFAULT ''";
		break;
		case 9:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` BIGINT NOT NULL DEFAULT '0'";
		break;
		case 11:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` BIGINT NOT NULL DEFAULT '0'";
		break;
		case 12:
			$query .= "\t`{$skillsdata['colunas'][$i]['nome']}` INT NOT NULL DEFAULT '0'";
		break;
	}
	if($i != ($skillsdata['total_colunas'] - 1)) $query .= ",\n";
}
$query .= "\n);\n";

for($a = 0; $a < $skillsdata['total_linhas']; $a++)
{
	$insert = "INSERT INTO `{$table}` VALUES (";
	for($i = 0; $i < $skillsdata['total_colunas']; $i++)
	{
		$insert .= "\"{$skillsdata['linhas'][$a][$i]}\"";
		if($i != ($skillsdata['total_colunas'] - 1)) $insert .= ",";
	}
	$insert .= ");\n";
	$query .= $insert;
}
echo "Query:<br /><textarea cols='150' rows='20'>{$query}</textarea><br /><br />";
echo "Feito!<br /><a href=\"ct-parser.php\"><< Voltar</a><br />";
} else {
?>
<form enctype="multipart/form-data" id="file" method="POST" action="ct-parser.php?parse">
<input type="file" id="userfile" name="userfile" />
<input type="submit" value="Enviar" />
</form>
<?php
}
?>
</div>
</body>
<?php
function parse_int($in, $pos)
{
	return sprintf("%u", ord($in{$pos}));
}

function parse_int16($in, $pos)
{
	return sprintf("%u", (ord($in{$pos+1}) << 8) | ord($in{$pos}));
}

function parse_int32($in, $pos)
{
	return sprintf("%u", (ord($in{$pos+3}) << 24) | (ord($in{$pos+2}) << 16) | (ord($in{$pos+1}) << 8) | ord($in{$pos}));
}

function parse_int64($in, $pos)
{
	return sprintf("%u", (ord($in{$pos+7}) << 56) | (ord($in{$pos+6}) << 48) | (ord($in{$pos+5}) << 40) | (ord($in{$pos+4}) << 32) | (ord($in{$pos+3}) << 24) | (ord($in{$pos+2}) << 16) | (ord($in{$pos+1}) << 8) | ord($in{$pos}));
}

function parse_hexcolor($in, $pos)
{
	return dechex(parse_int32($in, $pos));
}

function parse_string($in, $pos, $len)
{
	$str = "";
	$a = $pos;
	for($i = 0; $i < ($len / 2); $i++) 
	{
		$str .= sprintf('&#%u;', intval((ord($in{$a+1}) << 8) | ord($in{$a})));
		$a += 2;
	}
	$str = mb_convert_encoding($str, 'EUC-KR', 'HTML-ENTITIES');
	$str = str_replace("\\", "\\\\", $str);
	return $str;
}
?>