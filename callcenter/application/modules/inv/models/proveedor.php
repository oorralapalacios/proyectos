<?php
class Proveedor extends DataMapper {
    var $table = 'proveedores';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

/* End of file modelo.php */
/* Location: ./application/modules/proveedores/models/proveedor.php */