<?php
class Noticiasyeventos extends ActiveRecord {
    protected function initialize()
    {
        $this->has_many('areas');
        $this->belongs_to('estadocuentas','estados','idiomas','usuarios');
        //$this->validates_length_of('resumen', 'maximo: 76', 'too_long: El contenido debe tener caracteres');
        $this->validates_presence_of('titulo', 'message: Debe escribir el <b>Titulo a Mostrar</b> para la Noticia');
        $this->validates_presence_of('areas_id', 'message: Seleçoe <b>o area al que pertenece</b> para a Noticia');
        //$this->validates_uniqueness_of('titulo', 'message: El <b>TITULO</b> ya está siendo utilizada, vaya al listado y modifique lo que ya creó!!');
        //$this->validates_uniqueness_of('urlpath', 'message: Esta dirección <b>URL</b> ya está siendo utilizada');
    }
    public function before_validation_on_create() {
        $this->validates_uniqueness_of('urlpath', 'message: La url ya existe <b>Vaya a listado y modifique los datos</b>');
     }
    public function getNoticiasyeventos($page, $ppage=25){
        return $this->paginate("page: $page", "per_page: $ppage", 'order: nombre asc');
    }
    public function getAreas_id($id) {
    }
    public function destaques($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='destaque' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function projetos($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='projetos' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function dicasDeSaude($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='dicasDeSaude' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function analiseDaSaude($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='analiseDaSaude' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function lojaVirtual($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='loja' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function clinica($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='clinica' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function empresarial($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='empresarial' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function clubVantagens($areas_id, $idiomas_id)
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE areas_id=$areas_id and idiomas_id=$idiomas_id AND tipo='clubVantagens' AND caducar >= date_format(now(),'%Y-%m-%d') AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
    public function enlaceImg()
    {
        //$sql = "SELECT * FROM enlaces WHERE activo=1";
        return $this->find("conditions: activo=1");
    }
    public function clientes()
    {
        $sql = "SELECT * FROM noticiasyeventos WHERE posicion=6 AND tipo='clientes' AND activo=1 ORDER BY publicar DESC";
        return $this->find_all_by_sql($sql);
    }
}
