<?php
class Contactos extends ActiveRecord {
    protected function initialize()
	{
		$this->belongs_to('areas');
    }
}

