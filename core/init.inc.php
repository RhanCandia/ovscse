<?php

error_reporting(E_ALL && ~E_NOTICE && ~E_WARNING);

session_start();

$exceptions	= array("index", "confirmcast", "addnominee_process");

$page		= substr(end(explode("/", $_SERVER['SCRIPT_NAME'])), 0, -4);

if (in_array($page, $exceptions) === false) {
	if (isset($_SESSION['studID']) === false) {
		header("Location: index.php");
		die();
	}
}

if ($_SESSION['userGroup'] === 'encoder' && $page !== 'reguser') {
	header('Location: reguser.php');
}

if (in_array($page, $exceptions) === false) {
	include('pane.php');
}

mysql_connect('localhost', 'root', '');
mysql_select_db('online_elections');


include('inc/ballots.inc.php');
include('inc/nominees.inc.php');
include('inc/positions.inc.php');
include('inc/users.inc.php');
include('inc/colleges.inc.php');

?>