<?php 
    class KhachHang extends Db{

        public function getAll(){
            return $this->select("select * from khachhang");
        }

        public function deleteSDT($id, $sdt){
        return $this->delete("DELETE FROM `khachhang_sdt` WHERE maKhachHang = ? and sdt = ?", array($id, $sdt));
        }

        public function setImage($image_name, $id){
        return $this->update("update khachhang set hinh = ? where maKhachHang = ?", array($image_name, $id));
        }

        public function insertSDT($id, $sdt){
        return $this->insert("INSERT INTO `khachhang_sdt`(`sdt`, `maKhachHang`) VALUES (?, ?)", array($sdt, $id));
        }

        public function updateCustomerSDT($id, $newSdt, $sdt){
        return $this->update("update `khachhang_sdt` set sdt = ? where maKhachHang = ? and sdt = ?", array($newSdt, $id, $sdt));
        }

        public function updateCustomer($id, $name, $passW){
        return $this->update("update khachhang set tenKhachHang = ?, passWord = ? where maKhachHang = ?", array($name, $passW, $id));
        }

        public function getAllSDT($id){
            return $this->select("select sdt from khachhang_sdt where maKhachHang = ?", array($id));
        }

        public function logOut(){
            if(getCookie("customer_sdt") != ''){
                setcookie("customer_sdt",'', time() - (86400 * 30), "/");
                unset($_COOKIE["customer_sdt"]);
            }
            if(getSession("customer_sdt") != ''){
                unset($_SESSION["customer_sdt"]);
            }
            
        }
       
        public function getCustomer($sdt){
            $sql = "SELECT khachhang.maKhachHang as ma, tenKhachHang as ten, passWord, hinh FROM `khachhang_sdt` inner join khachhang 
                where khachhang_sdt.maKhachHang = khachhang.maKhachHang and sdt = ?";
            $data = $this->select($sql, array($sdt));
            if($data != null){
            return $data[0];
            }
            return $data;
        }

        public function getAccount($passW, $sdt){
            $sql = "SELECT * FROM khachhang INNER join khachhang_sdt WHERE khachhang.maKhachHang = khachhang_sdt.maKhachHang and 
             passWord = ? and sdt = ?";
            return $this->select($sql, array($passW, $sdt));
        }

        public function checkAccountExistence($sdt){
            $sql = "SELECT * FROM khachhang INNER join khachhang_sdt WHERE khachhang.maKhachHang = khachhang_sdt.maKhachHang and 
             sdt = ?";
            $data = $this->select($sql, array($sdt));
            if($data != null){
                return true;
            }
            return false;
        }

        public function addCustomer($name, $passW, $sdt){
            $sql = "INSERT INTO `khachhang`(`tenKhachHang`, `passWord`) VALUES (?, ?);
            INSERT INTO `khachhang_sdt`(`maKhachHang`, `sdt`) VALUES ((SELECT MAX(maKhachHang) from khachhang), ?)";
            return $this->insert($sql, array($name, $passW, $sdt));
        }

        public function checkLogin(){
            if(getSession("customer_sdt") != ''){
                return true;
            }else if(getCookie("customer_sdt") != ''){
                $_SESSION["customer_sdt"] = getCookie("customer_sdt");
                return true;
            }
            return false;
        }
    }
?>