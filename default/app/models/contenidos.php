<?php
class Contenidos extends ActiveRecord {
    protected function initialize()
    {
        $this->belongs_to('contenidosmenu','idiomas','usuarios');
    }
    
    protected function before_save()
    {
        //if (Auth::get('master')=='0') {
        $this->site_id= 1 /*Session::get('SITEID')*/;
        //} 
    }
    
    /**
     * Guarda los datos de un usuario, y los roles que va a poseer
     * @param array $data datos que se enviaron del form
     * @return boolean retorna TRUE si se pudieron guardar los datos con exito
     */
    public function guardar($data)
    {
        $this->begin();

        if (!$this->save($data)) {
            $this->rollback();
            return FALSE;
        }
        $this->commit();
        return TRUE;
    }

    /**
     * 
     * @param type $sitio_id
     * @return type
     */
    public function buscar($sitio_id){
        return $this->find("conditions: areas_id = $sitio_id");
    }

    public function sobreNos()
    {
        //$usuario = Load::model('usuario')->find_first("conditions: estado='A' ", "order: fecha desc");
        //$sql = "SELECT * FROM noticiasyeventos WHERE posicion=1 AND activo=1 ORDER BY publicar DESC";
        //return $this->find_first("conditions: contenidomenu_id=1");
        $sql = "SELECT * 
                FROM contenidomenu cm, contenidos c 
                WHERE cm.`id` = c.`contenidomenu_id`
                AND cm.`urlpath` = 'sobrenos'
                AND cm.`activo` = 1";
        return $this->find_by_sql($sql);
    }
}

