<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parametros extends MX_Controller{
	function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
		Datamapper::add_model_path( array( APPPATH.'modules/man/', APPPATH.'modules/seg/' ) );
		
		
    }
	
	function get_opcion_id(){
		return $this->session->userdata('tid');
	}
	
	function index()
	{
          
			$this->load->view('includes/header_panel');
			$this->load->view('man/parametro_view');
			$this->session->set_userdata(array('tid' => $_GET["tid"]));	
						
	}
	
		
	function ajax(){
		     date_default_timezone_set(TIMEZONE);
		     $username=modules::run('login/usuario');
			
			 switch($this->input->post('accion')){
					
				case 'tool':
				 echo json_encode(modules::run('login/tool_rol_ajax'));
				break;	
				
				case 'datatit': 
				    $op=new opcion();
					echo json_encode($op->get_opcion($this->get_opcion_id())); 
	            break;
				
				case 'datadet': 
				    $pard=new Parametro_opcion();
					echo json_encode($pard->get_opcion_parametros($this->get_opcion_id())); 
	            break;
				
				case 'dataHC': 
				    $pard=new Parametro_opcion();
					echo json_encode($pard->get_opcion_parametros(189)); 
	            break;
                case 'dataPE':
					$pard=new Parametro_opcion();
					echo json_encode($pard->get_opcion_parametros(194)); 
				break;
				case 'add':
				 	 
				      $obj = new Parametro_opcion();
					  $obj->insertar(array(
					                  'orden' =>  $this->input->post('orden'),
					                  'codigo' =>  $this->input->post('codigo'),
					                  'descripcion' =>  $this->input->post('descripcion'),
			                          'opcion_id' => $this->get_opcion_id(),
			                          'estado'=> 'AC',
			                          'usuario_ing'=> $username
			                 ));
	            
	     
				
	            break;
				case 'edit':
				  if($this->input->post('id')){
				  	 $obj = new Parametro_opcion();
					 $obj->editar(array('id' => $this->input->post('id'),
					                  'orden' =>  $this->input->post('orden'),
					                  'codigo' =>  $this->input->post('codigo'),
			                          'descripcion' =>  $this->input->post('descripcion'),
			                          'opcion_id' => $this->get_opcion_id(),
			                          'usuario_mod'=> $username
			                 ));
					  
			       }
				break;
				case 'del':
				   if($this->input->post('id')){
	                 $obj = new Parametro_opcion();
				     $obj->borrar(array('id' => $this->input->post('id'),
			                         'usuario_mod'=> $username
			                 ));
				  };
				break;
					
					
				default:
					/*Usar solo para probar controladores*/
					echo ($this->get_opcion_id());
					
				
					
			 }
        }
	
}
