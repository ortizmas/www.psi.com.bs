<?php
    Load::Models('paciente', 'idiomas');
    class PacienteController extends AdminController{
        protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    public function index($p=NULL,$pag= 1) {
        try {
            $sql ='';
            if (Input::hasPost('paciente')) {
                $p=Input::post('paciente_nome');
                $sql = "and nome='$p'";
            }
            $paciente = new Paciente();
            $this->paciente_list = $paciente->find("conditions: created_at IS NOT NULL $sql" ,"page: $pag","per_page: 30","order: nome asc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function perfildesaude($id,$p=NULL,$pag= 1){
        View::select('index');
        try {
            $paciente = new Paciente();
            $this->perfildesaude = $paciente->PerfilDeSaude($id);
            $sql ='';
            if (Input::hasPost('paciente')) {
                $p=Input::post('paciente_nome');
                $sql = "and nome='$p'";
            }
            $paciente = new Paciente();
            $this->paciente_nome = $paciente->find_first("conditions: id=$id");
            $this->paciente_list = $paciente->find("conditions: created_at IS NOT NULL $sql" ,"page: $pag","per_page: 30","order: nome asc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function ver($id,$p=NULL,$pag= 1){
        View::select('index');
        try {
            $sql ='';
            if (Input::hasPost('paciente')) {
                $p=Input::post('paciente_nome');
                $sql = "and nome='$p'";
            }
            $paciente = new Paciente();
            $this->paciente_all = $paciente->find_first("conditions: id=$id");
            $this->paciente_list = $paciente->find("conditions: created_at IS NOT NULL $sql" ,"page: $pag","per_page: 30","order: nome asc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function listapacientes($p=NULL,$pag= 1 ){
         try {
            $sql ='';
            if (Input::hasPost('nome')) {
                $p=Input::post('nome');
                $sql = "and nome='$p'";
            }
            $paciente = new Paciente();
            $this->paciente_list = $paciente->find("conditions: created_at IS NOT NULL $sql" ,"page: $pag","per_page: 30","order: nome asc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function lista($p=NULL,$pag= 1 ){
         try {
            $sql ='';
            if (Input::hasPost('nome')) {
                $p=Input::post('nome');
                $sql = "and nome='$p'";
            }
            $paciente = new Paciente();
            $this->paciente_list = $paciente->find("conditions: created_at IS NOT NULL $sql" ,"page: $pag","per_page: 30","order: nome asc");
            $Idiomas = new Idiomas();
            $this->idiomas = $Idiomas->find();
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function autocomplete_paciente() {
        View::template(NULL);
        View::select(NULL);
        if (Input::isAjax()) { //solo devolvemos los estados si se accede desde ajax
            $busqueda = Input::post('nome');
            $producto = Load::model('paciente')->obtenerPacienteNome($busqueda);
            die(json_encode($producto)); // solo devolvemos los datos, sin template ni vista
            //json_encode nos devolverá el array en formato json ["aragua","carabobo","..."]
        }
    }
    public function alterar($id) {
        $this->titulo = 'Alterar Estado de Paciente';
        try {
            $usuario_id = Auth::get('id');
            $usuario_id = Filter::get($usuario_id, 'digits');
            $usuario = new Usuarios();
            $this->usuario = $usuario->getNombres($usuario_id);
            $id = (int) $id;
            View::select('alterar');
            $paciente = new Paciente();
            $this->paciente = $paciente->find_first("conditions: id=$id");
            if ($this->paciente) {
                if (Input::hasPost('paciente')) {
                    if ($paciente->update(Input::post('paciente'))) {
                        Flash::valid('O paciente foi Alterado...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect('/website/paciente/listapacientes');
                        }
                          Input::delete();
                    } else {
                        Flash::warning('Na é possivel alterar os dados...!!!!!');
                    }
                }
            } else {
                Flash::warning("Não existe paciente com id '{$id}'");
                if (!Input::isAjax()) {
                    return Router::redirect();
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function crear() {
        $this->titulo = 'Cadastrar Paciente';
        try {
            $usuario_id = Auth::get('id');
            $usuario_id = Filter::get($usuario_id, 'digits');
            $Usuario = new Usuarios();
            $this->usuario = $Usuario->getNombres($usuario_id);
            if (Input::hasPost('pacientes')) {
                $pacientes = new Paciente(Input::post('pacientes'));
                $pacientes->usuarios_id=Session::get('id');
                if ($pacientes->save()) {
                    Flash::valid('O paciente foi cadastrado...!!!');            
                } else {
                    Flash::warning('Não é possivel cadastrar os dados...!!!');
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function editar($id) {
        $this->titulo = 'Alterar Paciente';
        try {
            $usuario_id = Auth::get('id');
            $usuario_id = Filter::get($usuario_id, 'digits');
            $usuario = new Usuarios();
            $this->usuario = $usuario->getNombres($usuario_id);
            $id = (int) $id;
            View::select('crear');
            $paciente = new Paciente();
            $this->paciente = $paciente->find_first("conditions: id=$id and areas_id= 1"/*.Session::get('SITEID')*/);
            if ($this->paciente) {
                if (Input::hasPost('paciente')) {
                    if ($paciente->update(Input::post('paciente'))) {
                        Flash::valid('O paciente foi Alterado...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                          Input::delete();
                    } else {
                        Flash::warning('Na é possivel alterar os dados...!!!!!');
                    }
                }
            } else {
                Flash::warning("Não existe paciente com id '{$id}'");
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
            $paciente = new Paciente();
            if (!$paciente->find_first("conditions: id=$id"/*.Session::get('SITEID')*/)) { //si no existe
                Flash::warning("Não existe paciente com id '{$id}'");
            } else if ($paciente->delete()) {
                Flash::valid("O paciente <b>{$paciente->nome}</b> foi excluido...!!!");
            } else {
                Flash::warning("Não é possivel excluir o paciente <b>{$paciente->nome}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
    public function activar($id) {
        try {
            $id = (int) $id;
            $paciente = new Paciente();
            if (!$paciente->find_first($id)) { //si no existe
                Flash::warning("Não existe paciente com id '{$id}'");
            } else if ($paciente->activar()) {
                Flash::valid("O paciente <b>{$paciente->nombre}</b> esta agora <b>ativo</b>...!!!");
            } else {
                Flash::warning("Não pode ativar o paciente <b>{$paciente->nombre}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }
    public function desactivar($id) {
        try {
            $id = (int) $id;
            $paciente = new Paciente();
            if (!$paciente->find_first($id)) { //si no existe
                Flash::warning("Não existe paciente com id '{$id}'");
            } else if ($paciente->desactivar()) {
                Flash::valid("O paciente <b>{$paciente->nome}</b> esta agora <b>inativo</b>...!!!");
            } else {
                Flash::warning("Não pode desativar o paciente <b>{$paciente->nome}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
}
?>