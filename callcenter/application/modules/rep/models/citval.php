<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Citval extends DataMapper {
    var $extensions = array('json');
    var $table = 'citas';
    var $has_many = array('cita_producto','cita_agenda');
	var $has_one = array('contacto');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	

		    
		function citas_contactos($fecha_inicial = NULL,$fecha_final = NULL){
			$sql=" SELECT CONCAT(emp.nombres,' ',emp.apellidos) as teleoperador,con.identificacion,
				con.nombres,con.apellidos,
				(select telefono from llamadas where id=ci.llamada_id) as telefono,
				con.direccion,cia.inicio,ci.cita_estado
                FROM citas ci inner join citas_agendas cia on ci.id=cia.cita_id 
				inner join empleados emp ON emp.id=ci.empleado_id 
				inner join contactos con on con.id=ci.contacto_id 
				WHERE
                cia.estado='AC' and ci.cita_estado='Cita confirmada'
               	and cia.inicio between ? AND ? AND cia.estado='AC';";
				$params = array($fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
		
		
		function citas_contactos_empleados($id_empleado = NULL,$fecha_inicial = NULL,$fecha_final = NULL){
			$sql="SELECT CONCAT(emp.nombres,' ',emp.apellidos) as teleoperador,con.identificacion,
				con.nombres,con.apellidos,
				(select telefono from llamadas where id=ci.llamada_id) as telefono,
				con.direccion,cia.inicio,ci.cita_estado
                FROM citas ci inner join citas_agendas cia on ci.id=cia.cita_id 
				inner join empleados emp ON emp.id=ci.empleado_id 
				inner join contactos con on con.id=ci.contacto_id 
				WHERE
                cia.estado='AC' and ci.cita_estado='Cita confirmada'
                and ci.empleado_id =? AND cia.inicio between ? AND ? AND cia.estado='AC';";
				$params = array($id_empleado,$fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		} 
		
}