<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Listing Controller
 */
class Listing extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        $this->load->model(array('Music_model', 'account/Account_details_model'));
        
    }
    
    /**
     * Listing of the most popular and recently added music
     */
    public function index($page = 0)
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        // Redirect unauthenticated users to signin page
        if ( ! $this->authentication->is_signed_in())
        {
            redirect('account/sign_in/?continue='.urlencode(base_url('music/listing')));
        }
	
	//prepare pagination
	
	
	//get the 10 songs for this page
        
        // Retrieve sign in user
	$data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
        
        //load the view
        $data['content'] = $this->load->view('music/listing', $data, TRUE);
        $this->load->view('template', $data);
    }
    
    public function page($page = 0)
    {
	$this->index($page);
    }
}
/* End of file Listing.php */
/* Location: ./application/controllers/music/Listing.php */