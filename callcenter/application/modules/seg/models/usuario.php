<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuario extends DataMapper {
    var $extensions = array('json');
    var $table = 'usuarios';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
}
