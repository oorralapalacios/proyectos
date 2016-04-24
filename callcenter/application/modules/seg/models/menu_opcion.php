<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_opcion extends DataMapper {
    var $extensions = array('json');
    var $table = 'menus_opciones';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}