<?php
class SanPham extends Db
{

    public function getAll()
    {
        return $this->select("select * from sanpham where maKhoaHoc = ?");
    }
    public function getAllForShow($limit)
    {
        return $this->select("select * from sanpham limit " . $limit . ", " . KHOA_HOC_MOT_TRANG);
    }
    public function countCourses()
    {
        $count = $this->select("select count(maSanPham) as count from sanpham");
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
}
?>