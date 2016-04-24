<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Esttel extends DataMapper {
    var $extensions = array('json');
    var $table = 'llamadas';
	

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function datails_query($param_id = NULL){
    	
	    $sql ="SELECT `llamadas`.* FROM (`llamadas`) WHERE `llamadas`.`estado`='AC' and `llamadas`.`campana_id` = ?";
 		$binds = array($param_id);
		return $this->db->query($sql,$binds);
	}  
	
	function llamadas_contactos($fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select DATE_FORMAT(inicio,'%d/%m/%Y') as fecha_llamada,llamadas.telefono,
				DATE_FORMAT(inicio,'%T') as hora_inicio,
					DATE_FORMAT(fin,'%T') as hora_fin,contactos.nombres,contactos.apellidos,respuesta_recibida,
					(SUBTIME(DATE_FORMAT(fin,'%T'),DATE_FORMAT(inicio,'%T'))) as duracion, 
				llamada_estado, empleado_id, CONCAT(empleados.nombres,' ',empleados.apellidos) As gestor,
				(select concat(nombres,' ',apellidos) as username  from empleados
			     where usuario_id in (
			     SELECT id FROM usuarios
			     where usuario=llamadas.usuario_ing))as usuario 
				from llamadas	
				inner join empleados ON llamadas.empleado_id=empleados.id 		
				inner join contactos ON llamadas.contacto_id=contactos.id 
				where llamadas.fecha_ing between ? AND ? AND llamadas.estado='AC'
				and llamadas.proceso in('Gestión telefónica','Seguimiento telefónico') ;";
				$params = array($fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
		
		function llamadas_contactos_empleados($id_empleado = NULL,$fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select DATE_FORMAT(inicio,'%d/%m/%Y') as fecha_llamada,llamadas.telefono,DATE_FORMAT(inicio,'%T') as hora_inicio,
			DATE_FORMAT(fin,'%T') as hora_fin,nombres,apellidos,respuesta_recibida,
			(SUBTIME(DATE_FORMAT(fin,'%T'),DATE_FORMAT(inicio,'%T'))) as duracion, llamada_estado, 
			(select concat(nombres,' ',apellidos) as username  from empleados
			where usuario_id in (
			SELECT id FROM usuarios
			where usuario=llamadas.usuario_ing))as usuario 
			from llamadas			
			inner join contactos ON llamadas.contacto_id=contactos.id 
			where llamadas.empleado_id =? AND llamadas.fecha_ing between ? AND ? AND llamadas.estado='AC'
			and llamadas.proceso in('Gestión telefónica','Seguimiento telefónico');";
				$params = array($id_empleado,$fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
		function resumen_llamadas_contactos($fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select fecha_llamada, nombres,apellidos,gestor,telefono,proceso,hora_inicio,hora_fin,duracion,
				(select llamada_estado from llamadas where id=query2.id) as llamada_estado,
				(select respuesta_recibida from llamadas where id=query2.id) as respuesta_recibida,
                (select usuario_ing from llamadas where id=query2.id) as usuario from 
				(select max(id) as id,fecha_llamada,  nombres,apellidos,gestor,telefono, proceso, min(hora_inicio) as hora_inicio ,max(hora_fin) as hora_fin, Sec_to_Time(Sum(Time_to_Sec(duracion))) as duracion
				from
				(select     llamadas.id as id,
                DATE_FORMAT(inicio,'%d/%m/%Y') as fecha_llamada,llamadas.telefono,
				DATE_FORMAT(inicio,'%T') as hora_inicio,
					DATE_FORMAT(fin,'%T') as hora_fin,contactos.nombres,contactos.apellidos,respuesta_recibida,
					(SUBTIME(DATE_FORMAT(fin,'%T'),DATE_FORMAT(inicio,'%T'))) as duracion, 
				llamada_estado,
                proceso,
                empleado_id, CONCAT(empleados.nombres,' ',empleados.apellidos) As gestor,
				(select concat(nombres,' ',apellidos) as username  from empleados
			     where usuario_id in (
			     SELECT id FROM usuarios
			     where usuario=llamadas.usuario_ing))as usuario 
				from llamadas	
				inner join empleados ON llamadas.empleado_id=empleados.id 		
				inner join contactos ON llamadas.contacto_id=contactos.id 
				where llamadas.estado='AC'
                and llamadas.fecha_ing between ? AND ? 
                and llamadas.estado='AC'
                and llamadas.proceso in('Gestión telefónica','Seguimiento telefónico')) as query1
                group by fecha_llamada, nombres,apellidos,telefono,gestor,proceso) as query2
				order by gestor,fecha_llamada,hora_inicio;";
				$params = array($fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
		
		function resumen_llamadas_contactos_empleados($id_empleado = NULL,$fecha_inicial = NULL,$fecha_final = NULL){
			$sql="select fecha_llamada, nombres,apellidos,gestor,telefono,proceso,hora_inicio,hora_fin,duracion,
				(select llamada_estado from llamadas where id=query2.id) as llamada_estado,
				(select respuesta_recibida from llamadas where id=query2.id) as respuesta_recibida,
                (select usuario_ing from llamadas where id=query2.id) as usuario from 
				(select max(id) as id,fecha_llamada,  nombres,apellidos,gestor,telefono, proceso, min(hora_inicio) as hora_inicio ,max(hora_fin) as hora_fin, Sec_to_Time(Sum(Time_to_Sec(duracion))) as duracion
				from
				(select     llamadas.id as id,
                DATE_FORMAT(inicio,'%d/%m/%Y') as fecha_llamada,llamadas.telefono,
				DATE_FORMAT(inicio,'%T') as hora_inicio,
					DATE_FORMAT(fin,'%T') as hora_fin,contactos.nombres,contactos.apellidos,respuesta_recibida,
					(SUBTIME(DATE_FORMAT(fin,'%T'),DATE_FORMAT(inicio,'%T'))) as duracion, 
				llamada_estado,
                proceso,
                empleado_id, CONCAT(empleados.nombres,' ',empleados.apellidos) As gestor,
				(select concat(nombres,' ',apellidos) as username  from empleados
			     where usuario_id in (
			     SELECT id FROM usuarios
			     where usuario=llamadas.usuario_ing))as usuario 
				from llamadas	
				inner join empleados ON llamadas.empleado_id=empleados.id 		
				inner join contactos ON llamadas.contacto_id=contactos.id 
				where llamadas.estado='AC'
                and llamadas.empleado_id =?
                and llamadas.fecha_ing between ? AND ? 
                and llamadas.estado='AC'
                and llamadas.proceso in('Gestión telefónica','Seguimiento telefónico')) as query1
                group by fecha_llamada, nombres,apellidos,telefono,gestor,proceso) as query2
				order by gestor,fecha_llamada,hora_inicio;";
				$params = array($id_empleado,$fecha_inicial,$fecha_final);
				$query=$this->db->query($sql,$params);
				return $query;
		}  	  	
		
		
		function gestion_call_center($fecha_inicial,$fecha_final){
				$sql="select DATE_FORMAT(cc.fecha_hora,'%Y-%m-%d') as fecha,CONCAT(co.apellidos,' ',co.nombres) as cliente,CONCAT(em.nombres,' ',em.apellidos) As gestor, cc.telefono, proceso,
				'0' as duracion_minutos, 'Planificada' as llamada_estado,
				 CASE bandeja when 'GC' then CONCAT(proceso,' por ','gestión de contactos') 
				 	when 'ST' then CONCAT(proceso,' por ', 'Seguimiento telefónico')
				    END as respuesta_recibida, ca.nombre as campana, 1 as total
				from contactos_campanas cc, contactos co, empleados em, campanas ca
				where cc.contacto_id=co.id
				and cc.empleado_id=em.id
				and cc.campana_id=ca.id
				and cc.fecha_hora between  '".$fecha_inicial."' AND '".$fecha_final."'
				union all
			     select DATE_FORMAT(fecha_llamada,'%Y-%m-%d') as fecha  , CONCAT(apellidos,' ',nombres)as cliente ,gestor,telefono,proceso,TIME_TO_SEC(duracion)/60 as duracion_minutos ,
				 llamada_estado,
				 respuesta_recibida,
				(select ca.nombre from llamadas ll, campanas ca where ll.campana_id=ca.id and ll.id=query1.id) as campana,-1 as total
				from
				(select llamadas.id as id,
                DATE_FORMAT(inicio,'%Y/%m/%d') as fecha_llamada,llamadas.telefono,
				DATE_FORMAT(inicio,'%T') as hora_inicio,
					DATE_FORMAT(fin,'%T') as hora_fin,contactos.nombres,contactos.apellidos,respuesta_recibida,
					(SUBTIME(DATE_FORMAT(fin,'%T'),DATE_FORMAT(inicio,'%T'))) as duracion, 
				llamada_estado,
                proceso,
                empleado_id, CONCAT(empleados.nombres,' ',empleados.apellidos) As gestor,
				(select concat(nombres,' ',apellidos) as username  from empleados
			     where usuario_id in (
			     SELECT id FROM usuarios
			     where usuario=llamadas.usuario_ing))as usuario 
				from llamadas	
				inner join empleados ON llamadas.empleado_id=empleados.id 		
				inner join contactos ON llamadas.contacto_id=contactos.id 
				where llamadas.estado='AC'
                and llamadas.fecha_ing in (select max(fecha_ing) from llamadas ll where ll.estado='AC'
                and ll.fecha_ing between '".$fecha_inicial."' AND '".$fecha_final."'
                and ll.respuesta_recibida not in ('Ninguna','Cancelada')
                and ll.proceso in('Gestión telefónica','Seguimiento telefónico','Base de contactos')  )
                and llamadas.fecha_ing between '".$fecha_inicial."' AND '".$fecha_final."'
                and llamadas.respuesta_recibida not in ('Ninguna','Cancelada')
                and llamadas.proceso in('Gestión telefónica','Seguimiento telefónico','Base de contactos')) as query1
              	order by gestor,fecha;";
				//$params = array($fecha_inicial,$fecha_final);
				//$query=$this->db->query($sql,$params);
				$query=$this->db->query($sql);
				return $query;
			
			
		}
		
		function historia_llamadas_contactos($fecha_inicial,$fecha_final){
			$sql="select fecha_llamada as fecha  , CONCAT(apellidos,' ',nombres)as cliente ,gestor,telefono,proceso,TIME_TO_SEC(duracion)/60 as duracion ,
				(select llamada_estado from llamadas where id=query2.id) as estado,
				(select respuesta_recibida from llamadas where id=query2.id) as respuesta,
				(select ca.nombre from llamadas ll, campanas ca where ll.campana_id=ca.id and ll.id=query2.id) as campana, 1 as total
				from 
				(select max(id) as id,fecha_llamada,  nombres,apellidos,gestor,telefono, proceso, min(hora_inicio) as hora_inicio ,max(hora_fin) as hora_fin, Sec_to_Time(Sum(Time_to_Sec(duracion))) as duracion
				from
				(select llamadas.id as id,
                DATE_FORMAT(inicio,'%Y/%m/%d') as fecha_llamada,llamadas.telefono,
				DATE_FORMAT(inicio,'%T') as hora_inicio,
					DATE_FORMAT(fin,'%T') as hora_fin,contactos.nombres,contactos.apellidos,respuesta_recibida,
					(SUBTIME(DATE_FORMAT(fin,'%T'),DATE_FORMAT(inicio,'%T'))) as duracion, 
				llamada_estado,
                proceso,
                empleado_id, CONCAT(empleados.nombres,' ',empleados.apellidos) As gestor,
				(select concat(nombres,' ',apellidos) as username  from empleados
			     where usuario_id in (
			     SELECT id FROM usuarios
			     where usuario=llamadas.usuario_ing))as usuario 
				from llamadas	
				inner join empleados ON llamadas.empleado_id=empleados.id 		
				inner join contactos ON llamadas.contacto_id=contactos.id 
				where llamadas.estado='AC'
                and llamadas.estado='AC'
                and llamadas.fecha_ing between '".$fecha_inicial."' AND '".$fecha_final."'
                and llamadas.respuesta_recibida not in ('Ninguna','Cancelada')
                and llamadas.proceso in('Gestión telefónica','Seguimiento telefónico','Base de contactos')) as query1
                group by fecha_llamada, nombres,apellidos,telefono,gestor,proceso) as query2
				order by gestor,fecha;";
				//$params = array($fecha_inicial,$fecha_final);
				//$query=$this->db->query($sql,$params);
				$query=$this->db->query($sql);
				return $query;
		}	
		
}