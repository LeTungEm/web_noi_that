<?php
class LoaiSanPham extends Db
{

    public function getAll()
    {
        return $this->select("select * from loaisanpham");
    }
}
?>