<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gesven extends DataMapper {
    var $extensions = array('json');
    var $table = 'parametricas_datos';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function estados(){
    		 
		 $sql="SELECT parametricas_datos.id, parametricas_datos.descripcion
			FROM parametricas_datos inner join parametricas on parametricas_datos.parametrica_id=parametricas.id
			WHERE parametricas.id=8;";
	    	//$params = array($cita_id);
			$query=$this->db->query($sql);
			return $query;
	}  
	
	function citas_empleados($fecha_inicial = NULL,$fecha_final = NULL,$estado_nom = NULL){
			$sql="SELECT citas_agendas.inicio, cit.empleado_id,CONCAT(empleados.nombres,' ',empleados.apellidos) as asesor,
				(select group_concat(CONCAT(e.nombres,' ',e.apellidos)) 
				from citas ci inner join empleados e on e.id=ci.empleado_id
				where  ci.contacto_id=cit.contacto_id AND cita_estado='Nueva') as teleoperador, 
				con.identificacion, con.nombres,con.apellidos,concam.telefono,	productos.nombre AS plan			
				FROM citas cit inner join citas_agendas on cit.id=citas_agendas.cita_id 
				inner join empleados ON empleados.id=cit.empleado_id 
				inner join contactos con on con.id=cit.contacto_id
				inner join contactos_campanas concam on concam.id=cit.contacto_campana_id 
				inner join citas_productos on citas_productos.cita_id=cit.id
				inner join productos on productos.id=citas_productos.producto_id
				WHERE citas_agendas.inicio between ? AND ? AND citas_agendas.estado='AC' and cita_estado=?;";
				$params = array($fecha_inicial,$fecha_final,$estado_nom);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
		
		function citas_empleados_contactos($id_asesor = NULL,$fecha_inicial = NULL,$fecha_final = NULL,$estado_nom = NULL){
			$sql="SELECT citas_agendas.inicio, cit.empleado_id,CONCAT(empleados.nombres,' ',empleados.apellidos) as asesor,
				(select group_concat(CONCAT(e.nombres,' ',e.apellidos)) 
				from citas ci inner join empleados e on e.id=ci.empleado_id
				where  ci.contacto_id=cit.contacto_id AND cita_estado='Nueva') as teleoperador, 
				con.identificacion, con.nombres,con.apellidos,concam.telefono,	productos.nombre AS plan			
				FROM citas cit inner join citas_agendas on cit.id=citas_agendas.cita_id 
				inner join empleados ON empleados.id=cit.empleado_id 
				inner join contactos con on con.id=cit.contacto_id
				inner join contactos_campanas concam on concam.id=cit.contacto_campana_id
				inner join citas_productos on citas_productos.cita_id=cit.id
				inner join productos on productos.id=citas_productos.producto_id
				WHERE empleados.id =? AND citas_agendas.inicio between ? AND ? AND citas_agendas.estado='AC' and cita_estado=?;";
				$params = array($id_asesor,$fecha_inicial,$fecha_final,$estado_nom);
				$query=$this->db->query($sql,$params);
				return $query;
		}  		 	
}