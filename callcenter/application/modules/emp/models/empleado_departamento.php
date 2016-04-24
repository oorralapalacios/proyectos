<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empleado_departamento extends DataMapper {
    var $extensions = array('json');
    var $table = 'empleados_departamentos';
	
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	
}