<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipos_clientes extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/mar/' ) );
    }

    function index(){
        $page['main_content'] = 'tipo_cliente_view';
        $this->load->view('includes/template_panel', $page);
    }

    function ajax(){
        switch($this->input->post('accion')){
            case 'add': 
                $tipo_cliente = new Tipo_cliente();
                $tipo_cliente->descripcion=$this->input->post('descripcion');
                $tipo_cliente->estado=$this->input->post('estado');
                $tipo_cliente->save();
                break;
            case 'edit':
                if($this->input->post('id')){
                    $tipo_cliente = new Tipo_cliente();
                    $tipo_cliente->where('id', $this->input->post('id'))->get();
                    $tipo_cliente->descripcion=$this->input->post('descripcion');
                    $tipo_cliente->estado=$this->input->post('estado');
                    $tipo_cliente->save();
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $tipo_cliente = new Tipo_cliente();
                    $tipo_cliente->where('id', $this->input->post('id'))->get();
                    $tipo_cliente->estado='IN';
                    $tipo_cliente->save();
                }
                break;
            default:
                $tipo_cliente = new Tipo_cliente();
                $tipo_cliente->where('estado', 'AC')->get();
                $results = array();
                foreach ($tipo_cliente as $r) {
                    $res[] = $r->to_json();
                }
                echo '['.join(',', $res).']';	
        }
    }
}
