<?php
class Modelo extends DataMapper {
    var $table = 'modelos';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

/* End of file modelo.php */
/* Location: ./application/modules/modelo/models/modelo.php */