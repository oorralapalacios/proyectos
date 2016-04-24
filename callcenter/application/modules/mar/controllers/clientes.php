<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        $page['main_content'] = 'cliente_view'; 
        $this->load->view('includes/template_panel', $page);
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
		 //echo $obj->to_json();
		 $results = array();
		 foreach ($obj as $o) {
	     $results[] = $o->to_json();
	     }
	     echo '['.join(',', $results).']';
		 				 	
	}
   
    function detalle($conta_id,$tipo)
	{
		 $obj = new Cliente_Campo();
		 $query=$obj->datails_query_type($conta_id,$tipo);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function detalleAll($conta_id)
	{
		 $obj = new Cliente_Campo();
		 $query=$obj->datails_query($conta_id);
		 $results=$query->result_array();
		 echo json_encode($results);				 	
	}
	
	function buscar_contacto($identificacion){
		 $obj = new Contacto();
		 $obj->where('identificacion', $identificacion)->get();
		 echo $obj->to_json();
		/* $obj = new Contactos();
		 $query=$obj->datails_query($identificacion);
		 $results=$query->result_array();
		 echo json_encode($results);*/
	}
	
    function ajax(){
        switch($this->input->post('accion')){
            case 'add': 
				  
                  
                  //$emp_id=$this->input->post('empleado_id');
				  //$cam_id=$this->input->post('campana_id');
                  $obj = new Cliente();
				  $identificacion = $this->input->post('identificacion');
                  if ($identificacion!=$obj->where('identificacion', $identificacion)->get())
                    {

					  $obj->tipo=$this->input->post('tipo_cliente');
					  $obj->identificacion=$this->input->post('identificacion');
					  $obj->nombres=$this->input->post('nombres');
					  $obj->apellidos=$this->input->post('apellidos');
					  $obj->genero=$this->input->post('genero');
					  $obj->ciudad=$this->input->post('ciudad');
					  $obj->direccion=$this->input->post('direccion');
					  $obj->estado=$this->input->post('estado');
					  $obj->save();
					   foreach($this->input->post('telefonos') as $arr)
							{
								$obj1 = new Cliente_Campo();
								$obj1->campo_id=$arr['campo_id'];
								$obj1->valor=$arr['valor'];
								$obj1->cliente_id=$obj->id;
								$obj1->save();	
							}
						foreach($this->input->post('mails') as $arr1)
							{
								$obj2 = new Cliente_Campo();
								$obj2->campo_id=$arr1['campo_id'];
								$obj2->valor=$arr1['valor'];
								$obj2->cliente_id=$obj->id;
								$obj2->save();	
							}
						if($obj->tipo=="Natural"){
						}else{
							$obj3 = new Empresa();
							$obj3->ruc=$this->input->post('identificacion');
							$obj3->razon_social=$this->input->post('nombres');
							$obj3->nombre_comercial=$this->input->post('apellidos');
							$obj3->ciudad=$this->input->post('ciudad');
							$obj3->direccion=$this->input->post('direccion');
							$obj3->estado=$this->input->post('estado');
							$obj3->save();
							
							foreach($this->input->post('telefonos') as $arr)
							{
								$obj1 = new Empresa_Campo();
								$obj1->campo_id=$arr['campo_id'];
								$obj1->valor=$arr['valor'];
								$obj1->cliente_id=$obj->id;
								$obj1->save();	
							}
							foreach($this->input->post('mails') as $arr1)
							{
								$obj2 = new Empresa_Campo();
								$obj2->campo_id=$arr1['campo_id'];
								$obj2->valor=$arr1['valor'];
								$obj2->cliente_id=$obj->id;
								$obj2->save();	
							}
							
							$obj4 = new Cliente_Empresa();
							$obj4->empresa_id=$obj3->id;
							$obj4->cliente_id=$obj->id;
							$obj4->save();	
						}
					}else{
                        return false;
                    }
											 			 			
				 
                break;
            case 'edit':
                if($this->input->post('id')){
                	$id=$this->input->post('id');
                	/*$con_id=$this->input->post('contacto_id');
                	$emp_id=$this->input->post('empleado_id');
				    $cam_id=$this->input->post('campana_id');	*/
                    $obj = new Cliente();
                    $obj->where('id', $con_id)->get();
					$obj->cliente_id=$this->input->post('tipo');
					$obj->identificacion=$this->input->post('identificacion');
					$obj->nombres=$this->input->post('nombres');
					$obj->apellidos=$this->input->post('apellidos');
					$obj->genero=$this->input->post('genero');
					$obj->ciudad=$this->input->post('ciudad');
					$obj->direccion=$this->input->post('direccion');
					$obj->estado=$this->input->post('estado');
                    $obj->save();
					foreach($this->input->post('telefonos') as $arr)
						{
							$obj1 = new Cliente_Campo();
							$obj1->where('id', $arr['id'])->get();
							$obj1->campo_id=$arr['campo_id'];
							$obj1->valor=$arr['valor'];
							$obj1->cliente_id=$con_id;
							$obj1->save();	
						}
					foreach($this->input->post('mails') as $arr1)
						{
							$obj2 = new Cliente_Campo();
							$obj2->where('id', $arr1['id'])->get();
							$obj2->campo_id=$arr1['campo_id'];
							$obj2->valor=$arr1['valor'];
							$obj2->cliente_id=$con_id;
							$obj2->save();	
						}
					$obj3 = new Cliente_Empresa();
					$obj3->where('id', $id)->get();
					$obj3->empleado_id=$emp_id;
				    $obj3->campana_id=$cam_id;
					$obj3->cliente_id=$con_id;
					$obj3->save();			 			
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $contacto = new Cliente_Empresa();
                    $contacto->where('id', $this->input->post('id'))->get();
                    $contacto->estado='IN';
                    $contacto->save();
                }
                break;
				
            default:
                	
					$obj = new Cliente_Empresa();
					$query=$obj->custom_query();
					$results=$query->result_array();
					echo json_encode($results);	
        }
    }
	
	
  	
}
