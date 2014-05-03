<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * API to allow saving and deleting saved pieces of music.
 */

 //remove this only if you autoload REST_Controller in the autoload config
require APPPATH.'libraries/REST_Controller.php';

class Music extends REST_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Saved_music_model');
    }
    
    /**
     * Save music for user
     * @param Numeric $music_id
     * @param Numeric $user_id
     */
    public function Save_post()
    {
        $music_id = $this->post('song');
        $user_id = $this->post('user');
        
        if($this->Saved_music_model->Save($music_id, $user_id))
        {
            $this->response(NULL, 201);
        }
        else
        {
            $this->response(NULL, 500);
        }
    }
    
    /**
     * Delete saved piece of music
     * @param Numeric $music_id
     * @param Numeric $user_id
     */
    public function Delete_post()
    {
        $music_id = $this->post('song');
        $user_id = $this->post('user');
        
        if($this->Saved_music_model->Delete($music_id, $user_id))
        {
            $this->response(NULL, 201);
        }
        else
        {
            $this->response(NULL, 500);
        }
    }
}
/* End of file Saved.php */
/* Location: ./application/controllers/api/Saved.php */