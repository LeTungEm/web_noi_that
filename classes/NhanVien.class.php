<?php 
    class NhanVien extends Db{

        public function getAllSDT($id){
            return $this->select("select sdt from nhanvien_sdt where maNhanVien = ?", array($id));
        }

        public function logOut(){
            if(getCookie("employee_sdt") != ''){
                setcookie("employee_sdt",'', time() - (86400 * 30), "/");
                unset($_COOKIE["employee_sdt"]);
            }
            if(getSession("employee_sdt") != ''){
                unset($_SESSION["employee_sdt"]);
            }
            
        }

        public function getEmployee($sdt){
            $sql = "SELECT NhanVien.maNhanVien as ma, tenNhanVien as ten, passWord, hinh FROM `NhanVien_sdt` inner join NhanVien 
                where NhanVien_sdt.maNhanVien = NhanVien.maNhanVien and sdt = ?";
            $data = $this->select($sql, array($sdt));
            if($data != null){
                return $data[0];
            }
            return $data;
        }

        public function getAccount($passW, $sdt){
            $sql = "SELECT * FROM nhanvien INNER join nhanvien_sdt WHERE nhanvien.maNhanVien = nhanvien_sdt.maNhanVien
            and passWord = ? and sdt = ?";
            return $this->select($sql, array($passW, $sdt));
        }

        public function checkLogin(){
            if(getSession("employee_sdt") != ''){
                return true;
            }else if(getCookie("employee_sdt") != ''){
                $_SESSION["employee_sdt"] = getCookie("employee_sdt");
                return true;
            }
            return false;
        }
    }
?>