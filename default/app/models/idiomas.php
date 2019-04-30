<?php
class Idiomas extends ActiveRecord {
    protected function initialize(){
        
        $this->validates_presence_of('nombre', 'message: Debe escribir un <b>Nombre</b> para el idioma');
        $this->validates_presence_of('code', 'message: Debe escribir un <b>Código</b> para el idioma');
        $this->validates_presence_of('Charset', 'message: Debe escribir un <b>Tipo de encodificación de caracteres</b> para el idioma');
    }
}

