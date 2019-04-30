<?php
class Informacoes extends ActiveRecord {
    protected function initialize()
	{
		$this->belongs_to('usuarios');
    }
}
?>

