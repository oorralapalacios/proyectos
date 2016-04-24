<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rol extends DataMapper {
    var $extensions = array('json');
    var $table = 'roles';
    var $has_many = array('opcion');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

/* End of file roles.php */
/* Location: ./application/modules/seg/models/roles.php */