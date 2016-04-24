<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Opcion extends DataMapper {
	var $extensions = array('json');
    var $table = 'opciones';
    var $has_one = array('modulo');
    var $has_many = array('rol');
    
    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function get_opcion($id){
		date_default_timezone_set(TIMEZONE);
		$this->db->select('o.id, o.nombre' );
        $this->db->from('opciones as o');
	    $this->db->where('o.id',$id);
	    $query=$this->db->get();
		$obj= $query->result();
		foreach ($obj as $row){
			  $result[] = array(
			                'id' => $row->id,
			                'nombre' => iconv($this->config->item('charset'), "UTF-8", $row->nombre),
			               
			            );
			         }
		return $result;
	}
    
}

/* End of file opcion.php */
/* Location: ./application/modules/seg/models/opcion.php */