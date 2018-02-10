<?php
/**
 * Index
 * 
 * PHP version 5
 *
 * @category Index
 * @package  RO2Database
 * @author   Adriano Teodoro <adrianopteodoro@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/adrianopteodoro/ro2database
 */

require "./include/main.inc.php";
require_once './vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment(
    $loader,
    array(
        'cache' => '/path/to/compilation_cache',
    )
);
$template = $twig->load('index.html');
echo $template->render(array('js' => javaLibs()));
?>