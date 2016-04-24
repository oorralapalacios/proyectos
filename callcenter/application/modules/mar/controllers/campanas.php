<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campanas extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        //$page['main_content'] = 'campana_view';
        //$this->load->view('includes/template_panel', $page);
        $this->load->view('includes/header_panel');
		$this->load->view('mar/campana_view');
    }
	
	function detalle($camp_id)
	{
		 $obj = new Campana_Producto();
		 $query=$obj->datails_query($camp_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function parametricas()
	{
		 $par = new Parametrica();
         $par->where('estado', 'AC')->get();
         //$results = array();
         foreach ($par as $r) {
               $res[] = $r->to_json();
         }
         echo '['.join(',', $res).']';				 	
	}
	
	function datostablas($tabla_id)
	{
		 $par = new Parametrica_dato();
         $par->where('parametrica_id', $tabla_id);
		 $par->where('estado', 'AC');
		 $par->get();
         $res = array();
         foreach ($par as $r) {
               $res[] = $r->to_json();
         }
         echo '['.join(',', $res).']';				 	
	}
	
	function confparametros($camp_id, $tabla_id)
	{
		 $obj = new Campana_Parametro();
		 $query=$obj->param_query($camp_id,$tabla_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function detalleparametros($camp_id, $tabla_id)
	{
		 $obj = new Campana_Parametro();
		 $query=$obj->details_query($camp_id,$tabla_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	function categorias($camp_id,$cliente_tipo_id)
	{
		 $obj = new Campana();
		 $query=$obj->categorias($camp_id,$cliente_tipo_id);
		 $results=$query->result_array();
		 echo json_encode($results);		
	}
	
	function productos($camp_id, $cat_id)
	{
		 $obj = new Campana();
		 $query=$obj->listproductos($camp_id, $cat_id);
		 $results=$query->result_array();
		 echo json_encode($results);		
	}
	
	function subproductos($pro_id)
	{
		 $obj = new Campana();
		 $query=$obj->listsubproductos($pro_id);
		 $results=$query->result_array();
		 echo json_encode($results);		
	}
	function filtersubproductos($pro_id)
	{
		 $obj = new Campana();
		 $query=$obj->filtersubproductos($pro_id);
		 $results=$query->result_array();
		 echo json_encode($results);		
	}
		
	function tipo_pregunta(){
		$json = '[{"id":"1","tipo":"Pregunta Abierta"},{"id":"2","tipo":"Pregunta Cerrada"}]';
	    echo ($json);
	}
	
	function escala_details(){
	    $obj = new Escala_opcion();
		$query=$obj->escala_descripcion();
		$results=$query->result_array();
		echo json_encode($results);
	}
	
	function escala_detalle($tipo){
	    $obj = new Escala_opcion();
		$query=$obj->lista_escala($tipo);
		$results=$query->result_array();
		echo json_encode($results);
	}
	
	function opciones_detalle(){
	    $obj = new Opcion_escala();
		$query=$obj->opciones_escala();
		$results=$query->result_array();
		echo json_encode($results);
	}
	
	function opciones_encuesta($escala){
	    $obj = new Opcion_escala();
		$query=$obj->opciones_preguntas($escala);
		$results=$query->result_array();
		echo json_encode($results);
		
		
		
	}	

    function ajax(){
    	date_default_timezone_set(TIMEZONE);
    	$username=modules::run('login/usuario');
        switch($this->input->post('accion')){
            case 'add': 
                $this->db->trans_start();
                $campana = new Campana();
				$campana->nombre=$this->input->post('nombre');
                $campana->descripcion=$this->input->post('descripcion');
				$campana->dialogo_llamada=$this->input->post('dialogo_llamada');
				$campana->texto_mail=$this->input->post('texto_mail');
				$campana->texto_rechazo=$this->input->post('texto_rechazo');
				$campana->texto_cobertura=$this->input->post('texto_cobertura');
				$campana->usuario_ing=$username;
				$campana->fecha_ing=date("y-m-d H:i:s");
                $campana->estado=$this->input->post('estado');
                $campana->save();
				foreach($this->input->post('productos') as $arr)
						{   
							$obj1 = new Campana_Producto();
				   	      	$obj1->producto_id=$arr['producto_id'];
							$obj1->campana_id=$campana->id;
							$obj1->usuario_ing=$username;
							$obj1->fecha_ing=date("y-m-d H:i:s");
							$obj1->save();	
						} 
				 foreach($this->input->post('formapago') as $arr)
						{
							 
							$obj2 = new Campana_Parametro();
				   	      	$obj2->parametrica_id=1;
							$obj2->parametro_id=$arr['parametro_id'];
							$obj2->campana_id=$campana->id;
							$obj2->usuario_ing=$username;
							$obj2->fecha_ing=date("y-m-d H:i:s");
							$obj2->save();	
						}
				foreach($this->input->post('preaprobacion') as $arr)
						{
							
							$obj3 = new Campana_Parametro();
				   	      	$obj3->parametrica_id=2;
							$obj3->parametro_id=$arr['parametro_id'];
							$obj3->campana_id=$campana->id;
							$obj3->usuario_ing=$username;
							$obj3->fecha_ing=date("y-m-d H:i:s");
							$obj3->save();	
						}
				foreach($this->input->post('nointeres') as $arr)
						{
							
							$obj4 = new Campana_Parametro();
				   	      	$obj4->parametrica_id=3;
							$obj4->parametro_id=$arr['parametro_id'];
							$obj4->campana_id=$campana->id;
							$obj4->usuario_ing=$username;
							$obj4->fecha_ing=date("y-m-d H:i:s");
							$obj4->save();	
						}  	
				foreach($this->input->post('preguntas') as $arr)
						{
							$pregunta = new Pregunta();
							$pregunta->campana_id=$campana->id;
							$pregunta->orden=$arr['orden'];
							$pregunta->detalle_pregunta=$arr['detalle_pregunta'];
							$pregunta->tipo_respuesta_id=$arr['tipo_respuesta_id'];
							$pregunta->obligatorio=$arr['obligatorio'];
							$pregunta->usuario_ing=$username;
							$pregunta->fecha_ing=date("y-m-d H:i:s");
							$pregunta->save();
							
						}
						
				if ($this->db->trans_status() === FALSE)
				 {
					$this->db->trans_rollback();
					echo 'Error de transacion';
				 } else {
					$this->db->trans_complete();
				 }	 				
                break;
            case 'edit':
                if($this->input->post('id')){
                	$this->db->trans_start();
                    $campana = new Campana();
                    $campana->where('id', $this->input->post('id'))->get();
					$campana->nombre=$this->input->post('nombre');
                    $campana->descripcion=$this->input->post('descripcion');
					$campana->dialogo_llamada=$this->input->post('dialogo_llamada');
				    $campana->texto_mail=$this->input->post('texto_mail');
					$campana->texto_rechazo=$this->input->post('texto_rechazo');
					$campana->texto_cobertura=$this->input->post('texto_cobertura');
                    $campana->estado=$this->input->post('estado');
					$campana->usuario_mod=$username;
					$campana->fecha_mod=date("y-m-d H:i:s");
                    $campana->save();
					foreach($this->input->post('productos') as $arr)
						{
							$obj1 = new Campana_Producto();
							$obj1->where('id', $arr['id'])->get();
							$obj1->producto_id=$arr['producto_id'];
							$obj1->campana_id=$campana->id;
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
					foreach($this->input->post('formapago') as $arr)
						{
							$obj2 = new Campana_Parametro();
							$obj2->where('id', $arr['id'])->get();
							$obj2->parametrica_id=1;
							$obj2->parametro_id=$arr['parametro_id'];
							$obj2->campana_id=$campana->id;
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
					foreach($this->input->post('preaprobacion') as $arr)
						{
							$obj3 = new Campana_Parametro();
							$obj3->where('id', $arr['id'])->get();
							$obj3->parametrica_id=2;
							$obj3->parametro_id=$arr['parametro_id'];
							$obj3->campana_id=$campana->id;
							if ($obj3->usuario_ing){
							 $obj3->usuario_mod=$username;
							}
							if (!$obj3->usuario_ing){
							 $obj3->usuario_ing=$username;	
							}
							if ($obj3->fecha_ing){
							 $obj3->fecha_mod=date("y-m-d H:i:s");
							}
							if (!$obj3->fecha_ing){
							 $obj3->fecha_ing=date("y-m-d H:i:s");
							}
							$obj3->save();	
						}
					foreach($this->input->post('nointeres') as $arr)
						{
							$obj4 = new Campana_Parametro();
							$obj4->where('id', $arr['id'])->get();
							$obj4->parametrica_id=3;
							$obj4->parametro_id=$arr['parametro_id'];
							$obj4->campana_id=$campana->id;
							if ($obj4->usuario_ing){
							 $obj4->usuario_mod=$username;
							}
							if (!$obj4->usuario_ing){
							 $obj4->usuario_ing=$username;	
							}
							if ($obj4->fecha_ing){
							 $obj4->fecha_mod=date("y-m-d H:i:s");
							}
							if (!$obj4->fecha_ing){
							 $obj4->fecha_ing=date("y-m-d H:i:s");
							}
							$obj4->save();	
						} 
					foreach($this->input->post('preguntas') as $arr)
						{
							$pregunta = new Pregunta();
							$pregunta->where('id', $arr['id'])->get();
							$pregunta->campana_id=$campana->id;
							$pregunta->orden=$arr['orden'];
							$pregunta->detalle_pregunta=$arr['detalle_pregunta'];
							$pregunta->tipo_respuesta_id=$arr['tipo_respuesta_id'];
							$pregunta->obligatorio=$arr['obligatorio'];
							if ($pregunta->usuario_ing){
							 $pregunta->usuario_mod=$username;
							}
							if (!$pregunta->usuario_ing){
							 $pregunta->usuario_ing=$username;	
							}
							if ($pregunta->fecha_ing){
							 $pregunta->fecha_mod=date("y-m-d H:i:s");
							}
							if (!$pregunta->fecha_ing){
							 $pregunta->fecha_ing=date("y-m-d H:i:s");
							}
							$pregunta->save();
							
						}
					 if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					 } else {
						$this->db->trans_complete();
					 }	 			 						 					
                }
                break;
            case 'del':
                if($this->input->post('id')){
                	$this->db->trans_start();
                    $campana = new Campana();
                    $campana->where('id', $this->input->post('id'))->get();
					$campana->usuario_mod=$username;
                    $campana->estado='IN';
                    $campana->save();
				    $obj1 = new Campana_Producto();
				    $obj1->where('campana_id', $this->input->post('id'))->update('estado', 'IN');
					$obj2 = new Campana_Parametro();
				    $obj2->where('campana_id', $this->input->post('id'))->update('estado', 'IN');
					if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					 } else {
						$this->db->trans_complete();
					 }	 	
                }
                break;
			  case 'delpreg':
                if($this->input->post('id')){
                	$this->db->trans_start();
                    $obj = new Pregunta();
                    $obj->where('id', $this->input->post('id'))->get();
					$obj->usuario_mod=$username;
                    $obj->estado='IN';
                    $obj->save();
				    if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					 } else {
						$this->db->trans_complete();
					 }	 	
                }
                break;
			   case 'delpro':
                if($this->input->post('id')){
                	$this->db->trans_start();
                    $obj = new Campana_Producto();
                    $obj->where('id', $this->input->post('id'))->get();
					$obj->usuario_mod=$username;
                    $obj->estado='IN';
                    $obj->save();
				    if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					 } else {
						$this->db->trans_complete();
					 }	 	
                }
                break;
				case 'delpar':
                if($this->input->post('id')){
                	$this->db->trans_start();
                    $obj = new Campana_Parametro;
                    $obj->where('id', $this->input->post('id'))->get();
					$obj->usuario_mod=$username;
                    $obj->estado='IN';
                    $obj->save();
				    if ($this->db->trans_status() === FALSE)
					 {
						$this->db->trans_rollback();
						echo 'Error de transacion';
					 } else {
						$this->db->trans_complete();
					 }	 	
                }
                break;
				
            default:
                $campana = new Campana();
                $campana->where('estado', 'AC')->get();
                $results = array();
                foreach ($campana as $r) {
                    $res[] = $r->to_json();
                }
                echo '['.join(',', $res).']';	
				
	       }
    }

	function saveEscala(){
		          $username=modules::run('login/usuario');
				  switch($this->input->post('accion')){
                   case 'add': 
					  $obj = new Escala_opcion();
				      $obj->tipo_pregunta_id=$this->input->post('tipo_pregunta_id');
					  $obj->nombre=$this->input->post('nombre_escala');
					  $obj->opcion_otro=$this->input->post('opcion_otro');
					  $obj->multiple_respuesta=$this->input->post('multiple_respuesta');
					  $obj->usuario_ing=$username;
					  $obj->save();
					    break;
					case 'edit': 
					  $obj = new Escala_opcion();
					  $obj->where('id', $this->input->post('id'))->get();
					  $obj->tipo_pregunta_id=$this->input->post('tipo_pregunta_id');
					  $obj->nombre=$this->input->post('nombre_escala');
					  $obj->opcion_otro=$this->input->post('opcion_otro');
					  $obj->multiple_respuesta=$this->input->post('multiple_respuesta');
					  $obj->usuario_mod=$username;
					  $obj->save();
						 break;
						 
					case 'del':
					  $obj = new Escala_opcion();
					  $obj->where('id', $this->input->post('id'))->get();
					  $obj->estado='IN';
					  $obj->usuario_mod=$username;
					  $obj->save();
						break;
                    default: 
				  }
	}
	
	
	
	function saveOpcion(){
		          $username=modules::run('login/usuario');
				  $id_escala = $this->input->post('escalas_id');
				  $opci = $this->input->post('detalle');
				  $esc = new Escala_opcion();
                  $esc->where('id', $id_escala)->get();
                  $results = array();
                  foreach ($esc as $r) {
                     $multi = $r->multiple_respuesta;
                  }
				  if ($multi=='true'){
				  	$objeto ="checkbox";
				  }else{
				  	$objeto ="radio";
				  }
				  
				  switch($this->input->post('accion')){
                   case 'add':
				      $obj = new Opcion_escala();
				      $obj->orden=$this->input->post('orden');
					  $obj->escalas_id=$this->input->post('escalas_id');
					  $obj->objeto=$objeto;
					  $obj->detalle=$opci;
					  $obj->usuario_ing=$username;
					  $obj->save();
					  
					   break;
					case 'edit': 
					  
					  $obj = new Opcion_escala();
					  $obj->where('id', $this->input->post('id'))->get();
					  $obj->orden=$this->input->post('orden');
					  $obj->escalas_id=$this->input->post('escalas_id');
					  $obj->objeto=$objeto;
					  $obj->detalle=$opci;
					  $obj->usuario_mod=$username;
					  $obj->save();
					  
					   break;
					case 'del':   
					  $obj = new Opcion_escala();
					  $obj->where('id', $this->input->post('id'))->get();
					  $obj->estado='IN';
					  $obj->usuario_mod=$username;
					 
					  break;
                   default: 
					
	            }
    }

}
