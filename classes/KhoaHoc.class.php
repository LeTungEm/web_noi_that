<?php 
    class KhoaHoc extends Db{

        public function insertCourse($txtCourseName, $txtCoursePrice, $txtCourseDescription, $txtCourseDate){
        return $this->select("SELECT `AUTO_INCREMENT` as maxID FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'quanlybankhoahoc' AND TABLE_NAME = 'khoahoc';
        INSERT INTO `khoahoc`(`tenKhoaHoc`, `gia`, `moTa`, `ngayDangTai`) VALUES (?, ?, ?, ?);
        UPDATE `khoahoc` SET hinh = (select CONCAT(max(maKhoaHoc), '.png') from khoahoc) WHERE maKhoaHoc = (select max(maKhoaHoc) from khoahoc)", array($txtCourseName, $txtCoursePrice, $txtCourseDescription, $txtCourseDate));
        }

        public function updateCourse($txtCourseName, $txtCoursePrice, $txtCourseDescription, $txtCourseDate, $idCourse){
        return $this->update("update khoahoc set tenKhoaHoc = ? , gia = ? , moTa = ? , ngayDangTai = ? where maKhoaHoc = ?", array($txtCourseName, $txtCoursePrice, $txtCourseDescription, $txtCourseDate, $idCourse));
        }

        public function setImage($imageName, $idCourse){
        return $this->update("update khoahoc set hinh = ? where maKhoaHoc = ?", array($imageName, $idCourse));
        }

        public function deleteCourseByID($id){
        return $this->delete("DELETE FROM `khoahoc` WHERE maKhoaHoc = ?", array($id));
        }

        public function getOnRequest($date, $type, $role, $search){
            if($date != ''){
                $date = $date . "-1";
                $sql = "SELECT * from khoahoc where month(ngayDangTai) = month(?) and year(ngayDangTai) = year(?)";
                if($search != ''){
                    $search = "%" . $search . "%";
                    $sql .= " and tenKhoaHoc like ? ";
                    $sql .= " order by " . $type . " " . $role;
                    return $this->select($sql, array($date, $date, $search));
                }
                $sql .= " order by " . $type . " " . $role;
                return $this->select($sql, array($date, $date));
            }else{
                $sql = "SELECT * from khoahoc ";
                if($search != ''){
                    $search = "%" . $search . "%";
                    $sql .= "where tenKhoaHoc like ? ";
                    $sql .= " order by " . $type . " " . $role;
                    return $this->select($sql, array($search));
                }
                $sql .= " order by " . $type . " " . $role;
                return $this->select($sql);
            }
        }

        public function getAllOrderBySLBan($date, $role, $search){
            if($date != ''){
                $date = $date . "-1";
            $sql = "SELECT khoahoc.maKhoaHoc,`tenKhoaHoc`,`gia`,`moTa`,`ngayDangTai`, COALESCE(lan, 0) as lan FROM khoahoc LEFT JOIN (SELECT count(*) as lan, maKhoaHoc from muakhoahoc GROUP by muakhoahoc.maKhoaHoc) as b1 on khoahoc.maKhoaHoc = b1.maKhoaHoc where month(ngayDangTai) = month(?) and year(ngayDangTai) = year(?)";
                if($search != ''){
                    $search = "%" . $search . "%";
                    $sql .= " and tenKhoaHoc like ? ";
                    $sql .= " order by lan"." ".$role;
                    return $this->select($sql, array($date, $date, $search));
                }
                $sql .= " order by lan"." ".$role;
                return $this->select($sql, array($date, $date));
            }else{
            $sql = "SELECT khoahoc.maKhoaHoc,`tenKhoaHoc`,`gia`,`moTa`,`ngayDangTai`, COALESCE(lan, 0) as lan FROM khoahoc LEFT JOIN (SELECT count(*) as lan, maKhoaHoc from muakhoahoc GROUP by muakhoahoc.maKhoaHoc) as b1 on khoahoc.maKhoaHoc = b1.maKhoaHoc";
                if($search != ''){
                    $search = "%" . $search . "%";
                    $sql .= " where tenKhoaHoc like ? ";
                    $sql .= " order by lan"." ".$role;
                    return $this->select($sql, array($search));
                }
                $sql .= " order by lan"." ".$role;
                return $this->select($sql);
            }
        }

        public function getAll(){
        return $this->select("select * from khoahoc");
        }

        public function formatPrice($price){
            $length = strlen($price);
            $resuft = substr($price, 0, $length%3);
            for($i = strlen($resuft); $i < $length; $i += 3){
                if($i >0)
                    $resuft .= ".".substr($price, $i, 3);
                else
                    $resuft .= substr($price, $i, 3);
            }
            return $resuft;
        }

        public function formatDecsription($data){
            if (strlen($data) > STRLEN_MO_TA) {
                return substr($data, 0, STRLEN_MO_TA) . "...";
            }
        return $data;
        }

        public function countCourses(){
            $count = $this->select("select count(maKhoaHoc) as count from khoahoc");
            return $count[0]["count"];
        }
        
        public function getAllForShow($limit){
            return $this->select("select * from KhoaHoc limit ".$limit.", ".SAN_PHAM_MOT_TRANG);
        }

        public function getTopThreeBestSeller(){
            $muakhoahoc = new MuaKhoaHoc();
            $arr = $muakhoahoc->countEach();
            $top_lan_mua = array();
            foreach($arr as $lan){$top_lan_mua[] = $lan["lan"];}
            $str = implode($top_lan_mua,",");
            //Lấy thông tin khóa học
            return $this->select("SELECT * FROM khoahoc inner join muakhoahoc 
                where khoahoc.maKhoaHoc = muakhoahoc.maKhoaHoc GROUP BY muakhoahoc.maKhoaHoc HAVING COUNT(*) IN (".$str.") ORDER by count(*) DESC limit 10");
        }

        public function getCourseByName($name){
            $name = "%".$name."%";
            return $this->select("select * from KhoaHoc where tenKhoaHoc like ?",array($name));
        }

        public function getCourseByID($id){
            $data = $this->select("select * from KhoaHoc where maKhoaHoc = ?",array($id));
            if($data != null){
                return $data[0];
            }
        return $data;
        }
    } 
?>