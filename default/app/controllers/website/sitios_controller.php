<?php
Load::model('areas');
class SitiosController extends AdminController{
	
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    
    public function index($pag= 1, $ppage = 30) {
        try {
            $areas = new Areas();
            $this->sitioslima = $areas->paginate("conditions: areas_id =1","page: $pag","per_page: $ppage");
            //$this->sitiosjuliaca = $areas->paginate("conditions: sedes_id=2","page: $pag","per_page: $ppage");
            //$this->sitiostarapoto = $areas->paginate("conditions: sedes_id=3","page: $pag","per_page: $ppage");
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function crear() {
        $this->titulo = 'Crear sitio';
        try {
            //$Areasupeu = new Areasupeu();
			//$this->areasupeu=$Areasupeu->find();
            if (Input::hasPost('sitios')) {
                $areas = new Areas(Input::post('sitios'));
                $areasid = new Areas();
                $areasid = $areasid->maximum("id");
                echo "$areasid";
                $areas->areas_id = $areasid+1;
                if ($areas->save()) {
                    
                    //print_r($areas);
                    Flash::valid('El sitio ha sido agregado exitosamente...!!!');
                    if (!Input::isAjax()) {
                        return Router::redirect('index');
                    }
                    Input::delete();
                } else {
                    Flash::warning('No se pudieron guardar los datos...!!!');
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function editar($id) {
        $this->titulo = 'Editar sitio';
        try {
            $id = (int) $id;
            View::select('crear');
            $areas = new Areas();
            $this->sitios = $areas->find_first($id);
            if ($this->sitios) {//verificamos la existencia del sede
                if (Input::hasPost('sitios')) {
                    if ($areas->update(Input::post('sitios'))) {
                        Flash::valid('El sitio ha sido actualizado exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                        Input::delete();
                    } else {
                        Flash::warning('No se pudieron guardar los datos...!!!');
                    }
                }
            } else {
                Flash::warning("No existe ningun sitio con id '{$id}'");
                if (!Input::isAjax()) {
                    return Router::redirect();
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function eliminar($id = NULL) {
        try {
            $areas = new Areas();
            
			if (!$areas->find_first($id)) { //si no existe
				Flash::warning("No existe ningun sitio con id '{$id}'");
			} else if ($areas->delete()) {
				Flash::valid("El sitio <b>{$areas->nombre}</b> fué eliminado...!!!");
			} else {
				Flash::warning("No se pudo eliminar el sitio <b>{$areas->nombre}</b>...!!!");
			}
			
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function activar($id) {
        try {
            $id = (int) $id;

            $areas = new Areas();

            if (!$areas->find_first($id)) { //si no existe
                Flash::warning("No existe idioma sitio con id '{$id}'");
            } else if ($areas->activar()) {
                Flash::valid("El sitio <b>{$areas->nombre}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar el sitio <b>{$areas->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;

            $areas = new Areas();

            if (!$areas->find_first($id)) { //si no existe
                Flash::warning("No existe ningun sitio con id '{$id}'");
            } else if ($areas->desactivar()) {
                Flash::valid("El sitio <b>{$areas->nombre}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar el sitio <b>{$areas->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
}

?>