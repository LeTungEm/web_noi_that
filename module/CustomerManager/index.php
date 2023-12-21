<div style="height: 100%" class="scrollVer">
    <div class="container bg-light text-center my-2 p-0 rounded" style="max-width: 100%">
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row customer-info">
                    <div class="col col-2 fw-bolder">Mã Khách hàng</div>
                    <div class="col col-3 fw-bolder">Tên khách hàng</div>
                    <div class="col col-2 fw-bolder">Hình</div>
                    <div class="col col-2 fw-bolder">SDT</div>
                    <div class="col col-3 fw-bolder">&nbsp;</div>
                </div>
            </li>
            <?php 
        $listCustomer = $customer->getAll();
        foreach($listCustomer as $data){ ?>
            <li class="list-group-item">
                <div class="row customer-info">
                    <div class="col col-2"><?php echo $data["maKhachHang"]; ?></div>
                    <div class="col col-3"><?php echo $data["tenKhachHang"]; ?></div>
                    <div class="col col-2">
                        <img src="./media/image/user/<?php
                        if ($data["hinh"] != null) {
                            echo $data["hinh"];
                        } else {
                            echo "default.png";} ?>" class="img-thumbnail" style="max-height: 50px;" alt="...">
                    </div>
                    <div class="col col-2 fw-bolder">
                        <?php
                            $listSDT = $customer->getAllSDT($data["maKhachHang"]);
                            foreach($listSDT as $sdt){
                            echo "<br>".$sdt["sdt"];
                            }
                        ?>
                    </div>
                    <div class="col col-3">
                        <!-- <i class="material-icons me-3" data-toggle="tooltip" title="Khóa tài khoản">&#xe14b;</i>
                        <i style="font-size:24px" data-toggle="tooltip" title="Chỉnh sửa" style="cursor: pointer;"
                            class="fa">&#xf044;</i> -->
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>



<style>
i {
    cursor: pointer;
}

i:hover {
    color: darkgray;
}
</style>