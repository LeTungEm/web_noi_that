<?php
function loadClass($c)
{
	include ROOT . "/classes/" . $c . ".class.php";
}

function getIndex($index, $value = '')
{
	$data = isset($_GET[$index]) ? $_GET[$index] : $value;
	return $data;
}

function postIndex($index, $value = '')
{
	$data = isset($_POST[$index]) ? $_POST[$index] : $value;
	return $data;
}

function requestIndex($index, $value = '')
{
	$data = isset($_REQUEST[$index]) ? $_REQUEST[$index] : $value;
	return $data;
}

function getCookie($index, $value = '')
{
	$data = isset($_COOKIE[$index]) ? $_COOKIE[$index] : $value;
	return $data;
}

function getSession($index, $value = '')
{
	$data = isset($_SESSION[$index]) ? $_SESSION[$index] : $value;
	return $data;
}
function validate($sdt, $mk, $ckmk, $ten)
{
	$flag = false;
	$errString = "";
	if ($sdt == "" || $mk == "" || $ckmk == "" || $ten == "") {
		//Kiểm tra null
		$errString = "Hãy nhập đủ thông tin!";
		$flag = true;
	} else {
		if (strlen($sdt) != 10) {
			$errString = "Nhập sai số điện thoại!";
			$flag = true;
		} else if (strlen($mk) < 8) {
			$errString = "Mật khẩu có ít nhất 8 ký tự!";
			$flag = true;
		}
	}
	if ($flag) {
		setcookie("err", $errString, time() + 1, "/");
		setcookie("ten", $ten, time() + 1, "/");
		setcookie("sdt", $sdt, time() + 1, "/");
		header("location:index.php?action=login&mod=register");
		exit;
	}
}
?>