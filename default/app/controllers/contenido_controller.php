<?php
Load::models('areas','contenidomenu','carpetas','contenidos','noticiasyeventos','correos');
class ContenidoController extends AppController
{
	public $limit_params = FALSE;
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
		if ($opcion == 'projetos') {
			if ($subopcion !='') {
				$projetos = Load::model('noticiasyeventos');
				$this->conteudoProjeto = $projetos->find_first("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and urlpath= '$subopcion' and tipo='projetos' and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
				$this->titulo = $projetos->titulo;
			}else {
				Router::redirect(' ');
			}
		}elseif ($opcion == 'clinica') {
			if ($subopcion !='') {
				$projetos = Load::model('noticiasyeventos');
				$this->conteudoProjeto = $projetos->find_first("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and urlpath= '$subopcion' and tipo='clinica' and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
				$this->titulo = $projetos->titulo;
			}else {
				Router::redirect(' ');
			}
		}elseif ($opcion == 'dicasdasaude') {
			if ($subopcion !='') {
				$projetos = Load::model('noticiasyeventos');
				$this->conteudoProjeto = $projetos->find_first("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and urlpath= '$subopcion' and tipo='dicasDeSaude' and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
				$this->titulo = $projetos->titulo;
			}else {
				Router::redirect(' ');
			}
		}elseif ($opcion == 'club-vantagens') {
			if ($subopcion !='') {
				$projetos = Load::model('noticiasyeventos');
				$this->conteudoProjeto = $projetos->find_first("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and urlpath= '$subopcion' and tipo='clubVantagens' and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
				$this->titulo = $projetos->titulo;
			}else {
				Router::redirect(' ');
			}

		}elseif ($opcion == 'agende-uma-consulta') {
			$Contenidomenu = Load::model('contenidomenu')->find_first("conditions: areas_id =$areas_id and urlpath= '$opcion'");
			if ($Contenidomenu != false) {
				$this->miniatura =$Contenidomenu->miniatura;
				$this->contenidos = Load::model('contenidos')->find_first("conditions: idiomas_id=$idiomas_id and contenidomenu_id='$Contenidomenu->id'");
			}
			$this->titulo = $projetos->titulo;
			$this->titulo="AGENDE UMA CONSULTA";
			View::select('agenda');
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
					$this->titulo =$Contenidomenu->titulo;
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
					$this->titulo =$Contenidomenu->titulo;
					$this->contenidos = Load::model('contenidos')->find_first("conditions: idiomas_id=$idiomas_id and contenidomenu_id='$Contenidomenu->id'");
				}else {
					Router::redirect(' ');
				}
			}
		}
		View::template('contenido');
	}

	public function contato(){
		//View::select('contato');
		$url    = Input::post('url');
		if (Input::hasPost('nome','email','phone','message')){

            if (!empty($_SERVER['HTTP_CLIENT_IP']))
			{
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
				$nome    = Input::post('nome');
				$sexo    = Input::post('sexo');
				$datanacimento    = Input::post('datanacimento');
	            $email   = Input::post('email1');
	            $pais    = Input::post('pais');
	            $estado    = Input::post('estado');
	            $horario    = Input::post('horario');
	            $atendimento    = Input::post('atendimento');
	            /*$phone    = Input::post('phone');
	            $whatsapp    = Input::post('whatsapp');*/
	            $message = Input::post('menssagem');
	            @$mensagem .="<p>Contato - PRO Saúde Integral<br><br>
				<strong>Nome:</strong> $nome<br>
				<strong>Sexo:</strong> $sexo<br>
				<strong>Data de Nacimento:</strong> $datanacimento<br>
				<strong>E-mail:</strong> $email<br>
				<strong>Pais:</strong> $pais<br>
				<strong>Estado:</strong> $estado<br>
				<strong>Horario:</strong> $horario<br>
				<strong>Opção de atendimento:</strong> $atendimento<br>
				<strong>Mensagem:</strong> $message<br>IP: $ip</p>";
            //$this->nome=$nome;

            Load::lib('phpmailer/class.phpmailer');

            $mail = new PHPMailer();
            $mail->isSMTP();
	        $mail->Host = 'smtp.gmail.com';//'smtp.tudominio.com';smtp.gmail.com
	        $mail->SMTPAuth = true;
	        $mail->Username = 'webmaster@iaene.br';
	        $mail->Password = '2016#$WebMaster';
	        $mail->SMTPSecure = 'ssl';
	        $mail->Port = 465;//587;  //revisar configuracion del puerto pues depende de cada host

	        //$mail->setLanguage('es', PUBLIC_PATH . 'lang/');
	        $mail->From = '$email'; //'usuario@tudominio.com'
	        $mail->FromName = $nome;
	        $mail->addAddress('contato@prosaudeintegral.com.br', 'Pro Saúde Integral');
	        $mail->addBCC('ortizmas14@gmail.com');
	        $mail->isHTML(true);
	        $mail->Subject = 'AGENDE UMA CONSULTA';//'Asunto del correo';
	        $mail->Body    = "$mensagem";
	        $mail->AltBody = "$mensagem"; //es alternativo, para clientes que no soportan html

	        if(!$mail->send()) {
	            /*Logger::debug('Message could not be sent.');
	            Logger::debug('Mailer Error: ' . $mail->ErrorInfo);
	            return false;*/
	            echo Flash::warning('Sua mesagem não foi enviado.');
	            Router::redirect($url);
	        } else {
	            //$this->nome = Logger::debug('Message has been sent');
	            //return true;
	            echo Flash::success('Sua mesagem foi enviado, estaremos en contato.');
	            Router::redirect($url);
	        }

	    }else{
	    	echo Flash::warning('Cadastre os dados porfavor!!');
	    	Router::redirect($url);
	    }
	}
}
?>