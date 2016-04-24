<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asicitas extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        //$page['main_content'] = 'citaasi_view';
        //$this->load->view('includes/template_panel', $page);
		$this->load->view('includes/header_panel');
		$this->load->view('mar/citaasi_view');
		//$this->load->view('mar/contacto_gestion');
		//$this->load->view('mar/contacto_call');
		$this->load->view('mar/citaasi_detalle');
		$this->load->view('mar/producto_lista');
		$this->load->view('mar/citagen_agenda');
    }
	
	function empresa($emp_id){
		$emp=new Empresa();
	    $emp->where('id', $emp_id);
		$emp->get();
		echo ($emp->to_json());
	}
	
	function productos($cita_id){
		$obj=new Cita_Producto();
		$query=$obj->productos($cita_id);
		$results=$query->result_array();
		echo json_encode($results);
	    
	}  
	
	function agenda($cita_id){
		$obj=new Cita_Agenda();
		$query=$obj->agenda($cita_id);
		$results=$query->result_array();
		echo json_encode($results);
	    
	}  

    function ajax(){
        switch($this->input->post('accion')){
            case 'add': 
               				
                break;
            case 'edit':
                
                break;
            case 'del':
                
                break;
            default:
				
				 $obj = new Cita();
				 $query=$obj->bandeja('Confirmada');
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
					 
        }
    }
}
