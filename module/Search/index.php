<?php
if (isset($_POST["btnSearchSubmit"])) { ?>
    <h1 class="mt-5 mx-3">Kết quả cho từ khóa:
        <?php echo postIndex('search') ?>
    </h1>
    <div class="container mt-5">
        <div class="row">
            <?php

            $dsSanPham = $sanPham->getProductByName($_POST["search"]);
            foreach ($dsSanPham as $sp) { ?>
                <div class="col col-6 col-lg-3 mb-3 d-flex flex-column justify-content-center">
                    <?php
                    $hinh = isset($sp["hinh"]) ? $sp["hinh"] : "";
                    $path = 'media/image/product/' . $hinh;
                    if (!file_exists($path) && !is_file($path)) {
                        $path = 'media/image/default.png';
                    } ?>
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
                </div>
            <?php } ?>
        </div>
    </div>

<?php } ?>
<!-- end list lesson -->
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