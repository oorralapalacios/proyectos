<?php
class Marca extends DataMapper {
    var $table = 'marcas';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

/* End of file modelo.php */
/* Location: ./application/modules/marcas/models/marca.php */