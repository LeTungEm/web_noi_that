<?php
    if(postIndex("btnAddCourse") != ''){
        $courseName = postIndex("courseName");
        $coursePrice = postIndex("coursePrice");
        $courseDescription = postIndex("courseDescription");
        $courseDate = postIndex("courseDate");
        $courseImage = (isset($_FILES["courseImage"])) ? $_FILES["courseImage"] : "";

        if(strlen($courseName) == 0 || strlen($coursePrice) == 0 || strlen($courseDate) == 0){
            $_SESSION["err"] = "Hãy điền thông tin vào các trường bắt buộc *";
        }else{
            $idNewCourse = $course->insertCourse($courseName, $coursePrice, $courseDescription, $courseDate);
            if($idNewCourse > 0){
                $idNewCourse = ($idNewCourse != null)?($idNewCourse[0]["maxID"]):"";
                $_SESSION["info"] = "Đã thêm khóa học " . $courseName;
            }

            // Lưu ảnh
            if($courseImage != '' && $courseImage["size"] > 0){
                if (!move_uploaded_file($courseImage["tmp_name"], "media/image/course/".$idNewCourse.".png")){
                    $_SESSION["err"] = "Không thể lưu ảnh!!!!";
                }
            }else{
                //Xử lý nếu không có ảnh
            }
        }
    }

    if(postIndex("btnDeleteCourse") != ''){
        $idCourse = postIndex("idCourse");
        if($purchasedCourse->countByCourseId($idCourse)["lanmua"] == 0){
            // Xóa video bài học của khóa này
            $listDeleteLession = $lession->getAll($idCourse);
            foreach($listDeleteLession as $lessonData){
                $path = "media/video/lession/".$lessonData['link'];
                (file_exists($path) && is_file($path))?unlink($path):"";
            }
            // xóa bài học
            $lession->deleteByCourseID($idCourse);
            $linkImage = $course->getCourseByID($idCourse)["hinh"];
            if($course->deleteCourseByID($idCourse) > 0){
                // Xóa ảnh khóa học vừa xóa
                $path = "media/image/course/$linkImage";
                (file_exists($path) && is_file($path))?unlink($path):"";
                $_SESSION["info"] = "Đã xóa khóa học mã " . $idCourse;
            }
        }else{
            $_SESSION["err"] = "Không thể xóa Khóa học đã được mua!!!!";
        }
    }
