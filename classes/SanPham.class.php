<?php
class SanPham extends Db
{

    public function getAll()
    {
        return $this->select("select * from sanpham");
    }
    public function getAllForShow($limit)
    {
        return $this->select("select * from sanpham limit " . $limit . ", " . SAN_PHAM_MOT_TRANG);
    }
    public function countProduct()
    {
        $count = $this->select("select count(maSanPham) as count from sanpham");
        return $count[0]["count"];
    }
    public function getAllForShowFilter($typeId, $brandId, $search, $limit)
    {
        $search = "%" . $search . "%";
        $sql = "select * from sanpham ";
        $params = array();
        if ($typeId != 0 && $brandId != 0) {
            $sql .= "where maHang = ? and maLoai = ? and tenSanPham like ?";
            $params = array($brandId, $typeId, $search);
        } else if ($typeId != 0) {
            $sql .= "where maLoai = ? and tenSanPham like ?";
            $params = array($typeId, $search);
        } else if ($brandId != 0) {
            $sql .= "where maHang = ? and tenSanPham like ?";
            $params = array($brandId, $search);
        } else {
            $sql .= "where tenSanPham like ?";
            $params = array($search);
        }
        $sql .= " limit " . $limit . ", " . SAN_PHAM_MOT_TRANG;
        return $this->select($sql, $params);
    }
    public function countProductFilter($typeId, $brandId, $search)
    {
        $search = "%" . $search . "%";
        $sql = "select count(maSanPham) as count from sanpham ";
        $params = array();
        if ($typeId != 0 && $brandId != 0) {
            $sql .= "where maHang = ? and maLoai = ? and tenSanPham like ?";
            $params = array($brandId, $typeId, $search);
        } else if ($typeId != 0) {
            $sql .= "where maLoai = ? and tenSanPham like ?";
            $params = array($typeId, $search);
        } else if ($brandId != 0) {
            $sql .= "where maHang = ? and tenSanPham like ?";
            $params = array($brandId, $search);
        } else {
            $sql .= "where tenSanPham like ?";
            $params = array($search);
        }
        $count = $this->select($sql, $params);
        return $count[0]["count"];
    }
    public function formatPrice($price)
    {
        $length = strlen($price);
        $resuft = substr($price, 0, $length % 3);
        for ($i = strlen($resuft); $i < $length; $i += 3) {
            if ($i > 0)
                $resuft .= "." . substr($price, $i, 3);
            else
                $resuft .= substr($price, $i, 3);
        }
        return $resuft;
    }
    public function getProductByName($name)
    {
        $name = "%" . $name . "%";
        return $this->select("select * from sanpham where tenSanPham like ?", array($name));
    }

    public function getSanPhamByID($id)
    {
        $data = $this->select("select `maSanPham`, `tenSanPham`, `gia`, `giaMoi`, sanpham.`moTa`, sanpham.`maLoai`, sanpham.`maHang`, `hinh`, `ngayTao`, loaisanpham.`tenLoai`, hang.`tenHang` from sanpham left join loaisanpham on sanpham.maLoai = loaisanpham.maLoai left join hang on hang.maHang = sanpham.maHang where maSanPham = ?", array($id));
        if ($data != null) {
            return $data[0];
        }
        return $data;
    }
    public function filterSanPham($typeId, $brandId, $search)
    {
        $search = "%" . $search . "%";
        $sql = "select * from sanpham ";
        $params = array();
        if ($typeId != 0 && $brandId != 0) {
            $sql .= "where maHang = ? and maLoai = ? and tenSanPham like ?";
            $params = array($brandId, $typeId, $search);
        } else if ($typeId != 0) {
            $sql .= "where maLoai = ? and tenSanPham like ?";
            $params = array($typeId, $search);
        } else if ($brandId != 0) {
            $sql .= "where maHang = ? and tenSanPham like ?";
            $params = array($brandId, $search);
        }else{
            $sql .= "where tenSanPham like ?";
            $params = array($search);
        }
        return $this->select($sql, $params);

    }
    public function deleteSanPhamByID($id)
    {
        $count = $this->delete("DELETE FROM `sanpham` WHERE `maSanPham` = ?", array($id));
        return $count > 0 ? true : false;
    }
    public function insertSanPham($tenSanPham, $gia, $giaMoi, $moTa, $maLoai, $maHang, $hinh)
    {
        return $this->insert("INSERT INTO `sanpham`(`tenSanPham`, `gia`, `giaMoi`, `moTa`, `maLoai`, `maHang`, `hinh`) VALUES (?,?,?,?,?,?,?);", array($tenSanPham, $gia, $giaMoi, $moTa, $maLoai, $maHang, $hinh));
    }
    public function updateSanPham($tenSanPham, $gia, $giaMoi, $moTa, $maLoai, $maHang, $maSanPham)
    {
        return $this->update("UPDATE `sanpham` SET `tenSanPham`= ?,`gia`= ?,`giaMoi`= ?,`moTa`= ?,`maLoai`= ?,`maHang`= ? WHERE `maSanPham` = ?;", array($tenSanPham, $gia, $giaMoi, $moTa, $maLoai, $maHang, $maSanPham));
    }

}
?>