<?php
class Parametrica extends DataMapper {
    var $table = 'parametricas';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	 
	
}