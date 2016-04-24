<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contacto_Campo extends DataMapper {
    var $extensions = array('json');
    var $table = 'contactos_campos';
    var $has_one = array('contacto');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function custom_query(){
    	 $this->db->select('contactos_campos.*, campos.campo as campo');
		 $this->db->join('campos', 'contactos_campos.campo_id = campos.id','left');
		 $this->db->from('contactos_campos');
		 //$this->db->where('producto_id', $id);
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}
	function datails_query_type($conta_id = NULL,$tipo = NULL){
    	 $this->db->select('contactos_campos.*, campos.campo as campo');
		 $this->db->join('campos', 'contactos_campos.campo_id = campos.id','left');
		 $this->db->from('contactos_campos');
		 $this->db->where('contactos_campos.estado', 'AC');
		 $this->db->where('contactos_campos.contacto_id', $conta_id);
		 $this->db->where('campos.tipo', $tipo);
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}
    function datails_query($conta_id = NULL,$tipo = NULL){
    	 $this->db->select('contactos_campos.*, campos.campo as campo, campos.tipo as tipo');
		 $this->db->join('campos', 'contactos_campos.campo_id = campos.id','left');
		 $this->db->from('contactos_campos');
		 $this->db->where('contactos_campos.estado', 'AC');
		 $this->db->where('contactos_campos.contacto_id', $conta_id);
		 $this->db->order_by("tipo","DESC");
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}    
	 	
}