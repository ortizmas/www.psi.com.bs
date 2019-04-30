<?php
class Enlaces extends ActiveRecord {
    protected function initialize()
	{
		$this->belongs_to('areas','idiomas');
		$this->validates_presence_of('enlaces_posicion', 'message: Debe seleccionar una <b>Posicion</b> !!!!');
    }

    public function enlacesMenu()
    {
        $sql = "SELECT * FROM enlaces WHERE posicion=posicion AND activo=1 GROUP BY posicion";
        return $this->find_all_by_sql($sql);
    }

    public function enlacesImagens()
    {
        /*$sql = "SELECT * FROM enlaces WHERE activo=1";
        return $this->find("conditions: activo=1");*/
        $sql = "SELECT *
                FROM enlaces e
                INNER JOIN portifolio p ON p.`id`=e.`portifolio_id`
                WHERE e.`activo`=1";
        return $this->find_all_by_sql($sql);
    }

    public function clientes()
    {
        //$sql = "SELECT * FROM enlaces WHERE activo=1";
        return $this->find("conditions: posicion='clientes' and activo=1");
    }

    public function propagandaAll($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM enlaces WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND posicion='propaganda' AND activo=1 ORDER BY id DESC";
        return $this->find_all_by_sql($sql);
    }

    public function propagandaTop($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM enlaces WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND posicion='propaganda-top' AND activo=1 ORDER BY id DESC";
        return $this->find_all_by_sql($sql);
    }
}

