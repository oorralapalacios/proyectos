<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empleado extends DataMapper {
    var $extensions = array('json');
    var $table = 'empleados';
	
	var $has_many = array('usuario');
	
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	
		
	function custom_query(){
	 	$sql="SELECT emp.*, CONCAT(emp.nombres, ' ', emp.apellidos) as empleado,
			    (select departamento_id from empleados_departamentos where empleado_id = emp.id
                 and estado='AC' order by fecha_ing desc LIMIT 1 ) as departamento_id,
				(select nombre from departamentos where id = (select departamento_id from empleados_departamentos where empleado_id= emp.id
                 and estado='AC'order by fecha_ing desc LIMIT 1 )) as departamento,
				(select usuario from usuarios where id=emp.usuario_id) as usuario,
                (select id from roles_usuarios where usuario_id=emp.usuario_id
        	     and estado='AC' order by fecha_ing desc LIMIT 1) as rol_usuario_id,
				(select rol_id from roles_usuarios where usuario_id=emp.usuario_id
        	     and estado='AC' order by fecha_ing desc LIMIT 1) as rol_id,
				(select nombre from roles where id =  (select rol_id from roles_usuarios where usuario_id=emp.usuario_id
                and estado='AC' order by fecha_ing desc LIMIT 1 ) ) as rol
				FROM empleados emp
				where emp.estado='AC' ;";
	    	  $query=$this->db->query($sql);
			  return $query;
    
	}
	
	function custom_sellers(){
	 	$sql="select * from (
                SELECT emp.*, CONCAT(emp.nombres, ' ', emp.apellidos) as empleado,
			    (select departamento_id from empleados_departamentos where empleado_id = emp.id
                 and estado='AC' order by fecha_ing desc LIMIT 1 ) as departamento_id,
				(select nombre from departamentos where id = (select departamento_id from empleados_departamentos where empleado_id= emp.id
                 and estado='AC'order by fecha_ing desc LIMIT 1 )) as departamento,
				(select usuario from usuarios where id=emp.usuario_id) as usuario,
                (select id from roles_usuarios where usuario_id=emp.usuario_id
        	     and estado='AC' order by fecha_ing desc LIMIT 1) as rol_usuario_id,
				(select rol_id from roles_usuarios where usuario_id=emp.usuario_id
        	     and estado='AC' order by fecha_ing desc LIMIT 1) as rol_id,
				(select nombre from roles where id =  (select rol_id from roles_usuarios where usuario_id=emp.usuario_id
                and estado='AC' order by fecha_ing desc LIMIT 1 ) ) as rol
				FROM empleados emp
				where emp.estado='AC'
                ) query
                where departamento_id=4 ;";
	    	  $query=$this->db->query($sql);
			  return $query;
    
	}
	
	function custom_teleoperators(){
	 	$sql="select * from (
                SELECT emp.*, CONCAT(emp.nombres, ' ', emp.apellidos) as empleado,
			    (select departamento_id from empleados_departamentos where empleado_id = emp.id
                 and estado='AC' order by fecha_ing desc LIMIT 1 ) as departamento_id,
				(select nombre from departamentos where id = (select departamento_id from empleados_departamentos where empleado_id= emp.id
                 and estado='AC'order by fecha_ing desc LIMIT 1 )) as departamento,
				(select usuario from usuarios where id=emp.usuario_id) as usuario,
                (select id from roles_usuarios where usuario_id=emp.usuario_id
        	     and estado='AC' order by fecha_ing desc LIMIT 1) as rol_usuario_id,
				(select rol_id from roles_usuarios where usuario_id=emp.usuario_id
        	     and estado='AC' order by fecha_ing desc LIMIT 1) as rol_id,
				(select nombre from roles where id =  (select rol_id from roles_usuarios where usuario_id=emp.usuario_id
                and estado='AC' order by fecha_ing desc LIMIT 1 ) ) as rol
				FROM empleados emp
				where emp.estado='AC'
                ) query
                where departamento_id in (9) ;";
	    	  $query=$this->db->query($sql);
			  return $query;
    
	}
	
	function custom_query_jerarquia($rolid = null){
			
	 	$sql="SELECT emp.*, CONCAT(emp.nombres, ' ', emp.apellidos, ' - ',(select nombre from departamentos where id = (select departamento_id from empleados_departamentos where empleado_id= emp.id
              and estado='AC' order by fecha_ing desc LIMIT 1 ))) as empleado                 
			  FROM empleados emp, empleados_departamentos empdep
			  where empdep.empleado_id=emp.id
			  and empdep.departamento_id in (
			  select departamento_id from roles_departamentos
			  where rol_id=?)
			  and emp.estado='AC' ;";
			  $binds = array($rolid);
		      $query= $this->db->query($sql,$binds);
	    	  return $query;
              
		
	}
	
	function custom_query_sinjerarquia($userid = null){
			
	 	$sql="SELECT emp.*, CONCAT(emp.nombres, ' ', emp.apellidos, ' - ',(select nombre from departamentos where id = (select departamento_id from empleados_departamentos where empleado_id= emp.id
              and estado='AC'order by fecha_ing desc LIMIT 1 ))) as empleado   
			  FROM empleados emp
              where emp.usuario_id =?
              and emp.estado='AC' ;";
			  $binds = array($userid);
		      $query= $this->db->query($sql,$binds);
	    	  return $query;
              
		
	}
	

}