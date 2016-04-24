<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opciones extends MX_Controller{
	function __construct(){
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
	}

	function index(){
            //$page['main_content'] = 'opcion_view';
            //$this->load->view('includes/template_panel', $page);
			$this->load->view('includes/header_panel');
            $this->load->view('seg/opcion_view');
            
	}
        
        function ajax($id_modulo){
            switch($this->input->post('accion')){
                case 'add': 
                    $rol = new Opcion();
                    $rol->nombre=$this->input->post('nombre');
                    $rol->descripcion=$this->input->post('descripcion');
                    $rol->estado=$this->input->post('estado');
                    $rol->save();
                    break;
                case 'edit':
                    if($this->input->post('id')){
                        $rol = new Opcion();
                        $rol->where('id', $this->input->post('id'))->get();
                        $rol->nombre=$this->input->post('nombre');
                        $rol->descripcion=$this->input->post('descripcion');
                        $rol->estado=$this->input->post('estado');
                        $rol->save();
                    }
                    break;
                case 'del':
                    if($this->input->post('id')){
                        $rol = new Opcion();
                        $rol->where('id', $this->input->post('id'))->get();
                        $rol->estado='IN';
                        $rol->save();
                    }
                    break;
                default:
                    echo true;//$this->get_modulos_opciones($id_modulo);
            }
        }
        
        function item($id){
		$opc=new Opcion();
		$opc->where('id', $id)->get();
        echo $opc->to_json();
       
	  }
        
        
}
