<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tab extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        //$page['main_content'] = 'calendar';
        //$this->load->view('includes/template_panel', $page);
		$this->load->view('includes/header_panel');
		//$this->load->view('mar/tab');
		$this->load->view('mar/prueba');
		
    }
	
	
}
