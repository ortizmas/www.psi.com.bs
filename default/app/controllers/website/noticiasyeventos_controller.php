<?php
	Load::Models('noticiasyeventos','idiomas','areas','usuarios');
	class NoticiasyeventosController extends AdminController{
		protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
        //$this->site_name=Session::get('SITENAME');
        //$this->site_key=Session::get('SITEKEY');
        //$this->sede_name=Session::get('SEDENAME');
    }
    
    public function index($p=NULL,$pag= 1) {

        try {
            if (Input::hasPost('noticiasyeventos')) {
                $p=Input::post('noticiasyeventos_tipo');
            }
            $noticiasyeventos = new Noticiasyeventos();
            $this->paginas_es = $noticiasyeventos->find("conditions: idiomas_id=1 and tipo='$p' and areas_id= 1" ,"page: $pag","per_page: 30","order: id desc");
            $this->paginas_en = $noticiasyeventos->find("conditions: idiomas_id=2 and tipo='$p' and areas_id= 1" ,"page: $pag","per_page: 30","order: id desc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();

        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function crear() {
        $this->titulo = 'Crear noticias y eventos';
        try {
            $usuario_id = Auth::get('id');
            $usuario_id = Filter::get($usuario_id, 'digits');
            $Usuario = new Usuarios();
            $this->usuario = $Usuario->getNombres($usuario_id);
            if (Input::hasPost('noticiasyeventos')) {
                $noticiasyeventos = new Noticiasyeventos(Input::post('noticiasyeventos'));
                $noticiasyeventos->usuarios_id=Session::get('id');
                if ($noticiasyeventos->save()) {
                    Flash::valid('La Noticia o evento ha sido agregada exitosamente...!!!');            
                } else {
                    Flash::warning('No se pudieron guardar los datos...!!!');
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
public function editar($id) {
        $this->titulo = 'Editar Noticias y eventos';
        try {
            $usuario_id = Auth::get('id');
            $usuario_id = Filter::get($usuario_id, 'digits');
            $usuario = new Usuarios();
            $this->usuario = $usuario->getNombres($usuario_id);
            $id = (int) $id;
            View::select('crear');
            $noticiasyeventos = new Noticiasyeventos();
            //$contenido = new Contenidos();
            $this->noticiasyeventos = $noticiasyeventos->find_first("conditions: id=$id and areas_id= 1"/*.Session::get('SITEID')*/);
            //$this->contenido = $contenido->find_first("conditions: contenidomenu_id=".$this->noticiasyeventos->id." and idiomas_id=".$this->noticiasyeventos->idiomas_id);
            
            if ($this->noticiasyeventos) {//verificamos la existencia del sede
                if (Input::hasPost('noticiasyeventos')) {
                    if ($noticiasyeventos->update(Input::post('noticiasyeventos'))) {
                        Flash::valid('La Noticia o evento ha sido actualizada exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                          Input::delete();
                    } else {
                        Flash::warning('No se pudieron guardar los datos...!!!!!');
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
            $noticiasyeventos = new Noticiasyeventos();
            
            if (!$noticiasyeventos->find_first("conditions: id=$id  and areas_id= 1"/*.Session::get('SITEID')*/)) { //si no existe
                Flash::warning("No existe ninguna página con id '{$id}'");
            } else if ($noticiasyeventos->delete()) {
                Flash::valid("La página <b>{$noticiasyeventos->nombre}</b> fué eliminada...!!!");
            } else {
                Flash::warning("No se pudo eliminar la página <b>{$noticiasyeventos->nombre}</b>...!!!");
            }
            
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
    public function activar($id) {
        try {
            $id = (int) $id;

            $noticiasyeventos = new Noticiasyeventos();

            if (!$noticiasyeventos->find_first($id)) { //si no existe
                Flash::warning("No existe idioma sitio con id '{$id}'");
            } else if ($noticiasyeventos->activar()) {
                Flash::valid("El sitio <b>{$noticiasyeventos->nombre}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar el sitio <b>{$noticiasyeventos->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;

            $noticiasyeventos = new Noticiasyeventos();

            if (!$noticiasyeventos->find_first($id)) { //si no existe
                Flash::warning("No existe ningun sitio con id '{$id}'");
            } else if ($noticiasyeventos->desactivar()) {
                Flash::valid("El sitio <b>{$noticiasyeventos->nombre}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar el sitio <b>{$noticiasyeventos->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

}


?>