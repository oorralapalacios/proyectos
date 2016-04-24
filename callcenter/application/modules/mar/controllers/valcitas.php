<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valcitas extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        //$page['main_content'] = 'citaval_view';
        //$this->load->view('includes/template_panel', $page);
		
		$this->load->view('includes/header_panel');
		$this->load->view('mar/citaval_view');
		$this->load->view('mar/contacto_gestion');
		$this->load->view('mar/contacto_call');
		$this->load->view('mar/citaval_detalle');
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

    function datos($camp_id, $emp_id, $bandeja){
		$obj = new Cita();
		$data=$obj->bandejafilter($camp_id, $emp_id,$bandeja);
		return $data;	
	} 


     function datoscitasnuevas($camp_id, $emp_id){
		
		$obj = new Cita();
		$query=$obj->bandeja('Nuevo',$camp_id, $emp_id);
		$results=$query->result_array();
		echo json_encode($results);	
	}

    function datoscitaconfirmada($camp_id, $emp_id){
		
		$obj = new Cita();
		$query=$obj->bandeja('Confirmada',$camp_id, $emp_id);
		$results=$query->result_array();
		echo json_encode($results);	
	}
	function datoscitanoconfirmada($camp_id, $emp_id){
		$obj = new Cita();
		$query=$obj->bandeja('No Confirmada',$camp_id, $emp_id);
		$results=$query->result_array();
		echo json_encode($results);	
	}
	
	function datosmalacita($camp_id, $emp_id){
		$obj = new Cita();
		$query=$obj->bandeja('Mala Cita',$camp_id, $emp_id);
		$results=$query->result_array();
		echo json_encode($results);	
	}
	
	function datoscancelocita($camp_id, $emp_id){
		$obj = new Cita();
		$query=$obj->bandeja('Cancelo Cita',$camp_id, $emp_id);
		$results=$query->result_array();
		echo json_encode($results);	
	}
	function datospostergocita($camp_id, $emp_id){
		$obj = new Cita();
		$query=$obj->bandeja('Postergo Cita',$camp_id, $emp_id);
		$results=$query->result_array();
		echo json_encode($results);	
	}
	


    function ajax(){
        switch($this->input->post('accion')){
        	case 'dataCN'://Citas nuevas
				 echo json_encode($this->datos($this->input->post('camp_id'),$this->input->post('emp_id'),'CN'));
				 break;
			case 'dataCC': //Citas confirmadas
				 echo json_encode($this->datos($this->input->post('camp_id'),$this->input->post('emp_id'),'CC'));
				 break;
		    case 'dataCNC'://Citas no confirmadas
				 echo json_encode($this->datos($this->input->post('camp_id'),$this->input->post('emp_id'),'CNC'));
				 break;
			 case 'dataCMC'://Citas mal canalizadas (mala cita)
				 echo json_encode($this->datos($this->input->post('camp_id'),$this->input->post('emp_id'),'CMC'));
				 break;
			case 'dataCCA'://Citas canceladas
				 echo json_encode($this->datos($this->input->post('camp_id'),$this->input->post('emp_id'),'CCA'));
				 break;
		  case 'dataCPO'://Citas postergadas
		         echo json_encode($this->datos($this->input->post('camp_id'),$this->input->post('emp_id'),'CPO'));
				  break;
			
		   /*
		    case 'add': 
                $cita = new Cita();
				 $cita->save();
				break;
            case 'edit':
                if($this->input->post('id')){
                    $cita = new Citas();
                    $cita->save();
                }
                break;
		      */
            case 'del':
                if($this->input->post('id')){
                    $cita = new Cita();
                    $cita->where('id', $this->input->post('id'))->get();
                    $cita->estado='IN';
                    $cita->save();
                }
                break;
            default:
				/*
				 $obj = new Cita();
				 $query=$obj->bandeja('Nuevo');
				 $results=$query->result_array();
				 echo json_encode($results);	
				 */
               	
					 
        }
    }
}
