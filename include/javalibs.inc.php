<?php

/*
  JavaScript Libs List
 */
$libs = [
    "jQuery" => "jquery-2.1.4.min.js",
    "AngularJS" => "angular.min.js"
];

foreach ($libs as $lib) {
    echo "<script type=\"text/javascript\" src=\"js/libs/$lib\"></script>";
}
?>