<?php
class Portifolio extends ActiveRecord {
    protected function initialize($pag= 0, $ppage = 5)
	{
        $this->validates_uniqueness_of('menu', 'message: Este <b>MENU</b> já está sendo utilizada');

    }

    public function PortifolioNomes()
    {
        /*$sql = "SELECT * FROM enlaces WHERE posicion=posicion AND activo=1 GROUP BY posicion";
        return $this->find_all_by_sql($sql);*/
        return $this->find("conditions: activo= 1","order: id desc");
    }

}

