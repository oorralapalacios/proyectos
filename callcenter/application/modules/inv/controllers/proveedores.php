<?php

class Proveedores extends MX_Controller
{
	function __construct()
	{
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/inv' ) );
	}

	function index()
	{
            // display our widget
            //$page['main_content'] = 'proveedor_view';
            //$this->load->view('includes/template_panel', $page);
			$this->load->view('includes/header_panel');
			$this->load->view('inv/proveedor_view');
	}
	
	function ajax(){
		     date_default_timezone_set(TIMEZONE);
		     $username=modules::run('login/usuario');
			 switch($this->input->post('accion')){
				case 'add': 
				      $obj = new Proveedor();
					  /*Inicia control transaccional*/
				      $obj->trans_begin();
					  $obj->ruc=$this->input->post('ruc');
					  $obj->razon_social=$this->input->post('razon_social');
					  $obj->nombre_comercial=$this->input->post('nombre_comercial');
					  $obj->celular=$this->input->post('celular');
					  $obj->telefono=$this->input->post('telefono');
					  $obj->email=$this->input->post('email');
					  $obj->estado=$this->input->post('estado');
					  $obj->usuario_ing=$username;
					  $obj->fecha_ing=date("y-m-d H:i:s");
					  $obj->save();
					  /*Valida Control Transaccional*/
					  if ($obj->trans_status() === FALSE) 
					   {
						    $obj->trans_rollback();
							
					   }
					   else
					   {
						    $obj->trans_commit();
							
					   }
	            break;
				case 'edit':
				  if($this->input->post('id')){
		               // Get 
					   $obj = new Proveedor();
					   /*Inicia control transaccional*/
				       $obj->trans_begin();
					   $obj->where('id', $this->input->post('id'))->get();
					   // Change the fields
					   $obj->ruc=$this->input->post('ruc');
					   $obj->razon_social=$this->input->post('razon_social');
					   $obj->nombre_comercial=$this->input->post('nombre_comercial');
					   $obj->celular=$this->input->post('celular');
					   $obj->telefono=$this->input->post('telefono');
					   $obj->email=$this->input->post('email');
					   $obj->estado=$this->input->post('estado');
					   $obj->usuario_mod=$username;
					   $obj->fecha_mod=date("y-m-d H:i:s");
					   // Save changes to existing 
					   $obj->save();
					   /*Valida Control Transaccional*/
					   if ($obj->trans_status() === FALSE) 
					    {
					 	    $obj->trans_rollback();
							
					    }
					   else
					    {
						    $obj->trans_commit();
							
					    }
					  
			       }
				break;
				case 'del':
				   if($this->input->post('id')){
	               // Get 
				   $obj = new Proveedor();
				   /*Inicia control transaccional*/
				   $obj->trans_begin();
				   $obj->where('id', $this->input->post('id'))->get();
				   // Change the fields
				   $obj->estado='IN';
				   $obj->usuario_mod=$username;
				   $obj->fecha_mod=date("y-m-d H:i:s");
				   // Save changes to existing 
				   $obj->save();
				   /*Valida Control Transaccional*/
					if ($obj->trans_status() === FALSE) 
					{
						    $obj->trans_rollback();
							
					}
					else
					{
						    $obj->trans_commit();
							
					}
				  };
				break;
				default:
					 $obj = new Proveedor();
		             $obj->where('estado', 'AC')->get();
			         $results = array();
	                 foreach ($obj as $o) {
	                 $results[] = $o->to_json();
	                 }
	                 echo '['.join(',', $results).']';	
				
					
			 }
        }
	
}
