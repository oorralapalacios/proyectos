<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguimientos extends MX_Controller{
    function __construct(){
        parent::__construct();
	    modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
    	
        $this->load->view('includes/header_panel');
		//$this->load->view('mar/contacto_view');
		$this->load->view('mar/seguimiento_view');
		//$this->load->view('mar/contacto_up');
		$this->load->view('mar/contacto_form');
		$this->load->view('mar/contacto_call');
		$this->load->view('mar/contacto_dialog');
		$this->load->view('mar/contacto_gestion');
		$this->load->view('mar/contacto_visita');
		$this->load->view('mar/contacto_llamar');
		$this->load->view('mar/contacto_rechaza');
		$this->load->view('mar/contacto_cobertura');
		$this->load->view('mar/contacto_info');
		//$this->load->view('includes/footer_panel'); 
    }
	
	function datos($camp_id, $emp_id){
		$obj = new Seguimiento_Telefonico();
		$query=$obj->custom_query($camp_id, $emp_id);
		$results=$query->result_array();
		echo json_encode($results);	
	}
	
	function campana($campana_id)
	{
		 $obj = new Campana();
		 $obj->where('id', $campana_id)->get();
		 echo $obj->to_json();
		 				 	
	}
	
	function campos($tipo)
	{
		 $obj = new Campo();
		 $obj->where('tipo', $tipo)->get();
		 $results = array();
		 foreach ($obj as $o) {
	     $results[] = $o->to_json();
	     }
	     echo '['.join(',', $results).']';
		 				 	
	}
   
    function detalle($conta_id,$tipo)
	{
		 $obj = new Contacto_Campo();
		 $query=$obj->datails_query_type($conta_id,$tipo);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function detalleAll($conta_id)
	{
		 $obj = new Contacto_Campo();
		 $query=$obj->datails_query($conta_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function llamadas($conta_id){
		 $obj = new Llamada();
		 $query=$obj->datails_query($conta_id);
		 $results=$query->result_array();
		 echo json_encode($results);
		
	}
	function llamada($id){
		 $obj = new Llamada();
		 $obj->where('id', $id)->get();
		 echo ($obj->to_json());
		
	}
	
	function productos($conta_id){
		 $obj = new Cita_Producto();
		 $query=$obj->datails_query($conta_id);
		 $results=$query->result_array();
		 echo json_encode($results);
		
	}
	
	function registro($con_id){
		$obj=new Contacto();
	    $obj->where('id', $con_id)->get();
		echo ($obj->to_json());
	}  
	
	function email($con_id){
		$obj=new Contacto_Campo();
	    $obj->where('contacto_id', $con_id);
		$obj->where('campo_id', 5);
		$obj->order_by('fecha_ing','DESC');
		$obj->get();
		echo ($obj->to_json());
	}  
	
	function empresa($con_id){
		$rce=new Contacto_Empresa();
		$rce->where('contacto_id',$con_id);
		$rce->order_by('fecha_ing','DESC');
		$rce->get();
		$emp=new Empresa();
	    $emp->where('id', $rce->empresa_id);
		$emp->get();
		echo ($emp->to_json());
	}  
	
	function current_time(){
	    $obj = new Llamada();
		$query=$obj->current_timestamp();
		$results=$query->result_array();
		echo json_encode($results);
		//return $results;
		
	}

    function ajax(){
    	$username=modules::run('login/usuario');
        switch($this->input->post('accion')){
            
            case 'edit':
                if($this->input->post('id')){
                	$id=$this->input->post('id');
                	$con_id=$this->input->post('contacto_id');
                	$emp_id=$this->input->post('empleado_id');
				    $cam_id=$this->input->post('campana_id');	
                    $obj = new Contacto();
                    $obj->where('id', $con_id)->get();
					$obj->identificacion=$this->input->post('identificacion');
					$obj->nombres=$this->input->post('nombre');
					$obj->apellidos=$this->input->post('apellido');
					$obj->ciudad=$this->input->post('ciudad');
					$obj->direccion=$this->input->post('direccion');
					$obj->estado=$this->input->post('estado');
					$obj->usuario_mod=$username;
                    $obj->save();
					foreach($this->input->post('telefonos') as $arr)
						{
							$obj1 = new Contacto_Campo();
							$obj1->where('id', $arr['id'])->get();
							$obj1->campo_id=$arr['campo_id'];
							$obj1->valor=$arr['valor'];
							$obj1->contacto_id=$con_id;
							if ($obj1->usuario_ing){
							 $obj1->usuario_mod=$username;
							}
							if (!$obj1->usuario_ing){
							 $obj1->usuario_ing=$username;	
							}
							
							$obj1->save();	
						}
					foreach($this->input->post('mails') as $arr1)
						{
							$obj2 = new Contacto_Campo();
							$obj2->where('id', $arr1['id'])->get();
							$obj2->campo_id=$arr1['campo_id'];
							$obj2->valor=$arr1['valor'];
							$obj2->contacto_id=$con_id;
							if ($obj2->usuario_ing){
							 $obj2->usuario_mod=$username;
							}
							if (!$obj2->usuario_ing){
							 $obj2->usuario_ing=$username;	
							}
							
							$obj2->save();	
						}
					$obj3 = new Seguimiento_Telefonico();
					$obj3->where('id', $id)->get();
					$obj3->empleado_id=$emp_id;
				    $obj3->campana_id=$cam_id;
					$obj3->contacto_id=$con_id;
					$obj3->usuario_mod=$username;
					$obj3->save();			 			
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $contacto = new Seguimiento_Telefonico();
                    $contacto->where('id', $this->input->post('id'))->get();
					$contacto->usuario_mod=$username;
                    $contacto->estado='IN';
                    $contacto->save();
                }
                break;
				
			case 'addllamada':
                    $obj = new Llamada();
               	    $obj->contacto_id=$this->input->post('contacto_id');
					$obj->empleado_id=$this->input->post('empleado_id');
					$obj->campana_id=$this->input->post('campana_id');
				    $obj->telefono=$this->input->post('telefono');
				    $obj->inicio=$this->input->post('inicio');
					$obj->fin=$this->input->post('fin');
				    $obj->llamada_estado=$this->input->post('llamada_estado');
					$obj->proceso=$this->input->post('proceso');
					$obj->respuesta_recibida=$this->input->post('respuesta');
					$obj->padre_id=$this->input->post('padre_id');
					$obj->usuario_ing=$username;
					$obj->estado='AC';
					$obj->save();
					echo $obj->id;
				  break;
				
			case 'delllamada':
				    $obj = new Llamada();
					$obj->where('id', $this->input->post('id'))->get();
					$obj->usuario_mod=$username;
					$obj->estado='IN';
					$obj->save();
				break;	
					
			case 'editllamada':
				 if($this->input->post('id')){
                    $obj = new Llamada();
					$obj->where('id', $this->input->post('id'))->get();
					$obj->inicio=$obj->inicio;
					$obj->fin=$this->input->post('fin');
					$obj->llamada_estado=$this->input->post('llamada_estado');
					$obj->respuesta_recibida=$this->input->post('respuesta');
					$obj->usuario_mod=$username;
					$obj->estado='AC';
					$obj->save();
										
				 }	
			     break;	
			
					
			
            case 'segtel':
		          
				    $obj = new Seguimiento_Telefonico();
               	    $obj->contacto_id=$this->input->post('contacto_id');
					$obj->campana_id=$this->input->post('campana_id');
					$obj->empleado_id=$this->input->post('empleado_id');
				    $obj->telefono=$this->input->post('telefono');
					$obj->fecha_hora=$this->input->post('fecha_hora');
					$obj->observaciones=$this->input->post('observacion');
					$obj->usuario_ing=$username;
				  	$obj->estado='AC';
					$obj->save();
					
					
					//echo $obj->id; 
				break;	
				
				
			case 'fcober':
				    $obj = new Contacto();
                    $obj->where('id', $this->input->post('contacto_id'))->get();
					$obj->ciudad=$this->input->post('ciudad');
					$obj->usuario_mod=$username;
					$obj->save();
				break;	
            case 'addcita':	
				    $con=new Contacto(); 
				    $con->where('id', $this->input->post('contacto_id'))->get();
			   	    $con->nombres=$this->input->post('nombres');
				    $con->apellidos=$this->input->post('apellidos');
					$con->ciudad=$this->input->post('ciudad');
					$con->usuario_mod=$username;
				    $con->save();
					
				    $cca=new Contacto_Campo();
				    $cca->where('contacto_id', $this->input->post('contacto_id'));
				    $cca->where('campo_id', 5);
					$cca->where('valor', $this->input->post('mail')); 
					$cca->get();
					if ($cca->exists()){
					 $cca->valor=$this->input->post('mail');
					 $cca->usuario_mod=$username;
					 $cca->estado='AC';
					 $cca->save();	
					}else{
					 $cca=new Contacto_Campo();
					 $cca->contacto_id=$this->input->post('contacto_id');
					 $cca->campo_id=5;
					 $cca->valor=$this->input->post('mail');
					 $cca->usuario_ing=$username;
					 $cca->estado='AC';
					 $cca->save();
					}
					
					if ($this->input->post('ruc')){
						$emp=new Empresa();
						$emp->where('ruc', $this->input->post('ruc'));
						$emp->get();
						if ($emp->exists()){
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_mod=$username;
							$emp->estado='AC';
							$emp->save(); 
							$rce=new Contacto_Empresa();
							$rce->where('contacto_id', $this->input->post('contacto_id'));
							$rce->where('empresa_id',$emp->id);
							$rce->get();
							if ($rce->exists()){
							   $rce->usuario_mod=$username;
							   $rce->estado='AC';
							   $rce->save();
							}else{
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->estado='AC';
							$rce->save();
							}
							
						}else{
							$emp=new Empresa();
							$emp->ruc=$this->input->post('ruc');
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_ing=$username;
							$emp->estado='AC';
							$emp->save();
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->estado='AC';
							$rce->save();
						}
					}	
					 
				    $cit=new Cita();
					$cit->llamada_id=$this->input->post('llamada_id');
					$cit->contacto_id=$this->input->post('contacto_id');
					$cit->empleado_id=$this->input->post('empleado_id');
					$cit->campana_id=$this->input->post('campana_id');
					$cit->empresa_id=$emp->id;
					$cit->tipo_cliente_id=$this->input->post('tipo_cliente_id');
					$cit->cita_estado=$this->input->post('cita_estado');
					if ($this->input->post('padre_id')){
					 $cit->padre_id=$this->input->post('padre_id');
					}
					if ($this->input->post('empleado_id')){
					 $cit->empleado_id=$this->input->post('empleado_id');
					}
					$cit->observacion=$this->input->post('observacion');
					$cit->forma_pago=$this->input->post('forma_pago');
				    $cit->estado_preaprobacion=$this->input->post('estado_preaprobacion');
				    $cit->codigo_preaprobacion=$this->input->post('codigo_preaprobacion');
				    $cit->perfil=$this->input->post('perfil');
				    $cit->limite_credito=$this->input->post('limite_credito');
				    $cit->financiamiento=$this->input->post('financiamiento');
					$cit->usuario_ing=$username;
					$cit->estado='AC';		
					$cit->save();
					if ($cit->id){
					 foreach ($this->input->post('productos') as $arr) {
				 		$pro = new Cita_Producto();
					    $pro->cita_id=$cit->id;
						$pro->producto_id=$arr['producto_id'];
						$pro->cantidad=$arr['cantidad'];
						$pro->usuario_ing=$username;
					  	$pro->estado='AC';
						$pro->save(); 
					 }
					 foreach ($this->input->post('agenda') as $arr) {
				 		$age = new Cita_Agenda();
					    $age->cita_id=$cit->id;
						$age->inicio=$arr['start'];
						$age->fin=$arr['end'];
						$age->texto=$arr['title'];
						$age->usuario_ing=$username;
					  	$age->estado='AC';
						$age->save(); 
					 }
					 	
					}
			      break;	
		
							
            default:
               /*  $obj = new Contacto_Campo();
				 $query=$obj->datails_query_type(null,null);
				 $results=$query->result_array();
				 echo json_encode($results);		*/
        }
    }
	
	
  	
}
