<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Escala_opcion extends DataMapper {
    var $extensions = array('json');
    var $table = 'escalas';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function escala_descripcion(){
		 $this->db->select("escalas.*,nombre as nombre_escala, (case when escalas.tipo_pregunta_id=1 Then 'Pregunta Abierta' else 'Pregunta Cerrada' end) as tipo",false);
		 $this->db->from('escalas');
		 $this->db->where('escalas.estado','AC');
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}
	
	function lista_escala($tipo = NULL){
    	 $this->db->select('escalas.*');
		 $this->db->from('escalas');
		 $this->db->where('escalas.tipo_pregunta_id', $tipo);
		 $this->db->order_by("id","ASC");
		 return $this->db->get();
	}
    
	 	
}