<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Parametro_opcion extends DataMapper {
    var $extensions = array('array', 'json', 'csv');
    var $table = 'parametricas_datos';
    
    function __construct($id = NULL)
    {
        parent::__construct($id);
		
    }
    
	function get_opcion_parametros($opcion_id){
		date_default_timezone_set(TIMEZONE);
		$this->db->select('pad.id, pad.orden, pad.codigo, pad.descripcion,pad.estado,pad.fecha_ing,pad.fecha_mod,pad.usuario_ing,pad.usuario_mod' );
        $this->db->from('parametricas_datos as pad');
	    $this->db->where('pad.opcion_id',$opcion_id);
	    $this->db->order_by('pad.codigo');
        $query=$this->db->get();
		$obj= $query->result();
		foreach ($obj as $row){
			  $result[] = array(
			                'id' => $row->id,
			                'orden' => iconv($this->config->item('charset'), "UTF-8", $row->orden),
			                'codigo' => iconv($this->config->item('charset'), "UTF-8", $row->codigo),
			                'descripcion' => iconv($this->config->item('charset'), "UTF-8", $row->descripcion),
			                'estado'=> $row->estado,
			                'fecha_ing'=> $row->fecha_ing,
			                'fecha_mod'=> $row->fecha_mod,
			                'usuario_ing'=> $row->usuario_ing,
			                'usuario_mod'=> $row->usuario_mod,
			            );
			         }
		return $result;
	}
	
	
	function insertar($array){
		 date_default_timezone_set(TIMEZONE);
		 $this->codigo=iconv("UTF-8", $this->config->item('charset'), $array['codigo']);
		 $this->descripcion=iconv("UTF-8", $this->config->item('charset'), $array['descripcion']);
		 $this->opcion_id=$array['opcion_id'];
		 $this->estado='AC';
		 $this->usuario_ing=$array['usuario_ing'];
	     $this->fecha_ing=date($this->config->item('log_date_format'));
         $this->save();
	            
		
	}
	
	function editar($array){
		date_default_timezone_set(TIMEZONE);
		$this->where('id', $array['id'])->get();
		$this->codigo=iconv("UTF-8", $this->config->item('charset'), $array['codigo']);
		$this->descripcion=iconv("UTF-8", $this->config->item('charset'), $array['descripcion']);
		$this->opcion_id=$array['opcion_id'];
		$this->estado='AC';
		$this->usuario_mod=$array['usuario_mod'];
		$this->fecha_mod=date($this->config->item('log_date_format'));
		$this->save();
		
	}
	
	
	function borrar ($array){
		date_default_timezone_set(TIMEZONE);
		$this->where('id', $array['id'])->get();
		$this->estado='IN';
		$this->usuario_mod=$array['usuario_mod'];
		$this->save();
			
	}
	
	
	
	
}

/* End of file modelo.php */
/* Location: ./application/modules/modelo/models/modelo.php */