<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Campo extends DataMapper {
    var $extensions = array('json');
    var $table = 'campos';
	//var $has_many = array('contacto','empresa');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	 	
}