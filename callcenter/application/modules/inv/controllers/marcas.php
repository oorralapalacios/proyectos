<?php

class Marcas extends MX_Controller
{
	function __construct()
	{
                parent::__construct();
                modules::run('login/autentificado');
				Datamapper::add_model_path( array( APPPATH.'modules/inv/' ) );
	}

	function index()
	{
           
            $this->load->view('includes/header_panel');
            $this->load->view('inv/marca_view');
	}
	
	function ajax(){
		     date_default_timezone_set(TIMEZONE);
		     $username=modules::run('login/usuario');
			 switch($this->input->post('accion')){
				case 'add': 
				      $obj = new Marca();
					   /*Inicia control transaccional*/
					  $obj->trans_begin();
					  $obj->nombre=$this->input->post('nombre');
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
		               // Get Modelo
					   $obj = new Marca();
					    /*Inicia control transaccional*/
					   $obj->trans_begin();
					   $obj->where('id', $this->input->post('id'))->get();
					   // Change the fields
					   $obj->nombre=$this->input->post('nombre');
					   $obj->estado=$this->input->post('estado');
					   $obj->usuario_mod=$username;
					   $obj->fecha_mod=date("y-m-d H:i:s");
					   // Save changes to existing Modelo
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
	               // Get Modelo
				   $obj = new Marca();
				   /*Inicia control transaccional*/
				   $obj->trans_begin();
				   $obj->where('id', $this->input->post('id'))->get();
				   // Change the fields
				   $obj->usuario_mod=$username;
				   $obj->fecha_mod=date("y-m-d H:i:s");
				   $obj->estado='IN';
				   // Save changes to existing Modelo
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
					 $obj = new Marca();
		             $obj->where('estado', 'AC')->get();
			         $results = array();
	                 foreach ($obj as $o) {
	                 $results[] = $o->to_json();
	                 }
	                 echo '['.join(',', $results).']';	
				
					
			 }
        }
	
}
