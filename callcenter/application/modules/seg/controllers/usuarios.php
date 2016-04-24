<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MX_Controller{
	function __construct(){
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
	}

	function index(){
            //$page['main_content'] = 'usuario_view';
            //$this->load->view('includes/template_panel', $page);
            $this->load->view('includes/header_panel');
			$this->load->view('seg/usuario_view');
            
	}
        
        function ajax(){
            switch($this->input->post('accion')){
                case 'res': 
                    $usuario = new Usuario();
                    $usuario->where('usuario', $this->input->post('usuario'))->get();
                    $usuario->clave=md5($this->input->post('usuario'));
                    $usuario->save();
                    break;
                case 'edirol': 
                    $rolusu = new Rol_usuario();
                    $rolusu->where('usuario_id', $this->input->post('usuario_id'))->get();
                    $rolusu->rol_id=$this->input->post('rol_id');
                    $rolusu->save();
                    break;
                default:
                    echo $this->get_usuarios();
            }
        }
        
        //obtiene usuarios con roles asignados
        function get_usuarios(){
            $usurol = new Rol_usuario();
            $query = $usurol->get_usuarios_roles();
            $res = $query->result_array();
            echo json_encode($res);
        }
        
		
}
