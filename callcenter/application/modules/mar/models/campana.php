<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Campana extends DataMapper {
    var $extensions = array('json');
    var $table = 'campanas';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	 function categorias($camp_id= NULL,$cliente_tipo_id= NULL){
	 	$sql="SELECT * FROM categorias
               WHERE EXISTS (SELECT * FROM productos, campanas_productos
               WHERE campanas_productos.producto_id=productos.id
               and productos.estado='AC'
               and productos.categoria_id=categorias.id
			   and campanas_productos.campana_id =?
               and productos.cliente_tipo_id = ?)
               and categorias.estado='AC';";
	    $params = array($camp_id,$cliente_tipo_id);
		$query=$this->db->query($sql,$params);
		return $query;
	 
	  }
	
	 function productos($camp_id= NULL,$cat_id= NULL){
	 	 $this->db->select('productos.*');
		 $this->db->join('productos', 'campanas_productos.producto_id = productos.id','left');
		 $this->db->from('campanas_productos');
		 $this->db->where('campanas_productos.campana_id', $camp_id);
		 $this->db->where('productos.categoria_id', $cat_id);
		 $this->db->where('campanas_productos.estado', 'AC');
	     $this->db->order_by("id","ASC");
		 return $this->db->get();
	 }	
	 
	 function listproductos($camp_id= NULL,$cat_id= NULL){
	 	$sql="SELECT productos.id,
	 	       productos.nombre,
	 	       productos.descripcion,
	 	       productos.costo,
	 	       productos.iva,
	 	       productos.descuento,
	 	       productos.estado
	 	       FROM productos, campanas_productos
               WHERE campanas_productos.producto_id=productos.id
               and campanas_productos.campana_id =?
               and productos.categoria_id=?
               and campanas_productos.estado='AC'
			   and productos.estado='AC';";
	    $params = array($camp_id,$cat_id);
		$query=$this->db->query($sql,$params);
		return $query;
	 }	
	 
	 
	 function listsubproductos($pro_id= NULL){
	   $sql="SELECT productos.id,
       productos.nombre,
       productos.costo,
       productos.iva,
       productos.descuento,
       productos.estado
	   FROM productos
	   	WHERE EXISTS (SELECT * FROM subproductos
			   where subproductos.producto_id =?
	   	and estado='AC'
               )
		and estado='AC';";
	    $params = array($pro_id);
		$query=$this->db->query($sql,$params);
		return $query;
	 }	
	 
	 
	  function filtersubproductos($pro_id= NULL){
	   $sql="SELECT productos.id,
        productos.nombre,
        productos.costo,
        productos.iva,
        productos.descuento,
        productos.estado
	    FROM productos, subproductos 
	    where subproductos.subproducto_id=productos.id
	    and subproductos.producto_id =?
	    and productos.estado='AC'
	    and subproductos.estado='AC';";
	    $params = array($pro_id);
		$query=$this->db->query($sql,$params);
		return $query;
	 }	
	 
	 
	 function custom_query(){
    	 $this->db->select('campanas.*');
		 $this->db->from('campanas');
	     $this->db->order_by("id","ASC");
	     $this->db->where('campanas.estado', 'AC');
		 return $this->db->get();
	}	
}

/* End of file roles.php */
/* Location: ./application/modules/seg/models/roles.php */