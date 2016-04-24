<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cliente extends DataMapper {
    var $extensions = array('json');
    var $table = 'clientes';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}