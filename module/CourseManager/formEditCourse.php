<form method="post" enctype="multipart/form-data">
    <!-- Hiện ảnh đã có và chọn ảnh mới -->
    <img id="courseImage" src="./media/image/course/<?php echo $dataCourse["hinh"]; ?>" class="img-thumbnail"
        style="max-height: 150px;" alt="...">
    <br>
    <h5 id="labelImage"></h5>
    <label class="btn btn-default text-success fw-bolder">
        Chọn ảnh mới<input id="labelChooseFile" type="file" accept="image/*" hidden name="fileCourseImage">
    </label>
    <!-- Hiện ảnh ngay khi load -->
    <script>
    const fileUploader = document.querySelector("#labelChooseFile");
    const reader = new FileReader();

    fileUploader.addEventListener('change', (event) => {
        const files = event.target.files;
        const file = files[0];

        // Get the file object after upload and read the
        // data as URL binary string
        reader.readAsDataURL(file);

        // Once loaded, do something with the string
        reader.addEventListener('load', (event) => {
            // Here we are creating an image tag and adding
            // an image to it.
            const img = document.getElementById('courseImage');
            img.src = event.target.result;
            img.alt = file.name;
            document.getElementById("labelImage").innerHTML = file.name;
        });
    });
    </script>
    <!-- Thông báo thông tin -->
    <?php if(getSession("info_course") != ''){ ?>
    <div class='alert alert-info'>
        <strong><?php echo getSession("info_course"); ?></strong>
    </div>
    <?php } unset($_SESSION["info_course"]); ?>

    <!-- Thông báo lỗi -->
    <?php if(getSession("err_course") != ''){ ?>
    <div class='alert alert-danger'>
        <strong><?php echo getSession("err_course"); ?></strong>
    </div>
    <?php } unset($_SESSION["err_course"]); ?>
    <div class="input-group mb-2">
        <span class="input-group-text">Tên khóa học *</span>
        <input type="text" name="txtCourseName" value="<?php echo $dataCourse["tenKhoaHoc"] ?>" class="form-control">
    </div>
    <div class="input-group mb-2">
        <span class="input-group-text">Giá *</span>
        <input type="text" name="txtCoursePrice" value="<?php echo $dataCourse["gia"] ?>" class="form-control">
    </div>
    <div class="input-group mb-2">
        <span class="input-group-text">Mô tả</span>
        <textarea name="txtCourseDescription" class="form-control" cols="30"
            rows="5"><?php echo $dataCourse["moTa"] ?></textarea>
    </div>
    <div class="input-group mb-2">
        <span class="input-group-text">Ngày đăng tải *</span>

        <input type="date" title="tháng/ngày/năm" name="txtCourseDate" value="<?php echo $dataCourse["ngayDangTai"] ?>"
            class="form-control">
    </div>
    <input class="btn btn-success" type="submit" name="btnEditCourse" value="Sửa thông tin">
</form>