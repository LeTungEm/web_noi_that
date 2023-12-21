<?php
class Hang extends Db
{

    public function getAll()
    {
        return $this->select("select * from hang");
    }
}
?>