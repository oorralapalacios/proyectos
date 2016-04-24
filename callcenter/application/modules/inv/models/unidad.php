<?php
class Unidad extends DataMapper {
    var $table = 'unidades';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function custom_query(){
    	 $this->db->select('unidades.id, unidades.nombre as unidad');
		 $this->db->from('unidades');
		 //$this->db->where('producto_id', $id);
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}
}