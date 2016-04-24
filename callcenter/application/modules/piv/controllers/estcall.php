<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estcall extends MX_Controller
{
	function __construct()
	{
                parent::__construct();
                modules::run('login/autentificado');
				Datamapper::add_model_path( array( APPPATH.'modules/piv/') );
				
	}

	function index()
	{
           $this->load->view('includes/header_panel');
		   $this->load->view('piv/estcall_view');
		  
		
		
	}
	
	function ajax($fecha_ini,$fecha_fin){
	  
		   
		    
		    $stamp_ini = strtotime($fecha_ini);
		    $fecha_inicial = date("Y-m-d", $stamp_ini);
		    //aumento un dia a la fecha fin para que incluya la fecha de fin seleccionada
		    $idia=1;
	        $stamp_fin = strtotime ( '+'.$idia.' day' , strtotime ( $fecha_fin ) ) ;
		    //$stamp_fin = strtotime($fecha_fin);
		    $fecha_final = date("Y-m-d", $stamp_fin);
			
			
				$result = new Esttel();
			    //$query=$result->historia_llamadas_contactos($fecha_inicial,$fecha_final);
			    $query=$result->historia_llamadas_contactos($fecha_inicial,$fecha_final);
			    $obj=$query->result_array();	
			    echo json_encode($obj); 
			
			
	   
			
    }
}