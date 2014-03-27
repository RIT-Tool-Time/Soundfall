<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get the music file info by id
     * @param Number $id
     * @return object
     */
    public function get($id)
    {
        return $this->db->get_where('music', array('id' => $id))->row();
    }
    
    /**
     * Get certain number of the latest addition with the given offset
     * @param Number $number Description
     * @param Number $offset Description
     * @return object
     */
    public function get_batch($number = 10, $offset = 0)
    {
        
    }
}

/* End of file Music_model.php */
/* Location: ./application/models/Music_model.php */