<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_tmp extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
    }

    function index(){
        $page['main_content'] = 'usuario_view';
        $this->load->view('includes/template_panel', $page);
    }

    function ajax1(){
        switch($this->input->post('accion')){
            case 'add': 
                $obj = new Usuarios();
                $obj->nombre=$this->input->post('usuario');
                $obj->descripcion=$this->input->post('clave');
                $obj->estado=$this->input->post('estado');
                $obj->save();
                break;
            case 'edit':
                if($this->input->post('id')){
                    $obj = new Usuarios();
                    $obj->where('id', $this->input->post('id'))->get();
                    $obj->nombre=$this->input->post('usuario');
                   $obj->descripcion=$this->input->post('clave');
                   $obj->estado=$this->input->post('estado');
                    $obj->save();
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $obj = new Usuarios();
                    $obj->where('id', $this->input->post('id'))->get();
                    $obj->estado='IN';
                    $obj->save();
                }
                break;
            default:
                $obj = new Usuarios();
                $obj->where('estado', 'AC')->get();
                $results = array();
                foreach ($obj as $r) {
                    $res[] = $r->to_json();
                }
                echo '['.join(',', $res).']';	
        }
    }

   function ajax(){
            switch($this->input->post('accion')){
                case 'res': 
                    $usuario = new Usuarios();
                    $usuario->where('usuario', $this->input->post('usuario'))->get();
                    $usuario->clave=md5($this->input->post('usuario'));
                    $usuario->save();
                    break;
                case 'edirol': 
                    $rolusu = new Roles_usuarios();
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
            $usurol = new Roles_usuarios();
            $query = $usurol->get_usuarios_roles();
            $res = $query->result_array();
            echo json_encode($res);
   }
}
