<?php

class Productos extends MX_Controller
{
	function __construct()
	{
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/inv' ) );
	}

	function index()
	{
		 	$this->load->view('includes/header_panel');
			$this->load->view('inv/producto_view');
			$this->load->view('inv/producto_form');
	}
	
					 
  
	function tarifas($prod_id)
	{
		 $obj = new Tarifa();
		 $query=$obj->datails_query($prod_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function subproductos($prod_id)
	{
		 $obj = new Subproducto();
		 $query=$obj->datails_query($prod_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function infoproducto($prod_id)
	{
		 $obj = new Producto();
		 $query=$obj->info_query($prod_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
		
		function ajax(){
			 date_default_timezone_set(TIMEZONE);
			 $username=modules::run('login/usuario');
			 switch($this->input->post('accion')){
			 		
				case 'add': 
					 /*Inicia control transaccional*/
				  	  $this->db->trans_start();
				      $obj = new Producto();
					  $obj->nombre=$this->input->post('nombre');
					  $obj->descripcion=$this->input->post('descripcion');
					  $obj->cliente_tipo_id=$this->input->post('cliente_tipo_id');
					  $obj->categoria_id=$this->input->post('categoria_id');
					  $obj->proveedor_id=$this->input->post('proveedor_id');
					  $obj->marca_id=$this->input->post('marca_id');
					  $obj->modelo_id=$this->input->post('modelo_id');
					  $obj->costo=$this->input->post('costo');
					  $obj->iva=$this->input->post('iva');
					  $obj->descuento=$this->input->post('descuento');
					  $obj->estado=$this->input->post('estado');
					  $obj->usuario_ing=$username;
					  $obj->fecha_ing=date("y-m-d H:i:s");
					  $obj->save();
					  foreach($this->input->post('detalletarifas') as $arr)
						{
							$obj1 = new Tarifa();
				   	      	$obj1->nombre=$arr['nombre'];
							$obj1->producto_id=$obj->id;
							$obj1->unidad_id=$arr['unidad_id'];
							$obj1->costo_unitario=$arr['costo_unitario'];
							$obj1->cantidad=$arr['cantidad'];
							$obj1->valor=$arr['cantidad']*$arr['costo_unitario'];
							$obj1->usuario_ing=$username;
							$obj1->fecha_ing=date("y-m-d H:i:s");
						    $obj1->save();
						    	
						} 
					  foreach($this->input->post('detallesubproductos') as $arr)
						{
							$obj2 = new Subproducto();
				   	      	$obj2->producto_id=$obj->id;
							$obj2->subproducto_id=$arr['subproducto_id'];
							$obj2->cantidad=$arr['cantidad'];
							$obj2->costo=$arr['costo'];
							$obj2->iva=$arr['iva'];
							$obj2->descuento=$arr['descuento'];
							$obj2->usuario_ing=$username;
							$obj2->fecha_ing=date("y-m-d H:i:s");
						    $obj2->save();
						    	
						}
						/*Valida Control Transaccional*/
					   if ($this->db->trans_status() === FALSE)
					   {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					   } else {
						$this->db->trans_complete();
					   }	 
						
											
	            break;
				case 'edit':
				  if($this->input->post('id')){
				  	   /*Inicia control transaccional*/
				  	   $this->db->trans_start();
		               $obj = new Producto();
					   $obj->where('id', $this->input->post('id'))->get();
					   $obj->nombre=$this->input->post('nombre');
					   $obj->descripcion=$this->input->post('descripcion');
					   $obj->cliente_tipo_id=$this->input->post('cliente_tipo_id');
					   $obj->categoria_id=$this->input->post('categoria_id');
					   $obj->proveedor_id=$this->input->post('proveedor_id');
					   $obj->marca_id=$this->input->post('marca_id');
					   $obj->modelo_id=$this->input->post('modelo_id');
					   $obj->costo=$this->input->post('costo');
					   $obj->iva=$this->input->post('iva');
					   $obj->descuento=$this->input->post('descuento');
					   $obj->estado=$this->input->post('estado');
					   $obj->usuario_mod=$username;
					   $obj->fecha_mod=date("y-m-d H:i:s");
					   $obj->save();
					   
					   foreach($this->input->post('detalletarifas') as $arr)
						{
							$obj1 = new Tarifa();
							$obj1->where('id', $arr['id'])->get();
				   	     	$obj1->nombre=$arr['nombre'];
							$obj1->producto_id=$obj->id;
							$obj1->unidad_id=$arr['unidad_id'];
							$obj1->costo_unitario=$arr['costo_unitario'];
							$obj1->cantidad=$arr['cantidad'];
							$obj1->valor=$arr['cantidad']*$arr['costo_unitario'];
							if ($obj1->usuario_ing){
							 $obj1->usuario_mod=$username;
							}
							if (!$obj1->usuario_ing){
							 $obj1->usuario_ing=$username;	
							}
							if ($obj1->fecha_ing){
							 $obj1->fecha_mod=date("y-m-d H:i:s");
							}
							if (!$obj1->fecha_ing){
							 $obj1->fecha_ing=date("y-m-d H:i:s");
							}
							$obj1->save();
						    						    
						}
						
						foreach($this->input->post('detallesubproductos') as $arr)
						{
							$obj2 = new Subproducto();
							$obj2->where('id', $arr['id'])->get();
				   	      	$obj2->producto_id=$obj->id;
							$obj2->subproducto_id=$arr['subproducto_id'];
							$obj2->cantidad=$arr['cantidad'];
							$obj2->costo=$arr['costo'];
							$obj2->iva=$arr['iva'];
							$obj2->descuento=$arr['descuento'];
							if ($obj2->usuario_ing){
							 $obj2->usuario_mod=$username;
							}
							if (!$obj2->usuario_ing){
							 $obj2->usuario_ing=$username;	
							}
							if ($obj2->fecha_ing){
							 $obj2->fecha_mod=date("y-m-d H:i:s");
							}
							if (!$obj2->fecha_ing){
							 $obj2->fecha_ing=date("y-m-d H:i:s");
							}
							$obj2->save();
						    
						   	
						} 
						/*Valida Control Transaccional*/
					   if ($this->db->trans_status() === FALSE)
					   {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					   } else {
						$this->db->trans_complete();
					   }	 		
									 					   
      	 	       }
				break;
				case 'del':
				   if($this->input->post('id')){
				   	/*Inicia control transaccional*/
				   	  $this->db->trans_start();
	                  $obj = new Producto();
					  $obj->where('id', $this->input->post('id'))->get();
				      $obj->estado='IN';
					  $obj->usuario_mod=$username;
					  $obj->fecha_mod=date("y-m-d H:i:s");
				      $obj->save();
					  
				      //$obj1 = new Tarifa();
				      //$obj1->where('producto_id', $this->input->post('id'))->update('estado', 'IN');
				      //$obj1->where('producto_id', $this->input->post('id'))->update(array('estado' => 'IN', 'usuario_mod' => $username,'fecha_mod' => date("y-m-d H:i:s")),TRUE);
					  $obj1->where('producto_id', $this->input->post('id'))->update(array('estado' => 'IN', 'usuario_mod' => $username,'fecha_mod' => date("y-m-d H:i:s")),TRUE);
					  //$obj2 = new Subproducto();
				      //$obj2->where('producto_id', $this->input->post('id'))->update('estado', 'IN');
				      //$obj2->where('producto_id', $this->input->post('id'))->update(array('estado' => 'IN', 'usuario_mod' => $username,'fecha_mod' => date("y-m-d H:i:s")),TRUE);
					  $obj2->where('producto_id', $this->input->post('id'))->update(array('estado' => 'IN', 'usuario_mod' => $username,'fecha_mod' => date("y-m-d H:i:s")),TRUE);
					  /*Valida Control Transaccional*/
					   if ($this->db->trans_status() === FALSE)
					   {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					   } else {
						$this->db->trans_complete();
					   }	 					
				  };
				break;
                case 'deltar':
					 $this->db->trans_start();
					  $obj = new Tarifa();
					  $obj->where('id', $this->input->post('id'))->get();
				      $obj->estado='IN';
					  $obj->usuario_mod=$username;
					  $obj->fecha_mod=date("y-m-d H:i:s");
				      $obj->save();
					
					 if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					 } else {
						$this->db->trans_complete();
					 }
				case 'delspro':
					 $this->db->trans_start();
					  $obj = new Subproducto();
					  $obj->where('id', $this->input->post('id'))->get();
				      $obj->estado='IN';
					  $obj->usuario_mod=$username;
					  $obj->fecha_mod=date("y-m-d H:i:s");
				      $obj->save();
					
					 if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					 } else {
						$this->db->trans_complete();
					 }	 		 	 	
				default:
					 
					 $obj = new Producto();
					 $query=$obj->custom_query();
					 $results=$query->result_array();
					 echo json_encode($results);
	                
				
					
			 }
        }
		  
		
}
