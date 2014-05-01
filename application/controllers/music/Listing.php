<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Music Listing Controller
 * Lists multitudes of songs.
 */
class Listing extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        $this->load->model(array('Music_model', 'Saved_music_model', 'account/Account_details_model'));
	$this->load->language('music');
	$this->load->helper('account/account');
    }
    
    /**
     * Listing of the most popular and recently added music
     */
    public function index($page = 0)
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
	
	//get site statistics if page is zero
	if($page === 0)
	{
	    //get the language
	    $this->load->language('about_lang');
	    
	    //get the stats
	    $data['stats']['music_total'] = $this->Music_model->count_all();
	}
	
	
	//prepare pagination
	
	
	//get the 10 songs for this page
	if($page > 0)
	{
	    $offset = ($page-1) * 10;
	}
	else
	{
	    $offset = 0;
	}
        $data['songs'] = $this->Music_model->get_batch(10, $offset);
        
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