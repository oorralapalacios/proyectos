<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresa extends DataMapper {
    var $extensions = array('json');
    var $table = 'empresas';
    var $has_many = array('empresa_campo','contacto_empresa');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}