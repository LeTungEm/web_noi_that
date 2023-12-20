<?php 
    class MuaKhoaHoc extends Db{

        public function buyCourse($cusID, $courseID){
        $this->insert("INSERT INTO `muakhoahoc`(`maKhachHang`, `maKhoaHoc`) VALUES (?, ?)", array($cusID, $courseID));
        }

        public function countByCustomerID($cusID){
        $data = $this->select("select count(*) as lan from muakhoahoc where maKhachHang = ?", array($cusID));
        return ($data != null) ? $data[0]["lan"] : $data;
        }

        public function getCourseByCustomerID($cusID, $limit){
        return $this->select("select * from muakhoahoc inner join khoahoc where muakhoahoc.maKhoaHoc = khoahoc.maKhoaHoc and maKhachHang = ? limit ".$limit.", ".KHOA_HOC_MOT_TRANG, array($cusID));
        }

        public function checkPurchasedCourseByCustomerID($cusID, $courseID){
        $data = $this->select("select maKhoaHoc from muakhoahoc where maKhachHang = ? and maKhoaHoc = ?", array($cusID, $courseID));
        if($data == null){
            return false;
        }
        return true; 
        }

        public function countEach(){
            return $this->select("select DISTINCT count(*) as lan from muakhoahoc
            GROUP by maKhoaHoc
            ORDER by count(*) DESC
            limit ".TOP_SELLER);
        }

        public function countByCourseId($id){
            return $this->select("select count(maKhoaHoc) as lanmua from muaKhoahoc where maKhoaHoc = ?", array($id))[0];
        }
    }
?>