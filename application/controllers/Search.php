<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Music Search Controller
 */
class Search extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        $this->load->model(array('Music_model', 'account/Account_details_model'));
	$this->load->language('music');
	$this->load->helper('account/account');
        
    }
    
    /**
     * Listing of the most popular and recently added music
     */
    public function index()
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        // Redirect unauthenticated users to signin page
        if ($this->authentication->is_signed_in())
	{
	    // Retrieve sign in user
	    $data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
	    //get their details
	    $this->load->model('Account_details_model');
	    $data['account_details'] = $this->Account_details_model->get_by_account_id($this->session->userdata('account_id'));
	}
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning">', '</div>');
        
        $this->form_validation->set_rules('search', 'lang:song_name', 'trim|xss_clean');
        
        if($this->form_validation->run())
        {
            //search for the songs
            $data['songs'] = $this->Music_model->find($this->input->post('search', TRUE));
            
            $data['stats']['music_total'] = count($data['songs']);
            
            //load the view
            $data['content'] = $this->load->view('music/listing', $data, TRUE);
            $this->load->view('template', $data);
        }
        else
        {
            redirect('');
        }
        
    }
}