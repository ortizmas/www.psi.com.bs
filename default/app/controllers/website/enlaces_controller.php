<?php
	Load::models('enlaces','areas','idiomas');
	class EnlacesController extends AdminController{
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }

		public function index($p=1, $pag=1){
			//$this->areas=$this->Areas->find();
			try{
                if (Input::hasPost('enlaces')) {
                    $p=Input::post('enlaces_posicion');
                }
				$enlaces = new Enlaces();
      	         $this->enlaces = $enlaces->find("conditions: idiomas_id=1 and posicion='$p' and areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30");
			}catch(KumbiaException $e){
				View::excepcion($e);
			}
		}

    public function crear() {
        $this->titulo = 'Crear enlace';
        try {
            //$Areasupeu = new Areasupeu();
						//$this->areasupeu=$Areasupeu->find();
            if (Input::hasPost('enlaces')) {
                $enlaces = new Enlaces(Input::post('enlaces'));
                if ($enlaces->save()) {
                    Flash::valid('El sitio ha sido agregado exitosamente...!!!');
                    if (!Input::isAjax()) {
                        //return Router::redirect('index');
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
        $this->titulo = 'Editar enlace';
        try {
            $id = (int) $id;
            View::select('crear');
            $enlaces = new Enlaces();
            $this->enlaces = $enlaces->find_first($id);
            if ($this->enlaces) {//verificamos la existencia del sede
                if (Input::hasPost('enlaces')) {
                    if ($enlaces->update(Input::post('enlaces'))) {
                        Flash::valid('El enlace ha sido actualizado exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                        Input::delete();
                    } else {
                        Flash::warning('No se pudieron guardar los datos...!!!');
                    }
                }
            } else {
                Flash::warning("No existe ningun enlace con id '{$id}'");
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
            $enlaces = new Enlaces();

			if (!$enlaces->find_first($id)) { //si no existe
				Flash::warning("No existe ningun enlace con id '{$id}'");
			} else if ($enlaces->delete()) {
				Flash::valid("El enlace <b>{$enlaces->nombre}</b> fué eliminado...!!!");
			} else {
				Flash::warning("No se pudo eliminar el enlace <b>{$enlaces->nombre}</b>...!!!");
			}

        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
    /*Para el modulo de Redes sociales*/
    public function redessociales($pag=1){
        try{
            //echo "Redes Sociales";
            $redessociales = new Enlaces();
            $this->redessociales = $redessociales->find("conditions: idiomas_id=1 and posicion=4 and areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30");

        }catch(KumbiaException $e){
            View::excepcion($e);
        }
    }
    public function redessociales_crear(){
        $this->titulo = 'Crear redes sociales';
        try {
            if (Input::hasPost('redessociales')) {
                $redessociales = new Enlaces(Input::post('redessociales'));
                if ($redessociales->save()) {
                    Flash::valid('La redsocial ha sido agregado exitosamente');
                    if (!Input::isAjax()) {
                        return Router::redirect();
                    }
                    Input::delete();
                }else{
                    Flash::warning('No se pudieron guardar los datos');
                }
           }
        } catch (KumbiaException $e) {
          View::excepcion($e);
        }
    }
    public function redessociales_editar($id) {
        $this->titulo = 'Editar Redes sociales';
        try {
            $id = (int) $id;
            View::select('redessociales_crear');
            $redessociales = new Enlaces();
            $this->redessociales = $redessociales->find_first($id);
            if ($this->redessociales) {//verificamos la existencia del sede
                if (Input::hasPost('redessociales')) {
                    if ($redessociales->update(Input::post('redessociales'))) {
                        Flash::valid('El enlace ha sido actualizado exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                        Input::delete();
                    } else {
                        Flash::warning('No se pudieron guardar los datos...!!!');
                    }
                }
            } else {
                Flash::warning("No existe ningun enlace con id '{$id}'");
                if (!Input::isAjax()) {
                    return Router::redirect();
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function redessociales_eliminar($id = NULL) {
        try {
            $redessociales = new Enlaces();

            if (!$redessociales->find_first($id)) { //si no existe
                Flash::warning("No existe ningun enlace con id '{$id}'");
            } else if ($redessociales->delete()) {
                Flash::valid("El enlace <b>{$redessociales->nombre}</b> fué eliminado...!!!");
            } else {
                Flash::warning("No se pudo eliminar el enlace <b>{$redessociales->nombre}</b>...!!!");
            }

        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect('website/enlaces/redessociales');
    }
    public function activar($id) {
        try {
            $id = (int) $id;

            $enlaces = new Enlaces();

            if (!$enlaces->find_first($id)) { //si no existe
                Flash::warning("No existe idioma sitio con id '{$id}'");
            } else if ($enlaces->activar()) {
                Flash::valid("El sitio <b>{$enlaces->nombre}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar el sitio <b>{$enlaces->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;

            $enlaces = new Enlaces();

            if (!$enlaces->find_first($id)) { //si no existe
                Flash::warning("No existe ningun sitio con id '{$id}'");
            } else if ($enlaces->desactivar()) {
                Flash::valid("El sitio <b>{$enlaces->nombre}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar el sitio <b>{$enlaces->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
    public function redsocial_activar($id) {
        try {
            $id = (int) $id;

            $redessociales = new Enlaces();

            if (!$redessociales->find_first($id)) { //si no existe
                Flash::warning("No existe idioma sitio con id '{$id}'");
            } else if ($redessociales->activar()) {
                Flash::valid("El sitio <b>{$redessociales->nombre}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar el sitio <b>{$redessociales->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect('website/enlaces/redessociales');
    }

    public function redsocial_desactivar($id) {
        try {
            $id = (int) $id;

            $redessociales = new Enlaces();

            if (!$redessociales->find_first($id)) { //si no existe
                Flash::warning("No existe ningun sitio con id '{$id}'");
            } else if ($redessociales->desactivar()) {
                Flash::valid("El sitio <b>{$redessociales->nombre}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar el sitio <b>{$redessociales->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect('website/enlaces/redessociales');
    }
}
?>