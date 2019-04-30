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
            if (Input::post('message')) {
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
	        $mail->Host = 'smtp.gmail.com';//'smtp.tudominio.com';smtp.gmail.com
	        $mail->SMTPAuth = true;
	        $mail->Username = 'webmaster@iaene.br';
	        $mail->Password = '2016#$WebMaster';
	        $mail->SMTPSecure = 'ssl';
	        $mail->Port = 465;//465;//587;  //revisar configuracion del puerto pues depende de cada host
	        //$mail->setLanguage('es', PUBLIC_PATH . 'lang/');
	        $mail->From = '$email'; //'usuario@tudominio.com'
	        $mail->FromName = $nome;
	        $mail->addAddress('contato@prosaudeintegral.com.br', 'Pro Saúde Integral');
	        $mail->addBCC('ortizmas14@gmail.com');
	        $mail->isHTML(true);
	        if (Input::post('message')) {
	        	$mail->Subject = 'Mensagem do site Pro Saúde Integral';//'Asunto del correo';
	        }else {
	        	$mail->Subject = 'Para Newsletter';//'Asunto del correo';
	        }
	        $mail->Body    = "$mensagem";
	        $mail->AltBody = "$mensagem"; //es alternativo, para clientes que no soportan html
	        if(!$mail->send()) {
	            echo Flash::warning('Sua mesagem não foi enviado.');
	            Router::redirect($url);
	        } else {
	            echo Flash::success('Sua mesagem foi enviado, estaremos en contato.');
	            Router::redirect($url);
	        }
	    }else{
	    	echo Flash::warning('Cadastre os dados porfavor!!');
	    	Router::redirect($url);
	    }
	}
	public function contatos(){
		View::template('contatos');
	}
}
?>