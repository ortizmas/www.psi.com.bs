<?php
class LojaController extends AppController
{
    protected function after_filter() {
        if (Input::isAjax()) {
            //View::select(NULL, NULL);
            View::response("view");
        }
    }

    public function index()
    {
        $this->titulo='Consultorio';
        View::template('loja');
    }
    public function crear() {
        try {

        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

}