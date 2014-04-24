<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * API to return information about music pieces
 */

 //remove this only if you autoload REST_Controller in the autoload config
require APPPATH.'libraries/REST_Controller.php';

class Music extends REST_Controller{
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Music_model');
    }
    
    /**
     * Summary
     * @param Numeric $id
     */
    public function song_get($id)
    {
        $this->response($this->Music_model->get($id));
    }
    
    /**
     * Summary
     * @param Numeric $page Description
     * @param Numeric $limit Description
     */
    public function music_get($page, $limit = 10)
    {
        if($page <= 1 || $page == NULL)
        {
            $offset = 0;
        }
        else
        {
            $offset = ($page-1)*$limit;
        }
        $this->response($this->Music_model->get_batch($limit, $offset), 201);
    }
    
    /**
     * API call to add uploaded music file into the DB
     * @param String $name
     * @param String $file
     * @param String $email
     * @param String $picture
     */
    public function song_post()
    {
        $name = $this->post('name');
        $file = $this->post('file');
        $email = $this->post('email');
        $email2 = $this->post('email2');
        $picture = $this->post('picture');
        
        //@TODO generate the control code
        $control_code = '12345';
        
        $response = $this->Music_model->add($name, $file, $control_code, $email, $email2, FALSE, $picture);
        if($response != NULL)
        {
            //@todo e-mail the user with their song info
            $this->load->library('email');
            
            //email setup
            $this->email->from('cascade@rit.edu', 'Cascade');
            $this->email->bcc($email);
            $this->email->bcc($email2);
            
            $this->email->subject('Cascade Email Test');
            $this->email->message('Claim your song here: ' . base_url('song/'.$response.'/'.$file) . "<br /> Your control code is: " . $control_code);
            
            $this->email->send();
            
            //API response
            $this->response(array('song_id' => $response),201);
        }
        else
        {
            $this->response(array('error' => 'There was an error adding the song to the DB.'), 500);
        }
    }
    
    /**
     * Search
     * @param Numeric $page
     * @param Numeric $limit
     * @param String $title
     * @param Array $tags
     * @return object
     */
    public function search_post()
    {
        $page = $this->post('page');
        $limit = $this->post('limit');
        $title = $this->post('title');
        $tags = $this->post('tags');
        
        if($page === NULL)
        {
            $page = 0;
        }
        if($limit === NULL)
        {
            $limit = 10;
        }
        
        if($page <= 1 || $page == NULL)
        {
            $offset = 0;
        }
        else
        {
            $offset = ($page-1)*$limit;
        }
        
        $this->response($this->Music_model->find($title, $tags, $limit, $offset), 201);
    }
    
    /**
     * Add one play to the given song
     * @param Numeric $song_id
     */
    public function add_play_post()
    {
        $return = $this->Music_model->add_play($this->post('song_id'));
        if($return === 1)
        {
            $this->response(array(), 200);
        }
        else
        {
            $this->response(array(), 404);
        }
    }
}


/* End of file Music.php */
/* Location: ./application/controllers/api/Music.php */