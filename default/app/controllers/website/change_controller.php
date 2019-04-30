<?php
class ChangeController extends AdminController{
	protected function before_filter(){
		
	}
	public function index(){
		
		Input::delete();
		Flash::warning('Este cambio se aplicará a todo el sistema');
		View::select(NULL, 'website/changemanual');
		return FALSE;	
	}
	public function from($uri){
		$this->uri=$uri;
		Input::delete();
		Flash::warning('Este cambio se aplicará a todo el sistema');
		View::select(NULL, "website/changemanual");//llama al template a aplicar
		return FALSE;	
	}
}
?>