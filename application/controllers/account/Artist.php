<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Artist Controller
 */
class Artist extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        //$this->load->model(array('music_model', 'account/Account_details_model'));
        
    }
    
    /**
     * User profile page
     * @var string User's nickname
     * @todo make it a public website
     */
    public function index($nickname)
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        if ( ! $this->authentication->is_signed_in())
        {
            redirect('account/sign_in/?continue='.urlencode(base_url('account/artist/'.$nickname)));
        }
        // Retrieve sign in user
        $data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
        
        //find the artist requested
        $data['artist'] = $this->Account_model->get_by_username($nickname);
        if($data['artist'] === NULL)
        {
            //if the artist was not found, show 404 page
            show_404();
        }
        
        //get the artist's songs and favorites
        
        //load the view
        $data['content'] = $this->load->view('account/artist', $data, TRUE);
        $this->load->view('template', $data);
    }
}
/* End of file Artist.php */
/* Location: ./application/controllers/account/Artist.php */