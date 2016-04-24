<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gescitas extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        //$page['main_content'] = 'calendar';
        //$this->load->view('includes/template_panel', $page);
		$this->load->view('includes/header_panel');
		$this->load->view('mar/citagen_view');
		$this->load->view('mar/citagen_agenda');
		$this->load->view('mar/citagen_detalle');
		$this->load->view('mar/producto_lista');
			
    }
	
	function datosGestion($emp_id, $bandeja){
		$obj = new Cita();
		$data=$obj->bandejafilter(null,$emp_id,$bandeja);
		return $data;	
	}
	function datosRegestion($camp_id, $emp_id, $bandeja){
		$obj = new Cita();
		$data=$obj->bandejafilter($camp_id, $emp_id,$bandeja);
		return $data;	
	}
	
	function ajax(){
        switch($this->input->post('accion')){
        	//Gestión
        	case 'dataGCA'://Citas asignadas
				 echo json_encode($this->datosGestion($this->input->post('emp_id'),'GCA'));
				 break;
			case 'dataGVC': //Ventas completadas
				 echo json_encode($this->datosGestion($this->input->post('emp_id'),'GVC'));
				 break;
		    case 'dataGVI': //Ventas incompletadas
				 echo json_encode($this->datosGestion($this->input->post('emp_id'),'GVI'));
				 break;
		    case 'dataGVIN': //Ventas interesados
				 echo json_encode($this->datosGestion($this->input->post('emp_id'),'GVIN'));
				 break;
		    case 'dataGVNI': //Ventas no interesados
				 echo json_encode($this->datosGestion($this->input->post('emp_id'),'GVNI'));
				 break;
		    case 'dataGVCA': //Ventas canceladas
				 echo json_encode($this->datosGestion($this->input->post('emp_id'),'GVCA'));
				 break;
		    case 'dataGVNV': //No visitados
				 echo json_encode($this->datosGestion($this->input->post('emp_id'),'GVNV'));
				 break;
				 
			//Regestión
			case 'dataRGVI': //registion ventas incompletas
			     echo json_encode($this->datosRegestion($this->input->post('camp_id'),$this->input->post('emp_id'),'RGVI'));
				 break;
            case 'dataRGVIN': //regestion interesados
                 echo json_encode($this->datosRegestion($this->input->post('camp_id'),$this->input->post('emp_id'),'RGVIN'));
				 break;
			case 'dataRGVNI': //regestion no interesados
				 echo json_encode($this->datosRegestion($this->input->post('camp_id'),$this->input->post('emp_id'),'RGVNI'));
				 break;
			case 'dataRGVCA': //regestion ventas canceladas
			     echo json_encode($this->datosRegestion($this->input->post('camp_id'),$this->input->post('emp_id'),'RGVCA'));
				 break;
			case 'dataRGVNV': //regestion no visitados
			     echo json_encode($this->datosRegestion($this->input->post('camp_id'),$this->input->post('emp_id'),'RGVNV'));
				 break;	
            
            default:
				
				 /*
				 $obj = new Cita();
				 $query=$obj->bandeja('Asignada');
				 $results=$query->result_array();
				 echo json_encode($results);
				 */	
				 
               	
					 
        }
    }


    
	
	function citasasignadas($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->citas_asignadas($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function ventasCompletadas($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->ventas_completadas($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function ventasInCompletadas($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->ventas_incompletadas($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function regestion_ventasInCompletadas($camp_id, $emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->regestion_ventas_incompletadas($camp_id, $emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	
	
	function Interesados($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->interesados($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function regestion_interesados($camp_id, $emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->regestion_interesados($camp_id,$emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function NoInteresados($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->nointeresados($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function regestion_noInteresados($camp_id, $emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->regestion_nointeresados($camp_id,$emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function citasCanceladas($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->citascanceladas($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function regestion_citasCanceladas($camp_id, $emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->regestion_citascanceladas($camp_id,$emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	
	function NoVisitados($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->novisitados($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	function regestion_noVisitados($camp_id,$emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->regestion_novisitados($camp_id,$emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
	
	
	
	
	function agendaempleado($emp_id){
        				
				 $obj = new Cita();
				 $query=$obj->agenda_empleado($emp_id);
				 $results=$query->result_array();
				 echo json_encode($results);	
				 
               	
	}
}
