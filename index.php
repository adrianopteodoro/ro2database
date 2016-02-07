<?php
include "./include/main.inc.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ragnarok 2 Database</title>
        <meta http-equiv="Content-type" content="text/html; charset=euc-kr" />
        <link rel="stylesheet" type="text/css" href="styles/main.css" />
<?php javaLibs(); ?>
        <script type="text/javascript" src="js/functions.js"></script>
    </head>
    <body> <!-- onload="window.getItems(0, 0, 20);" -->
        <div id="wrapper">
            <div id="container">
                <div id="nav">
                    <ul>
						<li><a href="./">Home<a></li>
                        <li><a href="javascript:void(0);" onClick="window.getItems(0, 0, 5);">Items List</a></li>
                        <li><a href="javascript:void(0);">Skills List</a></li>
                        <li><a href="javascript:void(0);">Quest List</a></li>
                    </ul>
                </div>
                <div id="content">
					<ul id="itemlist"><li id="item-0"><center><b>Selecione uma das opções acima</b></center></li></ul>
				</div>
                <div id="footer">
                    Desenvolvido por Adriano Teodoro
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        <br style="clear: both;" />
    </body>
</html>