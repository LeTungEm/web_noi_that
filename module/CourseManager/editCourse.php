<?php
$idCourse = getIndex("idCourse");
$idLessionEdit = getIndex("idLession");
if ($idCourse != '' || $idLessionEdit != '') {

    // Xử lý update Khóa học
    $flag = true;
    if(postIndex("btnEditCourse") != ''){
        $txtCourseName = postIndex("txtCourseName");
        $txtCoursePrice = postIndex("txtCoursePrice");
        $txtCourseDescription = postIndex("txtCourseDescription");
        $txtCourseDate = postIndex("txtCourseDate");
        $image = (isset($_FILES["fileCourseImage"])) ? $_FILES["fileCourseImage"] : "";

        if(strlen($txtCourseName) == 0 || strlen($txtCoursePrice) == 0 || strlen($txtCourseDate) == 0){
            $_SESSION["err_course"] = "Hãy nhập thông tin các trường bắt buộc * ";
            $flag = false;
        }else{
            // Sửa thông tin khóa học
            $rowUpdate = $course->updateCourse($txtCourseName, $txtCoursePrice, $txtCourseDescription, $txtCourseDate, $idCourse);
            if($rowUpdate > 0){
                $_SESSION["info_course"] = "Sửa thông tin thành công";
            }

            // update ảnh
            if($image["size"] > 0 && $flag == true){
                $arrImg = array("image/png", "image/jpeg", "image/bmp");
                $err = '';
                $errFile = $image["error"];
                if ($errFile>0)
                    $err .="Lỗi hình ảnh!";
                else
                {
                    $type = $image["type"];
                    if (!in_array($type, $arrImg))
                        $err .="Chỉ được chọn ảnh cho khóa học";
                    else
                    {	$temp = $image["tmp_name"];
                        $imageName = $idCourse.".png";
                        if (!move_uploaded_file($temp, "media/image/course/".$imageName))
                            $err .="Đổi ảnh thất bại";
                        
                    }
                }
                if($err != ''){
                    $_SESSION["err_course"] = $err;
                }else{
                    $course->setImage($imageName, $idCourse);
                }
            }
        }
        

        
    }


    // xử lý thêm bài học
    if(isset($_POST["btnAddLesion"])){
        $lessionName = trim(postIndex("lessionName"));
        $lessionDescription = postIndex("lessionDescription");
        $lessionDate = postIndex("lessionDate");
        $lessionVideo = (isset($_FILES["lessionVideo"])) ? $_FILES["lessionVideo"] : "";
        $idNewLession = "";

        $nameLession = $lession->getByName($lessionName);
        if($nameLession != null){
            $_SESSION["err_lession"] = "Tên bài học đã tồn tại";
        }else{
            if(strlen($lessionName) == 0 || strlen($lessionDate) == 0){
                $_SESSION["err_lession"] = "Hãy nhập thông tin các trường bắt buộc * ";
            }else{
                $idNewLession = $lession->insertLession($lessionName, $lessionDescription, $lessionDate, $idCourse);
                $idNewLession = ($idNewLession != null) ? $idNewLession[0]["maxID"] : "";
                $_SESSION["info_lession"] = "Đã thêm bài học " . $lessionName;
    
                // upload video
                if($lessionVideo["size"] > 0 && $lessionVideo["size"] <= (50*1024*1024) && $idNewLession != ""){
                    $lesionVideoName = $idNewLession . ".mp4";
                    if (move_uploaded_file($lessionVideo["tmp_name"], "media/video/lession/".$lesionVideoName)){
                        $lession->setLink($lesionVideoName, $idNewLession);
                    }
                }else{
                    if($lessionVideo["size"] > (10*1024*1024))
                        $_SESSION["err_lession"] = "File vừa chọn quá lớn";
                }
            }
        }

        
    }


    // Xử lý xóa bài học
    if(postIndex("btnDeleteLession") != ''){
        $idLession = postIndex("idLession");
        if($lession->deleteByLessionID($idLession) > 0){
            $path = "media/video/lession/" . $idLession . ".mp4";
            (file_exists($path) && is_file($path))?unlink($path):"";
            $_SESSION["info_lession"] = "Đã xóa bài học mã " . $idLession;
            echo '<meta http-equiv="refresh" content="0,url=index.php?action=course_manager&mod=editCourse&idCourse='.$idCourse.'">';
        }
    }


    // Lấy dữ liệu khóa học
    $dataCourse = $course->getCourseByID($idCourse);
    if($dataCourse == null){
        exit;
    }  
?>
<div style="height: 100%" class="scrollVer">
    <div class="container text-center p-0 rounded" style="max-width: 100%">
        <div class="row my-3">
            <div class="col-lg-6 col-md-6 pdm-No text-center">
                <ul class="list-group">
                    <li class="list-group-item">
                        <h3><a href="?action=course_manager&mod=editCourse&idCourse=<?php echo $idCourse; ?>"
                                class="text-black"><?php echo $dataCourse["tenKhoaHoc"]; ?></a></h3>
                    </li>
                    <li class="list-group-item">
                        <?php
                            if(getIndex("mod") == "editLession"){
                                include("module/CourseManager/formEditLession.php");
                            }else{
                                include("module/CourseManager/formEditCourse.php");
                            }
                        ?>
                    </li>
                </ul>
            </div>
            <div id="qlkh_listLession" class="col-lg-6 col-md-6 pdm-No text-center scrollVer">
                <script>
                var div_lession = document.getElementById("qlkh_listLession");
                var length = document.documentElement.clientHeight - 25;
                div_lession.style.height = length + "px";
                </script>
                <!-- Danh sách bài học -->
                <ul class="list-group">
                    <li class="list-group-item">
                        <h4>Danh sách bài học</h5>
                    </li>
                    <!-- Thông báo lỗi -->
                    <?php if(getSession("err_lession") != ''){ ?>
                    <div class='alert alert-danger'>
                        <strong><?php echo getSession("err_lession"); ?></strong>
                    </div>
                    <?php } unset($_SESSION["err_lession"]); ?>
                    <!-- Thông báo thông tin -->
                    <?php if(getSession("info_lession") != ''){ ?>
                    <div class='alert alert-info'>
                        <strong><?php echo getSession("info_lession"); ?></strong>
                    </div>
                    <?php } unset($_SESSION["info_lession"]); ?>
                    <li class="list-group-item">
                        <!-- form thêm bài học -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col col-lg-1 col-12 mb-1 fw-bolder">
                                    <!-- icon thêm bài học -->
                                    <label for="qlcourse_addLession" class="d-flex my-1">
                                        <i class="material-icons text-success" style="font-size:36px">
                                            add_circle
                                        </i>
                                    </label>
                                </div>
                                <input hidden type="checkbox" id="qlcourse_addLession">
                                <div hidden class="col col-lg-12 col-12 mb-1 fw-bolder">
                                    <!-- Thêm video -->
                                    <input hidden type='file' name="lessionVideo" accept="video/mp4" id='videoUpload' />

                                    <video class="img-thumbnail" style="max-height: 150px; display: none" width="320"
                                        height="240" controls></video>
                                    <label id="labelLessionVideo" for="videoUpload"
                                        class="btn btn-default text-success fw-bolder"> Chọn video</label>

                                    <script>
                                    document.getElementById("videoUpload")
                                        .onchange = function(event) {
                                            let file = event.target.files[0];
                                            let blobURL = URL.createObjectURL(file);
                                            document.querySelector("video").src = blobURL;
                                            document.querySelector("video").style.display = "unset";
                                        }
                                    </script>
                                </div>
                                <div hidden class="col col-lg-12 col-12 mb-1 fw-bolder">
                                    <input class="form-control" placeholder="Nhập tên *..." type="text"
                                        name="lessionName">
                                </div>
                                <div hidden class="col col-lg-12 col-12 mb-1 fw-bolder">
                                    <input class="form-control" placeholder="Mô tả..." type="text"
                                        name="lessionDescription">
                                </div>
                                <div hidden class="col col-lg-12 col-12 mb-1 fw-bolder">
                                    <input class="form-control" value="<?php echo date("Y-m-d",getdate()[0]); ?>"
                                        type="date" name="lessionDate">
                                </div>
                                <div hidden class="col col-lg-12 col-12 mb-1 fw-bolder">
                                    <input type="submit" name="btnAddLesion" class="btn btn-success fw-bolder"
                                        value="Thêm">
                                </div>
                            </div>
                        </form>
                    </li>
                    <li class="list-group-item">
                        <!-- Tên cột -->
                        <div class="row courses-info">
                            <div class="col col-1 fw-bolder">Mã</div>
                            <div class="col col-9 fw-bolder">Tên bài học</div>
                            <div class="col col-2 fw-bolder">&nbsp;</div>
                        </div>
                    </li>
                    <?php
                        $listLession = $lession->getAll($idCourse);
                        foreach($listLession as $row){
                    ?>
                    <li class="list-group-item">
                        <div class="row courses-info">
                            <div class="col col-1"><?php echo $row["maBaiHoc"]; ?></div>
                            <div class="col col-9 text-start"><?php echo $row["tenBaiHoc"]; ?></div>
                            <div class="col col-2 d-flex">
                                <!-- Button trigger modal -->
                                <i class="material-icons" onclick="deleteMessage(<?php echo $row['maBaiHoc']; ?>)"
                                    data-bs-toggle="modal" data-bs-target="#modelDeleteLession" data-toggle="tooltip"
                                    title="Xóa" style="cursor: pointer;"
                                    style="font-size: 20px; cursor: pointer;">delete</i>
                                <a href="?action=course_manager&mod=editLession&idCourse=<?php echo $idCourse; ?>&idLession=<?php echo $row["maBaiHoc"]; ?>"
                                    class="text-black"><i style="font-size:20px" data-toggle="tooltip" title="Chỉnh sửa"
                                        style="cursor: pointer;" class="fa">&#xf044;</i></a>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelDeleteLession" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc muốn xóa bài học này
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form method="post">
                    <input id="idLession" hidden type="text" name="idLession" value="">
                    <input name="btnDeleteLession" type="submit" value="Xóa bài học" class="btn btn-primary">
                </form>

            </div>
        </div>
    </div>
</div>

<script>
// Lấy id qua sự kiện click
function deleteMessage(id) {
    document.getElementById("idLession").value = id;
}
</script>

<style>
#qlcourse_addLession:checked~.col {
    display: block !important;
}

i {
    cursor: pointer;
}

i:hover {
    color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity));
}
</style>
<?php } ?>