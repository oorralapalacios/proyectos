<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rol_usuario extends DataMapper {
    var $extensions = array('json');
    var $table = 'roles_usuarios';
    
    function __construct($id = NULL)
    {
        parent::__construct($id);
		
    }
    
    //function get_usuarios($rol_id = NULL, $modulo_id = NULL){
    function get_usuarios_roles(){
        //opciones asignadas a rol
        $this->db->select('ru.id AS id, u.id AS usuario_id, u.usuario AS usuario, CONCAT(e.nombres," ",e.apellidos) AS nombre,
                           r.nombre AS rol, u.ultimo_acceso AS ultimo_acceso, u.numero_accesos AS numero_accesos,
                           CASE ru.estado WHEN "AC" THEN "ACTIVO" WHEN "IN" THEN "INACTIVO" WHEN "BO" THEN "BORRADO" END AS estado', FALSE);
        $this->db->from('roles_usuarios ru');
        $this->db->join('usuarios u', 'ru.usuario_id = u.id','left');
        $this->db->join('roles r', 'ru.rol_id = r.id','left');
        $this->db->join('empleados e', 'u.id = e.usuario_id','left');
        //$this->db->where('r.id <> 1');
        //$this->db->like('u.usuario', $identificacion, 'after');
        //$this->db->like('CONCAT(e.nombres," ",e.apellidos)', $nombre, 'after'); 
        $this->db->order_by('u.usuario','ASC');
        return $this->db->get();
   }
}

/* End of file rol_usuario.php */
/* Location: ./application/modules/seg/models/rol_usuario.php */