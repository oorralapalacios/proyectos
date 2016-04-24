<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Opcion_rol extends DataMapper {
    var $extensions = array('json');
    var $table = 'opciones_roles';
    
    function __construct($id = NULL)
    {
        parent::__construct($id);
		
    }
    
    function get_opciones_asignadas($rol_id = NULL, $modulo_id = NULL){
        //opciones asignadas a rol
        $this->db->select('DISTINCT \'true\' AS available, opr.opcion_id AS opcion_id, o1.nombre AS opcion, o1.tipo, o1.url AS url, o1.orden AS orden, o1.padre_id',false);
        $this->db->from('opciones_roles opr', 'opciones o1');
        $this->db->join('opciones o1', 'opr.opcion_id = o1.id','left');
        $this->db->where('opr.opcion_id IN (SELECT o2.id FROM opciones o2 WHERE o2.modulo_id = '.$modulo_id.') AND opr.rol_id = '.$rol_id.' AND o1.modulo_id = '.$modulo_id, NULL, FALSE);
        $this->db->get();
        $query1 = $this->db->last_query();
        //opciones NO asignadas a rol
        $this->db->select('DISTINCT \'false\' AS available, COALESCE(o1.id,0) AS opcion_id, o1.nombre AS opcion, o1.tipo, o1.url AS url, o1.orden AS orden, o1.padre_id',false);
        $this->db->from('opciones o1');
        $this->db->join('opciones_roles opr', 'o1.id = opr.opcion_id','left');
        $this->db->where('o1.modulo_id = '.$modulo_id.' AND o1.estado = \'AC\' AND o1.id NOT IN (SELECT opcion_id FROM opciones_roles WHERE rol_id = '.$rol_id.' AND estado = \'AC\')', NULL, FALSE);
        $this->db->get();
        $query2 =  $this->db->last_query();
        $query = $this->db->query($query1." UNION ".$query2);
        return $query;
   }
}

