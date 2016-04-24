<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modulo extends DataMapper {
	var $auto_populate_has_many = TRUE;
    //var $auto_populate_has_one = TRUE;
    var $extensions = array('json');
    var $table = 'modulos';
    var $has_many = array('opcion');
	
	
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	
}

/* End of file modulo_model.php */
/* Location: ./application/modules/seg/models/modulo_model.php */