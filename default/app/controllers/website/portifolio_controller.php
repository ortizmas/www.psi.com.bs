<?php
Load::model('portifolio');
class PortifolioController extends AdminController{
	
    protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }
    
    public function index($pag= 1) {
        try {
            $Portifolio = new Portifolio();
            $this->portifolio = $Portifolio->paginate("page: $pag");
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function crear() {
        $this->titulo = 'Criar Portafolio';
        try {

            if (Input::hasPost('portifolio')) {
                $portifolio = new Portifolio(Input::post('portifolio'));
                if ($portifolio->save()) {
                    Flash::valid('O portifolio ha sido agregado exitosamente...!!!');
                    if (!Input::isAjax()) {
                        return Router::redirect();
                    }
                } else {
                    Flash::warning('Não é posivel guardar los datos...!!!');
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function editar($id) {
        $this->titulo = 'Alterar Portifolio';
        try {
            $id = (int) $id;
            View::select('crear');
            $Portifolio = new Portifolio();
            $this->portifolio = $Portifolio->find_first($id);
            if ($this->portifolio) {//verificamos la existencia del sede
                if (Input::hasPost('portifolio')) {
                    if ($Portifolio->update(Input::post('portifolio'))) {
                        Flash::valid('O portifolio ha sido atualizado exitosamente...!!!');
                        if (!Input::isAjax()) {
                            return Router::redirect();
                        }
                    } else {
                        Flash::warning('Não é posivel guardar os datos...!!!');
                    }
                }
            } else {
                Flash::warning("Não têm ningum portifolio com id '{$id}'");
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
            $Portafolio = new Portifolio();
            
            if (!$Portafolio->find_first($id)) { //si no existe
                Flash::warning("Não existe portifolio com id '{$id}'");
            } else if ($Portafolio->delete()) {
                Flash::valid("o Portifolio <b>{$Portafolio->titulo}</b> foi excluido...!!!");
            } else {
                Flash::warning("Não é posivel excluir o portifolio <b>{$Portifolio->titulo}</b>...!!!");
            }
            
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }

    public function activar($id) {
        try {
            $id = (int) $id;

            $Portifolio = new Portifolio();

            if (!$Portifolio->find_first($id)) { //si no existe
                Flash::warning("Não existe portifolio com id '{$id}'");
            } else if ($Portifolio->activar()) {
                Flash::valid("O portifolio<b>{$Portifolio->titulo}</b> esta agora <b>ativo</b>...!!!");
            } else {
                Flash::warning("Não é posivel ativar o portifolio <b>{$Portifolio->titulo}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        Router::redirect();
    }

    public function desactivar($id) {
        try {
            $id = (int) $id;
            $Portifolio = new Portifolio();

            if (!$Portifolio->find_first($id)) { //si no existe
                Flash::warning("Não existe portifolio com id '{$id}'");
            } else if ($Portifolio->desactivar()) {
                Flash::valid("o Portifolio <b>{$Portifolio->titulo}</b> foi excluido...!!!");
            } else {
                Flash::warning("Não é posivel excluir o portifolio <b>{$Portifolio->titulo}</b>...!!!");
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        return Router::redirect();
    }
}

?>