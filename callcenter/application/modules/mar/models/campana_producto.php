<?php
class Campana_Producto extends DataMapper {
    var $table = 'campanas_productos';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	 
	  
	 function datails_query($campana_id = NULL){
    	 $this->db->select('campanas_productos.*, productos.nombre as producto');
		 $this->db->join('productos', 'campanas_productos.producto_id = productos.id','left');
		 $this->db->from('campanas_productos');
		 $this->db->where('campana_id', $campana_id);
		  $this->db->where('campanas_productos.estado', 'AC');
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}  
}