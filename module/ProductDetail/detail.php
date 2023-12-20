<?php
$id = getIndex("id");
if ($id == '')
    exit;
$user = null;
if($customer->checkLogin()){
    $user = $customer->getCustomer(getSession("customer_sdt"));
    if(getIndex("mod") != ''){
        $purchasedCourse->buyCourse($user["ma"], $id);
    }
}
if ($id != '') {
    $khoahoc = $course->getCourseByID($id);
?>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12 pdm-No text-center">
            <div class="d-flex justify-content-center">
                <?php
    $check = false;
    if ($customer->checkLogin()) {
        if ($purchasedCourse->checkPurchasedCourseByCustomerID($user["ma"], $id)) {
            $check = true;
        }
    }
    if (!$check) {
        $flag = false;
        $path = 'media/image/course/' . $khoahoc["hinh"];
        if (file_exists($path) && is_file($path)) {
            $flag = true; } ?>
                <div class="card <?php if (!$flag) { echo 'bg-secondary'; } ?> text-white mb-2">
                    <?php if ($flag) { ?>
                    <img style="width: 100%; height: 100%;" src="<?php echo $path; ?>" class="card-img border-0" alt="">
                    <?php } ?>
                </div>
                <?php } else {
        $flag = true;
        $lessionData = $lession->getOneLessionByCourseID(getIndex("id"));
        if ($lessionData != null) {
            $lession_link = $lessionData["link"];
        }
        if (postIndex("btnChangeLession") != '') {
            $lession_link = postIndex("linkLession");
        } ?>
                <video width="320" height="240" controls class="">
                    <source src="<?php echo $lession_link; ?>" type="video/mp4">
                    <source src="./media/video/lession/<?php echo $lession_link; ?>" type="video/mp4">
                </video>
                <?php } ?>
            </div>
            <div class="mb-4 ">
                <?php if (!$check) { ?>
                <h5 class="text-secondary"><?php echo $course->formatPrice($khoahoc["gia"]) . "đ"; ?></h5>
                <a class="bg-primary fw-bolder text-white p-2 px-4 rounded-pill" href="?<?php 
                if ($customer->checkLogin()) {
                    echo 'action=course_detail&mod=dkkh&id=' . $khoahoc["maKhoaHoc"];
                } else {
                    echo "action=login&mod=login";
                } ?>">Đăng ký học ngay</a>
                <?php } else { ?>
                <br>
                <p><?php echo postIndex("descriptionLession"); ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 pdm-No text-center bg-primary">
            <h1 class="text-white">
                <?php echo $khoahoc["tenKhoaHoc"]; ?>
            </h1>
            <div id="div_lession" class="scrollVer">
                <script>
                var div_lession = document.getElementById("div_lession");
                var length = (document.documentElement.clientHeight >= 1000) ? 700 : document.documentElement
                    .clientHeight - 100;
                div_lession.style.height = length + "px";
                </script>
                <p>
                    <?php echo $khoahoc["moTa"]; ?>
                </p>
                <ul class="list-group">
                    <?php
                        $lessions = $lession->getAll($id);
                        foreach ($lessions as $baihoc) {
                    ?>
                    <li class="list-group-item border border-primary">
                        <?php if ($check) { ?>
                        <form method="post">
                            <input type="text" hidden name="linkLession" value="<?php echo $baihoc["link"]; ?>">
                            <input type="text" hidden name="descriptionLession" value="<?php echo $baihoc["moTa"]; ?>">
                            <input type="submit" class="bg-white border-0" name="btnChangeLession"
                                value="<?php echo $baihoc["tenBaiHoc"]; ?>">
                        </form>
                        <?php } else {
                            echo $baihoc["tenBaiHoc"];
                        } ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php } ?>