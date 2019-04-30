<?php
class Areas extends ActiveRecord {
    protected function initialize($pag= 0, $ppage = 5)
	{
        $this->has_many('configuraciones','responsables','enlaces','vobopublicacion','noticiasyeventos','contactos','carpetas','contenidomenu','afiliaciones');
		$this->belongs_to('sedes','usuarios');
        $this->validates_uniqueness_of('urlpath', 'message: Esta dirección <b>URL</b> ya está siendo utilizada');

    }
    
    protected function before_save()
    {
        if (empty($this->keyapp)) {
            $this->keyapp=sha1(Session::get('SITEID').time());
        } 
    }
    
    
    /**
     * Guarda los datos de un usuario, y los roles que va a poseer
     *
     * @param array $data datos que se enviaron del form
     * @return boolean retorna TRUE si se pudieron guardar los datos con exito
     */
    public function guardar($data)
    {
        $this->begin();//Begin permite crear una transacción en el motor de base de datos

        if (!$this->save($data)) {
            $this->rollback();//Este método nos permite anular una transacción iniciada por el método begin en el motor de base de datos
            return FALSE;
        }
        $this->commit();//Commit nos permite confirmar una transacción iniciada por el método begin en el motor de base de datos
        return TRUE;
    }
	  public function buscar($campus){
                $query="";
                if(Auth::get('master')!='1'):
                    $query="and usuarios_id=".Auth::get('id');
                endif;
		return $this->find("conditions: sedes_id=$campus $query");
	  }


}

