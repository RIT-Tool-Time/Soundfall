<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Artist page
 */
class Artist extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        $this->load->model(array('Music_model', 'account/Account_details_model'));
	$this->load->language('music');
        
    }
    
    /**
     * Listing of the most popular and recently added music
     */
    public function index($artist, $page = 0)
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        if ($this->authentication->is_signed_in())
	{
	    // Retrieve sign in user
	    $data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
	}
	
	if($artist === NULL)
	{
	    show_404();
	}
	
	//get artist details
	$this->load->model('Account_details_model');
	$data['artist'] = $this->Account_model->get_by_id($artist);
	if($data['artist'] === NULL)
	{
	    show_404();
	}
	$data['artist_details'] = $this->Account_details_model->get_by_account_id($artist);
	
	//get site statistics if page is zero
	if($page === 0)
	{
	    //get the language
	    $this->load->language('about_lang');
	    
	    //get the stats
	    $data['stats']['music_total'] = $this->Music_model->count_by_artist($artist);
	}
	
	
	//prepare pagination
	
	
	//get the 10 songs for this page
        
        
        //load the view
        $data['content'] = $this->load->view('music/artist', $data, TRUE);
        $this->load->view('template', $data);
    }
}
/* End of file Artist.php */
/* Location: ./application/controllers/Artist.php */