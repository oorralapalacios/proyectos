<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresa_Campo extends DataMapper {
    var $extensions = array('json');
    var $table = 'empresas_campos';
    var $has_one = array('empresa','campo');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function custom_query(){
    	 $this->db->select('empresas_campos.*, campos.campo as campo');
		 $this->db->join('campos', 'empresas_campos.campo_id = campos.id','left');
		 $this->db->from('empresas_campos');
		 //$this->db->where('producto_id', $id);
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}
	function datails_query_type($conta_id = NULL,$tipo = NULL){
    	 $this->db->select('empresas_campos.*, campos.campo as campo');
		 $this->db->join('campos', 'empresas_campos.campo_id = campos.id','left');
		 $this->db->from('empresas_campos');
		 $this->db->where('empresas_campos.empresa_id', $conta_id);
		 $this->db->where('campos.tipo', $tipo);
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}
    function datails_query($conta_id = NULL,$tipo = NULL){
    	 $this->db->select('empresas_campos.*, campos.campo as campo, campos.tipo as tipo');
		 $this->db->join('campos', 'cliente_campos.campo_id = campos.id','left');
		 $this->db->from('empresas_campos');
		 $this->db->where('empresas_campos.empresa_id', $conta_id);
		 $this->db->order_by("tipo","DESC");
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}    
	 	
}