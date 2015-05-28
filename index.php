<?php
header('Content-type: text/html; charset=utf8');
include "./include/config.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Template</title>
	<meta http-equiv="Content-type" value="text/html; charset=euc-kr" />
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
</head>
<body>
	<div id="header">
	</div>
	<div id="navbar">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Fóruns</a></li>
			<li><a href="#">Informações</a></li>
			<li><a href="#">Database</a></li>
			<li><a href="#">Raidcall</a></li>
			<li><a href="#">Contato</a></li>
		</ul>
	</div>
	<div id="border">
		<div id="wrapper">
			<div id="container">
				<div id="content">
				</div>
				<div id="sidebar">
					<div id="menu">
						<ul>
							<li><a href="javascript:void(0);" onClick="getItems(null, 0, 80);">Ver Todos Itens</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(97, 0, 80);">Itens Espadachin</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(32, 0, 80);"> - Itens Guerreiro</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(64, 0, 80);"> - Itens Cavaleiro</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(386, 0, 80);">Itens Mago</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(128, 0, 80);"> - Itens Bruxo</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(256, 0, 80);"> - Itens Feiticeiro</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(1540, 0, 80);">Itens Arqueiro</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(512, 0, 80);"> - Itens Ranger</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(1024, 0, 80);"> - Itens Beastmaster</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(6152, 0, 80);">Itens Gatuno</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(2048, 0, 80);"> - Itens Mercenario</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(4096, 0, 80);"> - Itens Arruaceiro</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(24592, 0, 80);">Itens Noviço</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(8192, 0, 80);"> - Itens Sacerdote</a></li>
							<li><a href="javascript:void(0);" onClick="getItems(16384, 0, 80);"> - Itens Monge</a></li>
						</ul>
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</div>
	<br style="clear: both;" />
</body>
</html>