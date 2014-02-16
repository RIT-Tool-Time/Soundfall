<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Overview Controller
 */
class Statistics extends CI_Controller
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
     * Listing of the most popular and recently added music
     * @param int $id Id of the song
     */
    public function index($id)
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        // Redirect unauthenticated users to signin page
        if ( ! $this->authentication->is_signed_in())
        {
            redirect('account/sign_in/?continue='.urlencode(base_url('music/statistics/'.$id)));
        }
        
        // Retrieve sign in user
	$data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
        
        //check that it is user or owner
        
        
        //load the song statistics and details
        
        
        //load the view
        $data['content'] = $this->load->view('music/statistics', $data, TRUE);
        $this->load->view('template', $data);
    }
}
/* End of file Statistics.php */
/* Location: ./application/controllers/music/Statistics.php */