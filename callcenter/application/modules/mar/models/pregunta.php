<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pregunta extends DataMapper {
    var $extensions = array('json');
    var $table = 'preguntas';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function preguntas($campana= NULL){
    	 $this->db->select("preguntas.id,preguntas.detalle_pregunta,preguntas.orden,escalas.tipo_pregunta_id AS tipo_pregunta_id, escalas.nombre AS tipo_respuesta ,preguntas.tipo_respuesta_id, (case 
						when escalas.tipo_pregunta_id=1 Then 'Pregunta Abierta'
						else 'Pregunta Cerrada'
						end) AS tipo_pregunta");
		 $this->db->join('escalas', 'escalas.id = preguntas.tipo_respuesta_id','left');
		 $this->db->from('preguntas');
		 $this->db->where('preguntas.estado', 'AC');
		 $this->db->where('preguntas.campana_id', $campana);
	     $this->db->order_by("orden","ASC");
		 return $this->db->get();
	}	
	
	
	/*function pregunta_enc($campana= NULL){
    	 $this->db->select("preguntas.id,preguntas.detalle_pregunta,preguntas.orden,escalas.tipo_pregunta_id AS tipo_pregunta_id, escalas.nombre AS tipo_respuesta ,preguntas.tipo_respuesta_id, (case 
						when escalas.tipo_pregunta_id=1 Then 'Pregunta Abierta'
						else 'Pregunta Cerrada'
						end) AS tipo_pregunta");
		 $this->db->join('escalas', 'escalas.id = preguntas.tipo_respuesta_id','left');
		 $this->db->from('preguntas');
		 $this->db->where('preguntas.estado', 'AC');
		 $this->db->where('preguntas.campana_id', $campana);
	     $this->db->order_by("orden","ASC");
		 $query=$this->db->get();
					 
		// $results=$query->result_array();
		 $datos_array = array();
		  foreach ($query as $o) {
	     	array_push($datos_array,array(  
							"id" => $o->id,
							"orden" => $o->orden,
							"detalle_pregunta" => $o->detalle_pregunta,
							"opciones" => opciones_encuesta($o->tipo_respuesta_id)
						)); 
	     }
	    return json_encode($datos_array);
	}	*/	
}