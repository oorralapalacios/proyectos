<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tipo_cliente extends DataMapper {
    var $extensions = array('json');
    var $table = 'tipo_clientes';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

/* End of file roles.php */
/* Location: ./application/modules/seg/models/roles.php */