<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactos_all extends MX_Controller{
    function __construct(){
        parent::__construct();
	    modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
    	
        $this->load->view('includes/header_panel');
		$this->load->view('mar/contactoall_view');
		//$this->load->view('mar/contacto_up');
		$this->load->view('mar/contactoall_form');
		$this->load->view('mar/contacto_info');
		
    }
	
	function datos(){
		$obj = new Contacto();
		$data=$obj->bandejafilterall();
		echo json_encode($data);
	}
	
	function campos($tipo)
	{
		 $obj = new Campo();
		 //$obj->where('estado', 'AC');
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
		 
	     //$obj = new Llamada();
		 //$data=$obj->bandejafilter($conta_id);
		 //echo json_encode($data);
		
	}
	
	function llamadasfiltradaspaginadas($conta_id){
				 
	     $obj = new Llamada();
		 $data=$obj->bandejafilter($conta_id);
		 echo json_encode($data);
		
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
	
	
	function separaApellidos($full_name){
		
		/* separar el nombre completo en espacios */
		  $tokens = explode(' ', trim($full_name));
		  /* arreglo donde se guardan las "palabras" del nombre */
		  $names = array();
		  /* palabras de apellidos (y nombres) compuetos */
		  $special_tokens = array('da', 'de', 'del', 'la', 'las', 'los', 'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa');
		  
		  $prev = "";
		  foreach($tokens as $token) {
		      $_token = strtolower($token);
		      if(in_array($_token, $special_tokens)) {
		          $prev .= "$token ";
		      } else {
		          $names[] = $prev. $token;
		          $prev = "";
		      }
		  }
		  
		  $num_nombres = count($names);
		  $nombres = $apellidos = "";
		  switch ($num_nombres) {
		      case 0:
		          $nombres = '';
		          break;
		      case 1: 
		          $nombres = $names[0];
		          break;
		      case 2:
		          $nombres    = $names[0];
		          $apellidos  = $names[1];
		          break;
		      case 3:
		          $apellidos = $names[0] . ' ' . $names[1];
		          $nombres   = $names[2];
		      default:
		          $apellidos = $names[0] . ' '. $names[1];
		          unset($names[0]);
		          unset($names[1]);
		          
		          $nombres = implode(' ', $names);
		          break;
		  }
		  
		  $nombres    = mb_convert_case($nombres, MB_CASE_TITLE, 'UTF-8');
		  $apellidos  = mb_convert_case($apellidos, MB_CASE_TITLE, 'UTF-8');
		  
		  //echo "nombres: " .$nombres;
		  //echo " apellidos: " .$apellidos;
		  return $apellidos;
	}	

     function separaNombres($full_name){
		
		/* separar el nombre completo en espacios */
		  $tokens = explode(' ', trim($full_name));
		  /* arreglo donde se guardan las "palabras" del nombre */
		  $names = array();
		  /* palabras de apellidos (y nombres) compuetos */
		  $special_tokens = array('da', 'de', 'del', 'la', 'las', 'los', 'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa');
		  
		  $prev = "";
		  foreach($tokens as $token) {
		      $_token = strtolower($token);
		      if(in_array($_token, $special_tokens)) {
		          $prev .= "$token ";
		      } else {
		          $names[] = $prev. $token;
		          $prev = "";
		      }
		  }
		  
		  $num_nombres = count($names);
		  $nombres = $apellidos = "";
		  switch ($num_nombres) {
		      case 0:
		          $nombres = '';
		          break;
		      case 1: 
		          $nombres = $names[0];
		          break;
		      case 2:
		          $nombres    = $names[0];
		          $apellidos  = $names[1];
		          break;
		      case 3:
		          $apellidos = $names[0] . ' ' . $names[1];
		          $nombres   = $names[2];
		      default:
		          $apellidos = $names[0] . ' '. $names[1];
		          unset($names[0]);
		          unset($names[1]);
		          
		          $nombres = implode(' ', $names);
		          break;
		  }
		  
		  $nombres    = mb_convert_case($nombres, MB_CASE_TITLE, 'UTF-8');
		  $apellidos  = mb_convert_case($apellidos, MB_CASE_TITLE, 'UTF-8');
		  
		  //echo "nombres: " .$nombres;
		  //echo " apellidos: " .$apellidos;
		  return $nombres;
	}	
	
	
    function ajax(){
    	date_default_timezone_set(TIMEZONE);
    	$username=modules::run('login/usuario');
        switch($this->input->post('accion')){
            case 'add': 
				  $obj = new Contacto();
				  $obj->trans_begin();
               	  $obj->identificacion=$this->input->post('identificacion');
				  $obj->nombres=$this->input->post('nombre');
				  $obj->apellidos=$this->input->post('apellido');
				  $obj->ciudad=$this->input->post('ciudad');
				  foreach($this->input->post('telefonos') as $arr)
			  	  {
						$obj->telefono=$arr['valor'];	
				  }
				  $obj->direccion=$this->input->post('direccion');
				  $obj->estado=$this->input->post('estado');
				  $obj->usuario_ing=$username;
				  $obj->fecha_ing=date("y-m-d H:i:s");
                  $obj->save();
				   foreach($this->input->post('telefonos') as $arr)
						{
							$obj1 = new Contacto_Campo();
				   	      	$obj1->campo_id=$arr['campo_id'];
							$obj1->valor=$arr['valor'];
							$obj1->contacto_id=$obj->id;
							$obj1->usuario_ing=$username;
							$obj1->fecha_ing=date("y-m-d H:i:s");
							$obj1->save();	
							
						}
					foreach($this->input->post('mails') as $arr1)
						{
							$obj2 = new Contacto_Campo();
				   	      	$obj2->campo_id=$arr1['campo_id'];
							$obj2->valor=$arr1['valor'];
							$obj2->contacto_id=$obj->id;
							$obj2->usuario_ing=$username;
						    $obj2->fecha_ing=date("y-m-d H:i:s");
							$obj2->save();
							
						}
					
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
                	$id=$this->input->post('id');
                	$con_id=$id;
                    $obj = new Contacto();
					$obj->trans_begin();
                    $obj->where('id', $con_id)->get();
					$obj->identificacion=$this->input->post('identificacion');
					$obj->nombres=$this->input->post('nombre');
					$obj->apellidos=$this->input->post('apellido');
					$obj->ciudad=$this->input->post('ciudad');
					foreach($this->input->post('telefonos') as $arr)
			  	    {
						$obj->telefono=$arr['valor'];	
				    }
					$obj->direccion=$this->input->post('direccion');
					$obj->estado=$this->input->post('estado');
					$obj->usuario_mod=$username;
					$obj->fecha_mod=date("y-m-d H:i:s");
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
							if ($obj1->fecha_ing){
							 $obj1->fecha_mod=date("y-m-d H:i:s");
							}
							if (!$obj1->fecha_ing){
							 $obj1->fecha_ing=date("y-m-d H:i:s");
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
							if ($obj2->fecha_ing){
							 $obj2->fecha_mod=date("y-m-d H:i:s");
							}
							if (!$obj2->fecha_ing){
							 $obj2->fecha_ing=date("y-m-d H:i:s");
							}
							$obj2->save();
								
						}
									
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
                    $contacto = new Contacto;
					$contacto->trans_begin();
                    $contacto->where('id', $this->input->post('id'))->get();
					$contacto->usuario_mod=$username;
					$contacto->fecha_mod=date("y-m-d H:i:s");
                    $contacto->estado='IN';
                    $contacto->save();
					/*Valida Control Transaccional*/
						if ($contacto->trans_status() === FALSE) 
						{
						    $contacto->trans_rollback();
						}
						else
						{
						    $contacto->trans_commit();
						}			 
                }
                break;
				
			case 'delcampo':
                if($this->input->post('id')){
                    $contacto = new Contacto_Campo();
					$contacto->trans_begin();
                    $contacto->where('id', $this->input->post('id'))->get();
					$contacto->usuario_mod=$username;
					$contacto->fecha_mod=date("y-m-d H:i:s");
                    $contacto->estado='IN';
                    $contacto->save();
					/*Valida Control Transaccional*/
						if ($contacto->trans_status() === FALSE) 
						{
						    $contacto->trans_rollback();
						}
						else
						{
						    $contacto->trans_commit();
						}			 
                }
                break;
				
			case 'addllamada':
                    $obj = new Llamada();
				    $obj->trans_begin();
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
					$obj->fecha_ing=date("y-m-d H:i:s");
					$obj->estado='AC';
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
					echo $obj->id;		
				  break;
				
			case 'delllamada':
				    $obj = new Llamada();
				    $obj->trans_begin();
					$obj->where('id', $this->input->post('id'))->get();
					$obj->usuario_mod=$username;
					$obj->fecha_mod=date("y-m-d H:i:s");
					$obj->estado='IN';
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
					
			case 'editllamada':
				 if($this->input->post('id')){
                    $obj = new Llamada();
				    $obj->trans_begin();
					$obj->where('id', $this->input->post('id'))->get();
					$obj->inicio=$obj->inicio;
					$obj->fin=$this->input->post('fin');
					$obj->llamada_estado=$this->input->post('llamada_estado');
					$obj->respuesta_recibida=$this->input->post('respuesta');
					$obj->usuario_mod=$username;
					$obj->fecha_mod=date("y-m-d H:i:s");
					$obj->estado='AC';
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
			
				
			case 'fcober':
				    $obj = new Contacto();
                    $obj->where('id', $this->input->post('contacto_id'))->get();
					$obj->ciudad=$this->input->post('ciudad');
					$obj->usuario_mod=$username;
					$obj->fecha_mod=date("y-m-d H:i:s");
					$obj->save();
				break;	
            case 'addcita':	
				    /*Inicia control transaccional*/
				    $this->db->trans_start();
				    $con=new Contacto(); 
				    $con->where('id', $this->input->post('contacto_id'))->get();
			   	    $con->nombres=$this->input->post('nombres');
				    $con->apellidos=$this->input->post('apellidos');
					$con->ciudad=$this->input->post('ciudad');
					$con->direccion=$this->input->post('direccion');
					$con->usuario_mod=$username;
					$con->fecha_mod=date("y-m-d H:i:s");
				    $con->save();
					
					if ($this->input->post('mail')){
					    $cca=new Contacto_Campo();
					    $cca->where('contacto_id', $this->input->post('contacto_id'));
					    $cca->where('campo_id', 5);
						$cca->where('valor', $this->input->post('mail')); 
						$cca->get();
						if ($cca->exists()){
						 $cca->valor=$this->input->post('mail');
						 $cca->usuario_mod=$username;
						 $cca->fecha_mod=date("y-m-d H:i:s");
						 $cca->estado='AC';
						 $cca->save();	
						 
						}else{
						 $cca=new Contacto_Campo();
						 $cca->contacto_id=$this->input->post('contacto_id');
						 $cca->campo_id=5;
						 $cca->valor=$this->input->post('mail');
						 $cca->usuario_ing=$username;
						 $cca->fecha_ing=date("y-m-d H:i:s");
						 $cca->estado='AC';
						 $cca->save();
						 
						}
					}
					
					if ($this->input->post('ruc')){
						$emp=new Empresa();
						$emp->where('ruc', $this->input->post('ruc'));
						$emp->get();
						if ($emp->exists()){
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_mod=$username;
						    $emp->fecha_mod=date("y-m-d H:i:s");
							$emp->estado='AC';
						    $emp->save(); 
						
							
							$rce=new Contacto_Empresa();
							$rce->where('contacto_id', $this->input->post('contacto_id'));
							$rce->where('empresa_id',$emp->id);
							$rce->get();
							if ($rce->exists()){
							   $rce->usuario_mod=$username;
							   $rce->fecha_mod=date("y-m-d H:i:s");
							   $rce->estado='AC';
							   $rce->save();
							    
							}else{
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->fecha_ing=date("y-m-d H:i:s");
							$rce->estado='AC';
							$rce->save();
							 
							}
							
							
						}else{
							$emp=new Empresa();
							$emp->ruc=$this->input->post('ruc');
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_ing=$username;
							$emp->fecha_ing=date("y-m-d H:i:s");
							$emp->estado='AC';
							$emp->save();
						
							
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->fecha_ing=date("y-m-d H:i:s");
							$rce->estado='AC';
							$rce->save();
							 
							
						}
						
						
						
					}	
					 
				    $cit=new Cita();
					$cit->llamada_id=$this->input->post('llamada_id');
					$cit->contacto_id=$this->input->post('contacto_id');
					$cit->empleado_id=$this->input->post('empleado_id');
					$cit->campana_id=$this->input->post('campana_id');
					if ($this->input->post('ruc')){
					   $cit->empresa_id=$emp->id;
					}
					$cit->tipo_cliente_id=$this->input->post('tipo_cliente_id');
					$cit->cita_estado=$this->input->post('cita_estado');
					if ($this->input->post('padre_id')){
					 $cit->padre_id=$this->input->post('padre_id');
					}
					if ($this->input->post('empleado_id')){
					 $cit->empleado_id=$this->input->post('empleado_id');
					}
					if ($this->input->post('observacion')){
					 $cit->observacion=$this->input->post('observacion');
					}	
					if ($this->input->post('forma_pago')){
						$cit->forma_pago=$this->input->post('forma_pago');
					}
					if ($this->input->post('estado_preaprobacion')){
					  $cit->estado_preaprobacion=$this->input->post('estado_preaprobacion');
				  	
					}
					if ($this->input->post('codigo_preaprobacion')){
					  $cit->codigo_preaprobacion=$this->input->post('codigo_preaprobacion');
					}
				    if ($this->input->post('perfil')){
				      $cit->perfil=$this->input->post('perfil');	
				    }
					if ($this->input->post('limite_credito')){
					  $cit->limite_credito=$this->input->post('limite_credito');	
					}
				    if ($this->input->post('financiamiento')){
				      $cit->financiamiento=$this->input->post('financiamiento');	
				    }
				    $cit->usuario_ing=$username;
					$cit->fecha_ing=date("y-m-d H:i:s");
					$cit->estado='AC';		
					$cit->save();
			
					if ($cit->id){
					 foreach ($this->input->post('productos') as $arr) {
				 		$pro = new Cita_Producto();
					    $pro->cita_id=$cit->id;
						$pro->producto_id=$arr['producto_id'];
						$pro->cantidad=$arr['cantidad'];
						$pro->usuario_ing=$username;
						$pro->fecha_ing=date("y-m-d H:i:s");
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
						$age->fecha_ing=date("y-m-d H:i:s");
					  	$age->estado='AC';
						$age->save();
					 }
					 foreach ($this->input->post('encuesta') as $arr) {
				 				$contacto_id = $arr['contacto'];
								$pregunta_id = $arr['preg'];
								$where = "contactos_id = ".$contacto_id." AND preguntas_id = ".$pregunta_id."";
								$res = new Contacto_pregunta_respuesta();
				                $res->where($where)->get();
								$results = array();
				                  foreach ($res as $r) {
				                     $id = intval($r->id);
				                  }
								//echo intval($id);			
								if ($id!=0){	
									if ($this->input->post('multi')==1){
										//verifica_respuesta($where);
										$where_m = "contactos_id = ".$contacto_id." AND preguntas_id = ".$pregunta_id." AND opciones_respuesta= '".$arr['resp']."'";
										$res->where($where_m)->get();
										$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
										$res->contactos_id=$contacto_id;
										$res->preguntas_id=$pregunta_id;
										$res->save();
										
									}else{
										$res->where($where)->get();
										$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
										$res->contactos_id=$contacto_id;
										$res->preguntas_id=$pregunta_id;
										$res->save();
									}
									
								}else{
									
									$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
									$res->contactos_id=$contacto_id;
									$res->preguntas_id=$pregunta_id;
									$res->save();
									
								}
					 					 	
					    }
					}
					
					//Finaliza LLamada Visista in situ
					
					 $cal = new Llamada();
				     $cal->contacto_id=$this->input->post('contacto_id');
					 $cal->empleado_id=$this->input->post('empleado_id');
					 $cal->campana_id=$this->input->post('campana_id');
				     $cal->telefono=$this->input->post('telefono');
				     $cal->inicio=$this->input->post('inicio');
					 $cal->fin=date("y-m-d H:i:s");
				     $cal->llamada_estado=$this->input->post('llamada_estado');
					 $cal->proceso=$this->input->post('proceso');
					 $cal->respuesta_recibida=$this->input->post('respuesta');
					 $cal->padre_id=$this->input->post('llamada_padre_id');
					 $cal->usuario_ing=$username;
					 $cal->fecha_ing=date("y-m-d H:i:s");
					 $cal->estado='AC';
					 $cal->save();
				 			
						if ($this->db->trans_status() === FALSE)
						{
						     $this->db->trans_rollback();
							 echo 'Error de transacion';
						} else {
							$this->db->trans_complete();
							//$this->db->trans_rollback();
						}
			      break;
				  
				  
		    case 'asigcita':	
				    /*Inicia control transaccional*/
				    $this->db->trans_start();
				    $con=new Contacto(); 
				    $con->where('id', $this->input->post('contacto_id'))->get();
			   	    $con->nombres=$this->input->post('nombres');
				    $con->apellidos=$this->input->post('apellidos');
					$con->ciudad=$this->input->post('ciudad');
					$con->direccion=$this->input->post('direccion');
					$con->usuario_mod=$username;
					$con->fecha_mod=date("y-m-d H:i:s");
				    $con->save();
					
					if ($this->input->post('mail')){
					    $cca=new Contacto_Campo();
					    $cca->where('contacto_id', $this->input->post('contacto_id'));
					    $cca->where('campo_id', 5);
						$cca->where('valor', $this->input->post('mail')); 
						$cca->get();
						if ($cca->exists()){
						 $cca->valor=$this->input->post('mail');
						 $cca->usuario_mod=$username;
						 $cca->fecha_mod=date("y-m-d H:i:s");
						 $cca->estado='AC';
						 $cca->save();	
						 
						}else{
						 $cca=new Contacto_Campo();
						 $cca->contacto_id=$this->input->post('contacto_id');
						 $cca->campo_id=5;
						 $cca->valor=$this->input->post('mail');
						 $cca->usuario_ing=$username;
						 $cca->fecha_ing=date("y-m-d H:i:s");
						 $cca->estado='AC';
						 $cca->save();
						 
						}
					}
					
					if ($this->input->post('ruc')){
						$emp=new Empresa();
						$emp->where('ruc', $this->input->post('ruc'));
						$emp->get();
						if ($emp->exists()){
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_mod=$username;
						    $emp->fecha_mod=date("y-m-d H:i:s");
							$emp->estado='AC';
						    $emp->save(); 
						
							
							$rce=new Contacto_Empresa();
							$rce->where('contacto_id', $this->input->post('contacto_id'));
							$rce->where('empresa_id',$emp->id);
							$rce->get();
							if ($rce->exists()){
							   $rce->usuario_mod=$username;
							   $rce->fecha_mod=date("y-m-d H:i:s");
							   $rce->estado='AC';
							   $rce->save();
							    
							}else{
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->fecha_ing=date("y-m-d H:i:s");
							$rce->estado='AC';
							$rce->save();
							 
							}
							
							
						}else{
							$emp=new Empresa();
							$emp->ruc=$this->input->post('ruc');
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_ing=$username;
							$emp->fecha_ing=date("y-m-d H:i:s");
							$emp->estado='AC';
							$emp->save();
						
							
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->fecha_ing=date("y-m-d H:i:s");
							$rce->estado='AC';
							$rce->save();
							 
							
						}
						
						
						
					}	
					 
				    $cit=new Cita();
					$cit->llamada_id=$this->input->post('llamada_id');
					$cit->contacto_id=$this->input->post('contacto_id');
					$cit->empleado_id=$this->input->post('empleado_id');
					$cit->campana_id=$this->input->post('campana_id');
					if ($this->input->post('ruc')){
					   $cit->empresa_id=$emp->id;
					}
					$cit->tipo_cliente_id=$this->input->post('tipo_cliente_id');
					$cit->cita_estado=$this->input->post('cita_estado');
					if ($this->input->post('padre_id')){
					 $cit->padre_id=$this->input->post('padre_id');
					}
					if ($this->input->post('empleado_id')){
					 $cit->empleado_id=$this->input->post('empleado_id');
					}
					if ($this->input->post('observacion')){
					 $cit->observacion=$this->input->post('observacion');
					}	
					if ($this->input->post('forma_pago')){
						$cit->forma_pago=$this->input->post('forma_pago');
					}
					if ($this->input->post('estado_preaprobacion')){
					  $cit->estado_preaprobacion=$this->input->post('estado_preaprobacion');
				  	
					}
					if ($this->input->post('codigo_preaprobacion')){
					  $cit->codigo_preaprobacion=$this->input->post('codigo_preaprobacion');
					}
				    if ($this->input->post('perfil')){
				      $cit->perfil=$this->input->post('perfil');	
				    }
					if ($this->input->post('limite_credito')){
					  $cit->limite_credito=$this->input->post('limite_credito');	
					}
				    if ($this->input->post('financiamiento')){
				      $cit->financiamiento=$this->input->post('financiamiento');	
				    }
				    $cit->usuario_ing=$username;
					$cit->fecha_ing=date("y-m-d H:i:s");
					$cit->estado='AC';		
					$cit->save();
			
					if ($cit->id){
					 foreach ($this->input->post('productos') as $arr) {
				 		$pro = new Cita_Producto();
					    $pro->cita_id=$cit->id;
						$pro->producto_id=$arr['producto_id'];
						$pro->cantidad=$arr['cantidad'];
						$pro->usuario_ing=$username;
						$pro->fecha_ing=date("y-m-d H:i:s");
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
						$age->fecha_ing=date("y-m-d H:i:s");
					  	$age->estado='AC';
						$age->save();
					 }
					 foreach ($this->input->post('encuesta') as $arr) {
				 				$contacto_id = $arr['contacto'];
								$pregunta_id = $arr['preg'];
								$where = "contactos_id = ".$contacto_id." AND preguntas_id = ".$pregunta_id."";
								$res = new Contacto_pregunta_respuesta();
				                $res->where($where)->get();
								$results = array();
				                  foreach ($res as $r) {
				                     $id = intval($r->id);
				                  }
								//echo intval($id);			
								if ($id!=0){	
									if ($this->input->post('multi')==1){
										//verifica_respuesta($where);
										$where_m = "contactos_id = ".$contacto_id." AND preguntas_id = ".$pregunta_id." AND opciones_respuesta= '".$arr['resp']."'";
										$res->where($where_m)->get();
										$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
										$res->contactos_id=$contacto_id;
										$res->preguntas_id=$pregunta_id;
										$res->save();
										
									}else{
										$res->where($where)->get();
										$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
										$res->contactos_id=$contacto_id;
										$res->preguntas_id=$pregunta_id;
										$res->save();
									}
									
								}else{
									
									$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
									$res->contactos_id=$contacto_id;
									$res->preguntas_id=$pregunta_id;
									$res->save();
									
								}
					 					 	
					    }
					}
					
						 			
						if ($this->db->trans_status() === FALSE)
						{
						     $this->db->trans_rollback();
							 echo 'Error de transacion';
						} else {
							$this->db->trans_complete();
							//$this->db->trans_rollback();
						}
			      break;
				  
				  
		    case 'repcita':	
				    /*Inicia control transaccional*/
				    $this->db->trans_start();
				    $con=new Contacto(); 
				    $con->where('id', $this->input->post('contacto_id'))->get();
			   	    $con->nombres=$this->input->post('nombres');
				    $con->apellidos=$this->input->post('apellidos');
					$con->ciudad=$this->input->post('ciudad');
					$con->direccion=$this->input->post('direccion');
					$con->usuario_mod=$username;
					$con->fecha_mod=date("y-m-d H:i:s");
				    $con->save();
					
					if ($this->input->post('mail')){
					    $cca=new Contacto_Campo();
					    $cca->where('contacto_id', $this->input->post('contacto_id'));
					    $cca->where('campo_id', 5);
						$cca->where('valor', $this->input->post('mail')); 
						$cca->get();
						if ($cca->exists()){
						 $cca->valor=$this->input->post('mail');
						 $cca->usuario_mod=$username;
						 $cca->fecha_mod=date("y-m-d H:i:s");
						 $cca->estado='AC';
						 $cca->save();	
						 
						}else{
						 $cca=new Contacto_Campo();
						 $cca->contacto_id=$this->input->post('contacto_id');
						 $cca->campo_id=5;
						 $cca->valor=$this->input->post('mail');
						 $cca->usuario_ing=$username;
						 $cca->fecha_ing=date("y-m-d H:i:s");
						 $cca->estado='AC';
						 $cca->save();
						 
						}
					}
					
					if ($this->input->post('ruc')){
						$emp=new Empresa();
						$emp->where('ruc', $this->input->post('ruc'));
						$emp->get();
						if ($emp->exists()){
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_mod=$username;
						    $emp->fecha_mod=date("y-m-d H:i:s");
							$emp->estado='AC';
						    $emp->save(); 
						
							
							$rce=new Contacto_Empresa();
							$rce->where('contacto_id', $this->input->post('contacto_id'));
							$rce->where('empresa_id',$emp->id);
							$rce->get();
							if ($rce->exists()){
							   $rce->usuario_mod=$username;
							   $rce->fecha_mod=date("y-m-d H:i:s");
							   $rce->estado='AC';
							   $rce->save();
							    
							}else{
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->fecha_ing=date("y-m-d H:i:s");
							$rce->estado='AC';
							$rce->save();
							 
							}
							
							
						}else{
							$emp=new Empresa();
							$emp->ruc=$this->input->post('ruc');
							$emp->razon_social=$this->input->post('razon_social');
							$emp->usuario_ing=$username;
							$emp->fecha_ing=date("y-m-d H:i:s");
							$emp->estado='AC';
							$emp->save();
						
							
							$rce=new Contacto_Empresa();
							$rce->contacto_id=$this->input->post('contacto_id');
							$rce->empresa_id=$emp->id;
							$rce->usuario_ing=$username;
							$rce->fecha_ing=date("y-m-d H:i:s");
							$rce->estado='AC';
							$rce->save();
							 
							
						}
						
						
						
					}	
					 
				    $cit=new Cita();
					$cit->llamada_id=$this->input->post('llamada_id');
					$cit->contacto_id=$this->input->post('contacto_id');
					$cit->empleado_id=$this->input->post('empleado_id');
					$cit->campana_id=$this->input->post('campana_id');
					if ($this->input->post('ruc')){
					   $cit->empresa_id=$emp->id;
					}
					$cit->tipo_cliente_id=$this->input->post('tipo_cliente_id');
					$cit->cita_estado=$this->input->post('cita_estado');
					if ($this->input->post('padre_id')){
					 $cit->padre_id=$this->input->post('padre_id');
					}
					if ($this->input->post('empleado_id')){
					 $cit->empleado_id=$this->input->post('empleado_id');
					}
					if ($this->input->post('observacion')){
					 $cit->observacion=$this->input->post('observacion');
					}	
					if ($this->input->post('forma_pago')){
						$cit->forma_pago=$this->input->post('forma_pago');
					}
					if ($this->input->post('estado_preaprobacion')){
					  $cit->estado_preaprobacion=$this->input->post('estado_preaprobacion');
				  	
					}
					if ($this->input->post('codigo_preaprobacion')){
					  $cit->codigo_preaprobacion=$this->input->post('codigo_preaprobacion');
					}
				    if ($this->input->post('perfil')){
				      $cit->perfil=$this->input->post('perfil');	
				    }
					if ($this->input->post('limite_credito')){
					  $cit->limite_credito=$this->input->post('limite_credito');	
					}
				    if ($this->input->post('financiamiento')){
				      $cit->financiamiento=$this->input->post('financiamiento');	
				    }
				    $cit->usuario_ing=$username;
					$cit->fecha_ing=date("y-m-d H:i:s");
					$cit->estado='AC';		
					$cit->save();
			
					if ($cit->id){
					 foreach ($this->input->post('productos') as $arr) {
				 		$pro = new Cita_Producto();
					    $pro->cita_id=$cit->id;
						$pro->producto_id=$arr['producto_id'];
						$pro->cantidad=$arr['cantidad'];
						$pro->usuario_ing=$username;
						$pro->fecha_ing=date("y-m-d H:i:s");
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
						$age->fecha_ing=date("y-m-d H:i:s");
					  	$age->estado='AC';
						$age->save();
					 }
					 foreach ($this->input->post('encuesta') as $arr) {
				 				$contacto_id = $arr['contacto'];
								$pregunta_id = $arr['preg'];
								$where = "contactos_id = ".$contacto_id." AND preguntas_id = ".$pregunta_id."";
								$res = new Contacto_pregunta_respuesta();
				                $res->where($where)->get();
								$results = array();
				                  foreach ($res as $r) {
				                     $id = intval($r->id);
				                  }
								//echo intval($id);			
								if ($id!=0){	
									if ($this->input->post('multi')==1){
										//verifica_respuesta($where);
										$where_m = "contactos_id = ".$contacto_id." AND preguntas_id = ".$pregunta_id." AND opciones_respuesta= '".$arr['resp']."'";
										$res->where($where_m)->get();
										$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
										$res->contactos_id=$contacto_id;
										$res->preguntas_id=$pregunta_id;
										$res->save();
										
									}else{
										$res->where($where)->get();
										$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
										$res->contactos_id=$contacto_id;
										$res->preguntas_id=$pregunta_id;
										$res->save();
									}
									
								}else{
									
									$res->opciones_respuesta=$arr['resp'];//cambiar a varchar
									$res->contactos_id=$contacto_id;
									$res->preguntas_id=$pregunta_id;
									$res->save();
									
								}
					 					 	
					    }
					}
					
				
				 			
						if ($this->db->trans_status() === FALSE)
						{
						     $this->db->trans_rollback();
							 echo 'Error de transacion';
						} else {
							$this->db->trans_complete();
							//$this->db->trans_rollback();
						}
			      break;		

			case 'import': 
                                    
				   
				   $trans = new Contacto();
				   $trans->trans_begin();				
				   foreach($this->input->post('importados') as $arr)
						{
							$obj = new Contacto();
							$obj->get_by_identificacion($arr['identificacion']);
							$obj->get_by_telefono($arr['telefono_movil']);
							// Chequea si existe en la base de datos
							if ($obj->exists())
							{ //por si actualiza
							  $obj->identificacion=$arr['identificacion'];
							  $obj->telefono=$arr['telefono_movil'];
				              $obj->nombres=$this->separaNombres($arr['nombre_cliente']);
							  $obj->apellidos=$this->separaApellidos($arr['nombre_cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
				              $obj->direccion=mb_convert_case($arr['direccion'], MB_CASE_TITLE, 'UTF-8');
							  $obj->usuario_mod=$username;
							  $obj->fecha_mod=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							}else{ //si no existe en la base inserta
							  $obj = new Contacto();
							  $obj->identificacion=$arr['identificacion'];
							  $obj->telefono=$arr['telefono_movil'];
				              $obj->nombres=$this->separaNombres($arr['nombre_cliente']);
				              $obj->apellidos=$this->separaApellidos($arr['nombre_cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
				              $obj->direccion=mb_convert_case($arr['direccion'], MB_CASE_TITLE, 'UTF-8');
							  $obj->usuario_ing=$username;
							  $obj->fecha_ing=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							} 	
					
						   if (is_numeric($arr['telefono_movil'])) {			
								$obj1 = new Contacto_Campo();
							  	$obj1->where('contacto_id', $obj->id);
							    $obj1->where('valor', $arr['telefono_movil']);
								$obj1->get();
								if (!$obj1->exists())
							    { //si no existe en la base inserta
							        $obj1 = new Contacto_Campo();
						   	      	$obj1->campo_id=1;
									$obj1->valor=$arr['telefono_movil'];
									$obj1->contacto_id=$obj->id;
									$obj1->usuario_ing=$username;
									$obj1->fecha_ing=date("y-m-d H:i:s");
							        $obj1->estado='AC';
									$obj1->save();	
								}
							} 
							if (is_numeric($arr['telefono_casa_convencional'])) {	
								$obj2 = new Contacto_Campo();
							    $obj2->where('contacto_id', $obj->id);
							    $obj2->where('valor', $arr['telefono_casa_convencional']);
								$obj2->get();
								if (!$obj2->exists())
							    { //si no existe en la base inserta
							        $obj2 = new Contacto_Campo();
						   	      	$obj2->campo_id=2;
									$obj2->valor=$arr['telefono_casa_convencional'];
									$obj2->contacto_id=$obj->id;
									$obj2->usuario_ing=$username;
									$obj2->fecha_ing=date("y-m-d H:i:s");
							        $obj2->estado='AC';
									$obj2->save();	
								}
							} 
							if (is_numeric($arr['telefono_trabajo_convencional'])) {
								$obj3 = new Contacto_Campo();
							    $obj3->where('contacto_id', $obj->id);
							    $obj3->where('valor', $arr['telefono_trabajo_convencional']);
								$obj3->get();
								if (!$obj3->exists())
								{ //si no existe en la base inserta
									$obj3 = new Contacto_Campo();
						   	      	$obj3->campo_id=3;
									$obj3->valor=$arr['telefono_trabajo_convencional'];
									$obj3->contacto_id=$obj->id;
									$obj3->usuario_ing=$username;
									$obj3->fecha_ing=date("y-m-d H:i:s");
							        $obj3->estado='AC';
							  		$obj3->save();
								}		
							} 
							
							if (is_numeric($arr['telefono_trabajo_movil'])) {
								$obj4 = new Contacto_Campo();
								$obj4->where('contacto_id', $obj->id);
							    $obj4->where('valor', $arr['telefono_trabajo_movil']);
								$obj4->get();
								if (!$obj4->exists())
								{ //si no existe en la base inserta
									$obj4 = new Contacto_Campo();
						   	      	$obj4->campo_id=4;
									$obj4->valor=$arr['telefono_trabajo_movil'];
									$obj4->contacto_id=$obj->id;
									$obj4->usuario_ing=$username;
									$obj4->fecha_ing=date("y-m-d H:i:s");
							        $obj4->estado='AC';
									$obj4->save();	
								}
					        }
							
						    if (is_string($arr['email_personal'])) {
						    	$obj5 = new Contacto_Campo();
								$obj5->where('contacto_id', $obj->id);
							    $obj5->where('valor', $arr['email_personal']);
								$obj5->get();
								if (!$obj5->exists()) 
								{ //si no existe en la base inserta
									$obj5 = new Contacto_Campo();
						   	      	$obj5->campo_id=5;
									$obj5->valor=$arr['email_personal'];
									$obj5->contacto_id=$obj->id;
									$obj5->usuario_ing=$username;
									$obj5->fecha_ing=date("y-m-d H:i:s");
							        $obj5->estado='AC';
									$obj5->save();
							    }	
							}
							if (is_string($arr['email_trabajo'])) {
							   $obj6 = new Contacto_Campo();
							   $obj6->where('contacto_id', $obj->id);
							   $obj6->where('valor', $arr['email_trabajo']);
							   $obj6->get();
							   if (!$obj6->exists()) 
								{ //si no existe en la base inserta
									$obj6 = new Contacto_Campo();
						   	      	$obj6->campo_id=6;
									$obj6->valor=$arr['email_trabajo'];
									$obj6->contacto_id=$obj->id;
									$obj6->usuario_ing=$username;
									$obj6->fecha_ing=date("y-m-d H:i:s");
							        $obj6->estado='AC';
									$obj6->save();
								}	
							}
							
							/*Información Adicional*/
							if (is_string($arr['aprobacion'])) {
							   $obja1 = new Contacto_Campo();
							   $obja1->where('contacto_id', $obj->id);
							   $obja1->where('valor', $arr['aprobacion']);
							   $obja1->get();
							   if (!$obja1->exists()) 
								{ //si no existe en la base inserta
									$obja1 = new Contacto_Campo();
						   	      	$obja1->campo_id=7;
									$obja1->valor=mb_convert_case($arr['aprobacion'], MB_CASE_TITLE, 'UTF-8');
									$obja1->contacto_id=$obj->id;
									$obja1->usuario_ing=$username;
									$obja1->fecha_ing=date("y-m-d H:i:s");
							        $obja1->estado='AC';
									$obja1->save();
								}	
							}
							
														
							if (is_string($arr['limite_plan'])) {
							   $obja2 = new Contacto_Campo();
							   $obja2->where('contacto_id', $obj->id);
							   $obja2->where('valor', $arr['limite_plan']);
							   $obja2->get();
							   if (!$obja2->exists()) 
								{ //si no existe en la base inserta
									$obja2 = new Contacto_Campo();
						   	      	$obja2->campo_id=8;
									$obja2->valor=$arr['limite_plan'];
									$obja2->contacto_id=$obj->id;
									$obja2->usuario_ing=$username;
									$obja2->fecha_ing=date("y-m-d H:i:s");
							        $obja2->estado='AC';
									$obja2->save();
								}	
							}
							
							if (is_string($arr['limite_equipo'])) {
							   $obja3 = new Contacto_Campo();
							   $obja3->where('contacto_id', $obj->id);
							   $obja3->where('valor', $arr['limite_equipo']);
							   $obja3->get();
							   if (!$obja3->exists()) 
								{ //si no existe en la base inserta
									$obja3 = new Contacto_Campo();
						   	      	$obja3->campo_id=9;
									$obja3->valor=$arr['limite_equipo'];
									$obja3->contacto_id=$obj->id;
									$obja3->usuario_ing=$username;
									$obja3->fecha_ing=date("y-m-d H:i:s");
							        $obja3->estado='AC';
									$obja3->save();
								}	
							}
							
							
							if (is_string($arr['forma_pago'])) {
							   $obja4 = new Contacto_Campo();
							   $obja4->where('contacto_id', $obj->id);
							   $obja4->where('valor', $arr['forma_pago']);
							   $obja4->get();
							   if (!$obja4->exists()) 
								{ //si no existe en la base inserta
									$obja4 = new Contacto_Campo();
						   	      	$obja4->campo_id=10;
									$obja4->valor=mb_convert_case($arr['forma_pago'], MB_CASE_TITLE, 'UTF-8');
									$obja4->contacto_id=$obj->id;
									$obja4->usuario_ing=$username;
									$obja4->fecha_ing=date("y-m-d H:i:s");
							        $obja4->estado='AC';
									$obja4->save();
								}	
							}
							
							if (is_string($arr['fecha_activacion'])) {
							   $obja5 = new Contacto_Campo();
							   $obja5->where('contacto_id', $obj->id);
							   $obja5->where('valor', $arr['fecha_activacion']);
							   $obja5->get();
							   if (!$obja5->exists()) 
								{ //si no existe en la base inserta
									$obja5 = new Contacto_Campo();
						   	      	$obja5->campo_id=11;
									$obja5->valor=$arr['fecha_activacion'];
									$obja5->contacto_id=$obj->id;
									$obja5->usuario_ing=$username;
									$obja5->fecha_ing=date("y-m-d H:i:s");
							        $obja5->estado='AC';
									$obja5->save();
								}	
							}
							
							if (is_string($arr['banco'])) {
							   $obja6 = new Contacto_Campo();
							   $obja6->where('contacto_id', $obj->id);
							   $obja6->where('valor', $arr['banco']);
							   $obja6->get();
							   if (!$obja6->exists()) 
								{ //si no existe en la base inserta
									$obja6 = new Contacto_Campo();
						   	      	$obja6->campo_id=12;
									$obja6->valor=mb_convert_case($arr['banco'], MB_CASE_TITLE, 'UTF-8');
									$obja6->contacto_id=$obj->id;
									$obja6->usuario_ing=$username;
									$obja6->fecha_ing=date("y-m-d H:i:s");
							        $obja6->estado='AC';
									$obja6->save();
								}	
							}
							
							if (is_string($arr['tarifa_basica'])) {
							   $obja7 = new Contacto_Campo();
							   $obja7->where('contacto_id', $obj->id);
							   $obja7->where('valor', $arr['tarifa_basica']);
							   $obja7->get();
							   if (!$obja7->exists()) 
								{ //si no existe en la base inserta
									$obja7 = new Contacto_Campo();
						   	      	$obja7->campo_id=13;
									$obja7->valor=$arr['tarifa_basica'];
									$obja7->contacto_id=$obj->id;
									$obja7->usuario_ing=$username;
									$obja7->fecha_ing=date("y-m-d H:i:s");
							        $obja7->estado='AC';
									$obja7->save();
								}	
							}
							
							if (is_string($arr['plan'])) {
							   $obja8 = new Contacto_Campo();
							   $obja8->where('contacto_id', $obj->id);
							   $obja8->where('valor', $arr['plan']);
							   $obja8->get();
							   if (!$obja8->exists()) 
								{ //si no existe en la base inserta
									$obja8 = new Contacto_Campo();
						   	      	$obja8->campo_id=14;
									$obja8->valor=mb_convert_case($arr['plan'], MB_CASE_TITLE, 'UTF-8');
									$obja8->contacto_id=$obj->id;
									$obja8->usuario_ing=$username;
									$obja8->fecha_ing=date("y-m-d H:i:s");
							        $obja8->estado='AC';
									$obja8->save();
								}	
							}
							
							
						}
                        /*Valida Control Transaccional*/
						if ($obj->trans_status() === FALSE) 
						{
						    $trans->trans_rollback();
						}
						else
						{
						    $trans->trans_commit();
						} 			 			
				 
                break;	
				
            default:
				/*
                 $obj = new Contacto_Campo();
				 $query=$obj->datails_query_type(null,null);
				 $results=$query->result_array();
				 echo json_encode($results);
				  */		
					
        }
    }
	
	
  	
}
