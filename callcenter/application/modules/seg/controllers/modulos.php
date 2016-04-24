<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos extends MX_Controller{
	function __construct(){
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
	}

	function index(){
            $page['main_content'] = 'modulo_view';
            $this->load->view('includes/template_panel', $page);
            
	}
        
        function ajax($id_modulo){
            switch($this->input->post('accion')){
                case 'add': 
                    $rol = new Rol();
                    $rol->nombre=$this->input->post('nombre');
                    $rol->descripcion=$this->input->post('descripcion');
                    $rol->estado=$this->input->post('estado');
                    $rol->save();
                    break;
                case 'edit':
                    if($this->input->post('id')){
                        $rol = new Rol();
                        $rol->where('id', $this->input->post('id'))->get();
                        $rol->nombre=$this->input->post('nombre');
                        $rol->descripcion=$this->input->post('descripcion');
                        $rol->estado=$this->input->post('estado');
                        $rol->save();
                    }
                    break;
                case 'del':
                    if($this->input->post('id')){
                        $rol = new Rol();
                        $rol->where('id', $this->input->post('id'))->get();
                        $rol->estado='IN';
                        $rol->save();
                    }
                    break;
                default:
                    echo $this->get_modulos_opciones($id_modulo);
            }
        }
        
        function get_modulos_opciones($id_modulo){
        	
            $m = new Modulo();
            $m->where('id',$id_modulo)->get();
			$res = array();
			foreach ($m->opcion->all as $r) {
                $res[] = $r->to_json();
            }
            echo '['.join(',', $res).']';
			          
            /*
            $m = new Modulos();
            $m->get();
            $id = array();
            foreach ($m as $o){
                $id[] = $o->id;
            }
            foreach ($id as $c){
                $m->where('id',$c)->get();
                $m->opcion->get();
                foreach ($m->opcion->all as $u){
                    echo $c.'-'.$u->url . '<br />';
                }
            }
            */
        }
        //obtiene modulos
        function get_modulos(){
            $mod = new Modulo();
            $mod->where('estado', 'AC')->get();
            $res = array();
            foreach ($mod as $r) {
                $res[] = $r->to_json();
            }
            echo '['.join(',', $res).']';
        }
}
