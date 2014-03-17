<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
		$this->load->library(array('account/authentication', 'account/authorization'));
		$this->load->model('account/Account_model');
	}

	function index()
	{
		maintain_ssl();
		
		if ($this->authentication->is_signed_in())
		{
			//redirect loged in users to their langing page
			redirect('account/landing');
		}
		
		$data['page'] = "home";
		$data['content'] = $this->load->view('home', isset($data) ? $data : NULL, TRUE);
		$this->load->view('preview_template', $data);
	}
	
	function about()
	{
		maintain_ssl();
		
		if ($this->authentication->is_signed_in())
		{
			//figure out where we want to redirect the user to
			$data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
		}
		
		$this->load->language('about');
		
		$data['page'] = "about";
		$data['content'] = $this->load->view('about', isset($data) ? $data : NULL, TRUE);
		$this->load->view('preview_template', $data);
	}

}


/* End of file Home.php */
/* Location: ./system/application/controllers/Home.php */