<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        //$page['main_content'] = 'calendar';
        //$this->load->view('includes/template_panel', $page);
		$this->load->view('includes/header_panel');
		$this->load->view('mar/calendar_view');
		
    }
	
	function agendaempleado($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->agenda_empleado($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
}
