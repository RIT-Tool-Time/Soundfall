<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Song controller to display info about individual song and offer interaction with it
 */

class Song extends CI_Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Music_model');
	$this->load->language('music');
        
    }
    
    /**
     * Display song info
     * @param Number $id song id
     * @param String $claim
     */
    public function Index($id, $claim = NULL)
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        if ($this->authentication->is_signed_in())
	{
	    // Retrieve sign in user
	    $data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
	}
	else
	{
	    $data['account'] = NULL;
	}
        
        if($id === NULL || !is_numeric($id))
        {
            show_404();
        }
        
        $data['song'] = $this->Music_model->get($id);
        
        //check if private
        if($data['song']->private)
        {
            show_404();
        }
	
	//get the owner(s) profiles
	if($data['song']->owner != NULL)
	{
	    $data['owner'] = $this->Account_model->get_by_id($data['song']->owner);
	    if($data['song']->owner2 != NULL)
	    {
		$data['owner2'] = $this->Account_model->get_by_id($data['song']->owner2);
	    }
	}
	
	//check if song is being claimed
	if($claim !=  NULL)
	{
	    //check if this song can still be claimed
	    if($data['song']->owner === NULL || $data['song']->owner2 === NULL && $data['song']->owner != $data['account']->id)
	    {
		$data['claim'] = TRUE;
		
		//check if we are recieving claiming request
		if($this->input->post('submit', TRUE) != NULL)
		{
		    //requirements
		    $this->form_validation->set_rules('control_code', 'Control Code', 'required|alpha_numeric|max_length[5]|xss_clean');
		    
		    if($this->form_validation->run())
		    {
			if($this->Music_model->control_code_confirm($id, $this->session->userdata('account_id'), $this->input->post('control_code', TRUE)))
			{
			   //display confirmation message
			   $data['message'] = 'success';
			}
			else
			{
			    //display error message
			    $data['message'] = 'failure';
			}
		    }
		}
	    }
	}
	else
	{
	    $data['claim'] = FALSE;
	}
        
        //load the view
        $data['content'] = $this->load->view('music/song', $data, TRUE);
        $this->load->view('template', $data);
    }
    
    /**
     * Allows owner to edit the song info
     * @param Number $id song id
     */
    public function Edit($id)
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        if ($this->authentication->is_signed_in())
	{
	    // Retrieve sign in user
	    $data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
	}
        
        if($id === NULL || !is_numeric($id))
        {
            show_404();
        }
        
        $data['song'] = $this->Music_model->get($id);
        
        //check that the song author is accessing this, if not redirect
        if($data['song']->owner != $this->session->userdata('account_id'))
        {
            $this->Index($id);
        }
        
        //check if we have a form submit
        
        
        //load the view
        $data['content'] = $this->load->view('music/song_edit', $data, TRUE);
        $this->load->view('template', $data);
    }
    
    /**
     * Force download of the file
     * @param object $id Description
     * @return object  Description
     */
    public function Download($id)
    {
        // Enable SSL?
        maintain_ssl($this->config->item("ssl_enabled"));
        
        if ($this->authentication->is_signed_in())
	{
	    // Retrieve sign in user
	    $data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
	}
        
        if($id === NULL || !is_numeric($id))
        {
            show_404();
        }
        
        $song = $this->Music_model->get($id);
        
        //check if private
        if($data['song']->private)
        {
            show_404();
        }
        
	//record the download instance
        $this->Music_model->download($id);
	
        //get the file
        $this->load->helper('download');
        $data = file_get_contents('music/'.$song->file);
        force_download($song->name . '.mp3', $data);
    }
}