<?php
$idLession = getIndex("idLession");
$dataLession = $lession->getByLessionID($idLession);
if ($dataLession != null) {
    $path = $dataLession["link"];
    if(postIndex("btnEditLession") != ""){
        $lessionName = postIndex("txtLessionName");
        $lessionDescription = postIndex("txtLessionDescription");
        $lessionDate = postIndex("txtLessionDate");
        $lessionVideo = (isset($_FILES["lessionVideo"])) ? $_FILES["lessionVideo"] : "";

        if(strlen($lessionName) == 0 || strlen($lessionDate) == 0){
            $_SESSION["err_course"] = "Hãy nhập thông tin các trường bắt buộc * ";
        }else{
            
            if($lession->updateLession($lessionName, $lessionDescription, $lessionDate, $idLession) > 0)
                $_SESSION["info_course"] = "Đã sửa " . $lessionName;

            // upload video
            if($lessionVideo["size"] > 0 && $lessionVideo["size"] <= (50*1024*1024)){
                $lesionVideoName = $idLession . ".mp4";
                if (move_uploaded_file($lessionVideo["tmp_name"], "media/video/lession/".$lesionVideoName)){
                    $lession->setLink($lesionVideoName, $idLession);
                }
            }else{
                if($lessionVideo["size"] > (10*1024*1024))
                    $_SESSION["err_course"] = "File vừa chọn quá lớn";
            }
        }
        $dataLession = $lession->getByLessionID($idLession);
}
?>
<form method="post" enctype="multipart/form-data">
    <!-- Thêm video -->
    <input hidden type='file' name="lessionVideo" accept="video/mp4" id='videoEditLessionUpload' />

    <!-- <video class="img-thumbnail" style="max-height: 150px; display: none" width="320" height="240" controls>
        <source>
    </video> -->

    <video class="img-thumbnail" style="max-height: 150px; <?php if ($path == "")
        echo "display: none;"; ?>" width="320" height="240" controls>
        <source src="<?php echo $path; ?>" type="video/mp4">
        <source src="./media/video/lession/<?php echo $path; ?>" type="video/mp4">
    </video>
    <label id="labelLessionVideo" for="videoEditLessionUpload" class="btn btn-default text-success fw-bolder"> Chọn
        video</label>

    <script>
    document.getElementById("videoEditLessionUpload")
        .onchange = function(event) {
            let file = event.target.files[0];
            let blobURL = URL.createObjectURL(file);
            document.querySelector("video").src = blobURL;
            document.querySelector("video").style.display = "unset";
        }
    </script>
    <!-- Thông báo thông tin -->
    <?php if (getSession("info_course") != '') { ?>
    <div class='alert alert-info'>
        <strong><?php echo getSession("info_course"); ?></strong>
    </div>
    <?php }
    unset($_SESSION["info_course"]); ?>

    <!-- Thông báo lỗi -->
    <?php if (getSession("err_course") != '') { ?>
    <div class='alert alert-danger'>
        <strong><?php echo getSession("err_course"); ?></strong>
    </div>
    <?php }
    unset($_SESSION["err_course"]); ?>
    <!--  -->

    <div class="input-group mb-2">
        <span class="input-group-text">Tên bài học *</span>
        <input type="text" name="txtLessionName" value="<?php echo $dataLession["tenBaiHoc"] ?>" class="form-control">
    </div>
    <div class="input-group mb-2">
        <span class="input-group-text">Mô tả</span>
        <textarea name="txtLessionDescription" class="form-control" cols="30"
            rows="5"><?php echo $dataLession["moTa"] ?></textarea>
    </div>
    <div class="input-group mb-2">
        <span class="input-group-text">Ngày đăng tải *</span>
        <input type="date" title="tháng/ngày/năm" name="txtLessionDate"
            value="<?php echo $dataLession["ngayDangTai"] ?>" class="form-control">
    </div>
    <input class="btn btn-success" type="submit" name="btnEditLession" value="Sửa bài học">
</form>
<?php } ?>