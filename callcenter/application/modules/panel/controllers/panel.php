<?php

class Panel extends MX_Controller
{
	function __construct()
	{
          parent::__construct();
          modules::run('login/autentificado');
	}

	function index()
	{
		  $this->load->view('includes/template_panel');
	}
}
