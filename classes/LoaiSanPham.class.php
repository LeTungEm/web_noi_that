<?php
class SanPham extends Db
{

    public function getAll()
    {
        return $this->select("select * from sanpham where maKhoaHoc = ?");
    }
}
?>