<?php
Load::model('informacoes', 'usuarios');
class InformacoesController extends AdminController{
    
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    
    public function index($pag= 1, $ppage = 30) {
        try {
            $informacoes = new Informacoes();
            $this->informacao = $informacoes->paginate("conditions: areas_id =1","page: $pag","per_page: $ppage");
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function informacao() {
        try {
            //echo $id_usuario = Auth::get('id');
            $informacoes = new Informacoes();
            $informacao = $informacoes->find("conditions: usuarios_id =".Auth::get('id'));
            //print_r($informacao);
            $this->nome = $informacao[0]['nome'];
            $this->conteudo = $informacao[0]['conteudo'];
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function crear() {
        $this->titulo = 'Criar Informaçoes';
        try {
            //$Areasupeu = new Areasupeu();
            //$this->areasupeu=$Areasupeu->find();
            if (Input::hasPost('informacoes')) {
                $informacoes = new Informacoes(Input::post('informacoes'));
                if ($informacoes->save()) {
                    //print_r($areas);
                    Flash::valid('A Informação foi Cadastrada...!!!');
                    if (!Input::isAjax()) {
                        return Router::redirect('index');
                    }
                    Input::delete();
                } else {
                    Flash::warning('Não foi posivel cadastrar os dados...!!!');
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function editar($id) {
        $this->titulo = 'Alterar Informações';
        try {
            $id = (int) $id;
            View::select('crear');
            $informacoes = new Informacoes();
            $this->informacoes = $informacoes->find_first($id);
            if ($this->informacoes) {//verificamos la existencia del sede
                if (Input::hasPost('informacoes')) {
                    if ($informacoes->update(Input::post('informacoes'))) {
                        Flash::valid('A informação foi Alterada...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                        Input::delete();
                    } else {
                        Flash::warning('Não é posivel alterar a Informação...!!!');
                    }
                }
            } else {
                Flash::warning("Não existe informaçõ com id '{$id}'");
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