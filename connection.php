<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$l = "localhost";
$u = "root";
$pa = "root";
$db = "railway";

$con = mysqli_connect($l, $u, $pa, $db);

if (!$con) {
    die("Under Construction" . mysqli_connect_error());
}
?>
