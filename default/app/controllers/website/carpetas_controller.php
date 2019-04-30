<?php
	Load::models('carpetas','archivos','areas','usuarios');
	class CarpetasController extends AdminController{
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    
		public function index($pag=1){
			//$this->areas=$this->Areas->find();
			try{
				$carpetas = new Carpetas();
      	$this->carpetas = $carpetas->find("conditions: areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30");

        //$carpeta = Load::model('carpetas')->find_first(123);
			}catch(KumbiaException $e){
				View::excepcion($e);
			}		
		}

    public function crear() {
        $this->titulo = 'Crear Carpetas';
                $usuario_id = Auth::get('id');
                $usuario_id = Filter::get($usuario_id, 'digits');
                $usuario = new Usuarios();
                $this->usuario = $usuario->getNombres($usuario_id);
        try {
            $areas = new Areas();
            $this->areas = $areas->find_by_sql("select urlpath from areas where id = 1"/*.Session::get('SITEID')*/);
            $nomcarpeta = $areas->urlpath;
            //$carpeta="img/uploads/$nomcarpeta";
            $carpeta="uploads/$nomcarpeta";
            if (!is_dir($carpeta)) {
              if (!mkdir($carpeta, 755)) {
                   Flash::warning('La carpeta no  FUE CREADO!!!');
               }else{
                    Flash::valid('Se ha creado la carpeta padre en su sitio!!!!');
               }
              
            }else{
              Flash::warning('Le recordamos que el directorio padre ya existe, No hay problemas, continue adelante!!!');
            }
            //if(!is_dir($carpeta)) mkdir($carpeta,1755);

            $carpetas = new Carpetas();
            if (Input::hasPost('carpetas')) {
                $carpetas = new Carpetas(Input::post('carpetas'));
                $nombre = $carpetas['nombre'];
                $sede_id = Session::get('SEDEID');

                switch ($sede_id) {
                  case $sede_id:
                    $urls = "uploads/$nomcarpeta/";
                    break;
                }

                $url = $urls.$nombre;
                if(!is_dir($url)){ 
                    if(!mkdir($url, 755)){
                        Flash::warning('La carpeta no  FUE CREADO!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect('index');
                        }
                        exit();
                    }
                  }else{ 
                    Flash::warning('El directorio ya existe!!!');
                    if (!Input::isAjax()) {
                        return Router::redirect('index');
                    }
                    exit();
                }
                if ($carpetas->save()) {
                    Flash::valid('La carpeta ha sido creado exitosamente...!!!');
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
        $this->titulo = 'Editar carpetas';
                $usuario_id = Auth::get('id');
                $usuario_id = Filter::get($usuario_id, 'digits');
                $usuario = new Usuarios();
                $this->usuario = $usuario->getNombres($usuario_id);
        try {
            $id = (int) $id;
            View::select('crear');
            $carpetas = new Carpetas();
            $this->carpetas = $carpetas->find_first($id);
            
            if ($this->carpetas) {//verificamos la existencia del sede
                if (Input::hasPost('carpetas')) {
                    if ($carpetas->update(Input::post('carpetas'))) {
                        Flash::valid('lA carpeta ha sido actualizado exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                        Input::delete();
                    } else {
                        Flash::warning('No se pudieron guardar los datos...!!!');
                    }
                }
            } else {
                Flash::warning("No existe ninguna carpeta con id '{$id}'");
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
            $carpetas = new Carpetas();
			if (!$carpetas->find_first($id)) { //si no existe
				Flash::warning("No existe ninguna carpeta con id '{$id}'");
			} else if ($carpetas->delete()) {
				Flash::valid("El carpeta <b>{$carpetas->nombre}</b> fué eliminado...!!!");
			} else {
				Flash::warning("No se pudo eliminar el carpeta <b>{$carpetas->nombre}</b>...!!!");
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
            $this->redessociales = $redessociales->find("conditions: idiomas_id=1 and posicion=3 and areas_id= 1"/*.Session::get('SITEID')*/,"page: $pag","per_page: 30");

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
}
?>