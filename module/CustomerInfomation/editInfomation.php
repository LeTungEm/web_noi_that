<?php
    $user = null;
    if($customer->checkLogin()){
        $user = $customer->getCustomer(getSession("customer_sdt"));
    }
    if(isset($_POST["btnCusEditSubmit"])){
        $name = postIndex("txtCusName");
        $passW = postIndex("txtCusPW");
        $image = $_FILES["fileCusImage"];
        $sdt = postIndex("txtCusSDT");  //số dt có thể được sửa
        $newSdt = postIndex("txtNewCusSDT"); //số điện thoại mới cần thêm vào
        $olderSDT = postIndex("txtOlderSDT"); //số điện thoại cũ
        $deleteSDT = postIndex("ckbDeleteSDT"); //Số điện thoại muốn xóa
        $checkInfo = true;
        for($i = 0; $i < count($sdt); $i++){
            if(!validateCusEdit($sdt[$i], $passW, $name)){
            $checkInfo = false;
            }else{
            $customer->updateCustomerSDT($user["ma"], $sdt[$i], $olderSDT[$i]);
            if(!empty($deleteSDT[$i])){
                if(count($olderSDT) == count($deleteSDT)){
                    $_SESSION["err"] = "Bạn không thể xóa tất cả số điện thoại!!!";

                }else{
                    $customer->deleteSDT($user["ma"], $deleteSDT[$i]);
                    if(getSession("customer_sdt") == $deleteSDT[$i]){
                        $customer->logOut();
                        $_SESSION["info"] = "Bạn vừa sửa thông tin đăng nhập, Hãy đăng nhập lại.";
                        echo '<meta http-equiv="refresh" content="0,url=index.php?action=login&mod=login">';
                    }
                }
                
            }
            //Nếu sửa số điện thoại đang đăng nhập thì phải đăng nhập lại
            if(getSession("customer_sdt") == $olderSDT[$i]){
                if($olderSDT[$i] != $sdt[$i]){
                    $customer->logOut();
                    $_SESSION["info"] = "Bạn vừa sửa thông tin đăng nhập, Hãy đăng nhập lại.";
                    echo '<meta http-equiv="refresh" content="0,url=index.php?action=login&mod=login">';
                }
            }
            }
        }
        if($checkInfo){
            $customer->updateCustomer($user["ma"], $name, $passW);
            //Thêm số điện thoại mới
            if($newSdt != ""){
                if(strlen($newSdt) == 10 && $customer->checkAccountExistence($newSdt) == false){
                    $customer->insertSDT($user["ma"],$newSdt);
                }else{
                    $_SESSION["err"] = "Số điện thoại sai hoặc đã tồn tại!!!";
                }
            }
            //Lưu ảnh
            if($image["size"] > 0){
                $arrImg = array("image/png", "image/jpeg", "image/bmp");
                $err = '';
                $errFile = $image["error"];
                if ($errFile>0)
                    $err .="Lỗi hình ảnh!";
                else
                {
                    $type = $image["type"];
                    if (!in_array($type, $arrImg))
                        $err .="Avatar chỉ được là hình ảnh";
                    else
                    {	$temp = $image["tmp_name"];
                        $imageName = $user["ma"].".png";
                        if (!move_uploaded_file($temp, "media/image/user/".$imageName))
                            $err .="Đổi ảnh thất bại";
                        
                    }
                }
                if($err != ''){
                $_SESSION["err"] = $err;
                }else{
                $customer->setImage($imageName, $user["ma"]);
                }
            }
        }
        
    }
    if($customer->checkLogin()){
        $user = $customer->getCustomer(getSession("customer_sdt"));
    }
