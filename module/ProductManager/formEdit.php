<?php
$idProduct = getIndex("idProduct");

if (postIndex("btnEditProduct") != '') {
    $productInfo = $sanPham->getSanPhamByID($idProduct);
    $txtProName = postIndex("txtProName");
    $txtProPrice = postIndex("txtProPrice");
    $txtProNewPrice = postIndex("txtProNewPrice");
    $txtProDescription = postIndex("txtProDescription");
    $txtType = postIndex("txtType");
    $txtBrand = postIndex("txtBrand");
    $image = (isset($_FILES["fileProNewImage"])) ? $_FILES["fileProNewImage"] : "";
    echo $txtType;
    if (strlen($txtProName) == 0 || strlen($txtProPrice) == 0) {
        $_SESSION["err_pro"] = "Hãy nhập thông tin các trường bắt buộc * ";
    } else {
        // Sửa thông tin sản phẩm
        $rowUpdate = $sanPham->updateSanPham($txtProName, $txtProPrice, $txtProNewPrice, $txtProDescription, $txtType, $txtBrand, $idProduct);
        if ($rowUpdate > 0) {
            $_SESSION["info_pro"] = "Sửa thông tin thành công";
        }

        // update ảnh
        if ($image != '' && $image["size"] > 0) {
            $temp = $image["tmp_name"];
            $imageName = $productInfo["hinh"];
            if (!move_uploaded_file($temp, "media/image/product/" . $imageName))
                $_SESSION["err_pro"] = "Đổi ảnh thất bại";
        }
    }
}

$productInfo = $sanPham->getSanPhamByID($idProduct);


?>

<div class="formedit-product">
    <div class="bg-white shadow p-2">
        <div class="d-flex justify-content-between bold mb-3">
            <span class="fs-5">Sửa sản phẩm</span>
            <!-- start Icon đóng form sửa -->
            <a href="?action=product_manager" class="border py-2 px-3 cursor-pointer bg-black">
                <svg style="fill: white;" xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                    <path
                        d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
                </svg>
            </a>
            <!-- end Icon đóng form sửa -->
        </div>
        <form action="?action=product_manager&mod=editProduct&idProduct=<?php echo $idProduct ?>" method="post"
            enctype="multipart/form-data">
            <!-- Hiện ảnh đã có và chọn ảnh mới -->
            <img id="proImageEdit" src="./media/image/product/<?php echo $productInfo["hinh"]; ?>" class="img-thumbnail"
                style="max-height: 150px;" alt="...">
            <br>
            <h5 id="proLabelImageEdit"></h5>
            <label class="btn btn-default text-success fw-bolder">
                Chọn ảnh mới<input id="proLabelChooseFileEdit" type="file" accept="image/*" hidden
                    name="fileProNewImage">
            </label>
            <!-- Hiện ảnh ngay khi load -->
            <script>
                const fileUploader = document.querySelector("#proLabelChooseFileEdit");
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
                        const img = document.getElementById('proImageEdit');
                        img.src = event.target.result;
                        img.alt = file.name;
                        document.getElementById("proLabelImageEdit").innerHTML = file.name;
                    });
                });
            </script>
            <!-- Thông báo thông tin -->
            <?php if (getSession("info_pro") != '') { ?>
                <div class='alert alert-info'>
                    <strong>
                        <?php echo getSession("info_pro"); ?>
                    </strong>
                </div>
            <?php }
            unset($_SESSION["info_pro"]); ?>

            <!-- Thông báo lỗi -->
            <?php if (getSession("err_pro") != '') { ?>
                <div class='alert alert-danger'>
                    <strong>
                        <?php echo getSession("err_pro"); ?>
                    </strong>
                </div>
            <?php }
            unset($_SESSION["err_pro"]); ?>
            <div class="input-group mb-2">
                <span class="input-group-text">Tên sản phẩm *</span>
                <input type="text" name="txtProName" value="<?php echo $productInfo["tenSanPham"] ?>"
                    class="form-control">
            </div>
            <div class="input-group mb-2">
                <span class="input-group-text">Giá *</span>
                <input type="text" name="txtProPrice" value="<?php echo $productInfo["gia"] ?>" class="form-control">
            </div>
            <div class="input-group mb-2">
                <span class="input-group-text">Giá mới</span>
                <input type="text" name="txtProNewPrice" value="<?php echo $productInfo["giaMoi"] ?>"
                    class="form-control">
            </div>
            <div class="input-group mb-2">
                <span class="input-group-text">Mô tả</span>
                <textarea name="txtProDescription" class="form-control" cols="30"
                    rows="5"><?php echo $productInfo["moTa"] ?></textarea>
            </div>
            <div class="input-group mb-2">
                <select class="form-select" id="txtType" name="txtType">
                    <?php
                    foreach ($dsLoaiSP as $loai) {
                        ?>
                        <option <?php echo $productInfo["maLoai"] == $loai["maLoai"] ? "selected" : "" ?>
                            value="<?php echo $loai["maLoai"] ?>">
                            <?php echo $loai["tenLoai"] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group mb-2">
                <select class="form-select" id="txtBrand" name="txtBrand">
                    <?php
                    foreach ($dsHang as $hang) {
                        ?>
                        <option <?php echo $productInfo["maHang"] == $hang["maHang"] ? "selected" : "" ?> value="<?php echo $hang["maHang"] ?>">
                            <?php echo $hang["tenHang"] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <input class="btn btn-success" type="submit" name="btnEditProduct" value="Sửa thông tin">
        </form>
    </div>
</div>