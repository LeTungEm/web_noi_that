<?php 
    class BaiHoc extends Db{

        public function getByName($name){
        return $this->select("select * from baihoc where tenBaiHoc = ?", array($name));
        }

        public function updateLession($name, $description, $date, $lessionID){
        return $this->update("update baihoc set tenBaiHoc = ?, moTa = ?, ngayDangTai = ? where maBaiHoc = ?", array($name, $description, $date, $lessionID));
        }

        public function getByLessionID($idLession){
            $data = $this->select("select * from baihoc where maBaiHoc = ?", array($idLession));
            if($data != null){
                return $data[0];
            }
            return $data;
        }

        public function setLink($link, $idLession){
        return $this->update("update baihoc set link = ? where maBaiHoc = ?", array($link, $idLession));
        }

        public function insertLession($name, $description, $date, $idCourse){
        return $this->select("SELECT `AUTO_INCREMENT` as maxID FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'quanlybankhoahoc' AND TABLE_NAME = 'baihoc';
        INSERT INTO `baihoc`(`tenBaiHoc`, `moTa`, `ngayDangTai`, `maKhoaHoc`) VALUES (?, ?, ?, ?)", array($name, $description, $date, $idCourse));
        }

        public function deleteByLessionID($idLession){
            return $this->delete("delete from baihoc where maBaiHoc = ?", array($idLession));
        }

        public function deleteByCourseID($idCourse){
        return $this->delete("delete from baihoc where maKhoaHoc = ?", array($idCourse));
        }

        public function getOneLessionByCourseID($courseID){
            $data = $this->select("select * from baihoc where maKhoaHoc = ? limit 1", array($courseID));
            if($data != null){
                return $data[0];
            }
            return $data;
        }

        public function getAll($courseID){
            return $this->select("select * from baihoc where maKhoaHoc = ?", array($courseID));
        }
    }
?>