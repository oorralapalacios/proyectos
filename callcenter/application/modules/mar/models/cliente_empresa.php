<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cliente_Empresa extends DataMapper {
    var $extensions = array('json');
    var $table = 'clientes_empresas';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	function custom_query(){
    	 
		 //$this->db->select("clientes.id,contactos_campanas.contacto_id,contactos_campanas.empleado_id,contactos_campanas.observaciones,contactos_campanas.campana_id, contactos.identificacion,contactos.nombres,contactos.apellidos,contactos.direccion,contactos_campanas.estado, CONCAT(empleados.nombre, '  ',empleados.apellido) as empleado, campanas.nombre as campana",false);
		 $this->db->select("clientes.*,tipo_clientes.descripcion",false);
		 $this->db->join('tipo_clientes', 'clientes.tipo = tipo_clientes.id','left');
	  	 //$this->db->join('clientes_tipo', 'clientes.campana_id = campanas.id','left');
		 //$this->db->join('contactos', 'contactos_campanas.contacto_id = contactos.id','left');
	     $this->db->from('clientes');
		 $this->db->where('clientes.estado', 'AC');
		 $this->db->order_by("clientes.id","ASC");
		 return $this->db->get();
	}
	 	
}