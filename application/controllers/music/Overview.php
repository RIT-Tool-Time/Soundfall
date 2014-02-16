<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Overview Controller
 */
class Overview extends CI_Controller
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
            redirect('account/sign_in/?continue='.urlencode(base_url('music/overview/'.$id)));
        }
        
        // Retrieve sign in user
	$data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
        
        //load the view
        $data['content'] = $this->load->view('music/overview', $data, TRUE);
        $this->load->view('template', $data);
    }
}
/* End of file Overview.php */
/* Location: ./application/controllers/music/Overview.php */