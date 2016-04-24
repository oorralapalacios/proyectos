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
		$this->db->select("empleados.*, CONCAT(empleados.nombres, '  ',empleados.apellidos) as empleado, roles.id AS roles_id,roles.nombre as rol,usuarios.id AS usuario_id,roles_usuarios.id AS roles_usuarios_id, usuarios.usuario",false);
		$this->db->join('usuarios', 'empleados.usuario_id = usuarios.id','left');
		$this->db->join('roles_usuarios', 'roles_usuarios.usuario_id = usuarios.id','left');
		$this->db->join('roles', 'roles_usuarios.rol_id = roles.id','left');
		$this->db->from('empleados');
		return $this->db->get();
	}
	

}