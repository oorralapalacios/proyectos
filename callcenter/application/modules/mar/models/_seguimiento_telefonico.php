<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Seguimiento_Telefonico extends DataMapper {
    var $extensions = array('json');
	var $table = 'seguimientos_telefonicos';
    
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	function custom_query($camp_id=null,$emp_id=null){
		/*historial
    	 $sql="select cc.id,cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
				co.nombres,co.apellidos,co.ciudad,co.direccion,cc.fecha_ing,cc.fecha_mod,cc.estado, 
				CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
				cc.telefono as movil, cc.fecha_hora
				from seguimientos_telefonicos cc, campanas ca, contactos co, empleados em
				where cc.campana_id=ca.id
				and cc.contacto_id=co.id
				and cc.empleado_id=em.id
				and not exists (select * from llamadas where contacto_id=cc.contacto_id and campana_id=cc.campana_id
            	and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna','Seguimiento telefónico') )
				and cc.campana_id=?
				and cc.empleado_id=?
				and cc.estado in ('AC');";
		  */
		  //carga solo ultimas llamadas de seguimiento
		   /*$sql="select cc.id,cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
				co.nombres,co.apellidos,co.ciudad,co.direccion,cc.fecha_ing,cc.fecha_mod,cc.estado, 
				CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
				cc.telefono as movil, cc.fecha_hora
				from seguimientos_telefonicos cc, campanas ca, contactos co, empleados em
				where cc.campana_id=ca.id
				and cc.contacto_id=co.id
				and cc.empleado_id=em.id
				and not exists (select * from llamadas where contacto_id=cc.contacto_id and campana_id=cc.campana_id
            	and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna','Seguimiento telefónico') 
				and respuesta_recibida not in (select descripcion from parametricas_datos where parametrica_id=3 ))
				and cc.campana_id=?
				and cc.empleado_id=?
				and cc.estado in ('AC')
				and  cc.fecha_ing in (select max(fecha_ing) from seguimientos_telefonicos where contacto_id=cc.contacto_id
                                   and campana_id=cc.campana_id
                                   and cc.empleado_id=cc.empleado_id
                                   and estado='AC'
                                   );";*/
            $sql="select * from (select cc.id,cc.contacto_id,cc.empleado_id,cc.observaciones,cc.campana_id, co.identificacion,
				co.nombres,co.apellidos,co.ciudad,co.direccion,cc.fecha_ing,cc.fecha_mod,cc.estado, 
				CONCAT(em.nombres, '  ',em.apellidos) as empleado, ca.nombre as campana,
				cc.telefono as movil, cc.fecha_hora,
                 (select max(fecha_ing) from llamadas where contacto_id=cc.contacto_id and campana_id=cc.campana_id
                  and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna') )as ultima_llamada,
                 (select respuesta_recibida from llamadas where contacto_id=cc.contacto_id and campana_id=cc.campana_id
                 and respuesta_recibida not in ('Cancelada','No contestada','Fuera de servicio','Ninguna')
                 order by fecha_ing desc limit 1) respuesta_recibida
				from contactos_campanas cc, campanas ca, contactos co, empleados em
				where cc.campana_id=ca.id
				and cc.contacto_id=co.id
				and cc.empleado_id=em.id
				and not exists (select * from citas where contacto_id=cc.contacto_id and campana_id=cc.campana_id)
				and cc.campana_id=?
				and cc.empleado_id=?
				and cc.estado in ('AC')
				and cc.bandeja='Seguimiento telefonico'
				and  cc.fecha_ing in (select max(fecha_ing) from contactos_campanas where contacto_id=cc.contacto_id
                                   and campana_id=cc.campana_id
                                   and cc.empleado_id=cc.empleado_id
                                   and estado='AC'
                                   ) )as bandeja
		         where estado in ('AC')
                and respuesta_recibida in ('Seguimiento telefónico');";
	    	$params = array($camp_id,$emp_id);
			$query=$this->db->query($sql,$params);
			return $query;
	}
	
	function ultima_fecha_seguimiento_empleado($emp_id=null){
		$sql="select  cc.fecha_hora
				from contactos_campanas cc
				where cc.empleado_id=?
				and cc.estado in ('AC')
                order by cc.fecha_hora desc
                limit 1;";
	    	$params = array($emp_id);
			$query=$this->db->query($sql,$params);
			return $query;
		
	}
	 
	
}