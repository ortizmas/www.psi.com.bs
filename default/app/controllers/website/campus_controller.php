<?php
Load::model('sedes');
class CampusController extends AdminController{
	
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    
    public function index($pag= 1) {
        try {
            $campus = new Sedes();
            $this->campus = $campus->paginate("page: $pag");
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function crear() {
        $this->titulo = 'Crear campus';
        try {

            if (Input::hasPost('campus')) {
                $campus = new Sedes(Input::post('campus'));
                if ($campus->save()) {
                    Flash::valid('El campus ha sido agregado exitosamente...!!!');
                    if (!Input::isAjax()) {
                        return Router::redirect();
                    }
                } else {
                    Flash::warning('No se pudieron guardar los datos...!!!');
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function editar($id) {
        $this->titulo = 'Editar campus';
        try {
            $id = (int) $id;
            View::select('crear');
            $campus = new Sedes();
            $this->campus = $campus->find_first($id);
            if ($this->campus) {//verificamos la existencia del sede
                if (Input::hasPost('campus')) {
                    if ($campus->update(Input::post('campus'))) {
                        Flash::valid('El campus ha sido actualizado exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                    } else {
                        Flash::warning('No se pudieron guardar los datos...!!!');
                    }
                }
            } else {
                Flash::warning("No existe ningun campus con id '{$id}'");
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
            $campus = new Sedes();
            
			if (!$campus->find_first($id)) { //si no existe
				Flash::warning("No existe ningun campus con id '{$id}'");
			} else if ($campus->delete()) {
				Flash::valid("El campus <b>{$campus->nombre}</b> fué eliminado...!!!");
			} else {
				Flash::warning("No se pudo eliminar el campus <b>{$campus->nombre}</b>...!!!");
			}
			
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function activar($id) {
        try {
            $id = (int) $id;

            $campus = new Sedes();

            if (!$campus->find_first($id)) { //si no existe
                Flash::warning("No existe ningun campus con id '{$id}'");
            } else if ($campus->activar()) {
                Flash::valid("El campus <b>{$campus->nombre}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar el campus <b>{$campus->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;

            $campus = new Sedes();

            if (!$campus->find_first($id)) { //si no existe
                Flash::warning("No existe ningun campus con id '{$id}'");
            } else if ($campus->desactivar()) {
                Flash::valid("El campus <b>{$campus->nombre}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar el campus <b>{$campus->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
	
}

?>