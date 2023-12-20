<?php
class GioHang extends Db
{
    public function getAllByCusID($id)
    {
        return $this->select("select * from giohang left join sanpham on sanpham.maSanPham = giohang.maSanPham where giohang.maKhachHang = ?", array($id));
    }
    public function insertProductIntoCart($cusId, $proId, $quantity)
    {
        return $this->select("INSERT INTO `giohang`(`maKhachHang`, `maSanPham`, `soLuong`) VALUES (?,?,?)", array($cusId, $proId, $quantity));
    }
}
?>