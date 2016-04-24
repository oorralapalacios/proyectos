<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Encripta extends MX_Controller{
	function __construct(){
            parent::__construct();
            modules::run('login/autentificado');
            Datamapper::add_model_path( array( APPPATH.'modules/seg/' ) );
			
	}
	
	function index(){
		   $cadena_encriptada = $this->encrypt('upse9632198999','guru20234109088$');
            echo $cadena_encriptada;
			//$cadena_dencriptada = $this->decrypt('pdfo165oY5mm==','guru2012323');
			//echo $cadena_dencriptada;
			
            
	}
  function encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
    }
   return base64_encode($result);
  }
   
  function decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
 }
}