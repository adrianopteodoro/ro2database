<?php
include "./include/main.inc.php";

if (isset($_GET['get'])) {
    switch ($_GET['get']) {
        case 'item':
            $classe = 0;
            $start = 0;
            $count = 10;
            if (isset($_GET['classe'])) {
                $classe = $_GET['classe'];
            }
            if (isset($_GET['start'])) {
                $start = $_GET['start'];
            }
            if (isset($_GET['count'])) {
                $count = $_GET['count'];
            }
            jsonItemData($classe, $start, $count);
            break;
        case 'itemcount':
            $classe = 0;
            if (isset($_GET['classe'])) {
                $classe = $_GET['classe'];
            }
            jsonItemCount($classe);
            break;
    }
} else {
    die();
}
?>