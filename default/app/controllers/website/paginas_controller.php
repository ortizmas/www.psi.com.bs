<?php
Load::models('contenidomenu','contenidos','idiomas');
class PaginasController extends AdminController{
    
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
        $this->site_name=Session::get('SITENAME');
        $this->site_key=Session::get('SITEKEY');
        $this->sede_name=Session::get('SEDENAME');
    }
    
    public function index($pag= 1) {
        try {
            $Contenidos = new Contenidomenu();
            $this->paginas_es = $Contenidos->find("conditions: idiomas_id=1 and areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30","order: orden asc");
            $this->paginas_en = $Contenidos->find("conditions: idiomas_id=2 and areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30","order: orden asc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function ordenarlista($id=1,$pag=1){
            $Contenidos = new Contenidomenu();
            $this->paginas_es = $Contenidos->find("conditions: idiomas_id=1 and areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30","order: orden asc");
            $this->paginas_en = $Contenidos->find("conditions: idiomas_id=2 and areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30","order: orden asc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();
            //$this->areas_id=$id;
            Session::set('_NAVAREAID',$id); 
            
    }

    public function ordenar(){
            //$this->set_response("view");
            View::response('view');
            
            $listItem  = $_POST['listItem'];
            $orden = 1;
            foreach($listItem as $id):
                $Contenidos = new Contenidomenu();
                $data = $Contenidos->find($id);
                //print_r($data->orden);
                $data->orden =str_pad($orden, 5, "0", STR_PAD_LEFT);
                $data->update();
                $orden++;
            endforeach;
            $this->ln=$listItem;     
    }

    public function crear() {
        $this->titulo = 'Crear página';
        try {
            if (Input::hasPost('pagina')) {
                $pagina = new Contenidomenu(Input::post('pagina'));
                $pagina->usuarios_id= Auth::get('id');
                if ($pagina->save()) {
                    Flash::valid('La página ha sido agregada exitosamente...!!!');
                    if (Input::hasPost('contenido')) {
                        $Contenidos = new Contenidos(Input::post('contenido'));
                        $Contenidos->contenidomenu_id=$pagina->id;
                        $Contenidos->idiomas_id=$pagina->idiomas_id;
                        $Contenidos->usuarios_id=$pagina->usuarios_id;
                        $Contenidos->activo=$pagina->activo;
                        if ($Contenidos->save()) {
                            Flash::valid('El contenido ha sido agregada exitosamente...!!!');
                            if (!Input::isAjax()) {
                                return Router::redirect('index');
                            }
                            Input::delete();
                        } else {
                            Flash::warning('No se pudieron guardar el contenido...!!!');
                        }
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
        $this->titulo = 'Editar página';
        try {
            $id = (int) $id;
            View::select('crear');
            $pagina = new Contenidomenu();
            $contenido = new Contenidos();
            $this->pagina = $pagina->find_first("conditions: id=$id  and areas_id= 1"/*.Session::get('SITEID')*/);
            $this->contenido = $contenido->find_first("conditions: contenidomenu_id=".$this->pagina->id." and idiomas_id=".$this->pagina->idiomas_id);
            
            if ($this->pagina) { //verificamos la existencia del sede
                if (Input::hasPost('pagina')) {
                    if ($pagina->update(Input::post('pagina'))) {
                        Flash::valid('La página ha sido actualizada exitosamente...!!!');
                        if (Input::hasPost('contenido')) {
                            $Contenidos = new Contenidos(Input::post('contenido'));
                            $Contenidos->contenidomenu_id=$pagina->id;
                            $Contenidos->idiomas_id=$pagina->idiomas_id;
                            $Contenidos->usuarios_id=$pagina->usuarios_id;
                            $Contenidos->activo=$pagina->activo;
                            if ($Contenidos->save()) {
                                Flash::valid('El contenido ha sido actualizada exitosamente...!!!');
                                if (!Input::isAjax()) {
                                    return Router::redirect();
                                }
                                Input::delete();
                            } else {
                                Flash::warning('No se pudieron guardar el contenido...!!!');
                            }
                        }
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
            $pagina = new Contenidos();
            if (!$pagina->find_first("conditions: contenidomenu_id=$id")) {
                Flash::warning("No existe ninguna página con id '{$id}'");
            }else if ($pagina->delete()) {
                Flash::valid("La página con id <b>{$pagina->id}</b> fué eliminada...!!!");
            }
            $pagina = new Contenidomenu();
            
            if (!$pagina->find_first("conditions: id=$id  and areas_id= 1"/*.Session::get('SITEID')*/)) { //si no existe
                Flash::warning("No existe ninguna página con id '{$id}'");
            } else if ($pagina->delete()) {
                Flash::valid("La página <b>{$pagina->nombre}</b> fué eliminada...!!!");
            } else {
                Flash::warning("No se pudo eliminar la página <b>{$pagina->nombre}</b>...!!!");
            }
            
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function activar($id) {
        try {
            $id = (int) $id;

            $pagina = new Contenidomenu();

            if (!$pagina->find_first("conditions: id=$id  and areas_id= 1"/*.Session::get('SITEID')*/)) { //si no existe
                Flash::warning("No existe una página con id '{$id}'");
            } else if ($pagina->activar()) {
                Flash::valid("La página <b>{$pagina->nombre}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar la página <b>{$pagina->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;

            $pagina = new Contenidomenu();

            if (!$pagina->find_first("conditions: id=$id  and areas_id= 1"/*.Session::get('SITEID')*/)) { //si no existe
                Flash::warning("No existe ninguna página con id '{$id}'");
            } else if ($pagina->desactivar()) {
                Flash::valid("La página <b>{$pagina->nombre}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar la página <b>{$pagina->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
}
?>
