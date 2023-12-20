<?php
class GioHang extends Db
{
    public function getAllByCusID($id)
    {
        return $this->select("select * from giohang left join sanpham on sanpham.maSanPham = giohang.maSanPham where giohang.maKhachHang = ?", array($id));
    }
    public function insertProductIntoCart($cusId, $proId, $quantity)
    {
        return $this->insert("INSERT INTO `giohang`(`maKhachHang`, `maSanPham`, `soLuong`) VALUES (?,?,?)", array($cusId, $proId, $quantity));
    }
    public function isProductInCart($cusId, $proId)
    {
        $count = $this->select("select count(*) as count from giohang where maKhachHang = ? and maSanPham = ?", array($cusId, $proId));
        return $count[0]["count"] > 0 ? true : false;
    }
    public function updateQuantity($quantity, $cusId, $proId)
    {
        return $this->update("UPDATE `giohang` SET `soLuong`= `soLuong` + ? WHERE maKhachHang = ? and maSanPham = ?", array($quantity, $cusId, $proId));
    }
}
?>