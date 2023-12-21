<?php
$dsHang = $hang->getAll();
$dsLoaiSP = $loaiSanPham->getAll();
$filterTypeId = '';
$filterBrandId = '';
$search = '';
$page = 1;

if (getIndex("page") != '') {
    $page = getIndex("page");
}

if (isset($_POST["btnSubmit"])) {
    // Xử lý lọc khóa học
    $filterTypeId = postIndex("filterType");
    $filterBrandId = postIndex("filterBrand");
    $search = postIndex("search");

    $soLuongSP = ceil($sanPham->countProductFilter($filterTypeId, $filterBrandId, $search) / SAN_PHAM_MOT_TRANG);

    $dsSanPham = $sanPham->getAllForShowFilter($filterTypeId, $filterBrandId, $search, ($page - 1) * SAN_PHAM_MOT_TRANG);


} else {

    $soLuongSP = ceil($sanPham->countProduct() / SAN_PHAM_MOT_TRANG);

    $dsSanPham = $sanPham->getAllForShow(($page - 1) * SAN_PHAM_MOT_TRANG);
}
?>
<form class="container mt-5" method="post" action="?action=home">
    <ul class="list-group text-start my-2">
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

<div class="container mt-5">
    <!-- start duyệt sản phẩm -->
    <div class="row">
        <?php
        foreach ($dsSanPham as $sp) {

            ?>
            <div class="col col-6 col-lg-3 mb-3 d-flex flex-column justify-content-center">
                <?php
                // Lấy hình ảnh
                $hinh = isset($sp["hinh"]) ? $sp["hinh"] : "";
                $path = 'media/image/product/' . $hinh;
                if (!file_exists($path) && !is_file($path)) {
                    $path = 'media/image/default.png';
                } ?>
                <!-- start thẻ sản phẩm -->
                <a class="shadow" href="?action=product_detail&id=<?php echo $sp["maSanPham"]; ?>">
                    <div class="card mb-3 w-100">
                        <img style="width: 100%; height: 100%;" src="<?php echo $path; ?>" class="card-img-top" alt="">
                    </div>
                    <div class="px-2">
                        <h1 class="fs-5 text-black text-capitalize">
                            <?php echo isset($sp["tenSanPham"]) ? $sp["tenSanPham"] : ""; ?>
                        </h1>
                        <h5 class="d-flex flex-wrap text-success">
                            <span class="me-5">
                                <?php echo $sp["giaMoi"] > 0 ? $sanPham->formatPrice($sp["giaMoi"]) . 'đ' : $sanPham->formatPrice($sp["gia"]) . 'đ'; ?>
                            </span>
                            <span class="text-decoration-line-through text-secondary">
                                <?php echo $sp["giaMoi"] > 0 ? $sanPham->formatPrice($sp["gia"]) . 'đ' : ""; ?>
                            </span>
                        </h5>
                    </div>
                </a>
                <!-- end thẻ sản phẩm -->

            </div>
        <?php } ?>
    </div>
    <!-- end duyệt sản phẩm -->


    <!-- Phân trang -->
    <?php if ($soLuongSP > 1) { ?>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if ($page > 1) { ?>
                            <!-- page < 1 không cho lùi -->
                            <li class="page-item">
                                <a class="page-link" href="./index.php?action=home&page=<?php echo $page - 1; ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php if (1 == $page) {
                            echo "active";
                        } ?>"><a class="page-link" href="./index.php?action=home&page=1">1</a></li>
                        <!-- <li class="page-item"><a class="page-link">&nbsp;</a></li> -->
                        <?php for ($i = $page - 2; $i <= $soLuongSP - 1; $i++) {
                            if ($i > 1 && $i <= $page + 2) { ?>
                                <!-- chỉ xuất 5 trang trong khoản của page hiện tại -->
                                <li class="page-item <?php if ($i == $page) {
                                    echo "active";
                                } ?>"><a class="page-link" href="./index.php?action=home&page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a></li>
                            <?php }
                        } ?>
                        <!-- <li class="page-item"><a class="page-link">&nbsp;</a></li> -->
                        <li class="page-item <?php if ($soLuongSP == $page) {
                            echo "active";
                        } ?>"><a class="page-link" href="./index.php?action=home&page=<?php echo $soLuongSP; ?>">
                                <?php echo $soLuongSP; ?>
                            </a>
                        </li>
                        <?php if ($page < $soLuongSP) { ?>
                            <!-- page = max không cho tiến tới -->
                            <li class="page-item">
                                <a class="page-link" href="./index.php?action=home&page=<?php echo $page + 1; ?>"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    <?php } ?>
</div>
<!-- end phân trang -->

<div class="container">
    <div class="row">
        <h4 class="col text-center pb-4 pt-4 text-success">LÝ DO BẠN NÊN MUA SẮM TẠI TM_House</h4>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pdm-No text-center">
            <div class="mb-4">
                <div>
                    <i class='fas fa-chalkboard-teacher' style='font-size:70px'></i>
                    <h5>Đảm bảo uy tín</h5>
                    <span>Sản phẩm chất lượng</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pdm-No text-center">
            <div class="mb-4">
                <div>
                    <i class='fas fa-atlas' style='font-size:70px'></i>
                    <h5>Giao hành nhanh chóng</h5>
                    <span>Giao hàng tận nơi nhanh chóng</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pdm-No text-center">
            <div class="mb-4">
                <div>
                    <i class='fas fa-chalkboard-teacher' style='font-size:70px'></i>
                    <h5>Bảo hành dài lâu</h5>
                    <span>Bảo hành sản phẩm 1 năm</span>
                </div>
            </div>
        </div>
    </div>
</div>