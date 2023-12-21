<?php 
    if(isset($_GET["mod"])){
        $mod = $_GET["mod"];
        $db = new Db();
    
        $header = "Đăng nhập";
        $btnName = "btnSubmitLg";
        if($mod == "register"){
            $header = "Đăng ký";
            $btnName = "btnSubmitRG";
        }
        include("checkout.php");
?>
<style>
a {
    color: #007bff;
}

.container {
    width: 40%;
}

@media(max-width: 900px) {
    .container {
        width: 80%;
    }
}
</style>

<div class="d-flex mt-4 justify-content-center">
    <div class="border border-2 rounded p-3 container">
        <a href="./?action=home">
            <h1 class="fw-bold text-center text-primary border-bottom">TM_House</h1>
        </a>
        <h2 class="text-center py-2"><?php echo $header; ?></h2>
        <form method="post" action="?action=login&mod=login">
            <?php if($mod == "register"){ ?>
            <div class="form-group p-1">
                <label for="txtName">Tên</label>
                <input type="text" class="form-control" id="txtName" name="txtName"
                value="<?php echo getCookie("ten") ?>" placeholder="Nhập họ và tên">
            </div>
            <?php } ?>
            <div class="form-group p-1">
                <label for="txtPhone">Số điện thoại</label>
                <input type="number" class="form-control" id="txtPhone" name="txtPhone"
                    value="<?php echo getCookie("sdt") ?>" aria-describedby="numberHelp"
                    placeholder="Nhập số điện thoại">
            </div>
            <div class="form-group p-1">
                <label for="txtPassW">Mật khẩu</label>
                <input type="password" class="form-control" id="txtPassW" name="txtPassW" placeholder="Nhập mật khẩu">
            </div>
            <?php if($mod == "login"){?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="ckbRemember" name="ckbRemember" value="1">
                <label class="form-check-label" for="ckbRemember">Lưu đăng nhập</label>
            </div>
            <?php }else{ ?>
            <div class="form-group p-1">
                <label for="txtCKPassW">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="txtCKPassW" name="txtCKPassW"
                    placeholder="Nhập lại mật khẩu">
            </div>
            <?php } ?>
            <button style="width: 100%;" type="submit" name="<?php echo $btnName; ?>"
                class="btn btn-primary d-flex mx-auto"><span
                    class="d-flex mx-auto"><?php echo $header; ?></span></button>
        </form>
        <!-- Thông báo lỗi -->
        <?php if(getCookie("err") != ''){ ?>
        <div class='alert alert-danger'>
            <strong><?php echo getCookie("err"); ?></strong>
        </div>
        <?php } ?>
        <!-- Thông báo thông tin -->
        <?php if(getSession("info") != ''){ ?>
        <div class='alert alert-info'>
            <strong><?php echo getSession("info"); ?></strong>
        </div>
        <?php } unset($_SESSION["info"]); ?>


        <h6 class="my-3 text-center"><?php if($mod == "login"){echo"Bạn chưa có tài khoản <a href='?action=login&mod=register'>đăng ký";}
            else{echo"Bạn đã có tài khoản <a href='?action=login&mod=login'>đăng nhập";}?></a></h6>
    </div>
</div>
<?php } ?>