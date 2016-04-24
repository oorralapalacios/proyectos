<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends MX_Controller{
	function __construct(){
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
	}

	function index(){
           // $page['main_content'] = 'rol_view';
           // $this->load->view('includes/template_panel', $page);
           $this->load->view('includes/header_panel');
           $this->load->view('seg/rol_view');
            
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
                        $opcrol2 = new Opcion_rol();
                        $opcrol2->opcion_id = $arr;
                        $opcrol2->rol_id = $rol_id;
                        $opcrol2->save();	
                    }
                    break;
					
			      case 'deldeprol':
                    if(($this->input->post('rol_id')) and ($this->input->post('modulo_id'))){
                        //
                        $rol_id = $this->input->post('rol_id');
                        $modulo_id = $this->input->post('modulo_id');
                        //delete permisos actuales
                        $sql = "DELETE dep FROM roles_departamentos dep WHERE dep.rol_id = ?";
                        $binds = array($rol_id, $modulo_id);
                        $query = $this->db->query($sql, $binds);
                    }
                    break;
                case 'guadeprol':
                    $rol_id = $this->input->post('rol_id');
                    $array = explode(',', $this->input->post('departamento_id'));
                    //asigna permisos
                    foreach($array as $arr){
                        $deprol2 = new Rol_departamento();
                        $deprol2->departamento_id = $arr;
                        $deprol2->rol_id = $rol_id;
                        $deprol2->save();	
                    }
                    break;		
                default:
                    echo $this->get_opciones($rol_id,$modulo_id);
            }
        }
        
        //obtiene roles
        function get_roles(){
            //$where = "id <> 1 AND estado='AC'";
			$where = " id > 0 and estado='AC'";
            $rol = new Rol();
            $rol->where($where)->get();
            $res = array();
            foreach ($rol as $r) {
                $res[] = $r->to_json();
            }
            echo '['.join(',', $res).']';
        }
        //obtiene opciones asignadas y no asignadas a roles
        function get_opciones($rol_id,$modulo_id){
            $opc = new Opcion_rol();
            $query = $opc->get_opciones_asignadas($rol_id,$modulo_id);
            $res = $query->result_array();
            echo json_encode($res);
        }
		
		function get_departamentos($rol_id,$modulo_id){
            $opc = new Rol_departamento();
            $query = $opc->get_departamentos_asignados($rol_id,$modulo_id);
            $res = $query->result_array();
            echo json_encode($res);
        }
        
}