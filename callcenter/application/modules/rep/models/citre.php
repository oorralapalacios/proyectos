<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Citre extends DataMapper {
    var $extensions = array('json');
    var $table = 'citas';
    var $has_many = array('cita_producto','cita_agenda');
	var $has_one = array('contacto');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
	
		function citas_asignadas($emp_id = NULL){
			$sql="SELECT cit.*, con.identificacion, con.apellidos, con.nombres, CONCAT(con.apellidos, ' ', con.nombres) as contacto,
		        con.ciudad, con.direccion,
			    emp.ruc, emp.razon_social, cam.nombre as campana 
			    FROM citas cit
			    LEFT JOIN contactos con ON cit.contacto_id = con.id 
			    LEFT JOIN campanas cam ON cit.campana_id = cam.id 
			    LEFT JOIN empresas emp ON cit.empresa_id = emp.id
			    LEFT JOIN empleados col ON cit.empleado_id = col.id
			    where padre_id is not null
			    and cit.empleado_id=?
			    and cit.cita_estado='Cita Asignada'
			    and not exists (select * from citas where padre_id=cit.id);";
				$params = array($emp_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}	
		
		function citas_agendadas($id_cliente = NULL){
			$sql="select cit.id, cit.fecha_ing AS fecha_gestion,
			        (select telefono from llamadas where id=cit.llamada_id) as telefono,
			        financiamiento,limite_credito,financiamiento_tc,limite_credito_tc,perfil,observacion,
					cita_estado, contacto_id,empresa_id,codigo_preaprobacion,forma_pago,estado_preaprobacion,institucion_financiera,
					tipo_gestion, min(citas_agendas.inicio) AS fecha_cita, max(citas_agendas.inicio) AS fecha_nueva_cita
					from citas  cit inner join citas_agendas on cit.id=citas_agendas.cita_id
					where contacto_id=?
					and not exists (select * from citas where padre_id=cit.id);";
				$params = array($id_cliente);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
		function contacto_citas_agendadas($id_cliente = NULL){
			$sql="select c.identificacion, c.nombres, c.apellidos,c.ciudad,c.direccion,
					(Select valor from contactos_campos cc where c.id=cc.contacto_id and campo_id=5)AS email
					from contactos c
					where c.id=?;";
				$params = array($id_cliente);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
		function empresa_citas_agendadas($id_empresa = NULL){
			$sql="select ruc,razon_social from empresas e
             	  where e.id=?;";
				$params = array($id_empresa);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
		
		
		
		function citas_productos($cita_id = NULL){
			$sql="select nombre,cantidad
				from citas_productos inner join productos  on productos.id=citas_productos.producto_id
				where cita_id=?;";
				$params = array($cita_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
		function citas_parametricas($forma_pago_id = NULL,$estado_preaprobacion_id = NULL){
			$sql="select (select descripcion from parametricas_datos where id=?) as forma_pago,
					(select descripcion from parametricas_datos where id=?) as estado_preaprobado;";
				$params = array($forma_pago_id,$estado_preaprobacion_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		
		function citas_empleados($contacto_id = NULL){
			$sql="select concat(nombres,' ',apellidos) as gestor
								from citas inner join empleados on empleados.id=citas.empleado_id
								where contacto_id=? and cita_estado='Nueva';";
				$params = array($contacto_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
		function citas_vendedor($empleado_id = NULL){
			$sql="select concat(nombres,' ',apellidos) as vendedor
								from empleados 
								where id=? ;";
				$params = array($empleado_id);
				$query=$this->db->query($sql,$params);
				return $query;
		}
}