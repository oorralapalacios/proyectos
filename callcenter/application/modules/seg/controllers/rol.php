<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol extends MX_Controller{
    function __construct(){
        parent::__construct();
        modules::run('login/autentificado');
        Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
    }

    function index(){
        $page['main_content'] = 'rol_view';
        $this->load->view('includes/template_panel', $page);
    }
	
	function get_roles(){
		$rol = new Roles();
        $rol->where('estado', 'AC')->get();
        $results = array();
        foreach ($rol as $r) {
        $res[] = $r->to_json();
        }
        echo '['.join(',', $res).']';	
	}
	
	  //obtiene opciones asignadas y no asignadas a roles
    function get_opciones($rol_id,$modulo_id){
            $opc = new Opciones_roles();
            $query = $opc->get_opciones_asignadas($rol_id,$modulo_id);
            $res = $query->result_array();
            echo json_encode($res);
    }
	
	function ajax($rol_id,$modulo_id){
            switch($this->input->post('accion')){
                case 'delopcrol':
                    if(($this->input->post('rol_id')) and ($this->input->post('modulo_id'))){
                        //
                        $rol_id = $this->input->post('rol_id');
                        $modulo_id = $this->input->post('modulo_id');
                        //delete permisos actuales
                        $sql = "DELETE opr FROM opciones_roles opr WHERE opr.rol_id = ? AND opr.opcion_id IN (SELECT id FROM opciones WHERE modulo_id = ?)";
                        $binds = array($rol_id, $modulo_id);
                        $query = $this->db->query($sql, $binds);
                    }
                    break;
                case 'guaopcrol':
                    $rol_id = $this->input->post('rol_id');
                    $array = explode(',', $this->input->post('opcion_id'));
                    //asigna permisos
                    foreach($array as $arr){
                        $opcrol2 = new Opciones_roles();
                        $opcrol2->opcion_id = $arr;
                        $opcrol2->rol_id = $rol_id;
                        $opcrol2->save();	
                    }
                    break;
                default:
                    echo $this->get_opciones($rol_id,$modulo_id);
            }
        }

    function ajaxRol(){
        switch($this->input->post('accion')){
            case 'add': 
                $rol = new Roles();
                $rol->nombre=$this->input->post('nombre');
                $rol->descripcion=$this->input->post('descripcion');
                $rol->estado=$this->input->post('estado');
                $rol->save();
                break;
            case 'edit':
                if($this->input->post('id')){
                    $rol = new Roles();
                    $rol->where('id', $this->input->post('id'))->get();
                    $rol->nombre=$this->input->post('nombre');
                    $rol->descripcion=$this->input->post('descripcion');
                    $rol->estado=$this->input->post('estado');
                    $rol->save();
                }
                break;
            case 'del':
                if($this->input->post('id')){
                    $rol = new Roles();
                    $rol->where('id', $this->input->post('id'))->get();
                    $rol->estado='IN';
                    $rol->save();
                }
                break;
            default:
                $rol = new Roles();
                $rol->where('estado', 'AC')->get();
                $results = array();
                foreach ($rol as $r) {
                    $res[] = $r->to_json();
                }
                echo '['.join(',', $res).']';	
        }
    }
}
