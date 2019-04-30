<?php
class Paciente extends ActiveRecord {
    protected function initialize()
	{
        //$this->has_many('perfildasaude');
		//$this->belongs_to('archivos');
		$this->validates_presence_of('nome', 'message: Têm que escrever seu <b>Nome</b> por favor.');
    }
    function PerfilDeSaude($id){
    	$sql = "SELECT * FROM perfildasaude WHERE paciente_id=$id";
    	return $this->find_all_by_sql($sql);
    }

    public function obtenerPacienteNome($paciente) {
        if ($paciente != '') {
            $paciente = stripcslashes($paciente);
            $res= $this->find_all_by_sql("SELECT nome FROM paciente WHERE nome LIKE '%{$paciente}%' ORDER BY nome");
            if ($res) {
                foreach ($res as $paciente) {
                    $paciente[] = $paciente->nome;
                }
                return $paciente;
            }
        }
        return array('no hubo coincidencias');
    }
}