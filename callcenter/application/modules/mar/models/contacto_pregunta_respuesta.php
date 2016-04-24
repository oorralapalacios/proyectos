<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contacto_pregunta_respuesta extends DataMapper {
    var $extensions = array('json');
    var $table = 'contacto_pregunta_respuesta';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	 
}