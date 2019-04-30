<?php
Load::models('areas','contenidomenu','carpetas','contenidos','noticiasyeventos','correos');
//Load::lib('fecha');
//require_once APP_PATH.'libs/fecha.php';
class PaginaController extends AppController
{
	public $limit_params = FALSE;
	protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
            //View::response("view");
        }
    }

	public function index(){
		setcookie("ellus",$opcion,(time()+$tiempo));
		$_COOKIE["ellus"] = $opcion;

		$this->seccion='inicio';
		Session::set('_SECCION','$this->seccion');
		echo $this->ellus = $_COOKIE['ellus'];
	}

	public function contenido(){
		$this->titulo = 'SEMINÁRIO SAÚDE E LONGEVIDADE';
		View::template('contenido');
	}

	public function clinica(){
		$this->titulo = 'SEMINÁRIO SAÚDE E LONGEVIDADE';
		View::template('clinica');
	}

	public function contato(){
		View::select('contato');
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

            if (!empty(Input::post('message'))) {
				$nome    = Input::post('nome');
	            $email   = Input::post('email');
	            $phone    = Input::post('phone');
	            $whatsapp    = Input::post('whatsapp');
	            $message = Input::post('message');
	            @$mensagem .="<p>Contato - pRO Saúde Integral<br><br>
				<strong>Nome:</strong> $nome<br>
				<strong>E-mail:</strong> $email<br>
				<strong>Telefono:</strong> $phone<br>
				<strong>WhatsApp:</strong> $whatsapp<br>
				<strong>Mensagem:</strong> $message<br>IP: $ip</p>";
			}else {
				$nome    = Input::post('nome');
	            $email   = Input::post('email');
	            $message = 'Mantenha-se Informado';
	            @$mensagem .="<p>Contato - pRO Saúde Integral<br><br>
				<strong>Nome:</strong> $nome<br>
				<strong>E-mail:</strong> $email<br>
				<strong>Mensagem:</strong> $message<br>IP: $ip</p>";
			}
            //$this->nome=$nome;

            Load::lib('phpmailer/class.phpmailer');

            $mail = new PHPMailer();
            $mail->isSMTP();
	        $mail->Host = 'smtp.gmail.com';//'smtp.tudominio.com';
	        $mail->SMTPAuth = true;
	        $mail->Username = 'ortizmas14@gmail.com';
	        $mail->Password = 'lg*te_amo';
	        $mail->SMTPSecure = 'ssl';
	        $mail->Port = 465;//587;  //revisar configuracion del puerto pues depende de cada host

	        //$mail->setLanguage('es', PUBLIC_PATH . 'lang/');
	        $mail->From = '$email'; //'usuario@tudominio.com'
	        $mail->FromName = $nome;
	        $mail->addAddress('ortizmas14@gmail.com', 'Pro Saúde Integral');
	        //$mail->addBCC('mikimouse@upeu.edu.pe');

	        $mail->isHTML(true);
	        if (!empty(Input::post('message'))) {
	        	$mail->Subject = 'Mensagem do site Pro Saúde Integral';//'Asunto del correo';
	        }else {
	        	$mail->Subject = 'Para Newsletter';//'Asunto del correo';
	        }
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

	public function inscricao(){
		if (Input::hasPost('nome','rg','cpf','datanacimento','cep','cidade','uf','fone','confirm_email')){

            if (!empty($_SERVER['HTTP_CLIENT_IP']))
			{
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				$ip = $_SERVER['REMOTE_ADDR'];
			}

            $ins_nome    = Input::post('nome');
            $ins_rg    = Input::post('rg');
            $ins_cpf    = Input::post('cpf');
            $ins_datanacimento    = Input::post('datanacimento');
            $ins_rua    = Input::post('rua');
            $ins_numero    = Input::post('numero');
            $ins_barrio    = Input::post('barrio');
            $ins_cep    = Input::post('cep');
            $ins_cidade    = Input::post('cidade');
            $ins_uf    = Input::post('uf');
            $ins_formacao    = Input::post('formacao');
            $ins_empresa    = Input::post('empresa');
            $ins_ramo    = Input::post('ramo');
            $ins_funcao   = Input::post('funcao');
            $ins_fone = Input::post('fone');
            $ins_confirm_email = Input::post('confirm_email');
            @$mensagem .="<p>Esta mensagem foi enviada pelo Portal Web Crescer Brasil<br><br>
			<strong>Nome:</strong> $ins_nome<br>
			<strong>RG:</strong> $ins_rg<br>
			<strong>CPF:</strong> $ins_cpf<br>
			<strong>Data de Nacimento:</strong> $ins_datanacimento<br>
			<strong>RUA:</strong> $ins_rua - <strong>Numero:</strong> $ins_numero <br>
			<strong>Barrio:</strong> $ins_barrio - <strong>CEP:</strong> $ins_cep <br>
			<strong>Cidade:</strong> $ins_cidade - <strong>UF:</strong> $ins_uf <br>
			<strong>Formação:</strong> $ins_formacao<br>
			<strong>Empresa:</strong> $ins_empresa<br>
			<strong>Ramo:</strong> $ins_ramo<br>
			<strong>Função:</strong> $ins_funcao<br>
			<strong>Fone:</strong> $ins_fone<br>
			<strong>E-mail:</strong> $ins_confirm_email<br>
			<strong>IP:</strong> $ip</p>";
            //$this->nome=$nome;

            Load::lib('phpmailer/class.phpmailer');

            $mail = new PHPMailer();
            $mail->isSMTP();
	        $mail->Host = 'smtp.gmail.com';//'smtp.tudominio.com';
	        $mail->SMTPAuth = true;
	        $mail->Username = 'ortizmas14@gmail.com';
	        $mail->Password = 'lg*te_amo';
	        $mail->SMTPSecure = 'ssl';
	        $mail->Port = 465;//587;  //revisar configuracion del puerto pues depende de cada host

	        //$mail->setLanguage('es', PUBLIC_PATH . 'lang/');
	        $mail->From = '$ins_confirm_email'; //'usuario@tudominio.com'
	        $mail->FromName = $ins_nome;
	        $mail->addAddress('ortizmas14@gmail.com', 'Crescer Brasil');
	        $mail->addBCC('mikimouse@upeu.edu.pe');

	        $mail->isHTML(true);

	        $mail->Subject = 'Mensagem do Site CrescerBrasil';//'Asunto del correo';
	        $mail->Body    = "$mensagem";
	        $mail->AltBody = "$mensagem"; //es alternativo, para clientes que no soportan html

	        if(!$mail->send()) {
	            /*Logger::debug('Message could not be sent.');
	            Logger::debug('Mailer Error: ' . $mail->ErrorInfo);
	            return false;*/
	            echo Flash::warning('Sua messagem não foi enviado.');
	            Router::redirect('/inscrevase');
	        } else {
	            //$this->nome = Logger::debug('Message has been sent');
	            //return true;
	            echo Flash::success('Sua messagem foi cadastrado, estaremos en contato.');
	            Router::redirect('/inscrevase');
	        }

	    }else{
	    	echo Flash::warning('Cadastre os dados porfavor!!');
	    	Router::redirect('/inscrevase');
	    }
	}
	public function contatos(){
		View::template('contatos');
	}
	public function inscrevase(){
		View::template('inscrevase');
	}
	public function conteudocb($seccion, $opcion='',$subopcion='', $accion='', $parametro=''){
		//echo $this->controller_name; //noticias
		//echo $this->action_name; //ver
		//Un array con todos los parámetros enviados a la acción
		//var_dump($this->parameters);
		$parametros = $this->parameters;
		$this->seccion = $parametros[0];
		$this->opcion = $parametros[1];
		$areas_id = 1;
		$idiomas_id = 1;
		if ($this->seccion == 'destaque') {
			if($this->opcion!=''){
				$Destaque = New Noticiasyeventos();
				$this->destaque = $Destaque->find_first("conditions: areas_id= $areas_id and idiomas_id= $idiomas_id  and urlpath= '$this->opcion' and posicion= 1 and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
				$this->pantallatotal = $Destaque->pantalla;
			}else{
				//$this->Destaque = Load::model('noticiasyeventos')->find("conditions: areas_id= 1 and idiomas_id= 1 and posicion= 5 and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')","order: publicar desc","group: titulo");
				Router::redirect(' ');
			}
			//View::template('contenido');
		}elseif($this->seccion == 'servicos') {
			if($this->opcion!=''){
				$Servicos = New Noticiasyeventos();
				$this->servicos = $Servicos->find_first("conditions: areas_id= $areas_id and idiomas_id= $idiomas_id  and id= '$this->opcion' and posicion= 4 and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
						$this->pantallatotal = $Servicos->pantalla;
			}else{
				//$this->Servicos = Load::model('noticiasyeventos')->find("conditions: areas_id= 1 and idiomas_id= 1 and posicion= 5 and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')","order: publicar desc","group: titulo");
				Router::redirect(' ');
			}
			//View::template('contenido');
		}elseif($this->seccion == 'treinamentos') {
			if($this->opcion!=''){
				$Treinamentos = New Noticiasyeventos();
				$this->Treinamentos = $Treinamentos->find_first("conditions: areas_id= $areas_id and idiomas_id= $idiomas_id  and id= $this->opcion and posicion= 5 and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
						$this->pantallatotal = $Treinamentos->pantalla;
			}else{
				//$this->Treinamentos = Load::model('noticiasyeventos')->find("conditions: areas_id= 1 and idiomas_id= 1 and posicion= 5 and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')","order: publicar desc","group: titulo");
				Router::redirect(' ');
			}
			//View::template('contenido');
		}elseif ($this->seccion == 'eventos') {
			if($this->opcion!=''){
				$Eventos = New Noticiasyeventos();
				$this->Eventos = $Eventos->find_first("conditions: areas_id= $areas_id and idiomas_id= $idiomas_id  and id= $this->opcion and tipo='destaque' and posicion= 1 and activo='1' and caducar >= date_format(now(),'%Y-%m-%d')");
						$this->pantallatotal = $Eventos->pantalla;
			}else{
				Router::redirect(' ');
			}
		}
		else{
			View::template('default');
		}
		//View::select(NULL,'ver');
		View::template('contenido');
	}
	public function modeloparametros($seccion, $opcion='',$subopcion='', $accion='', $parametro=''){
		echo $this->controller_name; //noticias
		echo $this->action_name; //ver
		//Un array con todos los parámetros enviados a la acción
		var_dump($this->parameters);

		View::select(NULL,'ver');
		/*Respuesta*/
		/*http://www.ellustreinamentos.com.bs/pt/seccion/opcion/subopcion/accion/parametro/*/
		/*pagina/modeloparametros
		array (size=5)
		  0 => string 'seccion' (length=7)
		  1 => string 'opcion' (length=6)
		  2 => string 'subopcion' (length=9)
		  3 => string 'accion' (length=6)
		  4 => string 'parametro' (length=9)*/
	}
}

?>