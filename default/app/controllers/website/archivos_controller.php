<?php
  Load::models('archivos','carpetas','usuarios','areas');
  class ArchivosController extends AdminController{
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    
    public function index($p=1,$pag=1){
      try{
                if (Input::hasPost('archivos')) {
                    $p=Input::post('archivos_id');
                }
        $site_id = 1/*Session::get('SITEID')*/;
        $archivos = new Archivos();
                $this->archivos = $archivos->find_all_by_sql("select a.* from archivos a inner join carpetas c on a.carpetas_id =c.id and a.carpetas_id =$p where c.areas_id = $site_id order by a.id DESC","page: $pag","per_page: 100 ");
      }catch(KumbiaException $e){
        View::excepcion($e);
      }   
    }

    public function crear() {

          $this->titulo = 'Subir Archivos';          
            try {
                $usuario_id = Auth::get('id');
                $usuario_id = Filter::get($usuario_id, 'digits');
                $usuario = new Usuarios();
                $this->usuario = $usuario->getNombres($usuario_id);

                $areas = new Areas();
                $this->areas = $areas->find_by_sql("select urlpath from areas where id = 1"/*.Session::get('SITEID')*/);
                $nomcarpeta = $areas->urlpath;

                $sede_id = 1/*Session::get('SITEID')*/;

                switch ($sede_id) {
                  case $sede_id:
                   // $urls = "img/uploads/$nomcarpeta/";
                    $urls = "$nomcarpeta";
                    break;
                }

              if (Input::hasPost('archivos')) {
                    $carpetas_id = Input::post('archivos');
                    $id = $carpetas_id['carpetas_id'];
                    $carpetas = new Carpetas();
                    $carpetas = $carpetas->find_by_sql("select * from carpetas where id=$id limit 1");
                    $carpeta = $carpetas->nombre;

                        $archivo_temp = $_FILES['archivo']["tmp_name"];
                        $archivo = $_FILES["archivo"]["name"];
                        $ruta = str_replace (" ", "_", $archivo);
                        $tamafile = $_FILES["archivo"]["size"];
                        $tam = 1048576 .' bytes';
                        $extarray = array('jpg', 'png','doc','docx','pdf','xls','xlsx','ppt');
                        @$extension = end(explode('.', $ruta));
                        $ftp_carpeta_archivo =$archivo;
                        $path =  "uploads/$nomcarpeta/$carpeta/";//destino en el servidor ftp
                        $mi_nombredearchivo=$path.$ruta;
                        if (file_exists($mi_nombredearchivo)) {
                           Flash::success('El archivo ya existe en el servidor cambie de nombre o elija otro archivo!!!');
                        }else{
                          if (in_array($extension, $extarray)) {
                            if ($tamafile <= $tam) {
                                if ($_FILES['archivo']['error'] > 0) {
                                  Flash::success('<h3>Ha ocurrido un error al subir el archivosss</h3>');
                                  // return Router::redirect();
                              }else {
                                move_uploaded_file($archivo_temp, $path.$ruta);
                                Flash::success('<h3>El archivo subio con exito</h3>'); 
                                $url = '/uploads/'.$urls.'/'.$carpeta.'/'.$ruta;
                                 $fileType = $_FILES["archivo"]["type"];
                                 $fileSize = $_FILES["archivo"]["size"].' '."bytes";
                                     $usu = Input::post('archivos');
                                     $archivos = new Archivos();
                                     $archivos->carpetas_id = $usu['carpetas_id'];
                                     $archivos->usuarios_id = $usu['usuarios_id'];
                                     $archivos->archivo = $archivo;
                                     $archivos->urlname = $url;
                                     $archivos->tamanho = $fileSize;
                                     $archivos->tipo = $fileType;
                                     $archivos->activo = $usu['activo'];
                                     if ($archivos->save()) {
                                         Flash::success('<h3>Registro Guardado Correctamente...</h3>');
                                         return Router::redirect();
                                     }
                              }
                            }else{
                              Flash::error('El archivo excede el tamaño, Tamaño maximo '.'<strong> 4 MB </strong>');
                            }
                          }else{
                            Flash::error('La extension del archivo no es valido');
                          }
                        }
              } 
            }catch (KumbiaException $e) {
              View::excepcion($e);
            }
    }

    public function editar($id) {
        $this->titulo = 'Editar archivos';
        View::select('crear');
        try {
                $usuario_id = Auth::get('id');
                $usuario_id = Filter::get($usuario_id, 'digits');
                $usuario = new Usuarios();
                $this->usuario = $usuario->getNombres($usuario_id);
                $areas = new Areas();
                $this->areas = $areas->find_by_sql("select urlpath from areas where id = 1"/*.Session::get('SITEID')*/);
                $nomcarpeta = $areas->urlpath;

                $sede_id = 1/*Session::get('SITEID')*/;

                switch ($sede_id) {
                  case $sede_id:
                   // $urls = "img/uploads/$nomcarpeta/";
                    $urls = "$nomcarpeta";
                    break;
                }
            $id = (int) $id;
            $archivos = new Archivos();
            $this->archivos = $archivos->find_first($id);
            if ($this->archivos) {//verificamos la existencia del sede
                if (Input::hasPost('archivos')) {
                    $carpetas_id = Input::post('archivos');
                    $id = $carpetas_id['carpetas_id'];
                    $carpetas = new Carpetas();
                    $carpetas = $carpetas->find_by_sql("select * from carpetas where id=$id limit 1");
                    $carpeta = $carpetas->nombre;

                    $archivo = $_FILES["archivo"]["name"];//archivo es el nombre del input del form
                    $archivo_temp = $_FILES["archivo"]["tmp_name"];
                    $ruta = str_replace (" ", "_", $archivo);
                    $tamafile = $_FILES["archivo"]["size"];
                    $tam = 1048576 .' bytes';
                    $extarray = array('jpg', 'png','doc','docx','pdf','xls','xlsx','ppt');
                    @$extension = end(explode('.', $ruta));
                    $ftp_carpeta_archivo =$archivo;
                    $path= "uploads/$nomcarpeta/$carpeta/";//destino en el servidor ftp
                    $mi_nombredearchivo=$ruta;
                    //nombre de archivo es el archivo temporal que esta en el servidor ftp
                    $nombre_archivo = $archivo_temp;
                    $archivo_destino = $path.$mi_nombredearchivo;
                    $adel = $archivo_destino;

                    if (in_array($extension, $extarray)) {
                        if ($tamafile <= $tam) {
                            if (@unlink($adel)) {
                                Flash::valid('El archivo anterior '.'<strong>'.$mi_nombredearchivo.'</strong>'.' fue eliminado exitosamente...!!!');
                            }

                            $upload = move_uploaded_file($archivo_temp, $path.$ruta);
                            if (!$upload) {
                                Flash::success('<h3>Ha ocurrido un error al subir el archivo</h3>');
                                    return Router::redirect();
                            }else {
                                Flash::valid('El archivo '.'<strong>'.$mi_nombredearchivo.'</strong>'.' subio con exito');           
                                //$archivo->setMinSize("262144"); //Tamaño minimo del archivo 250 bytes aprox
                                //$archivo->setMaxSize("1048576"); //Tamaño maximo del archivo 1 MB
                                /*$archivo->setExtensions(array('jpg', 'png', 'gif','doc','docx')); //le asignamos las extensiones a permitir*/
                                $url = '/uploads/'.$urls.'/'.$carpeta.'/'.$ruta;
                                $fileType = $_FILES["archivo"]["type"];
                                $fileSize = $_FILES["archivo"]["size"].' '."bytes";

                                if ($archivos->save()) {
                                    $archivos->archivo = str_replace(" ", "_", $archivo);
                                    $archivos->urlname = $url;
                                    $archivos->tamanho = $fileSize;
                                    $archivos->tipo = $fileType;

                                    if ($archivos->update(Input::post('archivos'))) {
                                        Flash::valid('El enlace ha sido actualizado exitosamente...!!!');
                                        if (!Input::isAjax()) {
                                            return Router::redirect();
                                        }
                                        Input::delete();
                                    } else {
                                        Flash::warning('No se pudieron guardar los datos...!!!');
                                    }
                                }
                            }
                            if ($archivos->update(Input::post('archivos'))) {
                                Flash::valid('El enlace ha sido actualizado exitosamente...!!!');
                                if (!Input::isAjax()) {
                                    return Router::redirect();
                                }
                                Input::delete();
                            } else {
                                Flash::warning('No se pudieron guardar los datos...!!!');
                            }
                        }else{
                            Flash::error('El archivo excede el tamaño, Tamaño maximo '.'<strong> 4 MB </strong>');
                        }
                    }else{
                        Flash::error('La extension del archivo no es valido');
                    }
                }
            }else {
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
            $usuario_id = Auth::get('id');
            $usuario_id = Filter::get($usuario_id, 'digits');
            $usuario = new Usuarios();
            $this->usuario = $usuario->getNombres($usuario_id);

            $areas = new Areas();
                $this->areas = $areas->find_by_sql("select urlpath from areas where id = 1"/*.Session::get('SITEID')*/);
                $nomcarpeta = $areas->urlpath;
                $sede_id = 1/*Session::get('SITEID')*/;
                switch ($sede_id) {
                  case $sede_id:
                    //$urls = "uploads/$nomcarpeta/";
                  $urls = "$nomcarpeta";
                    break;
                }
                $arch = new Archivos();
                $arch->find_first($id);
                $carpetasid = $arch->carpetas_id;
                $archivonom = $arch->archivo;
                $carp = new Carpetas();
                $carp->find_first($carpetasid);
                $carpetanom = $carp->nombre;
                $ftp_carpeta_remota= "uploads/$nomcarpeta/$carpetanom/";//destino en el servidor ftp
                $mi_nombredearchivo=$archivonom;
                $archivo_destino = $ftp_carpeta_remota.$mi_nombredearchivo;
                $adel = $archivo_destino;

                if (@unlink($adel)) {
                    Flash::valid('El archivo '.'<strong>'.$mi_nombredearchivo.'</strong>'.' fue eliminado exitosamente del servidor...!!!');
                    $archivos = new Archivos();
                    if (!$archivos->find_first($id)) { //si no existe
                        Flash::warning("No existe ningun enlace con id '{$id}'");
                    } 
                    else if ($archivos->delete()) {
                        Flash::valid("El enlace <b>{$archivos->archivo}</b> fué eliminado de la base de datos...!!!");
                    } else {
                        Flash::warning("No se pudo eliminar el enlace <b>{$archivos->archivo}</b>...!!!");
                    }
                }else{
                    Flash::error('El archivo '.'<strong>'.$mi_nombredearchivo.'</strong>'.' No existe en el servidor, por tanto no se puede eliminar de la base de datos...Puede recurrir a la opcion Editar!!!');
                            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function activar($id) {
        try {
            $id = (int) $id;

            $archivos = new Archivos();

            if (!$archivos->find_first($id)) { //si no existe
                Flash::warning("No existe idioma sitio con id '{$id}'");
            } else if ($archivos->activar()) {
                Flash::valid("El sitio <b>{$archivos->archivo}</b> esta ahora <b>activo</b>...!!!");
            } else {
                Flash::warning("No se pudo activar el sitio <b>{$archivos->archivo}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;

            $archivos = new Archivos();

            if (!$archivos->find_first($id)) { //si no existe
                Flash::warning("No existe ningun sitio con id '{$id}'");
            } else if ($archivos->desactivar()) {
                Flash::valid("El sitio <b>{$archivos->archivo}</b> esta ahora <b>inactivo</b>...!!!");
            } else {
                Flash::warning("No se pudo desactivar el sitio <b>{$archivos->archivo}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
}
?>