<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rol_departamento extends DataMapper {
    var $extensions = array('json');
    var $table = 'roles_departamentos';
    
    function __construct($id = NULL)
    {
        parent::__construct($id);
		
    }
    
    function get_departamentos_asignados($rol_id = NULL, $modulo_id = NULL){
        //opciones asignadas a rol
        $this->db->select('DISTINCT \'true\' AS available, dpr.departamento_id AS departamento_id, dp1.nombre AS departamento, dp1.padre_id',false);
        $this->db->from('roles_departamentos dpr', 'departamentos dp1');
        $this->db->join('departamentos dp1', 'dpr.departamento_id = dp1.id','left');
        $this->db->where('dpr.departamento_id IN (SELECT dp2.id FROM departamentos dp2) AND dpr.rol_id = '.$rol_id, NULL, FALSE);
        $this->db->get();
        $query1 = $this->db->last_query();
        //opciones NO asignadas a rol
        $this->db->select('DISTINCT \'false\' AS available, COALESCE(dp1.id,0) AS departamento_id, dp1.nombre AS departamento, dp1.padre_id',false);
        $this->db->from('departamentos dp1');
        $this->db->join('roles_departamentos dpr', 'dp1.id = dpr.departamento_id','left');
        $this->db->where('dp1.estado = \'AC\' AND dp1.id NOT IN (SELECT departamento_id FROM roles_departamentos WHERE rol_id = '.$rol_id.' AND estado = \'AC\')', NULL, FALSE);
        $this->db->get();
        $query2 =  $this->db->last_query();
        $query = $this->db->query($query1." UNION ".$query2);
        return $query;
   }
}

