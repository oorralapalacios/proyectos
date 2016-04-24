<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactos_base extends MX_Controller{
    function __construct(){
        parent::__construct();
	    modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
    	
        $this->load->view('includes/header_panel');
		$this->load->view('mar/contactobase_view');
		$this->load->view('mar/contactobase_up');
		$this->load->view('mar/contactobase_form');
		$this->load->view('mar/contactobase_asignar');
		$this->load->view('mar/contactobase_reasignar');
		$this->load->view('mar/contactobase_selasignar');
		$this->load->view('mar/contactobase_selreasignar');
		$this->load->view('mar/contacto_info');
		
	}
	
	
	
	/*datos con paginacion*/
	function datos($campana_id,$estado){
		//$accion;
		
		$obj = new Contacto_subido();
		$data=$obj->bandejafilter($campana_id,$estado);
		return $data;

	}
	
	
	
	function buscadatos($campana_id,$campo,$valor){
		$obj = new Contacto();
	    $query=$obj->bandejaBusqueda($campana_id,$campo,$valor);
		$results=$query->result_array();
		echo json_encode($results);
	}
	function datosbajas($campana_id){
		$obj = new Contacto();
		$query=$obj->bandejabajas($campana_id);
		$results=$query->result_array();
		echo json_encode($results);
	}

	function datossingestor($campana_id){
		$obj = new Contacto_subido();
		$data=$obj->seldatasingestorfilter($campana_id);
		return $data;
	}
	

	
	function datoscongestor($campana_id,$empleado_id){
		$obj = new Contacto_subido();
		$data=$obj->seldatacongestorfilter($campana_id,$empleado_id);
		return $data;
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
	
	
	function configFechaLlamada($emp2_id){
	  date_default_timezone_set(TIMEZONE);
	 /*Busca en seguimiento telefonico la ultima fecha asignada al empleado
	 * Para Planificar la fecha y hora en base al algortimo de asignacion en la 
	 * pila de llamadas de seguimiento a realizar*/
	  $fecha=date("Y-m-d H:i:s",strtotime($this->ultimafechaSeguimiento($emp2_id)));
	  $nuevafecha=$fecha;
	  //echo($fecha);
      /*Reglas*/
	  /*Cada 15 minutos*/	
      $segundos=900;
	  /*Intervalo dias*/
	  $labdiaini=1;
	  $labdiafin=5;
	  /*Intervalos horas laborables*/
	  /*Desde*/
	  $labhoraini= date('H:i:s', strtotime ('08:00:00'));
	  /*Hasta*/
	  $labhorafin= date('H:i:s', strtotime ('17:45:00'));
	  /*Evaluaciones*/
	  /*Obtiene el dia de la semana*/
	  $dia= date("N", strtotime ( $fecha ));
	  /*Obtiene Hora*/
	  $hora=date('H:i:s', strtotime ( $fecha ));
	  //echo(' ');
	  //echo($hora);
	  
	 if ($dia>=$labdiaini and $dia<=$labdiafin){
		
	  if ($this->horaesmayorigual($hora,$labhoraini) and $this->horaesmenorigual($hora,$labhorafin)){
	    /*si estoy en dia laborables y en el horario de atención asigno la llamada en los 15 min poseriores*/
	    /*Incrementos*/
		//aumenta 15 minutos
		  
		$nuevafecha = strtotime ( '+'.$segundos.' second' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d H:i:s' , $nuevafecha );
	   }elseif($this->horaesmayorigual($hora,$labhorafin)){
		  if ($dia==5){
			  //echo ($dia);
		   $idia=3;
		   //si el dia es menor al anterior ultimo laboral o es dia 7 aumente 1 dia y empieza con hora laboral de inicio
		   $nuevafecha = strtotime ( '+'.$idia.' day' , strtotime ( $fecha ) ) ;
           $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		   $nuevafecha = date ( 'Y-m-d H:i:s', strtotime ($nuevafecha.' '.$labhoraini));
		 }
		  if ($dia<5){
			  // echo ($dia);
		   $idia=1;
		   //si el dia es menor al anterior ultimo laboral o es dia 7 aumente 1 dia y empieza con hora laboral de inicio
		   $nuevafecha = strtotime ( '+'.$idia.' day' , strtotime ( $fecha ) ) ;
           $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		   $nuevafecha = date ( 'Y-m-d H:i:s', strtotime ($nuevafecha.' '.$labhoraini));
		  }
	   }elseif($this->horaesmenorigual($hora,$labhoraini)){
	   	//revisar hace falta algo en el algoritmo cuando es de madrugada debe correr al siguiente dia laborable a partir de las 8
	   }
	 }else{
		 if($dia==6){//si es sabado aumente 2 dias es decir avanza al lunes y empieza con hora laboral de inicio  
			
		$idia=2;
	    $nuevafecha = strtotime ( '+'.$idia.' day' , strtotime ( $fecha ) ) ;
		
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		 //  echo($nuevafecha);
		$nuevafecha = date ( 'Y-m-d H:i:s', strtotime ($nuevafecha.' '. $labhoraini));
     }
	 if($dia==7){//si domingo aumente 1 dia es decir avanza al lunes y empieza con hora laboral de inicio  
		 
		$idia=1;
	    $nuevafecha = strtotime ( '+'.$idia.' day' , strtotime ( $fecha ) ) ;
		
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		 //  echo($nuevafecha);
		$nuevafecha = date ( 'Y-m-d H:i:s', strtotime ($nuevafecha.' '. $labhoraini));
     }
    }
     /*si es que es un sabado o domingo la validacion asigna fecha para el lunes desde el inicio del horario de atención*/
	return $nuevafecha;
	//echo $nuevafecha;
   }

   function horaesmenorigual($hora1,$hora2){
		$hi = explode(':', $hora1); $hf = explode(':', $hora2);
		for($i=0; $i<=count($hi); $i++) { $tem1=$hi[0]*3600; $tem2=$hi[1]*60; } $valor1=$tem2+$tem1;
		for ($i=0; $i<=count($hf); $i++) { $tem3=$hf[0]*3600; $tem4=$hf[1]*60; }
		$valor2=$tem3+$tem4;
		$val=($valor1<=$valor2 ? true : false);
	return $val;
	}
	
    function horaesmayorigual($hora1,$hora2){
		$hi = explode(':', $hora1); $hf = explode(':', $hora2);
		for($i=0; $i<=count($hi); $i++) { $tem1=$hi[0]*3600; $tem2=$hi[1]*60; } $valor1=$tem2+$tem1;
		for ($i=0; $i<=count($hf); $i++) { $tem3=$hf[0]*3600; $tem4=$hf[1]*60; }
		$valor2=$tem3+$tem4;
		$val=($valor1>=$valor2 ? true : false);
	return $val;
	}
	
	function ultimafechaSeguimiento($emp2_id){
	  date_default_timezone_set(TIMEZONE);
	  $seg = new Contacto_Campana();
	  $query=$seg->ultima_fecha_seguimiento_empleado($emp2_id);
	  
	  if ($query->num_rows()){
	 	foreach ($query->result() as $fila)
			{
			  $fecha=date($this->config->item('log_date_format'),strtotime ($fila->fecha_hora));
			}	 
	  	
	  } else {
	  	$fecha=date($this->config->item('log_date_format'));
	  }
 
     return $fecha;
	 //echo $fecha;
	}
	
	
	
    function ajax(){
    	date_default_timezone_set(TIMEZONE);
    	$username=modules::run('login/usuario');
        switch($this->input->post('accion')){
			case 'dataup':
				   echo json_encode($this->datos($this->input->post('camp_id'),'AC'));
				break;
	        case 'datadown':
				    echo json_encode($this->datos($this->input->post('camp_id'),'BA'));
			   break;
			case 'dataselasig':
			        echo json_encode ($this->datossingestor($this->input->post('camp_id')));
			   break; 
			case 'dataselreasig':   
				    echo json_encode ($this->datoscongestor($this->input->post('camp_id'),$this->input->post('emp_id')));
			   break;
            case 'add': 
				  $cam_id=$this->input->post('campana_id');
				  $obj = new Contacto_subido();
				  $obj->campana_id=$cam_id;
				  $obj->identificacion=$this->input->post('identificacion');
				  $obj->cliente=$this->input->post('cliente');
				  $obj->telefono_movil=$this->input->post('telefono_movil');
				  $obj->ciudad=$this->input->post('ciudad');
				  $obj->forma_pago=$this->input->post('forma_pago');
				  $obj->fecha_activacion=$this->input->post('fecha_activacion');
				  $obj->banco=$this->input->post('banco');  
				  $obj->tarifa_basica=$this->input->post('tarifa_basica'); 
				  $obj->plan=$this->input->post('plan'); 
				  $obj->estado=$this->input->post('estado');
				  $obj->tipo_subida='Manual';
				  $obj->usuario_ing=$username;
				  $obj->fecha_ing=date("y-m-d H:i:s");
                  $obj->save();
					 
                break;
            case 'edit':
			 $cam_id=$this->input->post('campana_id');
                if($this->input->post('id')){
                	$id=$this->input->post('id');
                	$obj = new Contacto_subido();
					$obj->where('id', $id)->get();
					$obj->identificacion=$this->input->post('identificacion');
					$obj->cliente=$this->input->post('cliente');
					$obj->telefono_movil=$this->input->post('telefono_movil');
				    $obj->ciudad=$this->input->post('ciudad');
					$obj->forma_pago=$this->input->post('forma_pago');
				    $obj->fecha_activacion=$this->input->post('fecha_activacion');
				    $obj->banco=$this->input->post('banco');  
				    $obj->tarifa_basica=$this->input->post('tarifa_basica'); 
				    $obj->plan=$this->input->post('plan'); 
					$obj->estado=$this->input->post('estado');
					$obj->usuario_mod=$username;
					$obj->fecha_mod=date("y-m-d H:i:s");
                    $obj->save();
				}
                break;
            case 'del':
                if($this->input->post('id')){
                	$contacto = new Contacto_subido();
					$contacto->where('id', $this->input->post('id'))->get();
					$contacto->usuario_mod=$username;
					$contacto->fecha_mod=date("y-m-d H:i:s");
                    $contacto->estado='IN';
                    $contacto->save();
							 
                }
                break;
				
			case 'baja':
                if($this->input->post('id')){
                	$contacto = new Contacto_subido();
					$contacto->where('id', $this->input->post('id'))->get();
					$contacto->usuario_mod=$username;
					$contacto->fecha_mod=date("Y-m-d H:i:s");
                    $contacto->estado='BA';
                    $contacto->save();
							 
                }
                break;
				
				case 'acbaja':
                if($this->input->post('id')){
                    $contacto = new Contacto_subido();
					$contacto->where('id', $this->input->post('id'))->get();
					$contacto->usuario_mod=$username;
					$contacto->fecha_mod=date("y-m-d H:i:s");
                    $contacto->estado='AC';
                    $contacto->save();
					 
                }
                break;		
				
		    case 'asig':
                    $emp_id=$this->input->post('empleado_id');
			        $camp_id=$this->input->post('campana_id');
			        $registros=$this->input->post('registros');
					/*selecciono n registros de contactos subidos*/
					$cup=new Contacto_subido();
					$query=$cup->dataparaasignar($camp_id,$registros);
					/*para integrar Omar*/
					$results=$query->result();
		            foreach ($results as $up){
					 	    $obj = new Contacto();
					        $obj->get_by_identificacion($up->identificacion);
							// Chequea si existe en la base de datos
							if ($obj->exists())
							{ //por si actualiza
							  $obj->identificacion=$up->identificacion;
							  $obj->nombres=$this->separaNombres($up->cliente);
							  $obj->apellidos=$this->separaApellidos($up->cliente);
							  $obj->ciudad=mb_convert_case($up->ciudad, MB_CASE_TITLE, 'UTF-8');
				              $obj->usuario_mod=$username;
							  $obj->fecha_mod=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							}else{ //si no existe en la base inserta
							  $obj = new Contacto();
							  $obj->identificacion=$up->identificacion;
							  $obj->nombres=$this->separaNombres($up->cliente);
				              $obj->apellidos=$this->separaApellidos($up->cliente);
							  $obj->ciudad=mb_convert_case($up->ciudad, MB_CASE_TITLE, 'UTF-8');
				              $obj->usuario_ing=$username;
							  $obj->fecha_ing=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							} 
							if (is_numeric($up->telefono_movil)) {			
								$obj1 = new Contacto_Campo();
							  	$obj1->where('contacto_id', $obj->id);
							    $obj1->where('valor', $up->telefono_movil);
								$obj1->get();
								if (!$obj1->exists())
							    { //si no existe en la base inserta
							        $obj1 = new Contacto_Campo();
						   	      	$obj1->campo_id=1;
									$obj1->valor=$up->telefono_movil;
									$obj1->contacto_id=$obj->id;
									$obj1->usuario_ing=$username;
									$obj1->fecha_ing=date("y-m-d H:i:s");
							        $obj1->estado='AC';
									$obj1->save();	
								}
							} 
							$obj7 = new Contacto_Campana();
							$obj7->where('contacto_id', $obj->id);
							$obj7->where('campana_id', $cam_id);
							$obj7->where('empleado_id', $emp_id);
							$obj7->where('telefono', $up->telefono_movil);
							$obj7->get();
							if ($obj7->exists())
							{
							}else{//inserta 
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$emp_id;
						       $obj7->campana_id=$camp_id;
							   $obj7->contacto_id=$obj->id;
						       $obj7->telefono=$up->telefono_movil;
							   //$obj7->fecha_hora=date("Y-m-d H:i:s",strtotime($this->configFechaLlamada($emp_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Asignado';
							   $obj7->bandeja='GC';
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=date("y-m-d H:i:s");
							   $obj7->estado='AC';
							   $obj7->save();
							} 
	                 }
		        
                 break;
			  case 'selasig':
                    $emp_id=$this->input->post('empleado_id');
			        $camp_id=$this->input->post('campana_id');
			        //$camp_id=$this->input->post('campana');
			        $registros=$this->input->post('registros');
					foreach($this->input->post('registros') as $arr)
						{
                	      	$obj = new Contacto();
					        $obj->get_by_identificacion($arr['identificacion']);
							// Chequea si existe en la base de datos
							if ($obj->exists())
							{ //por si actualiza
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
							  $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
				              $obj->usuario_mod=$username;
							  $obj->fecha_mod=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							}else{ //si no existe en la base inserta
							  $obj = new Contacto();
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
				              $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
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
							$obj7 = new Contacto_Campana();
							$obj7->where('contacto_id', $obj->id);
							$obj7->where('campana_id', $camp_id);
							$obj7->where('empleado_id', $emp_id);
							$obj7->where('telefono', $arr['telefono_movil']);
							$obj7->get();
							if ($obj7->exists())
							{
							}else{//inserta 
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$emp_id;
						       $obj7->campana_id=$camp_id;
							   $obj7->contacto_id=$obj->id;
						       $obj7->telefono=$arr['telefono_movil'];
							   //$obj7->fecha_hora=date("y-m-d H:i:s",strtotime ($this->configFechaLlamada($emp_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Asignado';
							   $obj7->bandeja='GC';
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=date("y-m-d H:i:s");
							   $obj7->estado='AC';
							   $obj7->save();
							} 
					   }
                
                break;
				
			case 'reasig':
                    $camp_id=$this->input->post('campana_id');
				    $emp1_id=$this->input->post('empleado1_id');
					$emp2_id=$this->input->post('empleado2_id');
                	
					$cup=new Contacto_subido();
					$query=$cup->dataparareasignar($camp_id,$emp1_id,$emp2_id);
					/*para integrar Omar*/
					$results=$query->result();
		            foreach ($results as $up){
					 	    
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$up->empleado_id;
						       $obj7->campana_id=$up->campana_id;
							   $obj7->contacto_id=$up->contacto_id;
						       $obj7->telefono=$up->telefono;
							   //$obj7->fecha_hora=date("Y-m-d H:i:s",strtotime($this->configFechaLlamada($emp2_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Reasignado';
							   $obj7->bandeja='GC';
							   $obj7->padre_id=$up->padre_id;
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=$up->fecha_ing;
							   $obj7->estado='AC';
							   $obj7->save();
							 
	                 }
		        
                                	
                	
                break;
				
			case 'selreasig':
                    $camp_id=$this->input->post('campana_id');
				    $emp1_id=$this->input->post('empleado1_id');
					$emp2_id=$this->input->post('empleado2_id');
                	$registros=$this->input->post('registros');
														        
					foreach($this->input->post('registros') as $arr)
						{
                	        
							
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$emp2_id;
						       $obj7->campana_id=$camp_id;
							   $obj7->contacto_id=$arr['contacto_id'];
						       $obj7->telefono=$arr['telefono'];
							   $obj7->observaciones=$arr['observaciones'];
							   //$obj7->fecha_hora=date("Y-m-d H:i:s",strtotime($this->configFechaLlamada($emp2_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Reasignado';
							   $obj7->bandeja='GC';
							   $obj7->padre_id=$arr['padre_id'];
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=date("Y-m-d H:i:s");
							   $obj7->estado='AC';
							   $obj7->save();
							
					   }
					
					
                break;	
			
				case 'selasigseg':
					$emp_id=$this->input->post('empleado_id');
			        $camp_id=$this->input->post('campana_id');
			        $registros=$this->input->post('registros');
					foreach($this->input->post('registros') as $arr)
						{
                	        $obj = new Contacto();
					        $obj->get_by_identificacion($arr['identificacion']);
							// Chequea si existe en la base de datos
							if ($obj->exists())
							{ //por si actualiza
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
							  $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
				              $obj->usuario_mod=$username;
							  $obj->fecha_mod=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							}else{ //si no existe en la base inserta
							  $obj = new Contacto();
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
				              $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
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
							
							$obj7 = new Contacto_Campana();
							$obj7->where('contacto_id', $obj->id);
							$obj7->where('campana_id', $camp_id);
							$obj7->where('empleado_id', $emp_id);
							$obj7->where('telefono', $arr['telefono_movil']);
							$obj7->get();
							if ($obj7->exists())
							{
							}else{//inserta 
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$emp_id;
						       $obj7->campana_id=$camp_id;
							   $obj7->contacto_id=$obj->id;
						       $obj7->telefono=$arr['telefono_movil'];
							   //$obj7->fecha_hora=date("Y-m-d H:i:s",strtotime ($this->configFechaLlamada($emp_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Asignado';
							   $obj7->bandeja='ST';
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=date("Y-m-d H:i:s");
							   $obj7->estado='AC';
							   $obj7->save();
							} 
					   }
                                             
					
					break;
				
				case 'selreasigseg':
                    $camp_id=$this->input->post('campana_id');
				    $emp1_id=$this->input->post('empleado1_id');
					$emp2_id=$this->input->post('empleado2_id');
                	$registros=$this->input->post('registros');
					
					foreach($this->input->post('registros') as $arr)
						{
                	       
						
							
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$emp2_id;
						       $obj7->campana_id=$camp_id;
							   $obj7->contacto_id=$arr['contacto_id'];
						       $obj7->telefono=$arr['telefono'];
							   $obj7->observaciones=$arr['observaciones'];
							   //$obj7->fecha_hora=date("Y-m-d H:i:s",strtotime($this->configFechaLlamada($emp2_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Reasignado';
							   $obj7->bandeja='ST';
							   $obj7->padre_id=$arr['padre_id'];
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=date("Y-m-d H:i:s");
							   $obj7->estado='AC';
							   $obj7->save();
							
							
					   }
                       					
					
                break;	
				
				
			case 'aselasigGC':
                    $emp_id=$this->input->post('empleado_id');
			        //$camp_id=$this->input->post('campana_id');
			        //$camp_id=$this->input->post('campana');
			        $registros=$this->input->post('registros');
					foreach($this->input->post('registros') as $arr)
						{
                	      	$obj = new Contacto();
					        $obj->get_by_identificacion($arr['identificacion']);
							// Chequea si existe en la base de datos
							if ($obj->exists())
							{ //por si actualiza
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
							  $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
				              $obj->usuario_mod=$username;
							  $obj->fecha_mod=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							}else{ //si no existe en la base inserta
							  $obj = new Contacto();
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
				              $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
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
							$obj7 = new Contacto_Campana();
							$obj7->where('contacto_id', $obj->id);
							$obj7->where('campana_id', $arr['campana_id']);
							$obj7->where('empleado_id', $emp_id);
							$obj7->where('telefono', $arr['telefono_movil']);
							$obj7->get();
							if ($obj7->exists())
							{
							}else{//inserta 
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$emp_id;
						       $obj7->campana_id=$arr['campana_id'];
							   $obj7->contacto_id=$obj->id;
						       $obj7->telefono=$arr['telefono_movil'];
							   //$obj7->fecha_hora=date("y-m-d H:i:s",strtotime ($this->configFechaLlamada($emp_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Asignado';
							   $obj7->bandeja='GC';
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=date("y-m-d H:i:s");
							   $obj7->estado='AC';
							   $obj7->save();
							} 
					   }
                
                break;	
			
			case 'aselasigIN':
                    $emp_id=$this->input->post('empleado_id');
			        //$camp_id=$this->input->post('campana_id');
			        //$camp_id=$this->input->post('campana');
			        $registros=$this->input->post('registros');
					foreach($this->input->post('registros') as $arr)
						{
                	      	$obj = new Contacto();
					        $obj->get_by_identificacion($arr['identificacion']);
							// Chequea si existe en la base de datos
							if ($obj->exists())
							{ //por si actualiza
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
							  $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
				              $obj->usuario_mod=$username;
							  $obj->fecha_mod=date("y-m-d H:i:s");
							  $obj->estado='AC';
					          $obj->save();
							}else{ //si no existe en la base inserta
							  $obj = new Contacto();
							  $obj->identificacion=$arr['identificacion'];
							  $obj->nombres=$this->separaNombres($arr['cliente']);
				              $obj->apellidos=$this->separaApellidos($arr['cliente']);
							  $obj->ciudad=mb_convert_case($arr['ciudad'], MB_CASE_TITLE, 'UTF-8');
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
							$obj7 = new Contacto_Campana();
							$obj7->where('contacto_id', $obj->id);
							$obj7->where('campana_id', $camp_id);
							$obj7->where('empleado_id', $emp_id);
							$obj7->where('telefono', $arr['telefono_movil']);
							$obj7->get();
							if ($obj7->exists())
							{
							}else{//inserta 
							   $obj7 = new Contacto_Campana();
						   	   $obj7->empleado_id=$emp_id;
						       $obj7->campana_id=$arr['campana_id'];
							   $obj7->contacto_id=$obj->id;
						       $obj7->telefono=$arr['telefono_movil'];
							   //$obj7->fecha_hora=date("y-m-d H:i:s",strtotime ($this->configFechaLlamada($emp_id)));
							   $obj7->fecha_hora=date("Y-m-d H:i:s");
							   $obj7->proceso='Asignado';
							   $obj7->bandeja='IN';
							   $obj7->usuario_ing=$username;
							   $obj7->fecha_ing=date("y-m-d H:i:s");
							   $obj7->estado='AC';
							   $obj7->save();
							} 
					   }
                
                break;	
	        
	        case 'import':
				if ($this->input->post('fields')&&$this->input->post('values')){
					    $campana_id=$this->input->post('campana_id');
					    //$finds=$this->input->post('finds');
					    $fields=$this->input->post('fields');
						$values=$this->input->post('values');
						$user=modules::run('login/usuario');
						if (!empty($fields)&&!empty($values)) {
					    
						  //$sql= " INSERT IGNORE INTO contactos_subidos ".$fields." VALUES ".$values.";";
						   $sql= " REPLACE INTO contactos_subidos ".$fields." VALUES ".$values.";";
						     						      	
				       }	

               

						$sqls = explode(';', $sql);
						array_pop($sqls);
						
						foreach($sqls as $statement){
							$statment = $statement . ";";
							$this->db->query($statement);	
						}
						
						
				 }
			 break;
		
 		   			
            default:
				
		       	
			    //echo json_encode ($this->datoscongestor(1,9));
				
               
					
        }
    }
	
	
  	
}
