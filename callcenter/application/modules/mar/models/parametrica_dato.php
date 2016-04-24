<?php
class Parametrica_dato extends DataMapper {
    var $table = 'parametricas_datos';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	 
	  
}