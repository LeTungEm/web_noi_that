<?php
function loadClass($c)
{
	include ROOT."/classes/".$c.".class.php";
}

function getIndex($index, $value='')
{
	$data = isset($_GET[$index])? $_GET[$index]:$value;
	return $data;
}

function postIndex($index, $value='')
{
	$data = isset($_POST[$index])? $_POST[$index]:$value;
	return $data;
}

function requestIndex($index, $value='')
{
	$data = isset($_REQUEST[$index])? $_REQUEST[$index]:$value;
	return $data;
}

function getCookie($index, $value=''){
	$data = isset($_COOKIE[$index])? $_COOKIE[$index]:$value;
	return $data;
}

function getSession($index, $value=''){
	$data = isset($_SESSION[$index])? $_SESSION[$index]:$value;
	return $data;
}
?>
