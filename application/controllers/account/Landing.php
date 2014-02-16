<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Landing Controller
 */
class Landing extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        //$this->load->model(array('music_model', 'users_following_model'));
        
    }
    
    /**
     * Main landing page for user displaying things that are related to the user
     */
    function index()
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        // Redirect unauthenticated users to signin page
        if ( ! $this->authentication->is_signed_in())
        {
            redirect('account/sign_in/');
        }
        
        // Retrieve sign in user
	$data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
        
        // Get users music and their statistics
        
        $data['content'] = $this->load->view('account/landing', $data, TRUE);
        $this->load->view('template', $data);
    }
}
/* End of file Landing.php */
/* Location: ./application/controllers/account/Landing.php */