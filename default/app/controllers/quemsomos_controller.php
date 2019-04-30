<?php
	class QuemsomosController extends AppController{
		public function index(){
			$this->titulo = "Quem Somos";
			View::template('quemsomos');
		}
	}
?>