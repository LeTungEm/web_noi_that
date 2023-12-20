<div class="container" style="max-width: 100%;">
    <div class="row" style="width: 100%; margin-left: 0px;">
        <div class="col-lg-9 col-md-9 col-sm-12 pdm-No text-center bg-primary">
            <?php 
                if(getIndex("mod") == ''){
                    include("module/CustomerInfomation/showInfomation.php");
                }else if(getIndex("mod") == "edit"){
                    if($customer->checkLogin()){
                        include("module/CustomerInfomation/editInfomation.php");
                    }
                }
            ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 pdm-No text-center bg-primary">
            <ul class="list-group my-2">
                <?php if($customer->checkLogin()){ ?>
                <li class="list-group-item list-group-item-action"><a class="fw-bolder text-black" href="?action=account_infomation&mod=edit">Sửa thông tin</a></li>
                <?php } ?>
                <li class="list-group-item list-group-item-action"><a class="fw-bolder text-black" href="?<?php if (getIndex("mod") != '') {
                    echo "action=account_infomation";
                } else {
                    echo "action=home";} ?>">Thoát</a></li>
            </ul>
        </div>
    </div>
</div>