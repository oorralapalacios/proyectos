<?php
class Campana_Parametro extends DataMapper {
    var $table = 'campanas_parametros';
    var $extensions = array('json');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	 
	  
	 function details_query($campana_id = NULL,$tabla_id = NULL){
    	 $this->db->select('campanas_parametros.*, parametricas_datos.descripcion');
		 $this->db->join('parametricas_datos', 'campanas_parametros.parametro_id = parametricas_datos.id','left');
		 $this->db->from('campanas_parametros');
		 $this->db->where('campanas_parametros.campana_id', $campana_id);
		 $this->db->where('campanas_parametros.parametrica_id', $tabla_id);
		 $this->db->where('campanas_parametros.estado', 'AC');
		 $this->db->order_by("campanas_parametros.id","ASC");
		 return $this->db->get();
	}  
	 
	 function param_query($campana_id = NULL,$tabla_id = NULL){
	 	
		$sql="SELECT * FROM parametricas_datos
               WHERE EXISTS (SELECT * FROM campanas_parametros
               WHERE campanas_parametros.parametro_id=parametricas_datos.id
               and campanas_parametros.estado='AC'
               and campanas_parametros.campana_id =?
               and campanas_parametros.parametrica_id = ?)
               and parametricas_datos.estado='AC'";
	    $params = array($campana_id,$tabla_id);
		$query=$this->db->query($sql,$params);
		return $query;
    	 
	}  
}