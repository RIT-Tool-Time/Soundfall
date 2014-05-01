<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saved_music_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Save music for user
     * @param Numeric $music_id
     * @param Numeric $user_id
     */
    public function Save($music_id, $user_id)
    {
        $this->db->insert('saved_music', array('user_id' => $user_id, 'music_id' => $music_id));
        return $this->db->insert_id();
    }
    
     /**
     * Delete saved piece of music
     * @param Numeric $music_id
     * @param Numeric $user_id
     */
    public function Delete($music_id, $user_id)
    {
        $this->db->where(array('user_id' => $user_id, 'music_id' => $music_id));
        $this->db->delete('saved_music');
        return $this->db->affected_rows();
    }
}

/* End of file Tags_model.php */
/* Location: ./application/models/Tags_model.php */