?>
<div style="height: 100%" class="scrollVer">
    <form method="post" action="?action=course_manager">
        <ul class="list-group text-start my-2">
            <li class="list-group-item">
                <!-- Thông báo lỗi -->
                <?php if(getSession("err") != ''){ ?>
                <div class='alert alert-danger'>
                    <strong><?php echo getSession("err"); ?></strong>
                </div>
                <?php } unset($_SESSION["err"]); ?>
                <!-- Thông báo thông tin -->
                <?php if(getSession("info") != ''){ ?>
                <div class='alert alert-info'>
                    <strong><?php echo getSession("info"); ?></strong>
                </div>
                <?php } unset($_SESSION["info"]); ?>
            </li>
            <li class="list-group-item">
                <!-- form lọc thông tin -->
                <div>
                    <b class="me-1">CHỌN Tháng - Năm</b>
                    <input class="btn border-success" type="month" name="date" id="date">
                </div>
                <div class="input-group my-2">
                    <label class="input-group-text" for="type">Sắp xếp theo</label>
                    <select class="form-select" id="type" name="type">
                        <option selected value="mkh">Mã khóa học</option>
                        <option value="tkh">Tên khóa học</option>
                        <option value="g">Giá</option>
                        <option value="ndt">Ngày đăng tải</option>
                        <option value="slb">Số lượng đã bán</option>
                    </select>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" checked name="role" type="radio" id="asc" value="1">
                    <label class="form-check-label" for="asc">Tăng dần dữ liệu</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="role" type="radio" id="desc" value="0">
                    <label class="form-check-label" for="desc">Giảm dần dữ liệu</label>
                </div>
                <input class="btn btn-success" value="Lọc dữ liệu" type="submit" name="btnSubmit">
            </li>
            <li class="list-group-item d-flex">
                <input class="form-control me-3" name="search" type="search" placeholder="Tìm khóa học"
                    aria-label="Search">
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
                            <label for="qlcourse_cbControl" class="d-flex my-1">
                                <i class="material-icons text-success" style="font-size:36px">
                                    add_circle
                                </i>
                            </label>
                        </div>
                        <input hidden type="checkbox" id="qlcourse_cbControl">
                        <div hidden class="col col-lg-2 col-12 mb-1 fw-bolder"><input class="form-control"
                                placeholder="Nhập tên *..." type="text" name="courseName"></div>
                        <div hidden class="col col-lg-2 col-12 mb-1 fw-bolder"><input class="form-control"
                                placeholder="Nhập giá *..." type="number" name="coursePrice"></div>
                        <div hidden class="col col-lg-2 col-12 mb-1 fw-bolder"><input class="form-control"
                                placeholder="Mô tả..." type="text" name="courseDescription"></div>
                        <div hidden class="col col-lg-2 col-12 mb-1 fw-bolder"><input class="form-control" type="date"
                                value="<?php echo date("Y-m-d",getdate()[0]); ?>" name="courseDate"></div>
                        <div hidden class="col col-lg-3 col-12 mb-1">
                            <label id="labelCourseImage" for="formAdd_courseImage"
                                class="btn btn-default text-success fw-bolder"> Chọn ảnh</label>
                            <input hidden accept="image/*" type="file" name="courseImage" id="formAdd_courseImage">
                            <script>
                            document.getElementById("formAdd_courseImage")
                                .onchange = function(event) {
                                    document.getElementById("labelCourseImage").innerText = event.target.files[0].name;
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
                    <div class="col col-2 fw-bolder">Tên khóa học</div>
                    <div class="col col-2 fw-bolder">Giá</div>
                    <div class="col col-2 fw-bolder">Mô tả</div>
                    <div class="col col-2 fw-bolder">Ngày đăng tải</div>
                    <div class="col col-2 fw-bolder">Đã bán</div>
                    <div class="col col-1 fw-bolder">&nbsp;</div>
                </div>
            </li>
            <?php 
        if(isset($_POST["btnSubmit"])){
            // Xử lý lọc khóa học
            $role = (postIndex("role") == '1')? "ASC":"DESC";
            $arrType = array("maKhoaHoc" => "mkh", "tenKhoaHoc" => "tkh", "gia" => "g", "ngayDangTai" => "ndt");
            $type = (postIndex("type") != 'slb')?array_keys($arrType,postIndex("type"))[0]:"";
            if (postIndex("type") == 'slb') {
                $listCourse = $course->getAllOrderBySLBan(postIndex("date") ,$role, postIndex("search"));
            }else{
                $listCourse = $course->getOnRequest(postIndex("date"), $type, $role, postIndex("search"));
            }
        }else{
            $listCourse = $course->getAll();
        }
        foreach($listCourse as $data){ ?>
            <!-- Hiện danh sách khóa học -->
            <li class="list-group-item">
                <div class="row courses-info">
                    <div class="col col-1"><?php echo $data["maKhoaHoc"]; ?></div>
                    <div class="col col-2"><?php echo $data["tenKhoaHoc"]; ?></div>
                    <div class="col col-2"><?php echo $course->formatPrice($data["gia"]); ?></div>
                    <div class="col col-2"><?php echo $course->formatDecsription($data["moTa"]); ?></div>
                    <div class="col col-2"><?php echo $data["ngayDangTai"]; ?></div>
                    <div class="col col-2">
                        <?php echo $purchasedCourse->countByCourseId($data["maKhoaHoc"])["lanmua"]; ?>
                    </div>
                    <div class="col col-1">
                        <!-- Button trigger modal -->
                        <i class="material-icons" onclick="deleteMessage(<?php echo $data['maKhoaHoc']; ?>)"
                            data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" title="Xóa"
                            style="cursor: pointer;" style="font-size: 24px; cursor: pointer;">delete</i>
                        <a href="?action=course_manager&mod=editCourse&idCourse=<?php echo $data["maKhoaHoc"]; ?>"
                            class="text-black"><i style="font-size:24px" data-toggle="tooltip" title="Chỉnh sửa"
                                style="cursor: pointer;" class="fa">&#xf044;</i></a>
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
                Bạn có chắc muốn xóa khóa học này
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form method="post">
                    <input id="idCourse" hidden type="text" name="idCourse" value="">
                    <input name="btnDeleteCourse" type="submit" value="Xóa khóa học" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Lấy id qua sự kiện click
function deleteMessage(id) {
    document.getElementById("idCourse").value = id;
}
</script>
<style>
i {
    cursor: pointer;
}

#qlcourse_cbControl:checked~.col {
    display: block !important;
}

i:hover {
    color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity));
}

.courses-info .col i {
    display: flex;
}
</style>