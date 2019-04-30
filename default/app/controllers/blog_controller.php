<?php
Load::models('areas','contenidomenu','carpetas','contenidos','noticiasyeventos','correos');
class BlogController extends AppController 
{
	//public $limit_params = FALSE;

	public function index($seccion, $opcion='',$subopcion='', $accion='', $parametro=''){
		//echo $this->controller_name; //noticias
		//echo $this->action_name; //ver
		$this->seccion = $seccion;
		$this->opcion = $opcion;
		$this->subopcion = $subopcion;
		//Un array con todos los parámetros enviados a la acción
		//var_dump($this->parameters);
		$areas_id = 1;
		$idiomas_id = 1;
		if ($opcion == 'blog') {
			if ($subopcion !='') {
				$Blogs = Load::model('noticiasyeventos');
					//$this->maximo_con = $Blogs->maximum("id", "conditions: tipo='blog' and posicion=2 and activo = 1");
				$max_id = $Blogs->maximum("id", "conditions: activo = 1");
				$this->conteudoblog = $Blogs->find_first("conditions: areas_id = $areas_id and idiomas_id= $idiomas_id and urlpath= '$subopcion'");
			}else {
				$Blogs = Load::model('noticiasyeventos');
				$this->maximo_all = $Blogs->maximum("id");
				$this->maximo_con = $Blogs->maximum("id", "conditions: tipo='blog' and posicion=2 and activo = 1");
				$max_id = $Blogs->maximum("id", "conditions: activo = 1");
				$this->conteudoblog = $Blogs->find_first("conditions: id=$max_id and areas_id = $areas_id and idiomas_id= $idiomas_id and posicion='2' and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
			}

		}else {
			if($parametro!=''){
				$Contenidomenu = Load::model('contenidomenu')->find_first("conditions: areas_id =$areas_id and idiomas_id='$idiomas_id' and urlpath= '$parametro'");
				@$this->miniatura =$Contenidomenu->miniatura;
				@$this->contenidos = Load::model('contenidos')->find_first("conditions: idiomas_id=$idiomas_id and contenidomenu_id= '$Contenidomenu->id'");
				@$this->pantallatotal = $contenidos->pantalla;
			}
			else if($accion!=''){
				$Contenidomenu = Load::model('contenidomenu')->find_first("conditions: areas_id =$areas_id and urlpath= '$accion'");
				if ($Contenidomenu != false) {
					$this->miniatura =$Contenidomenu->miniatura;
					$this->contenidos = Load::model('contenidos')->find_first("conditions: idiomas_id=$idiomas_id and contenidomenu_id='$Contenidomenu->id'");
				}else {
					Router::redirect(' ');
				}
			}
			else if($subopcion!=''){
				$Contenidomenu = Load::model('contenidomenu')->find_first("conditions: areas_id =$areas_id and urlpath= '$subopcion'");
				if ($Contenidomenu != false) {
					$this->miniatura =$Contenidomenu->miniatura;
					$this->plantilla =$Contenidomenu->plantilla;
					$this->contenidos = Load::model('contenidos')->find_first("conditions: idiomas_id=$idiomas_id and contenidomenu_id='$Contenidomenu->id'");
				}else {
					Router::redirect(' ');
				}
			}
			else{
				$Contenidomenu = Load::model('contenidomenu')->find_first("conditions: areas_id =$areas_id and urlpath= '$opcion'");
				if ($Contenidomenu != false) {
					$this->miniatura =$Contenidomenu->miniatura;
					$this->contenidos = Load::model('contenidos')->find_first("conditions: idiomas_id=$idiomas_id and contenidomenu_id='$Contenidomenu->id'");
				}else {
					Router::redirect(' ');
				}
			}
		}
		View::template('contenido');
	}
}

?>