<?php
class Carpetas extends ActiveRecord {
    protected function initialize()
	{
        $this->has_many('areas');
		$this->belongs_to('archivos','usuarios');
    }
}

