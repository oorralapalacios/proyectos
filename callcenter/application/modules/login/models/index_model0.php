<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Index_model extends CI_Model
{
	
	public function __construct()
	{
		
		parent::__construct();
		
	}
	
	public function get_user($id_user)
	{
		
		$query = $this->db->get_where('users',array('id' => $id_user));
		
		return $query->row();
		
	}
	
	public function get_users()
	{
		
		$query = $this->db->get('users');
		
		return $query->result();
		
	}
	
}
