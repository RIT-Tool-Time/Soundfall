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
     * @param Number $number How many songs should be returned
     * @param Number $offset Offset (If we have 10 songs per page then second page should have offset of 10)
     * @return object
     */
    public function get_batch($number = 10, $offset = 0)
    {
        $this->db->order_by('date', 'DESC');
        $this->db->limit($number, $offset);
        return $this->db->get('music')->result();
    }
    
    /**
     * Counts all songs in the DB
     * @return int
     */
    public function count_all()
    {
        return $this->db->count_all('music');
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
        $this->db->where('owner', $id);
        $this->db->or_where('owner2', $id);
        return $this->db->get('music')->result();
    }
    
    /**
     * Count all songs by the given artist
     * @param Number $id
     * @return Number
     */
    public function count_by_artist($id)
    {
        $this->db->where('owner', $id);
        $this->db->or_where('owner2', $id);
        $this->db->from('music');
        return $this->db->count_all_results();
    }
    
    /**
     * Adds one download to the download count
     * @param Numeric $id Song id
     */
    public function download($id)
    {
        $current = $this->db->get_where('music', array('id' => $id))->row();
        
        $count = $current->downloads + 1;
        
        $this->db->where('id', $id);
        return $this->db->update('music', array('downloads' => $count));
    }
}

/* End of file Music_model.php */
/* Location: ./application/models/Music_model.php */