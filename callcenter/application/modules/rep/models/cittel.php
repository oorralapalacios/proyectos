<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cittel extends DataMapper {
    var $extensions = array('json');
    var $table = 'citas';
	

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	
	function param_query($fecha_ini = NULL,$fecha_max = NULL){
	 				
		$this->db->select('citas.id AS codigo, contactos.nombres AS nombres,contactos.apellidos AS apellidos, contactos.direccion AS direccion,citas.fecha_ing AS fecha,citas.cita_estado');
		$this->db->join('empleados', 'citas.empleado_id=empleados.id','left');
		$this->db->join('contactos', 'citas.contacto_id=contactos.id','left');
		$this->db->from('citas');
		$where = "citas.fecha_ing between '".$fecha_ini."' AND '".$fecha_max."'";
		$this->db->where($where);
		$this->db->order_by("citas.id","ASC");		
		return $this->db->get();		
	     
	} 
	
	function custom_query_empleado(){
			
	 	$sql="SELECT emp.*, CONCAT(emp.nombres, ' ', emp.apellidos, ' - ',(select nombre from departamentos where id = (select departamento_id from empleados_departamentos where empleado_id= emp.id
              and estado='AC'order by fecha_ing desc LIMIT 1 ))) as empleado                 
			  FROM empleados emp, empleados_departamentos empdep
			  where empdep.empleado_id=emp.id
			  and empdep.departamento_id in (
			  select departamento_id from roles_departamentos
			  where emp.estado ='AC' and  rol_id in (3,4)) ;";
			  //$binds = array($rolid);
		      $query= $this->db->query($sql);
	    	  return $query;             
		
	}
	
	function citas_llamadas($fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select citas.empleado_id, contactos.identificacion,contactos.nombres,contactos.apellidos, contactos.direccion, llamadas.telefono,
				DATE_FORMAT(citas_agendas.inicio,'%d/%m/%Y %T') as fecha_visita,citas.cita_estado, 
				CONCAT(empleados.nombres,' ',empleados.apellidos) As teleoperador
				from contactos
				inner join citas on citas.contacto_id=contactos.id
				inner join llamadas on llamadas.id= citas.llamada_id
				inner join citas_agendas on citas.id= citas_agendas.cita_id
				inner join empleados ON citas.empleado_id=empleados.id 
		        where citas_agendas.inicio between ? AND ? AND llamadas.estado='AC'
		        and citas.cita_estado in ('Nueva');";
				$params = array($fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
		
		function citas_llamadas_empleados($id_empleado = NULL,$fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select citas.id AS codigo, contactos.identificacion, contactos.nombres,contactos.apellidos, contactos.direccion, llamadas.telefono,
				DATE_FORMAT(citas_agendas.inicio,'%d/%m/%Y %T') as fecha_visita,citas.cita_estado
				from contactos
				inner join citas on citas.contacto_id=contactos.id
				inner join llamadas on llamadas.id= citas.llamada_id
				inner join citas_agendas on citas.id= citas_agendas.cita_id
		        where llamadas.empleado_id=? AND citas_agendas.inicio between ? AND ? AND llamadas.estado='AC'
				and citas.cita_estado in ('Nueva');";
				$params = array($id_empleado,$fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}  	
}