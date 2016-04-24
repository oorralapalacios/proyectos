<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cita_Producto extends DataMapper {
    var $extensions = array('json');
    var $table = 'citas_productos';
    var $has_one = array('cita');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function productos($cita_id = NULL){
    	 $this->db->select('citas_productos.*, productos.nombre as producto');
		 $this->db->join('productos', 'citas_productos.producto_id = productos.id','left');
		 $this->db->from('citas_productos');
		 $this->db->where('cita_id', $cita_id);
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}  
		 	
}