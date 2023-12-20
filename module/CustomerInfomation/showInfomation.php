<?php
    if(postIndex("btnSubmit") != ''){
        if($admin->checkLogin()){
            $mk = postIndex("passW");
            if(strlen($mk) < 8){
                $_SESSION["err"] = "Mật khẩu có ít nhất 8 ký tự!!!";
            }else{
                $admin->setPassWord($mk, getSession("admin_sdt"), $user["ma"]);
                $_SESSION["info"] = "Đã thay đổi mật khẩu";
            }
        }
    }

    $user = null;
    if($customer->checkLogin()){
        $user = $customer->getCustomer(getSession("customer_sdt"));
    }else if($employee->checkLogin()){
        $user = $employee->getEmployee(getSession("employee_sdt"));
    }else if($admin->checkLogin()){
        $user = $admin->getAdmin(getSession("admin_sdt"));
    }

?>
<ul class="list-group my-2">
    <li class="list-group-item">
        <h2>Thông tin tài khoản</h2>
        <img src="./media/image/user/<?php if ($user != null) {
                        if ($user["hinh"] != null) {
                            echo $user["hinh"];
                        } else {
                            echo "default.png";}} ?>" class="img-thumbnail" style="max-height: 200px;" alt="...">
    </li>
    <li class="list-group-item">
        Tên: <?php if ($user != null) {
            echo $user["ten"];
        } ?>
    </li>
    <li class="list-group-item">
        <?php if (getSession("admin_sdt") != '') { ?>
        <form class="d-flex justify-content-center" method="post">
            Mật khẩu: <input class="form-control ms-2" style="width: 30%;" value="<?php echo $user["passWord"]; ?>"
                type="text" name="passW">
            <input class="btn btn-success mx-2" type="submit" value="Đổi mật khẩu" name="btnSubmit">
        </form>
            <!-- báo lỗi -->
            <?php if(getSession("err") != ''){ ?>
            <div class='alert alert-danger'>
                <strong><?php echo getSession("err"); ?></strong>
            </div>
            <?php } unset($_SESSION["err"]); ?>
            <!-- Báo thành công đổi passWord -->
            <?php if(getSession("info") != ''){ ?>
            <div class='alert alert-info'>
                <strong><?php echo getSession("info"); ?></strong>
            </div>
            <?php } unset($_SESSION["info"]); ?>
        <?php } else { ?>
        Mật khẩu: <?php echo $user["passWord"]; ?>
        <?php } ?>
    </li>
    <li class="list-group-item">
        Số điện thoại:
        <?php
            if(getSession("customer_sdt") != ''){
                $listSDT = $customer->getAllSDT($user["ma"]);
                foreach($listSDT as $sdt){
                echo "<br>".$sdt["sdt"];
                }
            }else if(getSession("employee_sdt") != ''){
                $listSDT = $employee->getAllSDT($user["ma"]);
                foreach($listSDT as $sdt){
                echo "<br>".$sdt["sdt"];
                }
            }else if(getSession("admin_sdt") != ''){
                echo getSession("admin_sdt");
            }
            
        ?>
    </li>
</ul>