<?php
class Tarifa extends DataMapper {
    var $table = 'productos_tarifas';
    var $extensions = array('json');
	var $has_one = array('producto');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function custom_query(){
    	 $this->db->select('productos_tarifas.*, unidades.nombre as unidad');
		 $this->db->join('unidades', 'productos_tarifas.unidad_id = unidades.id','left');
		 $this->db->from('productos_tarifas');
	     $this->db->where('productos_tarifas.estado', 'AC');
		 //$this->db->where('producto_id', $id);
		 $this->db->order_by("productos_tarifas.id","ASC");
		 return $this->db->get();
	}
	  
	 function datails_query($prod_id = NULL){
    	 $this->db->select('productos_tarifas.*, unidades.nombre as unidad');
		 $this->db->join('unidades', 'productos_tarifas.unidad_id = unidades.id','left');
		 $this->db->from('productos_tarifas');
		 $this->db->where('productos_tarifas.producto_id', $prod_id);
		 $this->db->where('productos_tarifas.estado', 'AC');
		 $this->db->order_by("productos_tarifas.id","ASC");
		 return $this->db->get();
	}  
}