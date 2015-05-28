<?php
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');

$config = array(
	'database' => 'u668280012_db',
	'dbusername' => 'u668280012_dbuse',
	'dbpassword' => ':UIj5xQ6Z$kjFC',
	'dbhost' => 'localhost',
	'dbport' => '3306'
);

function queryDB($query)
{
	global $config;
	$dbh = new PDO("mysql:host={$config['dbhost']};port={$config['dbport']};dbname={$config['database']}",  $config['dbusername'], $config['dbpassword'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$stm = $dbh->prepare($query);
    $result = $stm->execute();
	$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
	unset($stm); unset($dbh);
	return $rows;
}
?>