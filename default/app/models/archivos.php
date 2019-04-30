<?php
class Archivos extends ActiveRecord {
    protected function initialize()
	{
		$this->belongs_to('carpetas','usuarios');
		//$this->has_many('carpetas','usuarios');
    }
}
?>

