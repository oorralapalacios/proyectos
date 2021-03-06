<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/emp/' ) );
		Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
    }

    function index(){
        
        $this->load->view('includes/header_panel');
		$this->load->view('emp/empleado_view');
    }

    function ajax(){
    	$username=modules::run('login/usuario');
        switch($this->input->post('accion')){
            case 'add': 
                  $usuario = new Usuario();
				
				  $identificacion = $this->input->post('identificacion');
                  if ($identificacion!=$usuario->where('usuario', $identificacion)->get())
                    {
                    $usuario->usuario=$this->input->post('identificacion');
                    $usuario->clave=md5($this->input->post('identificacion'));
                    $usuario->estado=$this->input->post('estado');
					$usuario->usuario_ing=$username;
					$usuario->save();
                    }else{
                        return false;
                    }
					
					$empleado = new Empleado();
					if ($identificacion!=$empleado->where('identificacion', $identificacion)->get())
					{
						$empleado->usuario_id=$usuario->id;
						$empleado->identificacion=$this->input->post('identificacion');
						$empleado->nombres=$this->input->post('nombres');
						$empleado->apellidos=$this->input->post('apellidos');
						$empleado->genero=$this->input->post('genero');
						$empleado->direccion=$this->input->post('direccion');
						$empleado->telefono=$this->input->post('telefono');
						$empleado->celular=$this->input->post('celular');
						$empleado->email=$this->input->post('email');
						$empleado->correo_institucional=$this->input->post('correo_institucional');
						$empleado->estado=$this->input->post('estado');
						$empleado->usuario_ing=$username;
						$empleado->save();
						
						$emp_dep = new Empleado_departamento();
						$emp_dep->departamento_id=$this->input->post('departamento_id');
						$emp_dep->empleado_id=$empleado->id;
						$emp_dep->usuario_ing=$username;
						$emp_dep->save();
						
                    }else{
                        return false;
                    }
                    	$where = "rol_id = ".$this->input->post('rol_id')." AND usuario_id = ".$usuario->id."";
                    	$rol_usuario = new Rol_usuario();
						
						if ($rol_usuario->where($where)->get())
						{
							$rol_usuario->rol_id=$this->input->post('rol_id');
							$rol_usuario->usuario_id=$usuario->id;  
							$rol_usuario->usuario_ing=$username;
							$rol_usuario->save();
						}else{
							return false;
						}
                break;
            case 'edit':
                if($this->input->post('id')){
                    $empleado = new Empleado();
                    $empleado->where('id', $this->input->post('id'))->get();
					$empleado->usuario_id=$this->input->post('usuario_id');
					$empleado->identificacion=$this->input->post('identificacion');
                    $empleado->nombres=$this->input->post('nombres');
					$empleado->apellidos=$this->input->post('apellidos');
					$empleado->genero=$this->input->post('genero');
					$empleado->direccion=$this->input->post('direccion');
					$empleado->telefono=$this->input->post('telefono');
					$empleado->celular=$this->input->post('celular');
					$empleado->email=$this->input->post('email');
					$empleado->correo_institucional=$this->input->post('correo_institucional');
                    $empleado->estado=$this->input->post('estado');
					$empleado->usuario_mod=$username;
                    $empleado->save();
					
				    $emp_dep = new Empleado_departamento();
					$emp_dep->where('empleado_id', $empleado->id)->get();
					$emp_dep->departamento_id=$this->input->post('departamento_id');
					$emp_dep->empleado_id=$empleado->id;
					$emp_dep->usuario_mod=$username;
					$emp_dep->save();
					
					$usuario = new Usuario();
					$usuario->where('id', $this->input->post('usuario_id'))->get();
                    $usuario->usuario=$this->input->post('identificacion');
                    //$usuario->clave=md5($this->input->post('identificacion'));
                    $usuario->estado=$this->input->post('estado');
					$usuario->usuario_mod=$username;
                    $usuario->save();
                    
                    $rol_usuario = new Rol_usuario();
					$rol_usuario->where('id', $this->input->post('rol_usuario_id'))->get();
                    $rol_usuario->rol_id=$this->input->post('rol_id');
					$rol_usuario->usuario_id=$this->input->post('usuario_id');
					$rol_usuario->usuario_mod=$username;
                    $rol_usuario->save();
					
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $empleado = new Empleado();
                    $empleado->where('id', $this->input->post('id'))->get();
                    $empleado->estado='IN';
					$empleado->usuario_mod=$username;
                    $empleado->save();
					
					$usuario = new Usuario();
					$usuario->where('id', $this->input->post('usuario_id'))->get();
                    $usuario->estado='IN';
					$usuario->usuario_mod=$username;
					$usuario->save();
                    
                    $rol_usuario = new Rol_usuario();
					$rol_usuario->where('usuario_id', $this->input->post('usuario_id'))->get();
                    $rol_usuario->estado='IN';
					$rol_usuario->usuario_mod=$username;
					$rol_usuario->save();
					
                }
                break;
            default:
               		$obj = new Empleado();
		            $query=$obj->custom_query();
		            $results=$query->result_array();
		            echo json_encode($results);	
										 
				
        }
    }

    

     function getEmpleados(){
				
		$obj = new Empleado();
		$query=$obj->custom_query();
		$results=$query->result_array();
		echo json_encode($results);	
	 }
	 
	 function getVendedores(){
				
		$obj = new Empleado();
		$query=$obj->custom_sellers();
		$results=$query->result_array();
		echo json_encode($results);	
	 }
	 
	  function getTeleoperadores(){
				
		$obj = new Empleado();
		$query=$obj->custom_teleoperators();
		$results=$query->result_array();
		echo json_encode($results);	
	 }
	 
	 function getJerarquia(){
	 	$rolid=modules::run('login/get_rol_id');
		$userid=modules::run('login/get_user_id');
		$dep=new Departamento();
		if ($dep->deprol($rolid)) {
			//devuelve empleado con privilegios jerarquicos
			$obj = new Empleado();
			$query=$obj->custom_query_jerarquia($rolid);
			$results=$query->result_array();
			echo json_encode($results);		
		}else{//devuelve empleado sin privilegios jerarquicos
			$obj = new Empleado();
			$query=$obj->custom_query_sinjerarquia($userid);
			$results=$query->result_array();
			echo json_encode($results);	
		}
	 	
	 }
	 function getJerarquiaTeleoperadores(){
	 	$rolid=modules::run('login/get_rol_id');
		$userid=modules::run('login/get_user_id');
		$dep=new Departamento();
		if ($dep->deprol($rolid)) {
			//devuelve empleado con privilegios jerarquicos teleoperadores
			$obj = new Empleado();
			$query=$obj->custom_teleoperators();
			$results=$query->result_array();
			echo json_encode($results);		
		}else{//devuelve empleado sin privilegios jerarquicos
			$obj = new Empleado();
			$query=$obj->custom_query_sinjerarquia($userid);
			$results=$query->result_array();
			echo json_encode($results);	
		}
	 	
	 }
	 
	 function getJerarquiaVendedores(){
	 	$rolid=modules::run('login/get_rol_id');
		$userid=modules::run('login/get_user_id');
		$dep=new Departamento();
		if ($dep->deprol($rolid)) {
			//devuelve empleado con privilegios jerarquicos vendedores
			$obj = new Empleado();
			$query=$obj->custom_sellers();
			$results=$query->result_array();
			echo json_encode($results);		
		}else{//devuelve empleado sin privilegios jerarquicos
			$obj = new Empleado();
			$query=$obj->custom_query_sinjerarquia($userid);
			$results=$query->result_array();
			echo json_encode($results);	
		}
	 	
	 }

}
