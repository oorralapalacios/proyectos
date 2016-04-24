<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Citasig extends DataMapper {
    var $extensions = array('json');
    var $table = 'citas';
   
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	
		function citas_contactos($fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select * from(SELECT cit.id,cit.empleado_id,CONCAT(empleados.nombres,' ',empleados.apellidos) as teleoperador,
				contactos.identificacion, contactos.nombres,contactos.apellidos,(select telefono from llamadas where id=cit.llamada_id) as telefono,
				contactos.direccion,citas_agendas.inicio,cit.cita_estado,
				(select group_concat(CONCAT(e.nombres,' ',e.apellidos)) 
				from citas ci inner join empleados e on e.id=ci.empleado_id
				where ci.padre_id=cit.id AND cita_estado='Cita Asignada') as asignacion
				FROM citas cit inner join citas_agendas on cit.id=citas_agendas.cita_id 
				inner join empleados ON empleados.id=cit.empleado_id 
				inner join contactos on contactos.id=cit.contacto_id
				WHERE citas_agendas.inicio between ? AND ? AND citas_agendas.estado='AC' and cita_estado='Cita confirmada') as query
				where asignacion is not null ;";
				$params = array($fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
		
		function citas_contactos_empleados($id_empleado = NULL,$fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select * from(SELECT cit.id,cit.empleado_id,CONCAT(empleados.nombres,' ',empleados.apellidos) as teleoperador,
				contactos.identificacion, contactos.nombres,contactos.apellidos,(select telefono from llamadas where id=cit.llamada_id) as telefono,
				contactos.direccion,citas_agendas.inicio,cit.cita_estado,
				(select group_concat(CONCAT(e.nombres,' ',e.apellidos)) 
				from citas ci inner join empleados e on e.id=ci.empleado_id
				where ci.padre_id=cit.id AND cita_estado='Cita Asignada') as asignacion
				FROM citas cit inner join citas_agendas on cit.id=citas_agendas.cita_id 
				inner join empleados ON empleados.id=cit.empleado_id 
				inner join contactos on contactos.id=cit.contacto_id 
				WHERE empleados.id =? AND citas_agendas.inicio between ? AND ? AND citas_agendas.estado='AC' and cita_estado='Cita confirmada') as query
				where asignacion is not null;";
				$params = array($id_empleado,$fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
		function citas_estadistica($fecha_inicial = NULL,$fecha_final = NULL){
			
                $sql="select * from (
                select 
                (select CONCAT(cli.nombres,' ',cli.apellidos) from contactos cli where cli.id=cia.contacto_id )as cliente,
                (select CONCAT(emp.nombres,' ',emp.apellidos) from empleados emp, citas cit where emp.id=cit.empleado_id and cia.padre_id=cit.id )as teleoperador,
                (select CONCAT(emp.nombres,' ',emp.apellidos) from empleados emp where emp.id=cia.empleado_id )as asesor,
                cam.nombre as campana,
                DATE_FORMAT(ciag.inicio,'%Y-%m-%d') as fecha,
                ciag.inicio  as fecha_hora,
                cia.cita_estado
                 from citas cia, citas_agendas ciag, campanas cam
                where cia.cita_estado in ('Cita Asignada')
                and ciag.cita_id=cia.id
                and cia.campana_id= cam.id
                and not exists (select * from citas cir where padre_id=cia.id)
                union
                select 
                (select CONCAT(cli.nombres,' ',cli.apellidos) from contactos cli where cli.id=cia.contacto_id )as cliente,
                (select CONCAT(emp.nombres,' ',emp.apellidos) from empleados emp, citas cit where emp.id=cit.empleado_id and cia.padre_id=cit.id )as teleoperador,
                (select CONCAT(emp.nombres,' ',emp.apellidos) from empleados emp where emp.id=cia.empleado_id )as asesor,
                cam.nombre as campana,
                DATE_FORMAT(ciag.inicio,'%Y-%m-%d') as fecha,
                ciag.inicio  as fecha_hora,
                cir.cita_estado from citas cia, citas cir,citas_agendas ciag, campanas cam
                where cia.cita_estado in ('Cita Asignada')
                and cir.padre_id =cia.id
                 and cia.campana_id= cam.id
                and ciag.cita_id=cia.id) as result
                where fecha_hora
                between ? AND ?;";
				$params = array($fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
}