<?php
Load::models('paciente','perfildasaude');
class ConsultorioController extends AppController
{
    protected function after_filter() {
        if (Input::isAjax()) {
            //View::select(NULL, NULL);
            View::response("view");
        }
    }
    public function index()
    {
        $this->titulo='Cadastro de Cliente';
        View::template('consultorio');
    }
    public function crear() {
        $this->titulo='Cadastro de Cliente';
        //view::select('index');
        try {
            if (Input::hasPost('paciente')) {
                $pacientes = new Paciente(Input::post('paciente'));
                //print_r($paciente);
                /*$date = str_replace('/', '-', $paciente['datanasc']);
                $paciente->datanasc = date('Y-m-d', strtotime($date));*/
                if ($pacientes->save()) {
                    $perfil = Input::Post('perfildasaude');
                    $outros = Input::Post('outros');
                    $perfildasaude = new Perfildasaude();
                    foreach ($perfil as $value) {
                        if (!$perfildasaude->AsignarPerfil($pacientes->id, $value, $outros)) {
                            Flash::error('Não é posivel cadastrar os perfiles da Saude...');
                            $this->rollback();
                            return FALSE;
                        }
                    }
                    Flash::info('Seus dados forem cadastrados...!!!');
                    echo "<script type='text/javascript'>$('#Formulario')[0].reset();</script>";
                    Router::redirect('/consultorio/', 2);
                } else {
                    echo Flash::warning('Não foi possivel cadastrar seus dados...!!!');
                    Router::redirect('/consultorio/', 2);
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
        View::template('consultorio');
    }
}
