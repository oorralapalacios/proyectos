<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Opcion_escala extends DataMapper {
    var $extensions = array('json');
    var $table = 'opciones_respuestas';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	
    function opciones_escala($escala = NULL){
    	 $this->db->select('opciones_respuestas.*,escalas.nombre AS escala');
		 $this->db->join('escalas', 'opciones_respuestas.escalas_id=escalas.id ','left');
		 $this->db->from('opciones_respuestas');
		// $this->db->where('escalas_id', $escala);
		 $this->db->order_by("escalas.id,orden","ASC");
		 return $this->db->get();
	}    
	
	function opciones_preguntas($escala = NULL){
    	 $this->db->select('opciones_respuestas.*,escalas.nombre AS escala,escalas.multiple_respuesta,escalas.opcion_otro');
		 $this->db->join('escalas', 'opciones_respuestas.escalas_id=escalas.id ','left');
		 $this->db->from('opciones_respuestas');
		 $this->db->where('escalas_id', $escala);
		 $this->db->order_by("orden","ASC");
		 return $this->db->get();
	}  	
	
	function opciones_preguntas_enc($escala = NULL){
		 //$this->db->select('opciones_respuestas.detalle,escalas.multiple_respuesta,escalas.opcion_otro');
    	 $this->db->select('opciones_respuestas.detalle');
		 $this->db->join('escalas', 'opciones_respuestas.escalas_id=escalas.id ','left');
		 $this->db->from('opciones_respuestas');
		 $this->db->where('escalas_id', $escala);
		 $this->db->order_by("orden","ASC");
		 return $this->db->get();
	}
}