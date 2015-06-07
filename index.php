<?php
header('Content-type: text/html; charset=utf8');
include "./include/config.inc.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ragnarok 2 Database</title>
        <meta http-equiv="Content-type" content="text/html; charset=euc-kr" />
        <link rel="stylesheet" type="text/css" href="styles/main.css" />
        <?php include './include/javalibs.inc.php'; ?>
        <script type="text/javascript" src="js/functions.js"></script>
    </head>
    <body onload="getItems(null, 0, 10);">
        <div id="wrapper">
            <div id="container">
                <div id="nav">
                    <ul>
                        <li><a href="javascript:void(0);" onClick="getItems(null, 0, 10);">Items List</a></li>
                        <li><a href="javascript:void(0);">Skills List</a></li>
                        <li><a href="javascript:void(0);">Quest List</a></li>
                    </ul>
                </div>
                <div id="content"></div>
                <div id="footer">
                    Desenvolvido por Adriano Teodoro
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        <br style="clear: both;" />
    </body>
</html>