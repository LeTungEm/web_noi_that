<?php
if (postIndex("btnAddCourse") != '') {
    $productName = postIndex("productName");
    $productPrice = postIndex("productPrice");
    $productNewPrice = postIndex("productNewPrice") == "" ? 0 : postIndex("productNewPrice");
    $productDescription = postIndex("productDescription");
    $typeId = postIndex("type");
    $brandId = postIndex("brand");
    $productImage = (isset($_FILES["productImage"])) ? $_FILES["productImage"] : "";
    $imageName = rand(100000, 999999);

    if (strlen($productName) == 0 || strlen($productPrice) == 0) {
        $_SESSION["err"] = "Hãy điền thông tin vào các trường bắt buộc *";
    } else {
        $idNewProduct = $sanPham->insertSanPham($productName, $productPrice, $productNewPrice, $productDescription, $typeId, $brandId, $imageName . ".png");
        if ($idNewProduct > 0) {
            // Lưu ảnh
            $_SESSION["info"] = "Đã thêm sản phẩm: " . $productName;
            if ($productImage != '' && $productImage["size"] > 0) {
                if (!move_uploaded_file($productImage["tmp_name"], "media/image/product/" . $imageName . ".png")) {
                    $_SESSION["err"] = "Không thể lưu ảnh!!!!";
                }
            } else {
                //Xử lý nếu không có ảnh
            }
        }
    }
    unset($_POST["btnAddCourse"]);
}

if (postIndex("btnDeleteProduct") != '') {
    $idProduct = postIndex("idProduct");
    if ($gioHang->isProductExist($idProduct)) {
        $_SESSION["err"] = "Không thể xóa sản phẩm đã được mua!!!!";
    } else {

        $productInfo = $sanPham->getSanPhamByID($idProduct);

        if ($sanPham->deleteSanPhamByID($idProduct)) {
            $path = "media/image/product/" . $productInfo['hinh'];
            if (file_exists($path) && is_file($path)) {
                unlink($path);
            } else {
                $_SESSION["err"] = "Xóa ảnh thất bại!!!!";
            }
            $_SESSION["info"] = "Đã xóa sản phẩm tên: " . $productInfo['tenSanPham'];
        } else {
            $_SESSION["err"] = "Xóa thất bại!!!!";
        }
    }

}

$dsHang = $hang->getAll();
$dsLoaiSP = $loaiSanPham->getAll();
$filterTypeId = '';
$filterBrandId = '';
$search = '';
if (isset($_POST["btnSubmit"])) {
    // Xử lý lọc khóa học
    $filterTypeId = postIndex("filterType");
    $filterBrandId = postIndex("filterBrand");
    $search = postIndex("search");

    $listProduct = $sanPham->filterSanPham($filterTypeId, $filterBrandId, $search);

} else {
    $listProduct = $sanPham->getAll();
}


