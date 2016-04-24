<?php

class Departamentos extends MX_Controller
{
	function __construct()
	{
                parent::__construct();
                modules::run('login/autentificado');
				Datamapper::add_model_path( array( APPPATH.'modules/emp/' ) );
	}

	function index()
	{
            $this->load->view('includes/header_panel');
            $this->load->view('emp/departamento_view');
	}
	
	function listacbo(){
		$obj=new Departamento();
		$query=$obj->lista_padre();
		$results=$query->result_array();
		echo json_encode($results);
	    
	}
	
	function ajax(){
		     $username=modules::run('login/usuario');
			 switch($this->input->post('accion')){
				case 'add': 
				      $obj = new Departamento();
					  $obj->nombre=$this->input->post('nombre');
					  $obj->padre_id=$this->input->post('padre_id');
					  $obj->estado=$this->input->post('estado');
					  $obj->usuario_ing=$username;
					  $obj->save();
	            break;
				case 'edit':
				  if($this->input->post('id')){
		               // Get Modelo
					   $obj = new Departamento();
					   $obj->where('id', $this->input->post('id'))->get();
					   // Change the fields
					   $obj->nombre=$this->input->post('nombre');
					   $obj->padre_id=$this->input->post('padre_id');
					   $obj->estado=$this->input->post('estado');
					   $obj->usuario_mod=$username;
					   // Save changes to existing Modelo
					   $obj->save();
					  
			       }
				break;
				case 'del':
				   if($this->input->post('id')){
	               // Get Modelo
				   $obj = new Departamento();
				   $obj->where('id', $this->input->post('id'))->get();
				   // Change the fields
				   $obj->estado='IN';
				   $obj->usuario_mod=$username;
				   // Save changes to existing Modelo
				   $obj->save();
				  };
				break;
				default:
					 $obj = new Departamento();
		             $obj->where('estado', 'AC')->get();
			         $results = array();
	                 foreach ($obj as $o) {
	                 $results[] = $o->to_json();
	                 }
	                 echo '['.join(',', $results).']';	
				
					
			 }
        }
	
}