<?php
/**
 * JSON API
 * 
 * PHP version 5
 *
 * @category JSON_API
 * @package  RO2Database
 * @author   Adriano Teodoro <adrianopteodoro@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/adrianopteodoro/ro2database
 */

require "./include/main.inc.php";

if (isset($_GET['get'])) {
    switch ($_GET['get']) {
    case 'item':
        $opt = null;
        $start = 0;
        $count = 5;
        $data = [];
        if (isset($_GET['data'])) {
            $data = json_decode($_GET['data']);
        }
        foreach ($data as $d) {
            if (isset($d->{'classe'})) {
                $opt['classe'] = $d->{'classe'};
            }
            if (isset($d->{'category'})) {
                $opt['category'] = $d->{'category'};
            }
            if (isset($d->{'start'})) {
                $start = $d->{'start'};
            }
            if (isset($d->{'count'})) {
                $count = $d->{'count'};
            }
        }
        jsonItemData($opt, $start, $count);
        break;
    }
} else {
    die();
}
