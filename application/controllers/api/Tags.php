<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * API to return information about tags
 */

 //remove this only if you autoload REST_Controller in the autoload config
require APPPATH.'libraries/REST_Controller.php';

class Music extends REST_Controller{
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Tags_model');
    }
    
    public function get_tags_get()
    {
        $this->response($this->Tags_model->get_all());
    }
}
/* End of file Tags.php */
/* Location: ./application/controllers/api/Tags.php */