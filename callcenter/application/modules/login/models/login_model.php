<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
	
    function validar(){
        $this->db->where('usuario', $this->input->post('usuario'));
        $this->db->where('clave', md5($this->input->post('clave')));
        $query = $this->db->get('usuarios');
		
       if($query->num_rows == 1){
       	   foreach ($query->result() as $row)
		   {
		   	$this->update_access($row->id);
		   }
       	   return true;
        }
    }
    
    function get_usuarios($usuario){
        $this->db->where('usuario', $usuario);
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
    }
	
	
    
	function get_rol($rol_id){
        $this->db->where('id', $rol_id);
        $query = $this->db->get('roles');
         if($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
    }
	
    function get_roles_usuarios($usuario_id){
        $this->db->where('usuario_id', $usuario_id);
		$this->db->where('estado', 'AC');
        $query = $this->db->get('roles_usuarios');
         if($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
    }
    function get_menu_rol($rol_id){
    	
        $sql="SELECT o.id, o.nombre, o.padre_id, o.orden, o.ancho_submenu as subMenuWidth FROM opciones as o WHERE o.estado = 'DF'
			 	UNION 
				SELECT o.id, o.nombre, o.padre_id,o.orden, o.ancho_submenu as subMenuWidth  
				FROM opciones_roles as opr 
				JOIN opciones o ON opr.opcion_id = o.id 
				JOIN roles r ON opr.rol_id = r.id 
				JOIN modulos m ON o.modulo_id = m.id
				WHERE opr.estado = 'AC' 
				AND o.estado = 'AC' 
				AND o.tipo = 'Main Menu'
				AND opr.rol_id = ? 
				ORDER BY 4 ASC";
			  $binds = array($rol_id);
		      $query= $this->db->query($sql,$binds);
	    	  return $query;
        
		
		
	
    }

   /*
    function get_tool_rol($rol_id,$vista){
        $this->db->select('o.id,o.nombre,o.padre_id');
		$this->db->from('opciones_roles as opr');
		$this->db->join('opciones o', 'opr.opcion_id = o.id');
		$this->db->join('roles r', 'opr.rol_id = r.id');
		$this->db->join('modulos m', 'o.modulo_id = m.id');
		$this->db->where('opr.estado', 'AC'); 
		$this->db->where('o.estado', 'AC');
		$this->db->where('o.tipo', 'Tool Bar'); 
		$this->db->where('o.url', $vista);
		$this->db->where('opr.rol_id', $rol_id); 
		$this->db->order_by('o.orden','ASC');
        $query = $this->db->get();
        return $query;
    }*/
    
    function get_tool_rol($rol_id,$padre_id){
        $this->db->select('o.id,o.nombre,o.padre_id, o.orden, o.ancho_submenu as subMenuWidth');
		$this->db->from('opciones_roles as opr');
		$this->db->join('opciones o', 'opr.opcion_id = o.id');
		$this->db->join('roles r', 'opr.rol_id = r.id');
		$this->db->join('modulos m', 'o.modulo_id = m.id');
		$this->db->where('opr.estado', 'AC'); 
		$this->db->where('o.estado', 'AC');
		$this->db->where('o.tipo', 'Tool Bar'); 
		$this->db->where('o.opcion_id', $padre_id);
		$this->db->where('opr.rol_id', $rol_id); 
		$this->db->order_by('o.orden','ASC');
        $query = $this->db->get();
        return $query;
    }

     function get_tool_rol_ajax($rol_id,$padre_id){
        $this->db->select('o.id,o.nombre,o.padre_id,o.orden');
		$this->db->from('opciones_roles as opr');
		$this->db->join('opciones o', 'opr.opcion_id = o.id');
		$this->db->join('roles r', 'opr.rol_id = r.id');
		$this->db->join('modulos m', 'o.modulo_id = m.id');
		$this->db->where('opr.estado', 'AC'); 
		$this->db->where('o.estado', 'AC');
		$this->db->where('o.tipo', 'Tool Bar'); 
		$this->db->where('o.padre_id', $padre_id);
		$this->db->where('opr.rol_id', $rol_id); 
		$this->db->order_by('o.orden','ASC');
        $query = $this->db->get();
        foreach ($query->result() as $row){
        	$result[] = array(
                'id' => $row->id,
                'nombre' =>  iconv($this->config->item('charset'), "UTF-8", $row->nombre),
                'padre_id' => $row->padre_id,
                'orden'=> $row->orden,
            );
         }
         return $result;
    }
    
    function update_access($id){
    		 
		 $sql="update usuarios
			   set numero_accesos=IFNULL(numero_accesos,0)+1
			   where id=? ;";
			  $binds = array($id);
		      $query= $this->db->query($sql,$binds);
	    	  return $query;
	}
	
	
}