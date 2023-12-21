<!-- start icon mở giỏ hàng -->
<input <?php echo $isOpenCart ?> hidden type="checkbox" id='btnCart'>
<label for="btnCart" class="btn btn-outline-success d-flex justify-content-center align-items-center">
    <span>
        <?php echo $totalQuantityCart; ?>
    </span>
    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18"
        viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
        <path
            d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
    </svg>
</label>
<!-- end icon mở giỏ hàng -->

<div class="cart-container shadow d-none p-3">
    <div class="d-flex justify-content-between bold mb-3">
        <span class="fs-5">Giỏ hành</span>
        <!-- start Icon đóng giỏ hàng -->
        <label class="border py-2 px-3 cursor-pointer" for="btnCart">
            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                <path
                    d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
            </svg>
        </label>
        <!-- end Icon đóng giỏ hàng -->
    </div>
    <div class="scrollView">
        <!-- start duyệt sản phẩm trong giỏ hàng -->
        <?php
        $isOpenCart = "";
        foreach ($dsSPTrongGH as $sp) {

            $hinh = isset($sp["hinh"]) ? $sp["hinh"] : "";
            $path = 'media/image/product/' . $hinh;
            if (!file_exists($path) && !is_file($path)) {
                $path = 'media/image/default.png';
            } ?>
            <div class="d-flex mb-3 shadow">
                <img style="width: 30%;" src="<?php echo $path; ?>" class="card-img-top" alt="">
                <div class="ms-3 p-1">
                    <h1 class="text-capitalize fs-5">
                        <?php echo $sp["tenSanPham"]; ?>
                    </h1>
                    <h5 class="d-flex flex-wrap">
                        <span class="text-success">
                            <?php echo $sp["soLuong"]; ?>
                        </span>&nbsp;X&nbsp;
                        <span class="me-5 text-success">
                            <?php echo $sp["giaMoi"] > 0 ? $sanPham->formatPrice($sp["giaMoi"]) . 'đ' : $sanPham->formatPrice($sp["gia"]) . 'đ'; ?>
                        </span>
                    </h5>
                    <!-- start nút xóa sản phẩm khỏi giỏ hàng -->
                    <form class="deleteCartForm" method="post">
                        <input name="productIdRemoved" type="number" hidden value="<?php echo $sp["maSanPham"]; ?>">
                        <input name="btnDeleteCart" value="Xóa sản phẩm" type="submit"
                            class="border-0 bg-transparent fst-italic text-decoration-underline cursor-pointer" />
                    </form>
                    <!-- end nút xóa sản phẩm khỏi giỏ hàng -->
                </div>
            </div>

        <?php } ?>
        <!-- end duyệt sản phẩm trong giỏ hàng -->


        <!-- Đoạn js giúp mỗi lần xóa sản phẩm. Thì vẫn sẽ ở lại trang hiện tại -->
        <script>
            var forms = document.getElementsByClassName("deleteCartForm");

            for (var i = 0; i < forms.length; i++) {
                forms[i].addEventListener("submit", function (event) {
                    location.reload();
                });
            }
        </script>
    </div>
    <hr />
    <div class="fs-5 total-text">
        Tổng cộng: <span>
            <?php echo $sanPham->formatPrice($totalPriceCart) . 'đ'; ?>
        </span>
    </div>
    <div class="bg-success btn-checkout">Thanh Toán</div>
</div>