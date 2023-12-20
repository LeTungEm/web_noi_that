<?php 
    class Admin extends Db{
        public function setPassWord($pW, $sdt, $id){
        return $this->select("update admin set passWord = ? where sdt = ? and maAdmin = ?", array($pW, $sdt, $id));
        }

        public function logOut(){
            if(getCookie("admin_sdt") != ''){
                setcookie("admin_sdt",'', time() - (86400 * 30), "/");
                unset($_COOKIE["admin_sdt"]);
            }
            if(getSession("admin_sdt") != ''){
                unset($_SESSION["admin_sdt"]);
            }
            
        }

        public function checkLogin(){
            if(getSession("admin_sdt") != ''){
                return true;
            }else if(getCookie("admin_sdt") != ''){
                $_SESSION["admin_sdt"] = getCookie("admin_sdt");
                return true;
            }
            return false;
        }

        public function getAccount($passW, $sdt){
            $sql = "SELECT * FROM `admin` WHERE passWord = ? and sdt = ?";
            return $this->select($sql, array($passW, $sdt));
        }

        public function getAdmin($sdt){
            $sql = "SELECT maAdmin as ma, tenAdmin as ten, passWord, hinh, sdt FROM `admin` where sdt = ?";
            $data = $this->select($sql, array($sdt));
            if($data != null){
                return $data[0];
            }
            return $data;
        }

    }
?>