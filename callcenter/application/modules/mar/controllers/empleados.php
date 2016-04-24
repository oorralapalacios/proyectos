<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
		Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
    }

    function index(){
        $page['main_content'] = 'empleado_view'; 
        $this->load->view('includes/template_panel', $page);
    }

    function ajax(){
        switch($this->input->post('accion')){
            case 'add': 
                  $usuario = new Usuario();
				
				  $identificacion = $this->input->post('identificacion');
                  if ($identificacion!=$usuario->where('usuario', $identificacion)->get())
                    {
                    $usuario->usuario=$this->input->post('identificacion');
                    $usuario->clave=md5($this->input->post('identificacion'));
                    $usuario->estado=$this->input->post('estado');
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
						$empleado->save();
                    }else{
                        return false;
                    }
                    	$where = "rol_id = ".$this->input->post('roles_id')." AND usuario_id = ".$usuario->id."";
                    	$rol_usuario = new Rol_usuario();
						
						if ($rol_usuario->where($where)->get())
						{
							$rol_usuario->rol_id=$this->input->post('roles_id');
							$rol_usuario->usuario_id=$usuario->id;    
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
                    $empleado->save();
					
					$usuario = new Usuario();
					$usuario->where('id', $this->input->post('usuario_id'))->get();
                    $usuario->usuario=$this->input->post('identificacion');
                    $usuario->clave=md5($this->input->post('identificacion'));
                    $usuario->estado=$this->input->post('estado');
                    $usuario->save();
                    
                    $rol_usuario = new Rol_usuario();
					$rol_usuario->where('id', $this->input->post('roles_usuarios_id'))->get();
                    $rol_usuario->rol_id=$this->input->post('roles_id');
					$rol_usuario->usuario_id=$this->input->post('usuario_id');
                    $rol_usuario->save();
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $empleado = new Empleado();
                    $empleado->where('id', $this->input->post('id'))->get();
                    $empleado->estado='IN';
                    $empleado->save();
					
					$usuario = new Usuario();
					$usuario->where('id', $this->input->post('usuario_id'))->get();
                    $usuario->estado='IN';
                    $usuario->save();
                    
                    $rol_usuario = new Rol_usuario();
					$rol_usuario->where('usuario_id', $this->input->post('usuario_id'))->get();
                    $rol_usuario->estado='IN';
					$rol_usuario->save();
					
                }
                break;
            default:
               		$obj = new Empleado();
		            $query=$obj->custom_query();
		            $results=$query->result_array();
		            echo json_encode($results);	
										 
				/*$empleado = new Empleados();
				
			   	$empleado->where('estado', 'AC')->get();
                $results = array();
                foreach ($empleado as $r) {
                    $res[] = $r->to_json();
                }
                echo '['.join(',', $res).']';	*/
        }
    }

    

     function getEmpleados(){
		/*$empleado = new Empleados();
		$empleado->where('estado', 'AC')->get();
		$results = array();
		foreach ($empleado as $r) {
			$res[] = $r->to_json();
		}
		echo '['.join(',', $res).']';	*/
		
		$obj = new Empleado();
		$query=$obj->custom_query();
		$results=$query->result_array();
		echo json_encode($results);	
	 }

}
