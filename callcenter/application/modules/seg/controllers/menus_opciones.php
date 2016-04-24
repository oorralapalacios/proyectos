<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus_opciones extends MX_Controller{
	function __construct(){
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
	}

	function index(){
            $page['main_content'] = 'menu_view';
            $this->load->view('includes/template_panel', $page);
            
	}
        
        function menu($opc_id=null,$view=null){
            $obj = new Menu_opcion();
			$obj->where('opcion_id', $opc_id);
			$obj->where('vista', $view);
            $obj->where('estado', 'AC');
			$obj->get();
            $results = array();
		    foreach ($obj as $o) {
	        $results[] = $o->to_json();
	        }
	        echo '['.join(',', $results).']';
        }
}