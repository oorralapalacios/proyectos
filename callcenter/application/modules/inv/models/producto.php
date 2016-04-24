<?php
class Producto extends DataMapper {
	var $table = 'productos';
    var $extensions = array('json');
	
	/*Defino las relaciones*/
	var $has_many = array('tarifa','subproducto');
	//var $has_many = array('tarifa');
	
	/*var  $has_many  = array ( 
        'productos_tarifas'  => array( 
        'class'  =>  'tarifas' , 
        'other_field'  =>  'id' , 
        'join_other_as'  =>  'tarifa' , 
        'join_self_as'  =>  'producto' ,
        'join_table' => 'productos_tarifas'
      ) 
    ); */
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
		
    }
	
	/*function include_all_related(){
        foreach($this->has_many as $h){
            $this->include_related($h['class']);
        }
        return $this;
    }*/
    
    function custom_query(){
    	 $this->db->select('productos.*, categorias.nombre as categoria, proveedores.razon_social as proveedor,marcas.nombre as marca, modelos.nombre as modelo,tipo_clientes.descripcion as tipo_cliente');
		 $this->db->join('categorias', 'productos.categoria_id = categorias.id','left');
		 $this->db->join('proveedores', 'productos.proveedor_id = proveedores.id','left');
		 $this->db->join('marcas', 'productos.marca_id = marcas.id','left');
		 $this->db->join('modelos', 'productos.modelo_id = modelos.id','left');
		 $this->db->join('tipo_clientes', 'productos.cliente_tipo_id = tipo_clientes.id','left');
	     $this->db->from('productos');
	     $this->db->order_by("id","ASC");
		 return $this->db->get();
	}	

    function info_query($prod_id=null){
    	 $this->db->select('productos.*, categorias.nombre as categoria, proveedores.razon_social as proveedor,marcas.nombre as marca, modelos.nombre as modelo,tipo_clientes.descripcion as tipo_cliente');
		 $this->db->join('categorias', 'productos.categoria_id = categorias.id','left');
		 $this->db->join('proveedores', 'productos.proveedor_id = proveedores.id','left');
		 $this->db->join('marcas', 'productos.marca_id = marcas.id','left');
		 $this->db->join('modelos', 'productos.modelo_id = modelos.id','left');
		 $this->db->join('tipo_clientes', 'productos.cliente_tipo_id = tipo_clientes.id','left');
	     $this->db->from('productos');
		 $this->db->where('productos.id', $prod_id);
	     return $this->db->get();
	}	
   
 
  	      
}

