<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
	 
	
	public function index() {
    // loading captcha helper
    $this->load->helper('html');
    $this->load->helper('url');
    //$this->load->helper('captcha');
    //validating form fields
    $this->form_validation->set_rules('username', 'Email Address', 'required');
    $this->form_validation->set_rules('user_password', 'Password', 'required');
    //$this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|callback_check_captcha');
    //$userCaptcha = $this->input->post('userCaptcha');
    if ($this->form_validation->run() == false){
      // numeric random number for captcha
      //$random_number = substr(number_format(time() * rand(),0,'',''),0,6);
      // setting up captcha config
      /*$vals = array(
             'word' => $random_number,
             'img_path' => './captcha/',
             'img_url' => base_url().'captcha/',
             'img_width' => 302,
             'img_height' => 30,
             'expiration' => 7200
            );*/
      //$data['captcha'] = create_captcha($vals);
      //$this->session->set_userdata('captchaWord',$data['captcha']['word']);
      //$this->load->view('login_form', $data);
	  $this->load->view('login_form');
    }
    else {
      // do your stuff here.
      //echo 'I m here clered all validations';
	}
  }
  public function check_captcha($str){
    $word = $this->session->userdata('captchaWord');
    if(strcmp(strtoupper($str),strtoupper($word)) == 0){
      return true;
    }
    else{
      $this->form_validation->set_message('check_captcha', 'Please enter correct words!');
      return false;
    }
  }
	
	
    function rol(){
    	$this->load->model('login_model');
		$query=$this->login_model->get_rol($this->get_rol_id());
		foreach ($query as $row){
            $rol = $row->nombre;
        }
		return $rol;
    }

    function usuario(){
    	return $this->session->userdata('usuario');
    }
	

    function validar_sesion(){		
        $this->load->model('login_model');
        $query = $this->login_model->validar();
        if($query){
            $data = array(
                'usuario' => $this->input->post('usuario'),
                'autentificado' => true
            );
		    $this->session->set_userdata($data);
            redirect('panel');
        }else{ 
            $this->index();
        }
    }	
	
	
    function validar_sesion2(){
    	
    if ($this->check_captcha($this->input->post('userCaptcha'))){			
        $this->load->model('login_model');
        $query = $this->login_model->validar();
        if($query){
            $data = array(
                'usuario' => $this->input->post('usuario'),
                'autentificado' => true
            );
		    $this->session->set_userdata($data);
            redirect('panel');
        }else{ 
            //$this->index();
             redirect('login');
        }
      }else{
      	 //$this->index();
      	 redirect('login');
      }
    }	
    
	function get_user_id(){
        $this->load->model('login_model');
        $query = $this->login_model->get_usuarios($this->session->userdata('usuario'));
        foreach ($query as $row){
            $id = $row->id;
        }
        return $id;
    }
	
    function get_rol_id(){
        $this->load->model('login_model');
        $query = $this->login_model->get_usuarios($this->session->userdata('usuario'));
        foreach ($query as $row){
            $id = $row->id;
        }
        $query2 = $this->login_model->get_roles_usuarios($id);
        foreach ($query2 as $row2){
            $id_rol = $row2->rol_id;
        }
        return $id_rol;
    }

    function autentificado(){
        $autentificado = $this->session->userdata('autentificado');
        if(!isset($autentificado) || $autentificado != true){
            echo MINF001;	
            die();		
        }	
    }
    
    function logout(){
    	 $this->session->sess_destroy();
		 $this->index();
		
		
    }

    function menu_rol1(){
        $autentificado = $this->session->userdata('autentificado');
        if(isset($autentificado) || $autentificado == true){
            $this->load->model('login_model');
            $data['modulos'] = $this->login_model->get_menu_rol($this->get_rol_id());
			 if( !$data['modulos'] ){
                return false;
            }else{
                $this->load->view('panel_menu', $data);
               				
            }
        }else{
            return false;
        }
    }
	
	 function menu_rol(){
        $autentificado = $this->session->userdata('autentificado');
        if(isset($autentificado) || $autentificado == true){
            $this->load->model('login_model');
            $query = $this->login_model->get_menu_rol($this->get_rol_id());
			$results=$query->result_array();
			 if( !$results ){
                return false;
            }else{
                echo json_encode($results);
               				
            }
        }else{
            return false;
        }
    }
	
	 
	 function tool_rol($padre_id){
        $autentificado = $this->session->userdata('autentificado');
        if(isset($autentificado) || $autentificado == true){
            $this->load->model('login_model');
            $query = $this->login_model->get_tool_rol($this->get_rol_id(),$padre_id);
			$results=$query->result_array();
			 if( !$results ){
                return false;
            }else{
                echo json_encode($results);
               				
            }
        }else{
            return false;
        }
    }
	 
	function get_tool_id()
	{
		return $this->session->userdata('tid');
		
	}
	 
	function tool_rol_ajax(){
        $autentificado = $this->session->userdata('autentificado');
        if(isset($autentificado) || $autentificado == true){
            $this->load->model('login_model');
            $results = $this->login_model->get_tool_rol_ajax($this->get_rol_id(),$this->get_tool_id());
			if( !$results ){
                return false;
            }else{
               return $results;
               				
            }
        }else{
            return false;
        }
    }
	
		 	
}