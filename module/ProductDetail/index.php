<?php
$id = getIndex("id");
if ($id == '')
    exit;
if ($id != '') {
    $chiTietSP = $sanPham->getSanPhamByID($id);
    if (count($chiTietSP) == 0) {
        echo '<meta http-equiv="refresh" content="0,url=index.php?index.php?action=home">';
    }
    $hinh = isset($chiTietSP["hinh"]) ? $chiTietSP["hinh"] : "";
    $path = 'media/image/product/' . $hinh;
    if (!file_exists($path) && !is_file($path)) {
        $path = 'media/image/default.png';
    }
    ?>
    <div class="container my-5">
        <div class="row">
            <div class="col-12 col-lg-6 pdm-No mb-5 mb-lg-0">

                <img style="width: 100%;" src="<?php echo $path; ?>" class="shadow object-fit-contain" alt="">

            </div>
            <div class="col-12 col-lg-6 pdm-No">
                <h1 class="text-capitalize">
                    <?php echo $chiTietSP["tenSanPham"]; ?>
                </h1>
                <h5 class="d-flex flex-wrap my-3">
                    <span class="me-5">
                        <?php echo $chiTietSP["giaMoi"] > 0 ? $sanPham->formatPrice($chiTietSP["giaMoi"]) . 'đ' : $sanPham->formatPrice($chiTietSP["gia"]) . 'đ'; ?>
                    </span>
                    <span class="text-decoration-line-through text-secondary">
                        <?php echo $chiTietSP["giaMoi"] > 0 ? $sanPham->formatPrice($chiTietSP["gia"]) . 'đ' : ""; ?>
                    </span>
                </h5>
                <p>
                    <?php echo $chiTietSP["moTa"]; ?>
                </p>
                <div>
                    <b>Loại sản phẩm:</b>
                    <?php echo $chiTietSP['tenLoai'] ?>
                </div>
                <div>
                    <b>Hãng:</b>
                    <?php echo $chiTietSP['tenHang'] ?>
                </div>
                <form action="?action=product_detail&id=<?php echo $chiTietSP["maSanPham"]; ?>" method="post"
                    class="mt-5 pdm-No">
                    <span id="btnDecreateQuantity" class="btn py-2 px-3 m-0 border cursor-pointer">-</span>
                    <input type="number" value="1" readonly id="quantityField" name="quantityField"
                        class="btn py-2 px-4 m-0 border number-text">
                    <span id="btnIncreateQuantity" class="btn py-2 px-3 m-0 border cursor-pointer">+</span><br />
                    <input class="btn btn-success mt-5" type="submit" name="btnAddToCart" value="Thêm vào giỏ hàng">
                </form>
                <script>
                    let btnIncreateQuantity = document.getElementById('btnIncreateQuantity')
                    let btnDecreateQuantity = document.getElementById('btnDecreateQuantity')

                    btnIncreateQuantity.addEventListener("click", function () {
                        let quantityField = document.getElementById("quantityField");
                        quantityField.value = parseInt(quantityField.value) + 1;
                    });
                    btnDecreateQuantity.addEventListener("click", function () {
                        let quantityField = document.getElementById("quantityField");
                        if (quantityField.value > 1) {
                            quantityField.value = parseInt(quantityField.value) - 1;
                        }
                    });
                </script>
                <div id="div_lession" class="scrollVer">

                    <!-- <ul class="list-group">
                    
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
<?php } ?>