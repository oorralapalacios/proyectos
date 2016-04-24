<?php
class Subproducto extends DataMapper {
	var $table = 'subproductos';
    var $extensions = array('json');
	var $has_one = array('producto');

    function __construct($id = NULL)
    {
        parent::__construct($id);
		
    }
	
    
    function datails_query($prod_id = NULL){
    	 $this->db->select('subproductos.*, productos.nombre as subproducto');
		 $this->db->join('productos', 'subproductos.subproducto_id = productos.id','left');
		 $this->db->from('subproductos');
		 $this->db->where('subproductos.producto_id', $prod_id);
		 $this->db->where('subproductos.estado', 'AC');
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}  

	      
}
