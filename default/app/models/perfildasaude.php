<?php
class Perfildasaude extends ActiveRecord {
    protected function initialize()
	{
        //$this->has_many('perfildasaude');
		$this->belongs_to('paciente');
    }

    public function AsignarPerfil($id_paciente,$perfil, $outros){
        return ($this->create(array(
            'paciente_id' => $id_paciente,
            'perfil' => $perfil,
            'outros' => $outros,
        )));
    }
}