?>
<div style="height: 100%" class="scrollVer">
    <form method="post" action="?action=product_manager">
        <ul class="list-group text-start my-2">
            <li class="list-group-item">
                <!-- Thông báo lỗi -->
                <?php if (getSession("err") != '') { ?>
                    <div class='alert alert-danger'>
                        <strong>
                            <?php echo getSession("err"); ?>
                        </strong>
                    </div>
                <?php }
                unset($_SESSION["err"]); ?>
                <!-- Thông báo thông tin -->
                <?php if (getSession("info") != '') { ?>
                    <div class='alert alert-info'>
                        <strong>
                            <?php echo getSession("info"); ?>
                        </strong>
                    </div>
                <?php }

                unset($_SESSION["info"]); ?>
            </li>
            <li class="list-group-item">
                <!-- form lọc thông tin -->
                <div class="input-group my-2">
                    <label class="input-group-text" for="type">Lọc theo loại</label>
                    <select class="form-select" id="type" name="filterType">
                        <option value="0">
                            Tất cả loại
                        </option>
                        <?php
                        foreach ($dsLoaiSP as $loai) {
                            ?>
                            <option <?php echo $filterTypeId == $loai["maLoai"] ? "selected" : '' ?>
                                value="<?php echo $loai["maLoai"] ?>">
                                <?php echo $loai["tenLoai"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group my-2">
                    <label class="input-group-text" for="type">Lọc theo hãng</label>
                    <select class="form-select" id="type" name="filterBrand">
                        <option value="0">
                            Tất cả hãng
                        </option>
                        <?php
                        foreach ($dsHang as $hang) {
                            ?>
                            <option <?php echo $filterBrandId == $hang["maHang"] ? "selected" : '' ?>
                                value="<?php echo $hang["maHang"] ?>">
                                <?php echo $hang["tenHang"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </li>
            <li class="list-group-item d-flex">
                <input class="form-control me-3" value="<?php echo $search; ?>" name="search" type="search"
                    placeholder="Tìm theo tên">
                <input class="btn btn-success" value="Lọc dữ liệu" type="submit" name="btnSubmit">
            </li>
        </ul>
    </form>
    <div class="container bg-light text-center my-2 p-0 rounded" style="max-width: 100%">
        <ul class="list-group">
            <li class="list-group-item">
                <!-- form thêm khóa học -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row courses-info">
                        <div class="col col-lg-1 col-12 mb-1 fw-bolder">
                            <!-- icon thêm khóa học -->
                            <label for="qlproduct_cbControl" class="d-flex my-1">
                                <i class="material-icons text-success" style="font-size:36px">
                                    add_circle
                                </i>
                            </label>
                        </div>
                        <input hidden type="checkbox" id="qlproduct_cbControl">
                        <div hidden class="col col-12 mb-1 fw-bolder"><input class="form-control"
                                placeholder="Nhập tên *..." type="text" name="productName"></div>
                        <div hidden class="col col-12 mb-1 fw-bolder"><input class="form-control"
                                placeholder="Nhập giá *..." type="number" name="productPrice"></div>
                        <div hidden class="col col-12 mb-1 fw-bolder"><input class="form-control"
                                placeholder="Nhập giá mới..." type="number" name="productNewPrice"></div>
                        <div hidden class="col col-12 mb-1 fw-bolder"><input class="form-control" placeholder="Mô tả..."
                                type="text" name="productDescription"></div>
                        <div hidden class="col col-12 mb-1 fw-bolder">
                            <select class="form-select" id="type" name="type">
                                <?php
                                foreach ($dsLoaiSP as $loai) {
                                    ?>
                                    <option selected value="<?php echo $loai["maLoai"] ?>">
                                        <?php echo $loai["tenLoai"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div hidden class="col col-12 mb-1 fw-bolder">
                            <select class="form-select" id="type" name="brand">
                                <?php
                                foreach ($dsHang as $hang) {
                                    ?>
                                    <option selected value="<?php echo $hang["maHang"] ?>">
                                        <?php echo $hang["tenHang"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div hidden class="col col-12 mb-1">
                            <label id="labelproductImage" for="formAdd_productImage"
                                class="btn btn-default text-success fw-bolder"> Chọn ảnh</label>
                            <input hidden accept="image/*" type="file" name="productImage" id="formAdd_productImage">
                            <script>
                                document.getElementById("formAdd_productImage")
                                    .onchange = function (event) {
                                        document.getElementById("labelproductImage").innerText = event.target.files[0].name;
                                    }
                            </script>
                            <input type="submit" name="btnAddCourse" class="btn btn-success fw-bolder" value="Thêm">
                        </div>
                    </div>
                </form>
            </li>
            <li class="list-group-item">
                <div class="row courses-info">
                    <div class="col col-1 fw-bolder">Mã</div>
                    <div class="col col-2 fw-bolder">Tên sản phẩm</div>
                    <div class="col col-2 fw-bolder">Giá</div>
                    <div class="col col-2 fw-bolder">Giá giảm</div>
                    <div class="col col-2 fw-bolder">hình ảnh</div>
                    <div class="col col-2 fw-bolder">Ngày đăng tải</div>
                    <div class="col col-1 fw-bolder">&nbsp;</div>
                </div>
            </li>
            <?php
            foreach ($listProduct as $sp) { ?>
                <!-- Hiện danh sách khóa học -->
                <li class="list-group-item">
                    <div class="row courses-info">
                        <div class="col col-1">
                            <?php echo $sp["maSanPham"]; ?>
                        </div>
                        <div class="col col-2">
                            <?php echo $sp["tenSanPham"]; ?>
                        </div>
                        <div class="col col-2">
                            <?php echo $sanPham->formatPrice($sp["gia"]); ?>
                        </div>
                        <div class="col col-2">
                            <?php echo $sanPham->formatPrice($sp["giaMoi"]); ?>
                        </div>
                        <div class="col col-2">
                            <?php
                            $hinh = isset($sp["hinh"]) ? $sp["hinh"] : "";
                            $path = 'media/image/product/' . $hinh;
                            if (!file_exists($path) && !is_file($path)) {
                                $path = 'media/image/default.png';
                            }
                            ?>
                            <img src="<?php echo $path ?>" class="img-thumbnail" style="max-height: 50px;" alt="...">
                        </div>
                        <div class="col col-2">
                            <?php echo $sp["ngayTao"]; ?>
                        </div>
                        <div class="col col-1">
                            <!-- Button trigger modal -->
                            <i class="material-icons" onclick="deleteMessage(<?php echo $sp['maSanPham']; ?>)"
                                data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" title="Xóa"
                                style="cursor: pointer;" style="font-size: 24px; cursor: pointer;">delete</i>
                            <!-- <a href="?action=course_manager&mod=editCourse&idProduct=<?php echo $sp["maSanPham"]; ?>"
                                class="text-black"><i style="font-size:24px" data-toggle="tooltip" title="Chỉnh sửa"
                                    style="cursor: pointer;" class="fa">&#xf044;</i></a> -->

                            <a href="?action=course_manager&mod=editCourse&idProduct=<?php echo $sp["maSanPham"]; ?>"
                                class="text-black">
                                <svg style="font-size:24px" data-toggle="tooltip" title="Chỉnh sửa" style="cursor: pointer;"
                                    xmlns="http://www.w3.org/2000/svg" height="16" width="16"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                    <path
                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                </svg>
                            </a>

                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc muốn xóa sản phẩm này
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form method="post">
                    <input id="idProduct" hidden type="text" name="idProduct" value="">
                    <input name="btnDeleteProduct" type="submit" value="Xóa sản phẩm" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Lấy id qua sự kiện click
    function deleteMessage(id) {
        document.getElementById("idProduct").value = id;
    }
</script>
<style>
    i {
        cursor: pointer;
    }

    #qlproduct_cbControl:checked~.col {
        display: block !important;
    }

    i:hover {
        color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity));
    }

    svg:hover {
        fill: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity));
    }

    .courses-info .col i {
        display: flex;
    }
</style>