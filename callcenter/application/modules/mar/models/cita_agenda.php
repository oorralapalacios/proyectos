<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cita_Agenda extends DataMapper {
    var $extensions = array('json');
    var $table = 'citas_agendas';
    var $has_one = array('cita');

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function agenda($cita_id = NULL){
    		 
		 $sql="SELECT id, 
				cita_id,
				DATE_FORMAT(inicio, '%Y-%m-%dT%T') as start,
				DATE_FORMAT(fin, '%Y-%m-%dT%T') as end,
				texto as title,
				estado
				FROM citas_agendas
				where estado='AC'
				and cita_id=?
				;";
	    	$params = array($cita_id);
			$query=$this->db->query($sql,$params);
			return $query;
	}  
	
			 	
}