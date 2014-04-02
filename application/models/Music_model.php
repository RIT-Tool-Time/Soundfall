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
    
    /**
     * Counts all songs in the DB
     * @return int
     */
    public function count_all()
    {
        //return $this->db->count_all('music');
        return 10;
    }
    
    /**
     * Get songs by the given artist
     * @param Number $id Artist ID
     * @param Number $number How many should we get
     * @param Number $offset What is the offset
     * @return object
     */
    public function get_by_artist($id, $number = 10, $offset = 0)
    {
        
    }
    
    /**
     * Count all songs by the given artist
     * @param Number $id
     * @return Number
     */
    public function count_by_artist($id)
    {
        return 6;
    }
}

/* End of file Music_model.php */
/* Location: ./application/models/Music_model.php */