?>
<form method="post" action="?action=account_infomation&mod=edit" enctype="multipart/form-data">
    <ul class="list-group my-2">
        <li class="list-group-item">
            <h2>Sửa thông tin</h2>
            <!-- Hiện ảnh đã có và chọn ảnh mới -->
            <img id="avatar" src="./media/image/user/<?php if ($user != null) {
                        if ($user["hinh"] != null) {
                            echo $user["hinh"];
                        } else {
                            echo "default.png";}} ?>" class="img-thumbnail" style="max-height: 200px;" alt="...">
            <br>
            <h5 id="labelImage"></h5>
            <label class="btn btn-default text-success fw-bolder">
                Chọn ảnh mới<input id="labelChooseFile" type="file" hidden name="fileCusImage" id="fileCusImage">
            </label>
            <!-- Hiện ảnh ngay khi load -->
            <script>
            const fileUploader = document.querySelector("#labelChooseFile");
            const reader = new FileReader();

            fileUploader.addEventListener('change', (event) => {
                const files = event.target.files;
                const file = files[0];

                // Get the file object after upload and read the
                // data as URL binary string
                reader.readAsDataURL(file);

                // Once loaded, do something with the string
                reader.addEventListener('load', (event) => {
                    // Here we are creating an image tag and adding
                    // an image to it.
                    const img = document.getElementById('avatar');
                    img.src = event.target.result;
                    img.alt = file.name;
                    document.getElementById("labelImage").innerHTML = file.name;
                });
            });
            </script>
        </li>
        <li class="list-group-item bg-light d-flex">
            <!-- Tên -->
            <span style="width: 15%;" class="text-success fw-bolder">Tên: </span>
            <input type="text" class="form-control" name="txtCusName" id="txtCusName" value="<?php if ($user != null) {
            echo $user["ten"];} ?>">
        </li>
        <li class="list-group-item bg-light d-flex">
            <!-- Mật khẩu -->
            <span style="width: 15%;" class="text-success fw-bolder">Mật khẩu: </span>
            <input type="text" class="form-control" name="txtCusPW" id="txtCusPW" value="<?php if ($user != null) {
            echo $user["passWord"];} ?>">
        </li>
        <li class="list-group-item bg-light d-flex">
            <span style="width: 15%;" class="text-success fw-bolder">Sdt: </span>
            <div style="width: 100%;" class="bg-light border-0">
                <?php
                $countDelete = 1;
                $listSDT = $customer->getAllSDT($user["ma"]);
            foreach ($listSDT as $sdt) { ?>
                <!-- danh sách sdt -->
                <div class="d-flex">
                    <input class="delSDT" type="checkbox" hidden name="ckbDeleteSDT[]" id="ckbDeleteSDT<?php echo $countDelete; ?>" value="<?php
                    echo $sdt["sdt"];?>">
                    <input type="text" class="form-control" name="txtCusSDT[]" value="<?php
                    echo $sdt["sdt"];?>">
                    <label for="ckbDeleteSDT<?php echo $countDelete; ?>"><i class="material-icons" style="font-size: 30px; cursor: pointer;">delete</i></label>
                </div>
                <input type="text" hidden name="txtOlderSDT[]" value="<?php
                    echo $sdt["sdt"];?>">
                <?php
                    $countDelete++;} 
                ?>
                <!-- Thêm sdt mới -->
                <input type="checkbox" hidden id="cbControl">
                <input type="text" placeholder="Nhập sdt mới..." class="form-control d-none" name="txtNewCusSDT"
                    id="txtNewCusSDT">
                <label id="btnAddSDT" for="cbControl" class="d-flex my-1">
                    <i class="material-icons text-success" style="font-size:36px">
                        add_circle
                    </i>
                </label>
            </div>
        </li>
        <!-- Thông báo lỗi -->
        <?php if(getSession("err") != ''){ ?>
        <div class='alert bg-danger text-white mb-1'>
            <strong><?php echo getSession("err"); ?></strong>
        </div>
        <?php }
        unset($_SESSION["err"]); ?>
        <!--  -->
        <li class="list-group-item bg-primary border-0 d-flex">
            <!-- Button trigger modal -->
            <Button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                class="btn bg-success fw-bolder text-light">Lưu</Button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-success" id="exampleModalLabel">Thông báo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc muốn đổi thông tin này
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" name="btnCusEditSubmit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</form>
<?php
function validateCusEdit($sdt, $mk, $ten){
    $flag = false;
    $errString = "";
    if($sdt == "" || $mk == "" || $ten == ""){
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
        $_SESSION["err"] = $errString;
        return false;
    }
    return true;
}
?>