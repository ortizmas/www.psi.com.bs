<?php
Load::model('idiomas');
class IdiomasController extends AdminController{
	
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    
    public function index($pag= 1) {
        try {
            $idiomas = new Idiomas();
            $this->idiomas = $idiomas->paginate("page: $pag");
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function crear() {
        $this->titulo = 'Crear idioma';
        try {

            if (Input::hasPost('idiomas')) {
                $idiomas = new Idiomas(Input::post('idiomas'));
                if ($idiomas->save()) {
                    Flash::valid('El idioma ha sido agregado exitosamente...!!!');
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
        $this->titulo = 'Editar idioma';
        try {
            $id = (int) $id;
            View::select('crear');
            $idiomas = new Idiomas();
            $this->idiomas = $idiomas->find_first($id);
            if ($this->idiomas) {//verificamos la existencia del sede
                if (Input::hasPost('idiomas')) {
                    if ($idiomas->update(Input::post('idiomas'))) {
                        Flash::valid('El idioma ha sido actualizado exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                    } else {
                        Flash::warning('No se pudieron guardar los datos...!!!');
                    }
                }
            } else {
                Flash::warning("No existe ningun idioma con id '{$id}'");
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
            $idiomas = new Idiomas();
            
			if (!$idiomas->find_first($id)) { //si no existe
				Flash::warning("No existe ningun idioma con id '{$id}'");
			} else if ($idiomas->delete()) {
				Flash::valid("El idioma <b>{$idiomas->nombre}</b> fué eliminado...!!!");
			} else {
				Flash::warning("No se pudo eliminar el idioma <b>{$campus->nombre}</b>...!!!");
			}
			
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function activar($id) {
        try {
            $id = (int) $id;

            $idiomas = new Idiomas();

            if (!$idiomas->find_first($id)) { //si no existe
                Flash::warning("No existe idioma idioma con id '{$id}'");
            } else if ($idiomas->activar()) {
                Flash::valid("El idioma <b>{$idiomas->nombre}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar el idioma <b>{$idiomas->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;

            $idiomas = new Idiomas();

            if (!$idiomas->find_first($id)) { //si no existe
                Flash::warning("No existe ningun idioma con id '{$id}'");
            } else if ($idiomas->desactivar()) {
                Flash::valid("El idioma <b>{$idiomas->nombre}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar el idioma <b>{$idiomas->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
	
}

?>