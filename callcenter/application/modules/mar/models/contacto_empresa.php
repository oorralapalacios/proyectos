<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contacto_Empresa extends DataMapper {
    var $extensions = array('json');
    var $table = 'contactos_empresas';
    var $has_one = array('contacto','empresa');
	 
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	 	
}