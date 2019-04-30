<?php
class Contenidomenu extends ActiveRecord {
    protected function initialize()
    {
        $this->has_many('contenidos');
        $this->belongs_to('areas','secciones','idiomas','usuarios');
        $this->validates_presence_of('areas_id', 'message: Debe seleccionar un <b>Sitio</b> a donde se añadirá la página');
        $this->validates_presence_of('nombre', 'message: Debe escribir un <b>Nombre</b> para el menú');
        $this->validates_presence_of('urlpath', 'message: Debe escribir la <b>/URL-permanente</b> desde donde se accederá la página');
        
    }
    
    protected function before_save()
    {
        //if (Auth::get('master')=='0') {
        $this->areas_id= 1/*Session::get('SITEID')*/;
        //} 
    }
    
    /**
     * 
     * @param type $data
     * @return boolean
     */
     public function before_validation_on_create() {
        $this->validates_uniqueness_of('urlpath', 'message: La url ya existe <b>Cambie el Nombre de la url</b>');
     }
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

    
    public function buscar($sitio_id){
        return $this->find("conditions: areas_id = $sitio_id");
    }
    public function get_sub_contenidomenu(){
        $campos = 'contenidomenu.' . join(',contenidomenu.', $this->fields) . ',c.resumen';
        $join = 'INNER JOIN contenidos as c ON c.id = contenidomenu.contenidomenu_id AND c.activo = 1 ';
        $join .= 'INNER JOIN areas as a ON a.id = contenidomenu.areas_id ';
        $join .= 'INNER JOIN idiomas AS i ON i.id = contenidomenu.idiomas_id ';
        $condiciones = "contenidomenu.contenidomenu_id = '{$this->id}' AND contenidomenu.activo = 1 ";
        $agrupar_por = 'contenidomenu.' . join(',contenidomenu.', $this->fields) . ',c.resumen';
        return $this->find($condiciones, "join: $join", "columns: $campos", 'order: contenidomenu.id', "group: $agrupar_por");

    }
}

