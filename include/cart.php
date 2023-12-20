<?php
$dsSPTrongGH = array();
if (isset($user)) {
    $dsSPTrongGH = $gioHang->getAllByCusID($user['ma']);
}
?>

<input hidden type="checkbox" id='btnCart'>
<label for="btnCart" class="btn btn-outline-success">

    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18"
        viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
        <path
            d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
    </svg>
</label>
<div class="cart-container shadow d-none p-3">
    <div class="d-flex justify-content-between bold mb-3">
        <span class="fs-5">Giỏ hành</span>
        <label class="border py-2 px-3 cursor-pointer" for="btnCart">
            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12"
                viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                <path
                    d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
            </svg>
        </label>
    </div>
    <div class="scrollView">
        <?php
        foreach ($dsSPTrongGH as $sp) {

            $hinh = isset($sp["hinh"]) ? $sp["hinh"] : "";
            $path = 'media/image/product/' . $hinh;
            if (!file_exists($path) && !is_file($path)) {
                $path = 'media/image/default.png';
            } ?>
            <div class="d-flex mb-3 shadow">
                <img style="width: 30%;" src="<?php echo $path; ?>" class="card-img-top" alt="">
                <div class="ms-3">
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
                </div>
            </div>

        <?php } ?>
    </div>
</div>