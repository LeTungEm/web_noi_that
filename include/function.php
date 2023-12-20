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

<?php function printCourse($item)
{
	$course = new KhoaHoc();
	$purchasedCourse = new MuaKhoaHoc();
?>
<?php
		$flag = false;
		$moTa = isset($item["moTa"])? $item["moTa"]:"";
        $moTa = $course->formatDecsription($moTa);
		$hinh = isset($item["hinh"])?$item["hinh"]:"";
		$path = 'media/image/course/'.$hinh;
		if (file_exists($path) && is_file($path)) {
			$flag = true;
		} ?>
<div class="card border-black <?php if (!$flag) {
        echo 'bg-secondary';} ?> text-black">
    <?php
        if ($flag) {
    ?>
    <img style="width: 100%; height: 100%;" src="<?php echo $path; ?>" class="card-img border-0" alt="">
    <?php } ?>
    <div class="card-img-overlay">
        <h5 class="card-title"><?php echo isset($item["tenKhoaHoc"]) ? $item["tenKhoaHoc"] : ""; ?></h5>
        <p class="card-text"><?php echo $moTa; ?></p>
    </div>
    <div class="show_Button">
        <a href="./index.php?action=course_detail&id=<?php echo $item["maKhoaHoc"] ?>"
            class="btn bg-primary text-white m-auto">Xem khóa học</a>
    </div>
</div>
<h5 class="text-secondary mb-0"><?php echo $course->formatPrice($item["gia"]) . "đ" ?></h5>
<?php
	}

	//========================================================
    //login

    function validate($sdt, $mk, $ckmk, $ten){
        $flag = false;
        $errString = "";
        if($sdt == "" || $mk == "" || $ckmk == "" || $ten == ""){
            //Kiểm tra null
            $errString = "Hãy nhập đủ thông tin!";
            $flag = true;
        }else{
            if(strlen($sdt) != 10){
                $errString = "Nhập sai số điện thoại!";
                $flag = true;
            }else if(strlen($mk) < 8){
                $errString = "Mật khẩu có ít nhất 8 ký tự!";
                $flag = true;
            }
        }
        if($flag){
            setcookie("err", $errString, time() + 1, "/");
            setcookie("ten", $ten, time() + 1, "/");
            setcookie("sdt", $sdt, time() + 1, "/");
            header("location:index.php?action=login&mod=register");
            exit;
        }
    }

	
?>